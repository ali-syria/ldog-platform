<?php

namespace App\Actions;

use AliSyria\LDOG\Contracts\TemplateBuilder\DataTemplate;
use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use AliSyria\LDOG\TemplateBuilder\DataCollectionTemplate;
use AliSyria\LDOG\TemplateBuilder\ReportTemplate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InitializePublishingPipelineAction
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
    public function execute(string $dataTemplateUri,UploadedFile $dataFile):PublishingPipeline
    {
        $dataTemplate=DataCollectionTemplate::retrieve($dataTemplateUri);
        if(is_null($dataTemplate))
        {
            $dataTemplate=ReportTemplate::retrieve($dataTemplateUri);
        }
        $fileName=Str::random().'.'.$dataFile->getClientOriginalExtension();
        $path=$dataFile->storeAs('data/csv',$fileName,'public');
        $fullPath=Storage::disk('public')->path($path);

        return PublishingPipeline::initiate($dataTemplate,$fullPath);
    }
}
