<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Get associated transfer if any.
     */
    public function transfer()
    {
        return $this->hasOne('App\Transfer');
    }
}
