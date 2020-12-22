<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\Contracts\TemplateBuilder\ReportTemplateContract;
use App\Actions\InitializePublishingPipelineAction;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataImportWizardInitialize extends Component
{
    use WithFileUploads;

    public string $data_template='';
    public $data_csv_file=null;

    public $fileUrl=null;
    public $fileName=null;

    protected $rules=[
        'data_template'=>['required',],
        'data_csv_file'=>['required','file']
    ];
    protected $validationAttributes=[
        'data_template'=>'Data Template',
        'data_csv_file'=>'Data File(CSV)',
    ];

    public function updatedDataCsvFile()
    {
        $this->fileUrl="#";
        $this->fileName=$this->data_csv_file->getClientOriginalName();
    }

    public function handle(InitializePublishingPipelineAction $action)
    {
        $pipeline=$action->execute($this->data_template,$this->data_csv_file);

        return redirect()->route('admin.pipeline.mapColumnsToPredicates',[$pipeline->id]);
    }
    public function getDataTemplatesProperty()
    {
        $templates=[];
        foreach (locale()->organization->dataTemplatesForExport() as $exportTemplate)
        {
            $type="data collection";
            if($exportTemplate instanceof ReportTemplateContract)
            {
                $type="data report";
            }
            $templates[$exportTemplate->uri]=$exportTemplate->label." ($type)";
        }

        return $templates;
    }
    public function render()
    {
        return view('livewire.admin.data-import-wizard-initialize')
            ->layout('admin.layouts.wizard',[
                'step'=>1
            ]);
    }
}
