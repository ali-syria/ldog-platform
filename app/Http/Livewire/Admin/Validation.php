<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\PublishingPipeline\Predicate;
use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use AliSyria\LDOG\ShaclValidator\ShaclValidationReport;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use App\Actions\ValidationAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use ML\JsonLD\Node;
use ML\JsonLD\TypedValue;

/**
 * @property PublishingPipeline $pipeline
 */
class Validation extends Component
{
    public string $conversionId='';
    public ?bool $hasFailedRecord=null;
    public ?string $correctValue=null;
    public string $cacheBaseKey='';

    public array $resourceProperties=[];
    public ?string $focusNodeUri=null;
    public ?string $errorMessage=null;
    public ?string $failedPredicateUri=null;
    public ?string $failedPredicateValue=null;
    public ?int $occurences=null;

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
        $this->cacheBaseKey="reconciliation.{$this->pipeline->id}";
    }
    public function initialize()
    {
        $this->validateNext();
    }
    public function apply()
    {
        $this->pipeline->updateObjectValue($this->failedResource,$this->failedPredicateUri,$this->failedPredicateValue,$this->correctValue);
        $this->validateNext();
    }
    public function applyAll()
    {
        $this->pipeline->bulkUpdateObjectValues($this->failedPredicateUri,$this->failedPredicateValue,$this->correctValue);
        $this->validateNext();
    }
    private function validateNext()
    {
        $validationReport=app(ValidationAction::class)->execute($this->pipeline);
        if($validationReport->isConforms())
        {
            $this->hasFailedRecord=false;
            $this->correctValue=null;
        }
        else
        {
            $firstRsult=$validationReport->results()->first();
            $this->hasFailedRecord=true;
            $this->focusNodeUri=$firstRsult->getFocusNode();
            $this->errorMessage=$firstRsult->getMessage();
            $this->failedPredicateUri=$firstRsult->getResultPath();
            $this->failedPredicateValue=$firstRsult->getValue();
            $this->correctValue=$firstRsult->getValue();
            $this->occurences=$this->getValueOccurencesCount($this->failedPredicateUri,$this->failedPredicateValue);
        }
    }
    public function handle(ValidationAction $action)
    {
        return redirect()->route('admin.pipeline.publishing',[
            $this->conversionId
        ]);
    }
    public function getFailedResourceProperty()
    {
        $resource=$this->pipeline->getResourceNode($this->focusNodeUri);

        foreach ($resource->getProperties() as $predicate=>$object)
        {
            if($predicate==UriBuilder::PREFIX_RDFS.'label' || $predicate=='@type')
            {
                continue;
            }

            $this->resourceProperties[base64_encode($predicate)]=$this->valueOfObject($object);
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
    public function getValueOccurencesCount(string $predicate,?string $value):int
    {
        return $this->pipeline->getObjectOccurencesCount($predicate,$value);
    }
    public function valueOfObject($object):?string
    {
        if($object instanceof TypedValue)
        {
            return $object->getValue();
        }
        else
        {
            return $object->getId();
        }
    }
    public function render()
    {
        return view('livewire.admin.validation')
            ->layout('admin.layouts.wizard',[
                'step'=>5
            ]);
    }
}
