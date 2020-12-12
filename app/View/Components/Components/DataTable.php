<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public string $sortableEntityName='';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $sortableEntityName='')
    {
        $this->sortableEntityName=$sortableEntityName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.data-table');
    }
}
