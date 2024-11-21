<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function buys()
    {
        return $this->belongsTo('App\Models\Buy');
    }
}
