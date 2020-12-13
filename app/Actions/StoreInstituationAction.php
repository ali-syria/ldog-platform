<?php

namespace App\Actions;

use AliSyria\LDOG\Authentication\User;
use AliSyria\LDOG\OrganizationManager\Department;
use AliSyria\LDOG\OrganizationManager\Employee;
use AliSyria\LDOG\OrganizationManager\Institution;
use AliSyria\LDOG\OrganizationManager\Ministry;
use AliSyria\LDOG\OrganizationManager\Organization;

class StoreInstituationAction
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
    public function execute(Ministry $ministry,string $name,string $description,?UploadedFile $logo,
                            string $employeeId,string $employeeName,string $employeeDescription,
                            string $employeeUsername,string $employeePassword):Institution
    {
        $institution=null;
        $logoUrl=asset('img/defaults/organization-logo.png');
        if($logo)
        {
            $logoName=Str::random().'.'.$logo->getClientOriginalExtension();
            $path=$logo->storeAs('organizations/logos',$logoName,'public');
            $logoUrl=Storage::disk('public')->url($path);
        }
        $institution=Institution::create($ministry,$name,$description,$logoUrl);
        $user=User::create($employeeUsername,$employeePassword);
        $employee=Employee::create($institution,$user,$employeeId,$employeeName,$employeeDescription);

        return $institution;
    }

    public function getSuccessMessage():string
    {
        return 'Created successully!';
    }
}
