<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\Facades\GS;
use AliSyria\LDOG\Facades\REC;
use AliSyria\LDOG\GraphStore\ResourceLabel;
use AliSyria\LDOG\PublishingPipeline\Predicate;
use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use AliSyria\LDOG\PublishingPipeline\TermResourceMapping;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use AliSyria\LDOG\Utilities\LdogTypes\TermResourceMatchType;
use App\Actions\ReconciliationAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

/**
 * @property PublishingPipeline $pipeline
 */
class Reconciliation extends Component
{
    public array $mappings=[];
    public string $conversionId='';
    public string $cacheBaseKey='';
    public string $cacheIsInitializedKey='';
    public string $cacheFullMatchKey='';
    public string $cachePartialMatchKey='';

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
        $this->cacheBaseKey="reconciliation.{$this->pipeline->id}";
        $this->cacheIsInitializedKey=$this->cacheBaseKey.".is_initialized";
        $this->cacheFullMatchKey=$this->cacheBaseKey.".full_match";
        $this->cachePartialMatchKey=$this->cacheBaseKey.".partial_match";
    }
    public function initialize()
    {
        if(Cache::get($this->cacheIsInitializedKey))
        {
            return;
        }

        $termResourceMappings=[];
        $partialMatchColumnValues=[];

        $fullMatchType=TermResourceMatchType::find(UriBuilder::PREFIX_CONVERSION.TermResourceMatchType::FullMatch);

        foreach ($predicate=$this->shapeObjectPredicates as $shapeObjectPredicate)
        {
            $columnName=$this->pipeline->getCsvColumnNameForPredicate($shapeObjectPredicate);
            $columnValues=$this->pipeline->getCsvDistinctColumnValues($columnName);
            $resources=$this->shapeObjectPredicateClassResources
                ->where('predicate',$shapeObjectPredicate->uri)
                ->first()
                ->resources;
            foreach ($columnValues as $columnValue)
            {
                $targetResource=$resources->filter(function(ResourceLabel $resourceLabel,$key)use($columnValue){
                    return Str::lower($columnValue)===Str::lower($resourceLabel->label);
                })->first();
                if($targetResource)
                {
                    $termResourceMappings[]=new TermResourceMapping($shapeObjectPredicate->uri,$columnValue,$targetResource->uri,$fullMatchType);
                }
                else
                {
                    $partialMatchColumnValues[]=(object)[
                        'predicate'=>$shapeObjectPredicate->uri,
                        'column_value'=>$columnValue
                    ];
                }
            }
        }
        $this->isInitialized=true;
        Cache::remember($this->cacheIsInitializedKey,3600,fn()=>true);
        Cache::remember($this->cacheFullMatchKey,3600,fn()=>collect($termResourceMappings));
        Cache::remember($this->cachePartialMatchKey,3600,fn()=>collect($partialMatchColumnValues));
    }
    public function resetMappings()
    {
        $mappings=[];
        foreach ($this->predicates as $predicate)
        {
            foreach($this->partialMatchColumnValues->where('predicate',$predicate->uri) as $partialMatchObject)
            {
                $mappings[base64_encode($predicate->uri)][base64_encode($partialMatchObject->column_value)]=null;
            }
        }

        return $mappings;
    }
    public function handle(ReconciliationAction $action)
    {
        $termResourceMappings=$this->extractFullTermResourcesMappings()
            ->merge($this->extractPartialTermResourcesMappings());

        $action->execute($this->pipeline,collect($termResourceMappings));

        return redirect()->route('admin.pipeline.validation',[
            $this->conversionId
        ]);
    }
    private function extractPartialTermResourcesMappings():Collection
    {
        $partialMatchType=TermResourceMatchType::find(UriBuilder::PREFIX_CONVERSION.TermResourceMatchType::PartialMatch);

        $results=[];
        foreach ($this->mappings as $predicate=>$mappings)
        {
            foreach ($mappings as $columnValue=>$resourceUri)
            {
                $results[]=new TermResourceMapping(base64_decode($predicate),base64_decode($columnValue),$resourceUri,$partialMatchType);
            }
        }

        return collect($results);
    }
    private function extractFullTermResourcesMappings():Collection
    {
        return Cache::get($this->cacheFullMatchKey);
    }
    public function getIsInitializedProperty()
    {
        return Cache::get($this->cacheIsInitializedKey);
    }
    public function getPartialMatchColumnValuesProperty()
    {
        return Cache::get($this->cachePartialMatchKey);
    }
    public function search($columnValue,Predicate $predicate):Collection
    {
        $results=REC::search($columnValue,$predicate->objectClassUri);
        if($results->isEmpty())
        {
            $results=$this->shapeObjectPredicateClassResources
                ->where('predicate',$predicate->uri)
                ->first()
                ->resources;
        }

        return $results;
    }
    public function getShapeObjectPredicateClassResourcesProperty():Collection
    {
        return Cache::remember($this->cacheBaseKey."shapeObjectPredicateClassResources",3600,function(){
            $reults=[];
            foreach ($predicate=$this->shapeObjectPredicates as $shapeObjectPredicate)
            {
                $reults[]=(object)[
                    'predicate'=>$shapeObjectPredicate->uri,'resources'=>$this->pipeline->getShapeObjectPredicateClassResources($shapeObjectPredicate)
                ];
            }

            return collect($reults);
        });
    }
    public function getShapeObjectPredicatesProperty()
    {
        return Cache::remember($this->cacheBaseKey."shapeObjectPredicates",3600,function(){
            return $this->pipeline->getShapeObjectPredicates();
        });
    }
    public function getPipelineProperty()
    {
        return PublishingPipeline::make($this->conversionId);
    }
    public function getCsvColumnNamesProperty()
    {
        return Cache::remember($this->cacheBaseKey."csvColumnNames",3600,function(){
            return $this->pipeline->getCsvColumnNames();
        });
    }
    public function getPredicatesProperty()
    {
        return Cache::remember($this->cacheBaseKey."predicates",3600,function(){
            return $this->pipeline->getShapePredicates()->sortBy('order');
        });
    }
    public function render()
    {
        return view('livewire.admin.reconciliation')
            ->layout('admin.layouts.wizard',[
                'step'=>4
            ]);
    }
}
