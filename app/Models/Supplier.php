<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Supplier extends Model
{
    use Sortable;
    protected $fillable = [ 'name', 'gst','phone_nos','address' ];
	public $sortable = ['name', 'gst','phone_nos','address'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function buys()
    {
        return $this->hasMany('App\Models\Buy');
    }

    public function sells()
    {
        return $this->hasMany('App\Models\Sell');
    }
}
