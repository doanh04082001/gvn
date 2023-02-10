<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProfileLeftSidebar extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $sidebars = config('menus.profile_sidebar');

        return view('web.components.profile-left-sidebar', compact('sidebars'));
    }
}
