<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public string $type;
    public string $id;
    public string $name;
    public bool $isRtl;
    public string $liveName;
    public bool $withoutErrors;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $type='text',string $id=null,string $name,
        bool $isRtl=false,string $liveName=null,bool $withoutErrors=false)
    {
        $this->type=$type;
        $this->id=$liveName?$liveName:$id ?? $name;
        $this->name=$name;
        $this->isRtl=$isRtl;
        $this->liveName=$liveName ?? $name;
        $this->withoutErrors=$withoutErrors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
