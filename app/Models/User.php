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
    use HasFactory, Notifiable , HasApiTokens ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //public $timestamps = false;

    protected $fillable = [
        'id',
        'firstname',
        'middlename',
        'lastname',
        'userid',
        'email',
        'password',
        'contact',
        'address',
        'dateofbirth',
        'country',
        'state',
        'city',
        'status',
        'roleid',
        'avatar',
        'updated_at',
        'created_at',
    ];

    public function getUserRole() {
        return $this->hasOne(UserRole::class,'id','roleid')
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
/*
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
*/
}
