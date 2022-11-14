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
    protected $primaryKey = 'id_colis';
    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expediteur()
    {
        return $this->hasOne(Expediteur::class, 'id_Expediteur', 'id_Expediteur');
    }

    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function livreur()
    {
        return $this->hasOne(User::class, 'id', 'id_utilisateur');
    }

    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ville()
    {
        return $this->hasOne(Ville::class, 'id_ville', 'id_ville');
    }

    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statut()
    {
        return $this->hasOne(Statut::class, 'id_statut', 'id_statut');
    }

    /**
     * Get the remarque associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function remarque()
    {
        return $this->hasOne(Remarque::class, 'id_remarques', 'id_remarques');
    }

    public function getCountMonyAttribute()
    {
        return count(array_filter($this->montant));
    }
}
