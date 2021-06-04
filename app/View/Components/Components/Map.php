<?php

namespace App\View\Components\Components;

use Illuminate\View\Component;

class Map extends Component
{
    public float $latitude;
    public float $longitude;
    public string $id;
    public int $zoom;
    public bool $withoutImpotGoogle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(float $latitude,float $longitude,string $id='map',int $zoom=15,bool $withoutImpotGoogle=false)
    {
        $this->latitude=$latitude;
        $this->longitude=$longitude;
        $this->id=$id;
        $this->zoom=$zoom;
        $this->withoutImpotGoogle=$withoutImpotGoogle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.components.map');
    }
}
