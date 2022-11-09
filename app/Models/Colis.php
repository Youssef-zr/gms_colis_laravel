<?php

namespace App\Models;

use App\Models\Ville;
use App\Models\Statut;
use App\Models\Remarque;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Colis extends Model
{

    public $timestamps = false;
    protected $table = "colis";
    protected $guarded = ["count_mony"];
    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expediteur()
    {
        return $this->hasOne(Expediteur::class, 'id', 'id_expediteur');
    }

    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function livreur()
    {
        return $this->hasOne(User::class, 'id', 'id_livreur');
    }

    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ville()
    {
        return $this->hasOne(Ville::class, 'id', 'id_ville');
    }

    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statut()
    {
        return $this->hasOne(Statut::class, 'id', 'id_statut');
    }

    /**
     * Get the remarque associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function remarque()
    {
        return $this->hasOne(Remarque::class, 'id', 'id_remarques');
    }

    public function getCountMonyAttribute()
    {
        return count(array_filter($this->montant));
    }
}
