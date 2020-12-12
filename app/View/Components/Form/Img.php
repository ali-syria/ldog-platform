<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Img extends Component
{
    public string $liveName;
    public ?string $temporaryUrl;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $liveName,string $temporaryUrl=null)
    {
        $this->liveName=$liveName;
        $this->temporaryUrl=$temporaryUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.img');
    }
}
