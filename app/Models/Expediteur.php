<?php

namespace App\Models;

use App\Models\Colis;
use Illuminate\Database\Eloquent\Model;

class Expediteur extends Model
{
    public $timestamps = false;
    protected $table = "Expediteur";
    protected $guarded = [];
    protected $primaryKey = "id_Expediteur";

    /**
     * Get all of the bundels for the Shipper
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colis()
    {
        return $this->hasMany(Colis::class, 'id_Expediteur', 'id_Expediteur');
    }
}
