<li  :class='{"mr-1":true,"-mb-px":active === @json($id),"{{ $attributes->get('class') }}":true}' wire:ignore>
    <a :class='{"bg-white inline-block py-2 px-4  font-semibold":true,"border-l border-t border-r rounded-t text-blue-700":active === @json($id),"text-blue-500":active !== @json($id),"hover:text-blue-800":true,"{{$class ?? ""}}":true}' href="#" @click='active=@json($id)' >{{ $label }}</a>
</li>

