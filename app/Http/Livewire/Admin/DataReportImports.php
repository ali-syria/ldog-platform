<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class DataReportImports extends Component
{
    public function render()
    {
        return view('livewire.admin.data-report-imports')
                    ->layout('admin.layouts.app');
    }
}
