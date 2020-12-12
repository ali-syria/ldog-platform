<?php

namespace App\View\Components\Admin\Cards;

use Illuminate\View\Component;

class Count extends Component
{
    public string $title;
    public string $count;
    public string $color;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title,string $count,string $color)
    {
        $this->title=$title;
        $this->count=$count;
        $this->color=$color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.cards.count');
    }
}
