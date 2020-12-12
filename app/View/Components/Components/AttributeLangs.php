<?php

namespace App\View\Components\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class AttributeLangs extends Component
{
    public Model $model;
    public string $attribute;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Model $model,string $attribute)
    {
        $this->model=$model;
        $this->attribute=$attribute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.attribute-langs');
    }
}
