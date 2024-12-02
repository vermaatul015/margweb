<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use Helper;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function list(Request $request){
        $data["index"] = "Supplier";
        $searchKey               = ($request->all())?$request->skey:'';
        $data['skey']            = $searchKey;
        $num_results_on_page = \Config::get('ws_constant.per_page');
        $data['supplier'] = Supplier::select('id','name','gst','phone_no','address','created_at');
        if($searchKey){
            $data['supplier'] = $data['supplier']->where(function ($query) use($searchKey) {
                $query->where('name','like', '%'.$searchKey.'%')
                ->orWhere('phone_no','like', '%'.$searchKey.'%')
                ->orWhere('address','like', '%'.$searchKey.'%')
                ->orWhere('gst','like', '%'.$searchKey.'%');
            });
        }
        $data['supplier'] = $data['supplier']->sortable(['name' => 'asc'])->paginate($num_results_on_page);
        return view('front/supplier')->with('data',$data);
    }

    public function addSupplier(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:50'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->gst = $request->gst ? $request->gst : "";
            $supplier->phone_no = $request->phone_no ? $request->phone_no : "";
            $supplier->address = $request->address ? $request->address : "";
            if($supplier->save()){
                return Response::json(Helper::generateResponseBody((object)[],'Supplier added successfully.'));
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
            }   
        }
    }

    public function editSupplier(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'supplier_id' => 'required',
                'name' => 'required|max:50'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        } else {
            $supplier = Supplier::where('id',$request->supplier_id)->first();
            if($supplier){
                $supplier->name = $request->name;
                $supplier->gst = $request->gst;
                $supplier->phone_no = $request->phone_no ? $request->phone_no : "";
                $supplier->address = $request->address ? $request->address : "";
                if($supplier->save()){
                    return Response::json(Helper::generateResponseBody((object)[],'Supplier updated successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }  
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No supplier found.', false, \Config::get('ws_constant.code.CODE_202')));
            }
             
        }
    }

    public function deleteSupplier(Request $request){
        $validator = Validator::make($request->all(),
            [
                'supplier_id' => 'required'
            ]
        );
        $errors = $validator->errors()->all();
        if ($errors) {
            return Response::json(Helper::generateResponseBody((object)[], ["errors" => $errors], false, \Config::get('ws_constant.code.CODE_201')));
        }else{
            $supplier = Supplier::where('id',$request->supplier_id)->first();
            if($supplier){
                if($supplier->delete()){
                    return Response::json(Helper::generateResponseBody((object)[],'Supplier deleted successfully.'));
                }else{
                    return Response::json(Helper::generateResponseBody((object)[], 'Something went wrong.', false, \Config::get('ws_constant.code.CODE_202')));
                }
            }else{
                return Response::json(Helper::generateResponseBody((object)[], 'No supplier found.', false, \Config::get('ws_constant.code.CODE_202')));
            }

        }
    }
}
