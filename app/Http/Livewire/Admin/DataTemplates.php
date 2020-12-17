<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\UriBuilder\UriBuilder;
use AliSyria\LDOG\Utilities\LdogTypes\DataDomain;
use AliSyria\LDOG\Utilities\LdogTypes\DataExporterTarget;
use AliSyria\LDOG\Utilities\LdogTypes\ReportExportFrequency;
use App\Actions\StoreDataTemplateAction;
use App\Enums\DataTemplateType;
use App\Enums\Operation;
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
        ]);
    }
    public function isCreateOpertion():bool
    {
        return $this->operation==Operation::CREATE;
    }
    public function store(StoreDataTemplateAction $action)
    {
        $this->validate();
        $uri=null;
        if($this->source==RdfSource::URL)
        {
            $this->uri=$this->url;
        }
        elseif ($this->source==RdfSource::FILE)
        {
            $fileName=Str::random().'.ttl';
            $path=$this->rdf_file->storeAs('ontologies',$fileName,'public');
            $fullPath=Storage::disk('public')->path($path);
            $uri=UriBuilder::convertAbsoluteFilePathToUrl($fullPath);
        }
        elseif ($this->source==RdfSource::TEXT)
        {
            $fileName=Str::random().'.ttl';
            Storage::disk('public')->put('ontologies/'.$fileName,$this->rdf_text);
            $uri=UriBuilder::convertAbsoluteFilePathToUrl(Storage::disk('public')->path('ontologies/'.$fileName));
        }

        $action->execute(
            DataDomain::find($this->data_domain),$this->prefix,$this->namespace,$this->description,$uri
        );

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
        return DataExporterTarget::all();
    }
    public function getReportExportFrequenciesProperty()
    {
        return ReportExportFrequency::all();
    }

    public function render()
    {
        return view('livewire.admin.data-templates')
            ->layout('admin.layouts.app');
    }
}
