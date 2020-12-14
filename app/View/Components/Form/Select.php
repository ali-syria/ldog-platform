<?php

namespace App\View\Components\Form;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    public string $id;
    public string $name;
    public string $liveName;
    public $items;
    public string $key='id';
    public string $value='name';
    public ?string $selected=null;
    public bool $lazyUpdate;
    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string|null $liveName
     * @param string|null $id
     * @param array|collection $items
     */
    public function __construct(string $name,string $liveName=null,string $id=null,$items,
         string $key='id',string $value='name',string $selected=null,$lazyUpdate=false)
    {
        $this->name=$name;
        $this->liveName=$liveName ?? $name;
        $this->id=$liveName?$liveName:$id ?? $name;
        $this->key=$key;
        $this->value=$value;
        $this->selected=$selected;
        $this->items=$items;
        $this->lazyUpdate=$lazyUpdate;
    }
    public function isSelected($option)
    {
        return $this->selected==$option;
    }
    public function isItemsArray():bool
    {
        return is_array($this->items);
    }
    public function isItemsCollection():bool
    {
        return $this->items instanceof Collection;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
