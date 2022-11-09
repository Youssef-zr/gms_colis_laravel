<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remarque extends Model
{
    public $timestamps = false;
    protected $table = "remarques";
    protected $guarded = [];
}
