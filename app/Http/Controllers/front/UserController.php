<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Response;
use Helper;
use Redirect;
use Image;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        $data['index']           = "User";
        $data['user'] = User::first();
        $data['base_url'] = \URL::to('/').'/uploads/';
        return view('front/user')->with('data',$data);
    }

    public function detailsUpdate(Request $request){
        $user = User::first();
        $validatorField = [
            'name'         => 'required',
            'gst'         => 'required'
        ];
        $messages = [];
        if(!empty($request->logo)){
            $validatorField['logo'] = 'mimes:jpeg,bmp,png,jpg,gif';
            $validatorField['logo_base64'] = 'required';
            $messages = [
                'logo_base64.required' => 'Please click on logo crop!',
            ];
        }
        
        $validator = Validator::make($request->all(), $validatorField,$messages);
        
        if ($validator->fails()) {
            $errorMsg = '';
            // dd($validator->errors()->all());
            foreach ($validator->errors()->all() as $error) {
                $errorMsg .= $error.'<br>';
            }
            // $request->session()->flash('alert-error', $errorMsg);
            // dd($errorMsg);
            return Redirect::route('user')->with('flash-error',$errorMsg);
        } else {
            $base_url = public_path().'/uploads/';
            if(!empty($request->logo)){
                // \Log::debug('149');
                $getFileName         = pathinfo($request->logo->getClientOriginalName(),PATHINFO_FILENAME); 
                $getFileExt          = strtolower($request->logo->getClientOriginalExtension());
                $uploadedFile        = time().'_logo.'.$getFileExt;
                $path = $base_url . $uploadedFile;
                // \Log::debug('154');
                $imgObj = Image::make(file_get_contents($request->logo_base64));
                $bImgW = 80;
                $bImgH = 80;
                $imgObj2   = Image::canvas($bImgW,$bImgH,'#fff');
                $imgObj2->insert($imgObj,'center');
                $imgObj2->save($path);
                // \Log::debug('161');
            }else{
                $uploadedFile        = NULL;
            }
            $user           = $user ?? New User;
            $user->name = $request->name;
            $user->gst = $request->gst;
            $user->phone_no = $request->phone_no;
            $user->address = $request->address;
            if($uploadedFile){
                $user->logo =  $uploadedFile;
            }
            $user->save();
            return Redirect::route('user')->with('flash-success','User Details Updated');
        }
       
    }

    public function user_logo_delete(){
        $user = User::first();
        if($user == null){
            return \Redirect::route('user')->with('flash-error','No record found');
            exit;
        }
        
        $base_url = public_path().'/uploads/';
        if($user->logo && file_exists($base_url.$user->logo)){
            unlink($base_url.$user->logo);
        }
        
        $user->logo = null;
        $user->save();
        return \Redirect::back()->with('flash-success','Logo Deleted');
        exit;
    }
}
