<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class TabLink extends Component
{
    public string $id;
    public string $label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id,string $label)
    {
        $this->id=$id;
        $this->label=$label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.tab-link');
    }
}
