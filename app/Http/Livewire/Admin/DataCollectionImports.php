<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class DataCollectionImports extends Component
{
    public function render()
    {
        return view('livewire.admin.data-collection-imports')
                ->layout('admin.layouts.app');
    }
}
