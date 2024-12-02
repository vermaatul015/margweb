<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellPaidAmount extends Model
{
    public function sell()
    {
        return $this->belongsTo('App\Models\Sell');
    }
}
