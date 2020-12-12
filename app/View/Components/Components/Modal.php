<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public bool $isModalOpen;
    public string $action;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $isModalOpen,string $action)
    {
        $this->isModalOpen=$isModalOpen;
        $this->action=$action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.modal');
    }
}
