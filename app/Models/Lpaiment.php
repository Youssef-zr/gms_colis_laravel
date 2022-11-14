<?php

namespace App\Models;

use App\Models\Colis;
use Illuminate\Database\Eloquent\Model;

class Lpaiment extends Model
{
    public $timestamps = false;
    protected $table = "lpaiement";
    protected $guarded = [];
    protected $primaryKey = "ID_paiement";

    /**
     * Get all of the comments for the Lpaiment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colis()
    {
        return $this->hasMany(Colis::class, 'id_colis', 'id_colis');
    }
}
