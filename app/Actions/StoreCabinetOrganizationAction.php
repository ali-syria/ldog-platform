<?php

namespace App\Actions;

use AliSyria\LDOG\Authentication\User;
use AliSyria\LDOG\OrganizationManager\Cabinet;
use AliSyria\LDOG\OrganizationManager\CabinetOrganization;
use AliSyria\LDOG\OrganizationManager\Employee;
use AliSyria\LDOG\OrganizationManager\IndependentAgency;
use AliSyria\LDOG\OrganizationManager\Ministry;
use App\Enums\CabinetOrganizationType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class StoreCabinetOrganizationAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Cabinet $cabinet,string $name,string $type,string $description,?UploadedFile $logo,
        string $employeeId,string $employeeName,string $employeeDescription,string $employeeUsername,
        string $employeePassword):CabinetOrganization
    {
        $cabinetOrganization=null;
        $logoUrl=asset('img/defaults/organization-logo.png');
        if($logo)
        {
            $logoName=Str::random().'.'.$logo->getClientOriginalExtension();
            $path=$logo->storeAs('organizations/logos',$logoName,'public');
            $logoUrl=Storage::disk('public')->url($path);
        }
        if(CabinetOrganizationType::MINISTRY()->is($type))
        {
            $cabinetOrganization=Ministry::create($cabinet,$name,$description,$logoUrl);
        }
        elseif (CabinetOrganizationType::INDEPENDENT_AGENCY()->is($type))
        {
            $cabinetOrganization=IndependentAgency::create($cabinet,$name,$description,$logoUrl);
        }
        $user=User::create($employeeUsername,$employeePassword);
        $employee=Employee::create($cabinetOrganization,$user,$employeeId,$employeeName,$employeeDescription);

        return $cabinetOrganization;
    }
    public function getSuccessMessage():string
    {
        return 'Created successully!';
    }
}
