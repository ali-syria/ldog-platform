<?php

namespace App\Http\Livewire\Admin;

use AliSyria\LDOG\PublishingPipeline\PublishingPipeline;
use App\Actions\LinkToOthersAction;
use App\Actions\PublishingAction;
use Carbon\Carbon;
use Livewire\Component;

/**
 * @property PublishingPipeline $pipeline
 */
class Publishing extends Component
{
    public string $conversionId='';

    public ?string $fromDate=null;
    public ?string $toDate=null;

    protected $rules=[
        'fromDate'=>['required_with:toDate'],
        'toDate'=>['required_with:fromDate'],
    ];

    protected $validationAttributes=[
        'fromDate'=>'From Date',
        'toDate'=>'To Date',
    ];

    public function mount(string $conversion)
    {
        $this->conversionId=$conversion;
    }
    public function handle(PublishingAction $publishingAction)
    {
        $fromDate=$this->fromDate;
        $toDate=$this->fromDate;

        if(!is_null($fromDate) && !is_null($toDate))
        {
            $fromDate=Carbon::parse($fromDate);
            $toDate=Carbon::parse($toDate);
        }

        $publishingAction->execute($this->pipeline,locale()->organization,locale()->employee,
            $fromDate,$toDate);

    }
    public function link(LinkToOthersAction $linkToOthersAction)
    {
        $linkToOthersAction->execute($this->pipeline);
    }
    public function getPipelineProperty()
    {
        return PublishingPipeline::make($this->conversionId);
    }
    public function render()
    {
        return view('livewire.admin.publishing')
            ->layout('admin.layouts.wizard',[
                'step'=>6
            ]);
    }
}
