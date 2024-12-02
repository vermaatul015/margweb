<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Sell extends Model
{
    use Sortable;
    protected $fillable = ['supplier_id','supplier_name','total_selling_price','total_recieved_amount','due' ];
	public $sortable = ['supplier_id','supplier_name','total_selling_price','total_recieved_amount','due'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function products()
    {
        return $this->hasMany('App\Models\SellProduct');
    }

    public function paids()
    {
        return $this->hasMany('App\Models\SellPaidAmount');
    }
}
