<?php

namespace App\View\Components\Admin\Layouts;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public string $appName;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->appName=config('app.name');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.layouts.sidebar');
    }
}
