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

class BuyController extends Controller
{
    public function list(Request $request){
        $data["index"] = "Buy";
        $searchKey               = ($request->all())?$request->skey:'';
        $data['skey']            = $searchKey;
        $num_results_on_page = \Config::get('ws_constant.per_page');
        $data['buy'] = Buy::select('id','supplier_id','supplier_name','product_id','name','cost_price','quantity','total_cost_price','paid','due','created_at');
        if($searchKey){
            $data['buy'] = $data['buy']->where(function ($query) use($searchKey) {
                $query->where('supplier_name','like', '%'.$searchKey.'%')
                ->orWhere('name','like', '%'.$searchKey.'%')
                ->orWhere('cost_price','like', '%'.$searchKey.'%')
                ->orWhere('quantity','like', '%'.$searchKey.'%')
                ->orWhere('paid','like', '%'.$searchKey.'%')
                ->orWhere('due','like', '%'.$searchKey.'%');
            });
        }
        $data['buy'] = $data['buy']->sortable(['created_at' => 'desc'])->paginate($num_results_on_page);
        $data['supplier'] = Supplier::select('id','name')->get();
        $data['product'] = Product::select('id','name','price')->get();
        return view('front/buy')->with('data',$data);
    }

    public function addBuy(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'supplier_name' => 'required',
                'name' => 'required|max:50',
                'cost_price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'paid' => 'required|numeric'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            list($cost_price , $quantity, $paid,$total_cost_price,$due) = Helper::calculateDue($request->cost_price,$request->quantity,$request->paid);
            if($due < 0){
                return Response::json(Helper::generateResponseBody((object)[], 'You are paying more than total cost price.', false, \Config::get('ws_constant.code.CODE_202')));
            }
            $buy = new Buy;
            $buy->supplier_id = $request->supplier_id ?? NULL;
            $buy->product_id = $request->product_id ?? NULL;
            $buy->supplier_name = $request->supplier_name;
            $buy->name = $request->name;
            $buy->cost_price = $cost_price;
            $buy->quantity = $quantity;
            $buy->total_cost_price = $total_cost_price;
            $buy->paid = $paid;
            $buy->due = $due;
            if($buy->save()){
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
                'name' => 'required|max:50',
                'cost_price' => 'required|numeric',
                'quantity' => 'required|numeric',
                'paid' => 'required|numeric'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $buy = Buy::where('id',$request->buy_id)->first();
            if($buy){
                list($cost_price , $quantity, $paid, $total_cost_price,$due) =  Helper::calculateDue($request->cost_price,$request->quantity,$request->paid);
                if($due < 0){
                    return Response::json(Helper::generateResponseBody((object)[], 'You are paying more than total cost price.', false, \Config::get('ws_constant.code.CODE_202')));
                }
                $buy->supplier_id = $request->supplier_id ?? NULL;
                $buy->product_id = $request->product_id ?? NULL;
                $buy->supplier_name = $request->supplier_name;
                $buy->name = $request->name;
                $buy->cost_price = $cost_price;
                $buy->quantity = $quantity;
                $buy->total_cost_price = $total_cost_price;
                $buy->paid = $paid;
                $buy->due = $due;
                if($buy->save()){
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
                    return Response::json(Helper::generateResponseBody((object)[],'Buy deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product bought found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }
}
