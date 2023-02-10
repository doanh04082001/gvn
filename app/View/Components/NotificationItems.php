<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotificationItems extends Component
{
    /**
     * Notification object
     *
     * @var Illuminate\Database\Eloquent\Collection
     */
    public $notifications;

    /**
     * Item on dropdown
     * @var int
     */
    public bool $isDropdown;

    /**
     * Breadcrumb constructor
     *
     * @param array $menus
     */
    public function __construct($notifications, $isDropdown = true)
    {
        $this->notifications = $notifications;
        $this->isDropdown = $isDropdown;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View
     */
    public function render()
    {
        return view('web.components.notification-items');
    }
}
