<div>
    <select class="form-select mt-1 block w-full" @if($lazyUpdate) wire:model.lazy @else wire:model.defer @endif="{{ $liveName }}">
        @if($isItemsArray())
            <option value="">Select Option</option>
            @foreach($items as $key=>$text)
                <option value="{{ $key }}">{{ $text }}</option>
            @endforeach
        @else
            <option value="">Select Option</option>
            @foreach($items as $item)
                <option value="{{ $item->$key }}">{{ $item->$value }}</option>
            @endforeach
        @endif
    </select>
    @error($liveName)
    <p class="text-xs text-red-600 px-1">{{ $message }}</p>
    @enderror
</div>
