<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class SaveButton extends Component
{
    public string $liveTarget;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $liveTarget)
    {
        $this->liveTarget=$liveTarget;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.save-button');
    }
}
