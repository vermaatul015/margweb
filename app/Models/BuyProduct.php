<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyProduct extends Model
{
    public function buy()
    {
        return $this->belongsTo('App\Models\Buy');
    }
}
