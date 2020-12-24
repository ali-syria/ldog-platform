<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use Livewire\Component;

/**
 * @property PublishingPipeline $pipeline
 */
class Validation extends Component
{
    public string $conversionId='';

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
    }
    public function handle()
    {
        return redirect()->route('admin.pipeline.publishing',[
            $this->conversionId
        ]);
    }
    public function getPipelineProperty()
    {
        return PublishingPipeline::make($this->conversionId);
    }
    public function render()
    {
        return view('livewire.admin.validation')
            ->layout('admin.layouts.wizard',[
                'step'=>5
            ]);
    }
}
