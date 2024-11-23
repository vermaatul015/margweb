<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['namespace' => 'front'],function(){
    Route::group(['prefix'=>''],function(){
        Route::any('/',['as' => 'supplier_list','uses' => 'SupplierController@list']);
        Route::post('add-supplier', [ 'as' => 'add-supplier', 'uses' => 'SupplierController@addSupplier']);
        Route::post('edit-supplier', [ 'as' => 'edit-supplier', 'uses' => 'SupplierController@editSupplier']);
        Route::post('delete-supplier', [ 'as' => 'delete-supplier', 'uses' => 'SupplierController@deleteSupplier']);
    });
    Route::group(['prefix'=>'product'],function(){
        Route::any('/',['as' => 'product_list','uses' => 'ProductController@list']);
        Route::post('add-product', [ 'as' => 'add-product', 'uses' => 'ProductController@addProduct']);
        Route::post('edit-product', [ 'as' => 'edit-product', 'uses' => 'ProductController@editProduct']);
        Route::post('delete-product', [ 'as' => 'delete-product', 'uses' => 'ProductController@deleteProduct']);
    });
});