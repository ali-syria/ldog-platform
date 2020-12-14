<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\Facades\GS;
use AliSyria\LDOG\OntologyManager\OntologyManager;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use AliSyria\LDOG\Utilities\LdogTypes\DataDomain;
use App\Actions\StoreOntologyAction;
use App\Enums\Operation;
use App\Enums\RdfSource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Ontologies extends Component
{
    use WithFileUploads;

    public ?string $data_domain='';
    public ?string $prefix='';
    public ?string $namespace='';
    public ?string $description='';
    public ?string $source='';
    public ?string $url='';
    public ?string $rdf_text='';
    public $rdf_file=null;
    public $fileUrl=null;
    public $fileName=null;

    public ?bool $isModalOpen=false;
    public string $operation=Operation::CREATE;

    protected $rules=[
        'data_domain'=>['required'],
        'prefix'=>['required'],
        'namespace'=>['required'],
        'description'=>['required'],
        'source'=>['required'],
        'url'=>['nullable','url'],
        'rdf_text'=>['nullable',],
        'rdf_file'=>['nullable','file']
    ];

    protected $validationAttributes=[
        'data_domain'=>'Data Domain',
        'prefix'=>'Prefix',
        'namespace'=>'Namespace',
        'description'=>'Description',
        'source'=>'Source',
        'url'=>'Ontology (URL)',
        'rdf_text'=>'Ontology (Turtle Text)',
        'rdf_file'=>'Ontology (Turtle File)',
    ];

    public function mount()
    {
        $this->resetInputFields();
    }
    public function openModal()
    {
        $this->isModalOpen=true;
    }
    public function updatedRdfFile()
    {
        $this->fileUrl="#";
        $this->fileName=$this->rdf_file->getClientOriginalName();
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
            'data_domain',
            'prefix',
            'namespace',
            'description',
            'source',
            'url',
            'rdf_text',
            'rdf_file',
        ]);
    }
    public function isCreateOpertion():bool
    {
        return $this->operation==Operation::CREATE;
    }
    public function store(StoreOntologyAction $action)
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
    public function getOntologiesProperty()
    {
        return OntologyManager::getAll();
    }
    public function getRdfSourcesProperty()
    {
        return RdfSource::asSelectArray();
    }
    public function getDataDomainsProperty()
    {
        return DataDomain::all();
    }
    public function download(string $prefix,string $uri)
    {
        return response()->streamDownload(function()use($prefix,$uri){
            echo GS::getConnection()->fetchNamedGraph($uri,'text/turtle');
        },"$prefix.ttl");
    }

    public function render()
    {
        return view('livewire.admin.ontologies')
            ->layout('admin.layouts.app');
    }
}
