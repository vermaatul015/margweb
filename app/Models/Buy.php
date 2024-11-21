<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
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
