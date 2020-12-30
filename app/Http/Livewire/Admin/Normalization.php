<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use Livewire\Component;

/**
 * @property PublishingPipeline $pipeline
 */
class Normalization extends Component
{
    public string $conversionId='';

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
    }
    public function handle()
    {
        return redirect()->route('admin.pipeline.reconciliation',[
            $this->conversionId
        ]);
    }
    public function getPipelineProperty()
    {
        return PublishingPipeline::make($this->conversionId);
    }
    public function getResourceNodesProperty()
    {
        return $this->pipeline->getResourceNodes();
    }
    public function getPredicatesProperty()
    {
        return $this->pipeline->getShapePredicates()->sortBy('order');
    }
    public function render()
    {
        return view('livewire.admin.normalization')
            ->layout('admin.layouts.wizard',[
                'step'=>3
            ]);
    }
}
