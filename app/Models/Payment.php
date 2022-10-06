<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "paiments";
    protected $guarded = [];

    public function getHeureAttribute($value)
    {
        return Carbon::parse($value)->format('H:m');
    }

    /**
     * Get the user associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function livreur()
    {
        return $this->hasOne(User::class, 'id', 'id_livreur');
    }

    /**
     * Get the user associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expediteur()
    {
        return $this->hasOne(User::class, 'id', 'id_expediteur');
    }
}
