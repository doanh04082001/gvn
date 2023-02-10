<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepository;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class NotificationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

    /**
     * Get notification list
     *
     * @param  array $params
     * @return Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function getMyNotifications(array $params)
    {
        $createdAt = $params['created_at'] ?? null;
        $exceptedIds = $params['excepted_ids'] ?? null;
        $limit = parseItemsPerPage($params['limit'] ?? Notification::LIMIT_ADMIN_ITEMS);

        return $this->buildNotificationsQuery()
            ->when($createdAt, function ($query) use ($createdAt) {
                $query->where('created_at', '<=', $createdAt);
            })
            ->when($exceptedIds, function ($query) use ($exceptedIds) {
                $query->whereNotIn('id', $exceptedIds);
            })
            ->take($limit)
            ->get();
    }

    /**
     * Build notification query of user logined
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function buildNotificationsQuery()
    {
        return auth()->user()->notifications();
    }

    /**
     * Get notifications of user authenticated and return paginnation
     *
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getMyNofiticationsPagingation($limit = Notification::LIMIT_WEB_ITEMS)
    {
        return $this->buildNotificationsQuery()->paginate($limit);
    }

    /**
     * Get recent notifications
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMyRecentNotifications($limit = Notification::LIMIT_DROPDOWN_WEB_ITEMS)
    {
        return $this->buildNotificationsQuery()
            ->limit($limit)
            ->get();
    }
}
