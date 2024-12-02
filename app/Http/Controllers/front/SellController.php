<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use Helper;
use Carbon\Carbon;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Buy;
use App\Models\Stock;
use App\Models\Sell;
use App\Models\User;
use App\Models\SellPaidAmount;
use App\Models\SellProduct;

class SellController extends Controller
{
    public function list(Request $request){
        $data["index"] = "Sell";
        $data['count'] = 1;
        $searchKey               = ($request->all())?$request->skey:'';
        $data['skey']            = $searchKey;
        $num_results_on_page = \Config::get('ws_constant.per_page');
        $data['sell'] = Sell::select('id','supplier_id','supplier_name','total_selling_price','total_recieved_amount','due','created_at');
        if($searchKey){
            $data['sell'] = $data['sell']->where(function ($query) use($searchKey) {
                $query->where('supplier_name','like', '%'.$searchKey.'%')
                ->orWhere('total_selling_price','like', '%'.$searchKey.'%')
                ->orWhere('total_recieved_amount','like', '%'.$searchKey.'%')
                ->orWhere('due','like', '%'.$searchKey.'%');
            });
        }
        $data['sell'] = $data['sell']->with('products','paids')->sortable(['created_at' => 'desc'])->paginate($num_results_on_page);
        $data['supplier'] = Supplier::select('id','name')->get();
        $data['stock'] = Stock::select('id','product_id','name','cost_price','quantity')->where('quantity','>','0')->get();
        return view('front/sell')->with('data',$data);
    }

    public function invoice($id=null){
        $data['index']            = "Invoice";
        $data['id']            = $id;
        $sell = Sell::find($id);
        $data['sell'] = $sell;
        $data['user'] = User::first();
        $data['base_url'] = \URL::to('/').'/uploads/';
        return view('front/invoice')->with('data',$data);
    }

    public function addSellProduct(Request $request)
    {
        if($request->count && is_numeric($request->count)){
            $data['stock'] = Stock::select('id','product_id','name','cost_price','quantity')->get();
            $data['count'] = $request->count;
            $resp['product_html'] = view('front.elements.sell_products', compact('data'))->render();
            return Response::json(Helper::generateResponseBody($resp, ''));
        }else{
            return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong. Please refresh and do again.', false, \Config::get('ws_constant.code.CODE_201')));
        }
    }

    public function addSellPaidAmount(Request $request)
    {
        if($request->count && is_numeric($request->count)){
            $data['count'] = $request->count;
            $resp['paid_html'] = view('front.elements.sell_paid_amount', compact('data'))->render();
            return Response::json(Helper::generateResponseBody($resp, ''));
        }else{
            return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong. Please refresh and do again.', false, \Config::get('ws_constant.code.CODE_201')));
        }
    }

