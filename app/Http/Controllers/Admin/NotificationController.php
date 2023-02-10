<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    public function __construct(
        NotificationRepository $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Get notification list
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'notifications' => $this->notificationRepository
                ->getMyNotifications(
                    $request->only([
                        'created_at',
                        'excepted_ids',
                        'limit',
                    ])
                ),
            'total_unread' => auth()->user()
                ->totalUnreadNotifications(),
        ]);
    }

    /**
     * Mark as read
     *
     * @param  Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Notification $notification)
    {
        if (!auth()->user()->isMyNotification($notification->id)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $notification->markAsRead();

        return response()->json([
            'read_at' => $notification->read_at,
            'total_unread' => auth()->user()
                ->totalUnreadNotifications(),
        ]);
    }

    /**
     * Read all my notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsReadAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['read_at' => now()]);
    }
}
