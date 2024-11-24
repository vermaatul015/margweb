<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Sell extends Model
{
    use Sortable;
    protected $fillable = ['supplier_id','supplier_name','stock_id','name','selling_price','quantity','total_selling_price','amount_received','due' ];
	public $sortable = ['supplier_id','supplier_name','stock_id','name','selling_price','quantity','total_selling_price','amount_received','due'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function stock()
    {
        return $this->belongsTo('App\Models\Stock');
    }
}
