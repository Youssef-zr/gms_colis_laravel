<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    public $timestamps = false;
    protected $table = "Ville";
    protected $guarded = [];
    protected $primaryKey = "id_ville";
}
