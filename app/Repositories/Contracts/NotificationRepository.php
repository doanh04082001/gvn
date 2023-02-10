<?php

namespace App\Repositories\Contracts;

use App\Models\Notification;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface NotificationRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface NotificationRepository extends RepositoryInterface
{
    /**
     * Get notification list
     *
     * @param  array $params
     * @return Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function getMyNotifications(array $params);

    /**
     * Get notifications of user authenticated and return paginnation
     *
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getMyNofiticationsPagingation($limit = Notification::LIMIT_WEB_ITEMS);

    /**
     * Get recent notifications
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMyRecentNotifications($limit = Notification::LIMIT_WEB_ITEMS);
}
