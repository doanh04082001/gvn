<?php

namespace App\View\Components;

use App\Repositories\Contracts\SettingRepository;
use Illuminate\View\Component;

/**
 * Class Footer
 *
 * @package App\View\Components
 */
class Footer extends Component
{

    /**
     * @var SettingRepository
     */
    protected SettingRepository $settingRepository;

    /**
     * Footer constructor.
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
    public function render(): \Illuminate\Contracts\View\View
    {

        return view('web.components.footer', [
            'contactInfo' => $this->settingRepository->getContact(),
        ]);
    }
}
