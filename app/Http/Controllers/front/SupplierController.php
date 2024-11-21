<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request){
        $data["index"] = "Supplier";
        // $data['user'] = Auth::user();
        // $data['address_form'] = view('front.elements.address_form');
        return view('front/supplier')->with('data',$data);
    }
}
