<?php

namespace App;

use App\Models\Expediteur;
use App\Models\Shipper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    protected $table = "users";
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login_at',
        // your other new column
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function lastLogin()
    {
        $lastLoginDate = 'pas encore connecté';
        if ($this->last_login_at != null) {
            $lastLoginDate = $this->last_login_at->diffForHumans();
        }

        return $lastLoginDate;
    }

    /**
     * Get the expediteur associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function expediteur()
    {
        return $this->hasOne(Expediteur::class, 'id_Expediteur', 'id_Expediteur');
    }
}
