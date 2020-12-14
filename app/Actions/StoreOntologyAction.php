<?php

namespace App\Actions;

use AliSyria\LDOG\OntologyManager\OntologyManager;
use AliSyria\LDOG\Utilities\LdogTypes\DataDomain;
use Spatie\QueueableAction\QueueableAction;

class StoreOntologyAction
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
    public function execute(DataDomain $dataDomain,string $prefix,string $namespace,string $description,
                            string $url)
    {
        OntologyManager::importFromUrl($url,$dataDomain,$prefix,$namespace,$description);
    }
    public function getSuccessMessage():string
    {
        return 'Imported successully!';
    }
}
