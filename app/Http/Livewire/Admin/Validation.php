<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use App\Actions\ValidationAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use ML\JsonLD\TypedValue;

/**
 * @property PublishingPipeline $pipeline
 */
class Validation extends Component
{
    public string $conversionId='';
    public bool $hasFailedRecord=true;
    public string $cacheBaseKey='';

    public array $resourceProperties=[];

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
        $this->cacheBaseKey="reconciliation.{$this->pipeline->id}";
    }
    public function handle(ValidationAction $action)
    {
        dd($action->execute($this->pipeline)->results()->first());
        return redirect()->route('admin.pipeline.publishing',[
            $this->conversionId
        ]);
    }
    public function getFailedResourceProperty()
    {
        $resource=$this->pipeline->getResourceNode('http://health.ldog.test/resoucre/health-facility/35');

        foreach ($resource->getProperties() as $predicate=>$object)
        {
            if($predicate==UriBuilder::PREFIX_RDFS.'label' || $predicate=='@type')
            {
                continue;
            }

            if($object instanceof TypedValue)
            {
                $value=$object->getValue();
            }
            else
            {
                $value=$object->getId();
            }

            $this->resourceProperties[base64_encode($predicate)]=$value;
        }
        return $resource;
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
    public function getFailedResourcesProperty()
    {
        return $this->failedResource ? [$this->failedResource]:[];
    }
    public function getPipelineProperty()
    {
        return PublishingPipeline::make($this->conversionId);
    }
    public function getPredicatesProperty()
    {
        return Cache::remember($this->cacheBaseKey."predicates",3600,function(){
            return $this->pipeline->getShapePredicates()->sortBy('order');
        });
    }
    public function render()
    {
        return view('livewire.admin.validation')
            ->layout('admin.layouts.wizard',[
                'step'=>5
            ]);
    }
}
