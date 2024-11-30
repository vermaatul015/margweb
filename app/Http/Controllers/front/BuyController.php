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
use App\Models\BuyPaidAmount;
use App\Models\BuyProduct;

class BuyController extends Controller
{
    public function list(Request $request){
        $data["index"] = "Buy";
        $data['count'] = 1;
        $searchKey               = ($request->all())?$request->skey:'';
        $data['skey']            = $searchKey;
        $num_results_on_page = \Config::get('ws_constant.per_page');
        $data['buy'] = Buy::select('id','supplier_id','supplier_name','total_cost_price','total_paid_amount','due','created_at');
        if($searchKey){
            $data['buy'] = $data['buy']->where(function ($query) use($searchKey) {
                $query->where('supplier_name','like', '%'.$searchKey.'%')
                ->orWhere('total_cost_price','like', '%'.$searchKey.'%')
                ->orWhere('total_paid_amount','like', '%'.$searchKey.'%')
                ->orWhere('due','like', '%'.$searchKey.'%');
            });
        }
        $data['buy'] = $data['buy']->with('products','paids')->sortable(['created_at' => 'desc'])->paginate($num_results_on_page);
        $data['supplier'] = Supplier::select('id','name')->get();
        $data['product'] = Product::select('id','name','price')->get();
        return view('front/buy')->with('data',$data);
    }

    public function addBuyProduct(Request $request)
    {
        if($request->count && is_numeric($request->count)){
            $data['product'] = Product::select('id','name','price')->get();
            $data['count'] = $request->count;
            $resp['product_html'] = view('front.elements.buy_products', compact('data'))->render();
            return Response::json(Helper::generateResponseBody($resp, ''));
        }else{
            return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong. Please refresh and do again.', false, \Config::get('ws_constant.code.CODE_201')));
        }
    }

    public function addBuyPaidAmount(Request $request)
    {
        if($request->count && is_numeric($request->count)){
            $data['count'] = $request->count;
            $resp['paid_html'] = view('front.elements.buy_paid_amount', compact('data'))->render();
            return Response::json(Helper::generateResponseBody($resp, ''));
        }else{
            return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong. Please refresh and do again.', false, \Config::get('ws_constant.code.CODE_201')));
        }
    }

