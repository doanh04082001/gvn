<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repositories\Contracts\NotificationRepository;

class NotificationDropdown extends Component
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $notifications;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notifications = $notificationRepository->getMyRecentNotifications();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.notification-dropdown');
    }
}
