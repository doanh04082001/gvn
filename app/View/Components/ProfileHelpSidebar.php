<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProfileHelpSidebar extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $sidebars = [
            [
                'route' => 'questions',
                'title' => 'questions',
            ],
            [
                'route' => 'policy',
                'title' => 'policy',
            ],
            [
                'route' => 'regulation',
                'title' => 'regulation',
            ],
            [
                'route' => 'site_map',
                'title' => 'site_map',
            ],
            [
                'route' => 'recruitment',
                'title' => 'recruitment',
            ],
            [
                'route' => 'about_us',
                'title' => 'about_us',
            ],
            [
                'route' => 'order_android',
                'title' => 'order_android',
            ],
            [
                'route' => 'order_ios',
                'title' => 'order_ios',
            ],
            [
                'route' => 'account.help',
                'title' => 'order_web',
            ],
            [
                'route' => 'rules',
                'title' => 'rules',
            ],
            [
                'route' => 'insurrance',
                'title' => 'insurrance',
            ],
            [
                'route' => 'security',
                'title' => 'security',
            ],
            [
                'route' => 'ship',
                'title' => 'ship',
            ],
        ];

        return view('web.components.profile-help-sidebar', compact('sidebars'));
    }
}
