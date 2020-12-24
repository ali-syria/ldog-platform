<?php

namespace App\Actions;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use Illuminate\Support\Collection;

class ReconciliationAction
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
    public function execute(PublishingPipeline $pipeline,Collection $termResourceMappings)
    {
        $pipeline->reconcile($termResourceMappings);
    }
}
