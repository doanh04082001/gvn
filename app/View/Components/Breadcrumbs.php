<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * List url
     *
     * @var Collection
     */
    public Collection $menus;

    /**
     * Breadcrumb constructor
     *
     * @param array $menus
     */
    public function __construct($menus = [])
    {
        $this->menus = collect($menus)->prepend(['url' => route('home.index'), 'text' => __('web.home')]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View
     */
    public function render()
    {
        return view('web.components.breadcrumbs', [
            'menuItemHtmls' => $this->renderItemsHtml()
        ]);
    }

    /**
     * Render html of breadcrumb items
     *
     * @return string
     */
    private function renderItemsHtml()
    {
        return $this->menus
            ->map(function ($menu, $index) {
                $class = $index !== $this->menus->count() - 1 ? " " : "active-custom";
                $href = $index !== $this->menus->count() - 1 ? "href=\"{$menu['url']}\"" : '';

                return "<li class={$class} > <a {$href}>{$menu['text']}</a></li>";
            })
            ->join('<li>&nbsp;/&nbsp;</li>');
    }
}
