<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function buys()
    {
        return $this->hasMany('App\Models\Buy');
    }
}
