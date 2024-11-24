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
    Route::group(['prefix'=>'buy'],function(){
        Route::any('/',['as' => 'buy_list','uses' => 'BuyController@list']);
        Route::post('add-buy', [ 'as' => 'add-buy', 'uses' => 'BuyController@addBuy']);
        Route::post('edit-buy', [ 'as' => 'edit-buy', 'uses' => 'BuyController@editBuy']);
        Route::post('delete-buy', [ 'as' => 'delete-buy', 'uses' => 'BuyController@deleteBuy']);
    });
    Route::group(['prefix'=>'stock'],function(){
        Route::any('/',['as' => 'stock_list','uses' => 'StockController@list']);
        Route::post('edit-stock', [ 'as' => 'edit-stock', 'uses' => 'StockController@editStock']);
        Route::post('delete-stock', [ 'as' => 'delete-stock', 'uses' => 'StockController@deleteStock']);
    });
    Route::group(['prefix'=>'sell'],function(){
        Route::any('/',['as' => 'sell_list','uses' => 'SellController@list']);
        Route::post('add-sell', [ 'as' => 'add-sell', 'uses' => 'SellController@addSell']);
        Route::post('edit-sell', [ 'as' => 'edit-sell', 'uses' => 'SellController@editSell']);
        Route::post('delete-sell', [ 'as' => 'delete-sell', 'uses' => 'SellController@deleteSell']);
    });
});