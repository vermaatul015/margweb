<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Stock extends Model
{
    use Sortable;
    protected $fillable = ['product_id','name','cost_price','quantity','selling_price' ];
	public $sortable = ['product_id','name','cost_price','quantity','selling_price'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
