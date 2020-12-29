<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\Facades\GS;
use AliSyria\LDOG\ShaclValidator\ShaclValidationReport;
use AliSyria\LDOG\ShapesManager\ShapeManager;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use AliSyria\LDOG\Utilities\LdogTypes\DataDomain;
use AliSyria\LDOG\Utilities\LdogTypes\DataExporterTarget;
use AliSyria\LDOG\Utilities\LdogTypes\ReportExportFrequency;
use App\Actions\StoreDataTemplateAction;
use App\Enums\DataTemplateType;
use App\Enums\Operation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataTemplates extends Component
{
    use WithFileUploads;

    public ?string $title='';
    public ?string $description='';
    public ?string $template_type=null;
    public ?string $data_domain=null;
    public ?string $export_target=null;
    public ?string $report_export_frequency=null;
    public $data_shape=null;
    public $silk_sls=null;

    public $dataShapeUrl=null;
    public $dataShapeFileName=null;
    public $silkSlsUrl=null;
    public $silkSlsFileName=null;

    public ?bool $isModalOpen=false;
    public string $operation=Operation::CREATE;

    public bool $isValidShape=true;
    private ?ShaclValidationReport $validatioReport=null;

    protected $rules=[
        'title'=>['required'],
        'description'=>['required'],
        'template_type'=>['required'],
        'data_domain'=>['required'],
        'export_target'=>['required'],
        'report_export_frequency'=>['required_if:template_type,'.DataTemplateType::DATA_REPORT],
        'data_shape'=>['nullable','file'],
        'silk_sls'=>['nullable','file'],
    ];

    protected $validationAttributes=[
        'title'=>'Title',
        'description'=>'Description',
        'template_type'=>'Template Type',
        'data_domain'=>'Data Domain',
        'export_target'=>'Export Target',
        'report_export_frequency'=>'Export Frequency',
        'data_shape'=>'Data Shape (Shacl-Turtle)',
        'silk_sls'=>'Silk Sls',
    ];

    public function mount()
    {
        $this->resetInputFields();
    }
    public function openModal()
    {
        $this->isModalOpen=true;
    }

    public function updatedDataShape()
    {
        $this->dataShapeUrl="#";
        $this->dataShapeFileName=$this->data_shape->getClientOriginalName();
    }
    public function updatedSilkSls()
    {
        $this->silkSlsUrl="#";
        $this->silkSlsFileName=$this->silk_sls->getClientOriginalName();
    }
    public function updated($propertyName)
    {
        if(is_string($this->$propertyName))
        {
            $this->$propertyName=(string)Str::of($this->$propertyName)->trim();
        }
        $this->validateOnly($propertyName);
    }
    public function create()
    {
        $this->openModal();
        $this->resetInputFields();
        $this->resetValidation();
        $this->operation=Operation::CREATE;
    }
    public function closeModal()
    {
        $this->resetInputFields();
        $this->resetValidation();
        $this->isModalOpen=false;
    }
    private function resetInputFields():void
    {
        $this->reset([
            'title',
            'description',
            'template_type',
            'data_domain',
            'export_target',
            'report_export_frequency',
            'data_shape',
            'silk_sls',
            'dataShapeUrl',
            'dataShapeFileName',
            'silkSlsUrl',
            'silkSlsFileName'
        ]);
    }
    public function isCreateOpertion():bool
    {
        return $this->operation==Operation::CREATE;
    }
    public function store(StoreDataTemplateAction $action)
    {
        $this->isValidShape=true;
        $this->validate();
        $reportExportFrequency=$this->report_export_frequency?ReportExportFrequency::find($this->report_export_frequency):null;
        $shapeFileName=Str::random().'.ttl';
        $shapePath=$this->data_shape->storeAs('shapes',$shapeFileName,'public');
        $shapeFullPath=Storage::disk('public')->path($shapePath);
        $validationReport=ShapeManager::validateShape($shapeFullPath);
        if($validationReport->isConforms())
        {
            $this->isValidShape=true;
        }
        else
        {
            $this->isValidShape=false;
            $this->validatioReport=$validationReport;
            return;
        }
        $action->execute(locale()->organization,DataTemplateType::coerce($this->template_type),$this->title,$this->description,
            DataDomain::find($this->data_domain),DataExporterTarget::find($this->export_target),
            $reportExportFrequency,$shapeFullPath,
            $this->silk_sls);

        $this->resetInputFields();
        $this->resetValidation();
        $this->emit('success',$action->getSuccessMessage());
    }
    public function getDataTemplateTypesProperty()
    {
        return DataTemplateType::asSelectArray();
    }
    public function getDataDomainsProperty()
    {
        return DataDomain::all();
    }
    public function getExportTargetsProperty()
    {
        return locale()->organization->exportTargets();
    }
    public function getReportExportFrequenciesProperty()
    {
        return ReportExportFrequency::all();
    }
    public function getDataTemplatesProperty()
    {
        return locale()->organization->dataTemplates();
    }
    public function getValidationResultReportProperty()
    {
        return $this->validatioReport;
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
        return view('livewire.admin.data-templates')
            ->layout('admin.layouts.app');
    }
}
