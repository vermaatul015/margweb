<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
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
