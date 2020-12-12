<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class File extends Component
{
    public string $liveName;
    public ?string $url;
    public ?string $fileName;
    public ?string $mimeType;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $liveName,?string $url=null,?string $fileName=null,string $mimeType=null)
    {
        $this->liveName=$liveName;
        $this->url=$url;
        $this->mimeType=$mimeType;
        $this->fileName=$fileName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.file');
    }
}
