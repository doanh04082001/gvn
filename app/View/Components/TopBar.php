<?php

namespace App\View\Components;

use App\Repositories\Contracts\SettingRepository;
use Illuminate\View\Component;

/**
 * Class TopBar
 *
 * @package App\View\Components
 */
class TopBar extends Component
{
    /**
     * @var SettingRepository
     */
    protected SettingRepository $settingRepository;

    /**
     * TopBar constructor.
     *
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('web.components.top-bar', [
            'contactInfo' => $this->settingRepository->getContact(),
        ]);
    }
}
