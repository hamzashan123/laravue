<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\UserRole;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasFactory, Notifiable , HasApiTokens ,HasRoles ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //public $timestamps = false;

    protected $fillable = [
        'id',
        'first_name',
        'user_name',
        'last_name',
        'user_id',
        'email',
        'password',
        'contact',
        'address',
        'date_of_birth',
        'country',
        'state',
        'city',
        'status',
        'role_id',
        'avatar',
        'reset_password_code',
        'reset_password_expiry',
        'updated_at',
        'created_at',
    ];

    public function getUserRole() {
        return $this->hasOne(UserRole::class,'id','role_id')
                    ->select('user_role.*');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin()
    {
        if(auth()->user()->hasRole('super-admin'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
