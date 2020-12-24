<?php

namespace App\Actions;

use AliSyria\LDOG\OrganizationManager\Employee;
use AliSyria\LDOG\OrganizationManager\Organization;
use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use Carbon\Carbon;

class PublishingAction
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
    public function execute(PublishingPipeline $pipeline,Organization $organization,Employee $employee,
        Carbon $fromDate=null,Carbon $toDate=null)
    {
        $pipeline->publish($organization,$employee,$fromDate,$toDate);
    }
}
