<?php

namespace App\Models;

use App\Consts\UserTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name',
        'type',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'password'
    ];

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
        'phone_verified_at' => 'datetime'
    ];

    public function checkPermissionTo($permission, $guardName = null)
    {
        if( $this->type === UserTypes::SUPER_ADMIN ) {
            return true;
        }

        // for all the other users (mainly sub-admins):
        // check if they have the permission to do what they are doing
        // might throw an exception
        return rescue(function() use($permission) {
            return $this->hasDirectPermission($permission);
        }, false);
    }

    public function isAdmin()
    {
        return in_array(
            $this->type,
            [UserTypes::SUPER_ADMIN, UserTypes::SUB_ADMIN]
        );
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
