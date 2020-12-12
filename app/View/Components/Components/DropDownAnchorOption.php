<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class DropDownAnchorOption extends Component
{
    public string $title;
    public string $href;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title,string $href)
    {
        $this->title=$title;
        $this->href=$href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.drop-down-anchor-option');
    }
}
