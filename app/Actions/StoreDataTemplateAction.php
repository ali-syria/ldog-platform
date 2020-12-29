<?php

namespace App\Actions;

use AliSyria\LDOG\Contracts\OrganizationManager\ModellingOrganizationContract;
use AliSyria\LDOG\ShapesManager\ShapeManager;
use AliSyria\LDOG\TemplateBuilder\DataCollectionTemplate;
use AliSyria\LDOG\TemplateBuilder\ReportTemplate;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use AliSyria\LDOG\Utilities\LdogTypes\DataDomain;
use AliSyria\LDOG\Utilities\LdogTypes\DataExporterTarget;
use AliSyria\LDOG\Utilities\LdogTypes\ReportExportFrequency;
use App\Enums\DataTemplateType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreDataTemplateAction
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
    public function execute(ModellingOrganizationContract $modellingOrganization,
        DataTemplateType $dataTemplateType,string $label, string $description,DataDomain $dataDomain,
        DataExporterTarget $dataExporterTarget,ReportExportFrequency $reportExportFrequency=null,
        string $shapeFullPath,UploadedFile $silkLslSpecsFile=null)
    {
        $shapeUri=UriBuilder::convertAbsoluteFilePathToUrl($shapeFullPath);
        $dataShape=ShapeManager::importFromUrl($shapeUri,$dataDomain,$label);

        $silkLslSpecsString=null;
        if($silkLslSpecsFile)
        {
            $slsFileName=Str::random().'.ttl';
            $slsPath=$silkLslSpecsFile->storeAs('silk-sls',$slsFileName,'public');
            $silkLslSpecsString=Storage::disk('public')->get($slsPath);
        }

        if($dataTemplateType->is(DataTemplateType::DATA_COLLECTION()))
        {
            DataCollectionTemplate::create($label,$label,$description,$dataShape,$modellingOrganization,
                $dataExporterTarget,$dataDomain,$silkLslSpecsString);
        }
        elseif ($dataTemplateType->is(DataTemplateType::DATA_REPORT()))
        {
            ReportTemplate::create($label,$label,$description,$dataShape,$modellingOrganization,
                $dataExporterTarget,$dataDomain,$reportExportFrequency,$silkLslSpecsString);
        }
    }

    public function getSuccessMessage():string
    {
        return 'Created successully!';
    }
}
