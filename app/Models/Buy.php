<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Buy extends Model
{
    use Sortable;
    protected $fillable = ['supplier_id', 'supplier_name','product_id', 'name', 'cost_price','quantity','total_cost_price','paid','due' ];
	public $sortable = ['supplier_id', 'supplier_name','product_id', 'name', 'cost_price','quantity','total_cost_price','paid','due'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function products()
    {
        return $this->hasMany('App\Models\BuyProduct');
    }

    public function paids()
    {
        return $this->hasMany('App\Models\BuyPaidAmount');
    }

}
