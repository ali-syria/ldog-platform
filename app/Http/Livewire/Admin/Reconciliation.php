<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\Facades\GS;
use AliSyria\LDOG\GraphStore\ResourceLabel;
use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use AliSyria\LDOG\PublishingPipeline\TermResourceMapping;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use AliSyria\LDOG\Utilities\LdogTypes\TermResourceMatchType;
use App\Actions\ReconciliationAction;
use Illuminate\Support\Str;
use Livewire\Component;

/**
 * @property PublishingPipeline $pipeline
 */
class Reconciliation extends Component
{
    public string $conversionId='';

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
    }
    public function handle(ReconciliationAction $action)
    {
        $termResourceMappings=[];
        $fullMatchType=TermResourceMatchType::find(UriBuilder::PREFIX_CONVERSION.TermResourceMatchType::FullMatch);
        foreach ($predicate=$this->shapeObjectPredicates as $shapeObjectPredicate)
        {
            $columnName=$this->pipeline->getCsvColumnNameForPredicate($shapeObjectPredicate);
            $columnValues=$this->pipeline->getCsvDistinctColumnValues($columnName);
            $resources=$this->pipeline->getShapeObjectPredicateClassResources($shapeObjectPredicate);
            foreach ($columnValues as $columnValue)
            {
                $targetResource=$resources->filter(function(ResourceLabel $resourceLabel,$key)use($columnValue){
                    return Str::lower($columnValue)===Str::lower($resourceLabel->label);
                })->first();
                if($targetResource)
                {
                    $termResourceMappings[]=new TermResourceMapping($shapeObjectPredicate->uri,$columnValue,$targetResource->uri,$fullMatchType);
                }
            }
        }
        $action->execute($this->pipeline,collect($termResourceMappings));
        return redirect()->route('admin.pipeline.validation',[
            $this->conversionId
        ]);
    }
    public function getShapeObjectPredicatesProperty()
    {
        return $this->pipeline->getShapeObjectPredicates();
    }
    public function getPipelineProperty()
    {
        return PublishingPipeline::make($this->conversionId);
    }
    public function getCsvColumnNamesProperty()
    {
        return $this->pipeline->getCsvColumnNames();
    }
    public function getPredicatesProperty()
    {
        return $this->pipeline->getShapePredicates()->sortBy('order');
    }
    public function render()
    {
        return view('livewire.admin.reconciliation')
            ->layout('admin.layouts.wizard',[
                'step'=>4
            ]);
    }
}
