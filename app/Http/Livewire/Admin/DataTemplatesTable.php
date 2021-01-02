<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\Facades\GS;
use Livewire\Component;

class DataTemplatesTable extends Component
{
    protected $listeners=[
        'refreshDataTemplates'
    ];

    public function refreshDataTemplates()
    {

    }
    public function getDataTemplatesProperty()
    {
        return locale()->organization->dataTemplates();
    }
    public function downloadShapeFile(string $shapeUri,string $label)
    {
        return response()->streamDownload(function()use($shapeUri){
            echo GS::getConnection()->fetchNamedGraph($shapeUri,'text/turtle');
        },"$label- data shape.ttl");
    }
    public function downloadSlsFile(string $slsSpecs,string $label)
    {
        $slsSpecs=base64_decode($slsSpecs);
        return response()->streamDownload(function()use($slsSpecs){
            echo $slsSpecs;
        },"$label- silk sls.xml");
    }
    public function render()
    {
        return view('livewire.admin.data-templates-table');
    }
}
