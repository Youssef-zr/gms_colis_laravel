<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    public $timestamps = false;
    protected $table = "journals";
    protected $guarded = [];
}
