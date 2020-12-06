<li class="relative px-3 py-3">
    @if($active)
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
    @endif
    <a
        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        href="{{ $href }}"
    >
        {{ $icon }}
        <span class="ml-4">{{ $title }}</span>
    </a>
</li>
