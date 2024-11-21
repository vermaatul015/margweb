<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $data["index"] = "Product";
        // $data['user'] = Auth::user();
        // $data['address_form'] = view('front.elements.address_form');
        return view('front/product')->with('data',$data);
    }
}
