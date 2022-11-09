<?php

namespace App\Models;

use App\Models\Colis;
use Illuminate\Database\Eloquent\Model;

class Lpaiment extends Model
{
    public $timestamps = false;
    protected $table = "Lpaiments";
    protected $guarded = [];

    /**
     * Get all of the comments for the Lpaiment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bundels()
    {
        return $this->hasMany(Colis::class, 'id', 'id_colis');
    }
}
