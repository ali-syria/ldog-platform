<?php

namespace App\Http\Livewire\Admin;

use App\Actions\StoreCabinetOrganizationAction;
use App\Enums\CabinetOrganizationType;
use App\Enums\Operation;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CabinetOrganizations extends Component
{
    use WithFileUploads;

    public ?string $name='';
    public ?string $type='';
    public ?string $description='';
    public $logo=null;
    public ?string $employeeId='';
    public ?string $employeeName='';
    public ?string $employeeDescription='';
    public ?string $employeeUsername='';
    public ?string $employeePassword='';
    public ?bool $isModalOpen=false;
    public string $operation=Operation::CREATE;

    protected $rules=[
        'name'=>['required'],
        'type'=>['required'],
        'description'=>['required'],
        'logo'=>['nullable','image'],
        'employeeId'=>['required'],
        'employeeName'=>['required'],
        'employeeDescription'=>['required'],
        'employeeUsername'=>['required'],
        'employeePassword'=>['required'],
    ];
    protected $validationAttributes=[
        'name'=>'Name',
        'type'=>'Type',
        'description'=>'Description',
        'logo'=>'Logo',
        'employeeId'=>'Identifier',
        'employeeName'=>'Name',
        'employeeDescription'=>'Description',
        'employeeUsername'=>'Username',
        'employeePassword'=>'Password',
    ];

    public function mount()
    {
        $this->resetInputFields();
    }
    public function openModal()
    {
        $this->isModalOpen=true;
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
            'name',
            'type',
            'description',
            'logo',
            'employeeId',
            'employeeName',
            'employeeDescription',
            'employeeUsername',
            'employeePassword',
        ]);
    }
    public function isCreateOpertion():bool
    {
        return $this->operation==Operation::CREATE;
    }
    public function store(StoreCabinetOrganizationAction $action)
    {
        $this->validate();
        $action->execute(
            locale()->organization,$this->name,$this->type,$this->description,$this->logo,
            $this->employeeId,$this->employeeName,$this->employeeDescription,$this->employeeUsername,
            $this->employeePassword
        );

        $this->resetInputFields();
        $this->resetValidation();
        $this->emit('success',$action->getSuccessMessage());
    }
    public function getCabinetOrganizationTypesProperty()
    {
        return CabinetOrganizationType::asSelectArray();
    }
    public function getOrganizationsProperty()
    {
        return locale()->organization->cabinetOrganizations();
    }
    public function render()
    {
        return view('livewire.admin.cabinet-organizations')
            ->layout('admin.layouts.app');
    }
}
