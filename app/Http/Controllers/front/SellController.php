<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use Helper;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Buy;
use App\Models\Stock;
use App\Models\Sell;
use App\Models\User;

class SellController extends Controller
{
    public function list(Request $request){
        $data["index"] = "Sell";
        $searchKey               = ($request->all())?$request->skey:'';
        $data['skey']            = $searchKey;
        $num_results_on_page = \Config::get('ws_constant.per_page');
        $data['sell'] = Sell::select('id','supplier_id','supplier_name','stock_id','name','selling_price','quantity','total_selling_price','amount_received','due','created_at');
        if($searchKey){
            $data['sell'] = $data['sell']->where(function ($query) use($searchKey) {
                $query->where('supplier_name','like', '%'.$searchKey.'%')
                ->orWhere('name','like', '%'.$searchKey.'%')
                ->orWhere('selling_price','like', '%'.$searchKey.'%')
                ->orWhere('quantity','like', '%'.$searchKey.'%')
                ->orWhere('amount_received','like', '%'.$searchKey.'%')
                ->orWhere('due','like', '%'.$searchKey.'%');
            });
        }
        $data['sell'] = $data['sell']->sortable(['created_at' => 'desc'])->paginate($num_results_on_page);
        $data['supplier'] = Supplier::select('id','name')->get();
        $data['stock'] = Stock::select('id','product_id','name','cost_price','quantity','selling_price')->get();
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

    public function addSell(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'stock_id' => 'required',
                'supplier_name' => 'required',
                'name' => 'required|max:50',
                'selling_price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'amount_received' => 'required|numeric'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $stock = Stock::where("id",$request->stock_id)->first();
            $quantity = (int)$request->quantity;
            $stock_quantity = (int)$stock->quantity;
            if($quantity > $stock_quantity){
                return Response::json(Helper::generateResponseBody((object)[], 'You dont have stock for this product.', false, \Config::get('ws_constant.code.CODE_202')));
            }
            list($selling_price , $quantity, $amount_received, $total_selling_price,$due) = Helper::calculateAmountRecieved($request->selling_price,$request->quantity,$request->amount_received);
            
            $sell = new Sell;
            $sell->supplier_id = $request->supplier_id ?? NULL;
            $sell->stock_id = $request->stock_id;
            $sell->supplier_name = $request->supplier_name;
            $sell->name = $request->name;
            $sell->selling_price = $selling_price;
            $sell->quantity = $quantity;
            $sell->total_selling_price = $total_selling_price;
            $sell->amount_received = $amount_received;
            $sell->due = $due;
            if($sell->save()){
                $existingStock = Stock::where('id',$request->stock_id)->first();
                if($existingStock){
                    $existingStock->decrement('quantity', $quantity);
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
                // 'stock_id' => 'required',
                'supplier_name' => 'required',
                'name' => 'required|max:50',
                'selling_price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'amount_received' => 'required|numeric'
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
                list($selling_price , $quantity, $amount_received, $total_selling_price,$due) = Helper::calculateAmountRecieved($request->selling_price,$request->quantity,$request->amount_received);

                $sell->supplier_id = $request->supplier_id ?? NULL;
                $sell->stock_id = $request->stock_id ?? NULL;
                $sell->supplier_name = $request->supplier_name;
                $sell->name = $request->name;
                $sell->selling_price = $selling_price;
                $sell->quantity = $quantity;
                $sell->total_selling_price = $total_selling_price;
                $sell->amount_received = $amount_received;
                $sell->due = $due;
                if($sell->save()){
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
                    return Response::json(Helper::generateResponseBody((object)[],'Sell record deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No sell record found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }
}
