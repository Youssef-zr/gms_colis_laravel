<?php

namespace App\Models;

use App\Models\Bundel;
use Illuminate\Database\Eloquent\Model;

class Lpaiment extends Model
{
    protected $table = "Lpaiments";
    protected $guarded = [];

    /**
     * Get all of the comments for the Lpaiment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bundels()
    {
        return $this->hasMany(Bundel::class, 'id', 'id_colis');
    }
}
