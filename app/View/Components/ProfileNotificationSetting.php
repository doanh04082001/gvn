<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProfileNotificationSetting extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.profile-notification-setting', [
            'notificationState' => auth()->user()->setting['notification_state'] ?? 0
        ]);
    }
}
