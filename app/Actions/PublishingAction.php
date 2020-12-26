<?php

namespace App\Actions;

use AliSyria\LDOG\OrganizationManager\Employee;
use AliSyria\LDOG\OrganizationManager\Organization;
use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use Carbon\Carbon;

class PublishingAction
{
    public LinkToOthersAction $linkToOthersAction;
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct(LinkToOthersAction $linkToOthersAction)
    {
        $this->linkToOthersAction=$linkToOthersAction;
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
        $this->linkToOthersAction->execute($pipeline);
    }
}
