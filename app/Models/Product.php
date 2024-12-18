<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;
    protected $fillable = ['supplier_id', 'supplier_name', 'name', 'price','hsn' ];
	public $sortable = ['supplier_id', 'supplier_name', 'name', 'price','hsn'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function buys()
    {
        return $this->hasMany('App\Models\Buy');
    }

    public function stocks()
    {
        return $this->hasMany('App\Models\Stock');
    }
}
