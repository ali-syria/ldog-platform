<?php

namespace App\Actions;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use Spatie\QueueableAction\QueueableAction;

class LinkToOthersAction
{
    use QueueableAction;

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
    public function execute(PublishingPipeline $pipeline)
    {
        $pipeline->linkToOthersDatasets();
    }
}
