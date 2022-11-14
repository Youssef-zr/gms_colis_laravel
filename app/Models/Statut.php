<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    public $timestamps = false;
    protected $table = "statut";
    protected $guarded = [];
    protected $primaryKey = "id_statut";
}
