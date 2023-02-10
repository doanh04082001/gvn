<?php

namespace App\View\Components;

use App\Repositories\Contracts\MetaDatumRepository;
use App\Repositories\Contracts\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class MetaTag extends Component
{
    /**
     * @var mixed
     */
    public $meta;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(MetaDatumRepository $metaDatumRepository, Request $request)
    {
        $this->meta = $metaDatumRepository->where('url', $request->path())->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('web.components.meta-tag');
    }
}
