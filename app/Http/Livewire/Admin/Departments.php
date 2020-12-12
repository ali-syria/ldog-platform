<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Departments extends Component
{
    public function render()
    {
        return view('livewire.admin.departments')
            ->layout('admin.layouts.app');
    }
}
