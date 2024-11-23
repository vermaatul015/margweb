<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use Helper;
use App\Models\Supplier;
use App\Models\Product;

class ProductController extends Controller
{
    public function list(Request $request){
        $data["index"] = "Product";
        $searchKey               = ($request->all())?$request->skey:'';
        $data['skey']            = $searchKey;
        $num_results_on_page = \Config::get('ws_constant.per_page');
        $data['product'] = Product::select('id','supplier_id','supplier_name','name','price','created_at');
        if($searchKey){
            $data['product'] = $data['product']->where(function ($query) use($searchKey) {
                $query->where('supplier_name','like', '%'.$searchKey.'%')
                ->orWhere('name','like', '%'.$searchKey.'%')
                ->orWhere('price','like', '%'.$searchKey.'%');
            });
        }
        $data['product'] = $data['product']->sortable()->paginate($num_results_on_page);
        $data['supplier'] = Supplier::select('id','name')->get();
        return view('front/product')->with('data',$data);
    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                // 'supplier_id' => 'required',
                'name' => 'required|max:50',
                'price' => 'required|numeric'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $product = new Product;
            $product->supplier_id = $request->supplier_id ?? NULL;
            $product->supplier_name = $request->supplier_name ?? '';
            $product->name = $request->name;
            $product->price = $request->price;
            if($product->save()){
                return Response::json(Helper::generateResponseBody((object)[],'Product added successfully.'));
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
            }   
        }
    }

    public function editProduct(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required',
                // 'supplier_id' => 'required',
                'name' => 'required|max:50',
                'price' => 'required|numeric'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $product = Product::where('id',$request->product_id)->first();
            if($product){
                $product->supplier_id = $request->supplier_id ?? NULL;
                $product->supplier_name = $request->supplier_name ?? '';
                $product->name = $request->name;
                $product->price = $request->price;
                if($product->save()){
                    return Response::json(Helper::generateResponseBody((object)[],'Product updated successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }  
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product found.', false, \Config::get('ws_constant.code.CODE_202')));
            }
             
        }
    }

    public function deleteProduct(Request $request){
        $validator = Validator::make($request->all(),
            [
                'product_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $product = Product::where('id',$request->product_id)->first();
            if($product){
                if($product->delete()){
                    return Response::json(Helper::generateResponseBody((object)[],'Product deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No product found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }
}
