<li
    class="px-2 py-1 transition-colors duration-150 hover:text-blue-600 {{ $active?'text-blue-800':'' }} dark:hover:text-gray-200"
>
    @if($active)
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a class="w-full" href="{{ $href }}">{{ $title }}</a>
</li>
