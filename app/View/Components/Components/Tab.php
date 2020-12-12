<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class Tab extends Component
{
    public string $active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $active)
    {
        $this->active=$active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.tab');
    }
}
