<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class DataImportWizard extends Component
{
    public function render()
    {
        return view('livewire.admin.data-import-wizard')
            ->layout('admin.layouts.app');
    }
}
