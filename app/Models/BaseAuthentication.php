<?php

namespace App\Models;

use App\Models\Traits\UsesUuid;
use DongttFd\LaravelUploadModel\Contracts\UploadOnEloquentModel;
use DongttFd\LaravelUploadModel\Eloquent\UploadFileEloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class BaseAuthentication extends Authenticatable implements UploadOnEloquentModel
{
    use HasFactory,
        Notifiable,
        UsesUuid,
        UploadFileEloquent,
        SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get all of the customer's device tokens.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function deviceTokens()
    {
        return $this->morphMany(DeviceToken::class, 'tokenable');
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }

    /**
     * Get the entity's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    /**
     * Get total unread notificaiton
     *
     * @return int
     */
    public function totalUnreadNotifications()
    {
        return $this->unreadNotifications()->count();
    }

    /**
     * Check notification id is My notification
     *
     * @param string $id
     * @return bool
     */
    public function isMyNotification($id)
    {
        return $this->notifications()->whereId($id)->exists();
    }
}
