<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Instituations extends Component
{
    public function render()
    {
        return view('livewire.admin.instituations')
            ->layout('admin.layouts.app');
    }
}