    public function addBuy(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required|array',
                'supplier_name' => 'required',
                'name'    => 'required|array',
                'name.*' => 'required|max:50',
                'cost_price'    => 'required|array',
                'cost_price.*' => 'required|numeric',
                'quantity'    => 'required|array',
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
            list($cost_price , $quantity, $paid,$total_cost_price,$total_paid_amount,$due) = Helper::calculateDue($request->cost_price,$request->quantity,$request->paid);
            if($due < 0){
                return Response::json(Helper::generateResponseBody((object)[], 'You are paying more than total cost price.', false, \Config::get('ws_constant.code.CODE_202')));
            }
            $buy = new Buy;
            $buy->supplier_id = $request->supplier_id ?? NULL;
            $buy->supplier_name = $request->supplier_name;
            $buy->total_cost_price = $total_cost_price;
            $buy->total_paid_amount = $total_paid_amount;
            $buy->due = $due;
            
            if($buy->save()){
                foreach($cost_price as $key=>$cp){
                    $buyProduct = new BuyProduct;
                    $buyProduct->product_id = $request->product_id[$key] ?? NULL;
                    $buyProduct->name = $request->name[$key];
                    $buyProduct->cost_price = $cost_price[$key];
                    $buyProduct->quantity = $quantity[$key];
                    $buyProduct->buy_id = $buy->id;
                    $buyProduct->save();
                }
                foreach($paid as $k => $p){
                    $buyPaidAmount = new BuyPaidAmount;
                    $buyPaidAmount->buy_id = $buy->id;
                    $buyPaidAmount->paid = $paid[$k];
                    $buyPaidAmount->paid_date = Carbon::parse( $request->paid_date[$k])->format('Y-m-d');
                    $buyPaidAmount->save();
                }
                

                foreach($cost_price as $key=>$cp){
                    $existingStock = Stock::where('product_id',$request->product_id[$key])->where('cost_price',$cost_price[$key])->first();
                    if($existingStock){
                        $existingStock->increment('quantity', $quantity[$key]);
                    }else{
                        $inputs = ['product_id'=>$request->product_id[$key],'name'=>$request->name[$key],'cost_price'=>$cost_price[$key],'quantity'=>$quantity[$key]];
                        Stock::create($inputs);
                    }   
                }             
                return Response::json(Helper::generateResponseBody((object)[],'Product bought successfully.'));
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
            }   
        }
    }

    public function editBuy(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'buy_id' => 'required',
                'supplier_name' => 'required',
                'buy_product_id'    => 'required|array',
                'name'    => 'required|array',
                'name.*' => 'required|max:50',
                'cost_price'    => 'required|array',
                'cost_price.*' => 'required|numeric',
                'quantity'    => 'required|array',
                'quantity.*' => 'required|numeric',
                'buy_paid_id'    => 'required|array',
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
            $buy = Buy::where('id',$request->buy_id)->first();
            if($buy){
                list($cost_price , $quantity, $paid,$total_cost_price,$total_paid_amount,$due) =  Helper::calculateDue($request->cost_price,$request->quantity,$request->paid);
                if($due < 0){
                    return Response::json(Helper::generateResponseBody((object)[], 'You are paying more than total cost price.', false, \Config::get('ws_constant.code.CODE_202')));
                }
                $buy->supplier_id = $request->supplier_id ?? NULL;
                $buy->supplier_name = $request->supplier_name;
                $buy->total_cost_price = $total_cost_price;
                $buy->total_paid_amount = $total_paid_amount;
                $buy->due = $due;
                if($buy->save()){

                    foreach($cost_price as $key=>$cp){
                        $buyProduct = BuyProduct::where('id',$request->buy_product_id[$key])->first();
                        $buyProduct->product_id = $request->product_id[$key] ?? NULL;
                        $buyProduct->name = $request->name[$key];
                        $buyProduct->cost_price = $cost_price[$key];
                        $buyProduct->quantity = $quantity[$key];
                        $buyProduct->buy_id = $buy->id;
                        $buyProduct->save();
                    }
                    
                    foreach($paid as $k => $p){
                        if(isset($request->buy_paid_id[$k])){
                            $buyPaidAmount = BuyPaidAmount::where('id',$request->buy_paid_id[$k])->first();    
                        }else{
                            $buyPaidAmount = new BuyPaidAmount;
                        }
                        $buyPaidAmount->paid = $paid[$k];
                        $buyPaidAmount->buy_id = $buy->id;
                        $buyPaidAmount->paid_date = Carbon::parse( $request->paid_date[$k])->format('Y-m-d');
                        $buyPaidAmount->save();
                    }


                    return Response::json(Helper::generateResponseBody((object)[],'Product bought updated successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }  
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product bought found.', false, \Config::get('ws_constant.code.CODE_202')));
            }
             
        }
    }

    public function deleteBuy(Request $request){
        $validator = Validator::make($request->all(),
            [
                'buy_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $buy = Buy::where('id',$request->buy_id)->first();
            if($buy){
                if($buy->delete()){
                    BuyProduct::where('buy_id',$request->buy_id)->delete();
                    BuyPaidAmount::where('buy_id',$request->buy_id)->delete();
                    return Response::json(Helper::generateResponseBody((object)[],'Buy deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product bought found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }

    public function deleteBuyProduct(Request $request){
        $validator = Validator::make($request->all(),
            [
                'buy_product_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $buy = BuyProduct::where('id',$request->buy_product_id)->first();
            if($buy){
                $buy_id = $buy->buy_id;
                if($buy->delete()){
                    $buyProducts = BuyProduct::select('id','buy_id', 'cost_price','quantity')->where('buy_id', $buy_id)->get();
                    $cost_price = [];
                    $quantity = [];
                    if($buyProducts->count()){
                        foreach($buyProducts as $key=>$buyProduct){
                            $cost_price[] = $buyProduct->cost_price;
                            $quantity[] = $buyProduct->quantity;
                        }
                    }

                    $buyPaidAmounts = BuyPaidAmount::select('id','buy_id', 'paid')->where('buy_id', $buy_id)->get();
                    $paid = [];
                    if($buyPaidAmounts->count()){
                        foreach($buyPaidAmounts as $key=>$buyPaidAmount){
                            $paid[] = $buyPaidAmount->paid;
                        }
                    }

                    list($cost_price , $quantity, $paid,$total_cost_price,$total_paid_amount,$due) =  Helper::calculateDue($cost_price,$quantity,$paid);
                    Buy::where('id',$buy_id)->update(['total_cost_price'=>$total_cost_price,'total_paid_amount'=>$total_paid_amount,'due'=>$due]);
                    return Response::json(Helper::generateResponseBody((object)[],'Bought product deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product bought found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }

    public function deleteBuyPaidAmount(Request $request){
        $validator = Validator::make($request->all(),
            [
                'buy_paid_amount_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $buy = BuyPaidAmount::where('id',$request->buy_paid_amount_id)->first();
            if($buy){
                $buy_id = $buy->buy_id;
                if($buy->delete()){
                    $buyProducts = BuyProduct::select('id','buy_id', 'cost_price','quantity')->where('buy_id', $buy_id)->get();
                    $cost_price = [];
                    $quantity = [];
                    if($buyProducts->count()){
                        foreach($buyProducts as $key=>$buyProduct){
                            $cost_price[] = $buyProduct->cost_price;
                            $quantity[] = $buyProduct->quantity;
                        }
                    }

                    $buyPaidAmounts = BuyPaidAmount::select('id','buy_id', 'paid')->where('buy_id', $buy_id)->get();
                    $paid = [];
                    if($buyPaidAmounts->count()){
                        foreach($buyPaidAmounts as $key=>$buyPaidAmount){
                            $paid[] = $buyPaidAmount->paid;
                        }
                    }

                    list($cost_price , $quantity, $paid,$total_cost_price,$total_paid_amount,$due) =  Helper::calculateDue($cost_price,$quantity,$paid);
                    Buy::where('id',$buy_id)->update(['total_cost_price'=>$total_cost_price,'total_paid_amount'=>$total_paid_amount,'due'=>$due]);
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
