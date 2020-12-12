<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class SubmitButton extends Component
{
    public string $liveTarget;
    public string $title;
    public string $processingTitle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $liveTarget,string $title=null,string $processingTitle=null)
    {
        $this->liveTarget=$liveTarget;
        $this->title=$title ?? __j('Submit');
        $this->processingTitle=$processingTitle ?? __j('Processing');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.components.submit-button');
    }
}
