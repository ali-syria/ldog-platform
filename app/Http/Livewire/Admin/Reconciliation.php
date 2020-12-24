<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use App\Actions\ReconciliationAction;
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
    public function render()
    {
        return view('livewire.admin.reconciliation')
            ->layout('admin.layouts.wizard',[
                'step'=>4
            ]);
    }
}
