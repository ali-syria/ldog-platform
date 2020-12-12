<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class Progress extends Component
{
    public int $percentage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $percentage)
    {
        $this->percentage=$percentage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.progress');
    }
}
