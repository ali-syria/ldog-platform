@php
    $langClasses="";
    if($isRtl)
    {
        $langClasses="rtl";
    }
    $editorID=\Illuminate\Support\Str::replaceArray('.',['-'],$id).'-editor';
    $inputID=\Illuminate\Support\Str::replaceArray('.',['-'],$id).'-input';
@endphp

<div>
    <input type="hidden" id="{{ $inputID }}" wire:model="{{ $liveName }}"  />
    <div wire:ignore class="{{ $langClasses }}">
        <textarea rows="5" name="{{ $name }}" id="{{ $editorID }}" style="direction: rtl">
            {{ data_get($this,$liveName) }}
        </textarea>
    </div>
@unless($withoutErrors)
    @error($liveName)
    <span class="text-xs text-red-600 px-1">{{ $message }}</span>
    @enderror
@endunless
</div>


@push('js-scripts')
    <script>
        ClassicEditor
            .create( document.querySelector( '#{{ $editorID }}' ), {
                toolbar: [ 'heading','|','alignment','bold', 'italic','link','bulletedList','numberedList','undo','redo' ]
            } )
            .then(function (editor) {
                editor.model.document.on('change:data', (e, data) => {
                    arguments.callee.iteration=arguments.callee.iteration || 0;

                    if(!editor.getData() && arguments.callee.iteration==0)
                    {
                        arguments.callee.iteration++;
                        return;
                    }
                    document.getElementById("{{ $inputID }}").value =editor.getData();
                    document.getElementById("{{ $inputID }}").dispatchEvent(new Event('input'));
                   {{--//@this.set('{{ $liveName }}', editor.getData());--}}
                });

                window.livewire.on('refreshEditor',function (data) {
                    editor.setData(_.get(data,'{{ $liveName }}',''));
                });
            })
    </script>
@endpush

@once
@push('js-links')
    <script src="{{ asset('vendor/ckeditor5/build/ckeditor.js') }}"></script>
@endpush

@endonce
