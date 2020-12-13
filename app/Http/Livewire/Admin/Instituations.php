<?php

namespace App\Http\Livewire\Admin;

use App\Actions\StoreInstituationAction;
use App\Enums\Operation;
use Illuminate\Support\Str;
use Livewire\Component;

class Instituations extends Component
{
    public ?string $name='';
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
    public function store(StoreInstituationAction $action)
    {
        $this->validate();
        $action->execute(
            locale()->organization,$this->name,$this->description,$this->logo,
            $this->employeeId,$this->employeeName,$this->employeeDescription,$this->employeeUsername,
            $this->employeePassword
        );

        $this->resetInputFields();
        $this->resetValidation();
        $this->emit('success',$action->getSuccessMessage());
    }
    public function getInstituationsProperty()
    {
        return locale()->organization->instituations();
    }

    public function render()
    {
        return view('livewire.admin.instituations')
            ->layout('admin.layouts.app');
    }
}
