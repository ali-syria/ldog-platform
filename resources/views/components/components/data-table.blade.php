
<div {{ $attributes->merge(["class"=>"  w-full overflow-hidden rounded-lg shadow-xs bg-white shadow-md"]) }}>
    <table class="mb-2 w-full">
        <thead>
            {{ $head }}
        </thead>
        <tbody class="sortable" data-entityname="{{ $sortableEntityName ?? null }}">
            {{ $body }}
        </tbody>
    </table>
</div>
