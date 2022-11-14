<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    public $timestamps = false;
    protected $table = "Paiement";
    protected $guarded = [];
    protected $primaryKey= "ID_paiement";

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
        return $this->hasOne(User::class, 'id', 'id_utilisateur');
    }

    /**
     * Get the user associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expediteur()
    {
        return $this->hasOne(expediteur::class, 'id_Expediteur', 'id_Expediteur');
    }

    /**
     * Get all of the colis for the Paiement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lpaiement()
    {
        return $this->hasMany(Lpaiment::class, 'ID_paiement', 'ID_paiement');
    }
}
