<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyPaidAmount extends Model
{
    public function buy()
    {
        return $this->belongsTo('App\Models\Buy');
    }
}
