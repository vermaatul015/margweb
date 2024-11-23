<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Buy extends Model
{
    use Sortable;
    protected $fillable = ['supplier_id', 'supplier_name','product_id', 'name', 'cost_price','quantity','total_cost_price','paid','due','selling_price' ];
	public $sortable = ['supplier_id', 'supplier_name','product_id', 'name', 'cost_price','quantity','total_cost_price','paid','due','selling_price'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function sells()
    {
        return $this->hasMany('App\Models\Sell');
    }
}
