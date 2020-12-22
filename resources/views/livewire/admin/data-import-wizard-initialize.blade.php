<div>
    @section('title','Batch Data Import Wizard')
    <div class="form-group">
        <span class="text-gray-700 text-xs font-semibold">Data File(CSV)</span>
        <x-form.file live-name="data_csv_file" name="data_csv_file" :url="$fileUrl" :fileName="$fileName" mimeType="text/csv"/>
    </div>
    <div class="form-group w-1/3 mt-3">
        <span class="text-gray-700 text-xs font-semibold">Data Template</span>
        <x-form.select name="data_template" :items="$this->data_templates" required/>
    </div>
    <div class="form-group mt-8">
        <button wire:click="handle" wire:loading.attr="disabled" class="px-4 py-2 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple text-sm" style="background: #047481">
            <div wire:loading.remove wire:target="handle">
                Process
            </div>
            <div wire:loading wire:target="handle">
                Processing ...
            </div>
        </button>
    </div>
</div>
