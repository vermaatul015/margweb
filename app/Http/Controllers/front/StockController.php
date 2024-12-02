<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use Helper;
use App\Models\Product;
use App\Models\Stock;

class StockController extends Controller
{
    public function list(Request $request){
        $data["index"] = "Stock";
        $searchKey               = ($request->all())?$request->skey:'';
        $data['skey']            = $searchKey;
        $num_results_on_page = \Config::get('ws_constant.per_page');
        $data['stock'] = Stock::select('id','product_id','name','cost_price','quantity','created_at');
        if($searchKey){
            $data['stock'] = $data['stock']->where(function ($query) use($searchKey) {
                $query->Where('name','like', '%'.$searchKey.'%');
            });
        }
        $data['stock'] = $data['stock']->sortable(['name' => 'asc'])->paginate($num_results_on_page);
        return view('front/stock')->with('data',$data);
    }

    public function editStock(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'stock_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $stock = Stock::where('id',$request->stock_id)->first();
            if($stock){
                if($stock->save()){
                    return Response::json(Helper::generateResponseBody((object)[],'Stock updated successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }  
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No stock found.', false, \Config::get('ws_constant.code.CODE_202')));
            }
             
        }
    }

    public function deleteStock(Request $request){
        $validator = Validator::make($request->all(),
            [
                'stock_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $stock = Stock::where('id',$request->stock_id)->first();
            if($stock){
                if($stock->delete()){
                    return Response::json(Helper::generateResponseBody((object)[],'Stock deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No stock found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }
}
