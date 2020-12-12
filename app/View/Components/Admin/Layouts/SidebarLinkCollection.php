<?php

namespace App\View\Components\Admin\Layouts;

use Illuminate\View\Component;

class SidebarLinkCollection extends Component
{
    public string $title;
    public bool $active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title,bool $active=false)
    {
        $this->title=$title;
        $this->active=$active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.layouts.sidebar-link-collection');
    }
}
