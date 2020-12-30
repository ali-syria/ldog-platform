<?php

namespace App\Actions;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use AliSyria\LDOG\ShaclValidator\ShaclValidationReport;

class ValidationAction
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
    public function execute(PublishingPipeline $pipeline):ShaclValidationReport
    {
        return $pipeline->validate();
    }
}
