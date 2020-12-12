<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class Img extends Component
{
    public string $smallImage;
    public string $largeImage;
    public ?string $caption;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $smallImage,string $largeImage,string $caption=null)
    {
        $this->smallImage=$smallImage;
        $this->largeImage=$largeImage;
        $this->caption=$caption;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.img');
    }
}
