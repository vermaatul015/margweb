<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellProduct extends Model
{
    public function sell()
    {
        return $this->belongsTo('App\Models\Sell');
    }

    public function stock()
    {
        return $this->belongsTo('App\Models\Stock');
    }
}
