<?php

namespace App\Models;

use App\Models\Traits\ActiveQuery;
use App\Models\Traits\JWTAuthentication;
use App\Notifications\ResetPasswordNotification;
use Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseAuthentication implements JWTSubject
{
    use HasRoles, ActiveQuery, JWTAuthentication;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'address',
        'password',
        'social_id',
        'social_type'
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
    ];

    /**
     * Check user is superadmin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(Role::SUPER_ADMIN_NAME);
    }

    public function isLeader()
    {
        return $this->hasRole(Role::LEADER);
    }


    /**
     * The stores that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function applyLeaves()
    {
        return $this->hasMany(ApplyLeave::class,'user_id','id');
    }



    /**
     * Once we have the reset token, we are ready to send the message out to this
     * user with a link to reset their password. We will then redirect back to
     * the current URI having nothing set in the session to indicate errors.
     *
     * @param $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The stores that belong to the users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function storesWithInactive()
    {
        return $this->belongsToMany(Store::class);
    }

    /**
     * Can access store.
     *
     * @param  mixed $storeId
     * @return boolean
     */
    public function canAccessStore($storeId)
    {
        return $this->isSuperAdmin() || $this->stores()->whereId($storeId)->exists();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    // public function canDeleteApplyLeave($id)
    // {
    //     $idUser = Auth::user()->getId();
    //     return $idUser === $id ? true : false;
    // }
}
