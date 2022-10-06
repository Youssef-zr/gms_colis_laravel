<?php

namespace App\Models;

use App\Models\City;
use App\Models\Status;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Bundel extends Model
{

    protected $table = "colis";
    protected $guarded = ["count_mony"];
    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expediteur()
    {
        return $this->hasOne(User::class, 'id', 'id_expediteur');
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
        return $this->hasOne(City::class, 'id', 'id_ville');
    }

    /**
     * Get the user associated with the Bundel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statut()
    {
        return $this->hasOne(Status::class, 'id', 'id_statut');
    }

    public function getCountMonyAttribute()
    {
        return count(array_filter($this->montant));
    }
}
