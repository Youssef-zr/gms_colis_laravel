<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colis;

class Expediteur extends Model
{
    public $timestamps = false;
    protected $table = "expediteurs";
    protected $guarded = [];

    /**
     * Get all of the bundels for the Shipper
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colis()
    {
        return $this->hasMany(Colis::class, 'id_expediteur', 'id');
    }
}
