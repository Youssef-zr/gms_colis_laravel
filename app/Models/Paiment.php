<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Paiment extends Model
{
    protected $table = "paiments";
    protected $guarded = [];
    protected $casts = [
        'heure' => 'date:hh:mm',
    ];

    public function getHeureAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('hh:mm');
    }
}
