@extends('layouts.app')

@section('title','Sparql Endpoint')

@push('head')
    <link href="https://unpkg.com/@triply/yasgui/build/yasgui.min.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/@triply/yasgui/build/yasgui.min.js"></script>
    <style>
        .yasgui .autocompleteWrapper {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div id="yasgui"></div>
    <script>
        const yasgui = new Yasgui(document.getElementById("yasgui"), {
            requestConfig: { endpoint: "{{ route('ldog.sparql') }}" },
            copyEndpointOnNewTab: false,
        });
        const yasqe=yasgui.getTab().yasqe;
        yasqe.addPrefixes({ ldog: "{{ \AliSyria\LDOG\UriBuilder\UriBuilder::PREFIX_LDOG }}" });
        yasqe.addPrefixes({ conv: "{{ \AliSyria\LDOG\UriBuilder\UriBuilder::PREFIX_CONVERSION }}" });
    </script>
@endsection


