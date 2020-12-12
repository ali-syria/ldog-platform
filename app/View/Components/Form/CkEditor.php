<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class CkEditor extends Component
{
    public string $id;
    public string $name;
    public ?string $value;
    public bool $isRtl;
    public string $liveName;
    public bool $withoutErrors;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id,string $name,string $value=null,bool $isRtl=false,string $liveName=null,
                                bool $withoutErrors=false)
    {
        $this->id=$liveName?$liveName:$id ?? $name;
        $this->name=$name;
        $this->value=$value;
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
        return view('components.form.ck-editor');
    }
}
