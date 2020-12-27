<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use AliSyria\LDOG\UriBuilder\UriBuilder;
use App\Actions\GenerateRawRdfAction;
use App\Actions\NormalizationAction;
use Livewire\Component;

class MapColumnsToPredicates extends Component
{
    public string $conversionId='';
    public array $mappings=[];

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
        $this->resetMappings();
    }
    public function resetMappings()
    {
        $mappings=[];
        foreach ($this->predicates as $predicate)
        {
            $mappings[base64_encode($predicate->uri)]=null;
        }

        return $mappings;
    }
    public function rules()
    {
        $rules=[];
        foreach ($this->predicates as $predicate)
        {
            $rules['mappings.'.base64_encode($predicate->uri)]=['required'];
        }

        return $rules;
    }
    public function validationAttributes()
    {
        $attributes=[];
        foreach ($this->predicates as $predicate)
        {
            $attributes['mappings.'.base64_encode($predicate->uri)]=$predicate->name;
        }

        return $attributes;
    }

    public function handle(GenerateRawRdfAction $generateRawRdfAction,NormalizationAction $normalizationAction)
    {
        $this->validate();
        $generateRawRdfAction->execute($this->pipeline,$this->formatMappings($this->mappings));
        $normalizationAction->execute($this->pipeline);

        return redirect()->route('admin.pipeline.normalization',[$this->conversionId]);
    }
    private function formatMappings(array $mappings):array
    {
        $finalMapping=[];
        foreach ($mappings as $predicate=>$columnName)
        {
            $finalMapping[base64_decode($predicate)]=$columnName;
        }
        return $finalMapping;
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
        return view('livewire.admin.map-columns-to-predicates')
            ->layout('admin.layouts.wizard',[
                'step'=>2
            ]);
    }
}