    public function addSell(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'stock_id' => 'required|array',
                'stock_id.*' => 'required',
                'supplier_name' => 'required',
                'name' => 'required|array',
                'name.*' => 'required|max:50',
                'selling_price' => 'required|array',
                'selling_price.*' => 'required|numeric',
                'quantity' => 'required|array',
                'quantity.*' => 'required|numeric',
                'paid' => 'required|array',
                'paid.*' => 'required|numeric',
                'paid_date' => 'required|array',
                'paid_date.*' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            foreach($request->stock_id as $k => $stk){
                $stock = Stock::where("id",$stk)->first();
                $quantity = (int)$request->quantity[$k];
                $stock_quantity = (int)$stock->quantity;
                if($quantity > $stock_quantity){
                    return Response::json(Helper::generateResponseBody((object)[], 'You dont have stock for '.$stock->name.' product.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }
            
            list($selling_price , $quantity, $paid, $total_selling_price,$total_recieved_amount,$due) = Helper::calculateAmountRecieved($request->selling_price,$request->quantity,$request->paid);
            
            $sell = new Sell;
            $sell->supplier_id = $request->supplier_id ?? NULL;
            $sell->supplier_name = $request->supplier_name;
            $sell->total_selling_price = $total_selling_price;
            $sell->total_recieved_amount = $total_recieved_amount;
            $sell->due = $due;
            if($sell->save()){
                foreach($selling_price as $key=>$sp){
                    $sellProduct = new SellProduct;
                    $sellProduct->stock_id = $request->stock_id[$key] ?? NULL;
                    $sellProduct->name = $request->name[$key];
                    $sellProduct->selling_price = $selling_price[$key];
                    $sellProduct->quantity = $quantity[$key];
                    $sellProduct->sell_id = $sell->id;
                    $sellProduct->save();
                }
                foreach($paid as $k => $p){
                    $sellPaidAmount = new SellPaidAmount;
                    $sellPaidAmount->sell_id = $sell->id;
                    $sellPaidAmount->paid = $paid[$k];
                    $sellPaidAmount->paid_date = Carbon::parse( $request->paid_date[$k])->format('Y-m-d');
                    $sellPaidAmount->save();
                }
                foreach($request->stock_id as $k => $stk){
                    $existingStock = Stock::where('id',$request->stock_id[$k])->first();
                    if($existingStock){
                        $existingStock->decrement('quantity', $quantity[$k]);
                    }   
                }            
                return Response::json(Helper::generateResponseBody((object)[],'Product sold successfully.'));
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
            }   
        }
    }

    public function editSell(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'sell_id' => 'required',
                'supplier_name' => 'required',
                'sell_product_id' => 'required|array',
                'name' => 'required|array',
                'name.*' => 'required|max:50',
                'selling_price' => 'required|array',
                'selling_price.*' => 'required|numeric',
                'quantity' => 'required|array',
                'quantity.*' => 'required|numeric',
                'sell_paid_id'    => 'required|array',
                'paid' => 'required|array',
                'paid.*' => 'required|numeric',
                'paid_date' => 'required|array',
                'paid_date.*' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $sell = Sell::where('id',$request->sell_id)->first();
            if($sell){
                // $stock = Stock::where("id",$request->stock_id)->first();
                // $quantity = (int)$request->quantity;
                // $stock_quantity = (int)$stock->quantity;
                // if($quantity > $stock_quantity){
                //     return Response::json(Helper::generateResponseBody((object)[], 'You dont have stock for this product.', false, \Config::get('ws_constant.code.CODE_202')));
                // }
                list($selling_price , $quantity, $paid, $total_selling_price,$total_recieved_amount,$due) = Helper::calculateAmountRecieved($request->selling_price,$request->quantity,$request->paid);

                $sell->supplier_id = $request->supplier_id ?? NULL;
                $sell->supplier_name = $request->supplier_name;
                $sell->total_selling_price = $total_selling_price;
                $sell->total_recieved_amount = $total_recieved_amount;
                $sell->due = $due;
                if($sell->save()){
                    foreach($selling_price as $key=>$sp){
                        $sellProduct = SellProduct::where('id',$request->sell_product_id[$key])->first();
                        $sellProduct->stock_id = $request->stock_id[$key] ?? NULL;
                        $sellProduct->name = $request->name[$key];
                        $sellProduct->selling_price = $selling_price[$key];
                        $sellProduct->quantity = $quantity[$key];
                        $sellProduct->sell_id = $sell->id;
                        $sellProduct->save();
                    }
                    
                    foreach($paid as $k => $p){
                        if(isset($request->sell_paid_id[$k])){
                            $sellPaidAmount = SellPaidAmount::where('id',$request->sell_paid_id[$k])->first();    
                        }else{
                            $sellPaidAmount = new SellPaidAmount;
                        }
                        $sellPaidAmount->paid = $paid[$k];
                        $sellPaidAmount->sell_id = $sell->id;
                        $sellPaidAmount->paid_date = Carbon::parse( $request->paid_date[$k])->format('Y-m-d');
                        $sellPaidAmount->save();
                    }
                    return Response::json(Helper::generateResponseBody((object)[],'Product sold updated successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }  
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No sell record found.', false, \Config::get('ws_constant.code.CODE_202')));
            }
             
        }
    }

    public function deleteSell(Request $request){
        $validator = Validator::make($request->all(),
            [
                'sell_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $sell = Sell::where('id',$request->sell_id)->first();
            if($sell){
                if($sell->delete()){
                    SellProduct::where('sell_id',$request->sell_id)->delete();
                    SellPaidAmount::where('sell_id',$request->sell_id)->delete();
                    return Response::json(Helper::generateResponseBody((object)[],'Sell record deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No sell record found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }

    public function deleteSellProduct(Request $request){
        $validator = Validator::make($request->all(),
            [
                'sell_product_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $sell = SellProduct::where('id',$request->sell_product_id)->first();
            if($sell){
                $sell_id = $sell->sell_id;
                if($sell->delete()){
                    $sellProducts = SellProduct::select('id','sell_id', 'selling_price','quantity')->where('sell_id', $sell_id)->get();
                    $selling_price = [];
                    $quantity = [];
                    if($sellProducts->count()){
                        foreach($sellProducts as $key=>$sellProduct){
                            $selling_price[] = $sellProduct->selling_price;
                            $quantity[] = $sellProduct->quantity;
                        }
                    }

                    $sellPaidAmounts = SellPaidAmount::select('id','sell_id', 'paid')->where('sell_id', $sell_id)->get();
                    $paid = [];
                    if($sellPaidAmounts->count()){
                        foreach($sellPaidAmounts as $key=>$sellPaidAmount){
                            $paid[] = $sellPaidAmount->paid;
                        }
                    }

                    list($selling_price , $quantity, $paid, $total_selling_price,$total_recieved_amount,$due) = Helper::calculateAmountRecieved($selling_price,$quantity,$paid);
                    Sell::where('id',$sell_id)->update(['total_selling_price'=>$total_selling_price,'total_recieved_amount'=>$total_recieved_amount,'due'=>$due]);
                    return Response::json(Helper::generateResponseBody((object)[],'Bought product deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product bought found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }

    public function deleteSellPaidAmount(Request $request){
        $validator = Validator::make($request->all(),
            [
                'sell_paid_amount_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $sell = SellPaidAmount::where('id',$request->sell_paid_amount_id)->first();
            if($sell){
                $sell_id = $sell->sell_id;
                if($sell->delete()){
                    $sellProducts = SellProduct::select('id','sell_id', 'selling_price','quantity')->where('sell_id', $sell_id)->get();
                    $selling_price = [];
                    $quantity = [];
                    if($sellProducts->count()){
                        foreach($sellProducts as $key=>$sellProduct){
                            $selling_price[] = $sellProduct->selling_price;
                            $quantity[] = $sellProduct->quantity;
                        }
                    }

                    $sellPaidAmounts = SellPaidAmount::select('id','sell_id', 'paid')->where('sell_id', $sell_id)->get();
                    $paid = [];
                    if($sellPaidAmounts->count()){
                        foreach($sellPaidAmounts as $key=>$sellPaidAmount){
                            $paid[] = $sellPaidAmount->paid;
                        }
                    }

                    list($selling_price , $quantity, $paid, $total_selling_price,$total_recieved_amount,$due) = Helper::calculateAmountRecieved($selling_price,$quantity,$paid);
                    Sell::where('id',$sell_id)->update(['total_selling_price'=>$total_selling_price,'total_recieved_amount'=>$total_recieved_amount,'due'=>$due]);
                    return Response::json(Helper::generateResponseBody((object)[],'Bought product deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product bought found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }
}
