<div class="embed-responsive aspect-ratio-16/9">
    <div id="{{ $id }}" wire:ignore {{ $attributes }}  class="embed-responsive-item">

    </div>
</div>
@push('body-start')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAmSbgPfqla7UjQjRaMmYOffTh3bL7_vQ"></script>
@endpush

@push('js-scripts')
    <script>
        (function () {
            var latitude={{ $latitude }};
            var longitude={{ $longitude }};
            var center=new google.maps.LatLng(latitude,longitude);
            var marker=new google.maps.Marker({
                position:center
            });
            function initialize() {
                var mapProp = {
                    center:center,
                    zoom:{{  $zoom }},
                    mapTypeId:google.maps.MapTypeId.ROADMAP,
                };

                var map=new google.maps.Map(document.getElementById("{{ $id }}"),mapProp);
                marker.setMap(map);
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        })();
    </script>
@endpush
