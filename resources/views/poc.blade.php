@extends('layouts.app')

@section('POC - '.$title)
@section('content')
    <div class="mt-12 grid grid-cols-1 md:grid-cols-2 p-2 gap-4">
        <div>
            <div class="prose">
                <h1 style="margin-bottom: 0rem;">{{ $title }}</h1>
                <p style="margin-bottom: 0px;margin-top: 5px;">
                    {{ \Illuminate\Support\Str::limit($areaDesc,150) }} <small>[source: <a>DBpedia</a>]</small>
                </p>
                <b>Population:</b> <span>{{ $areaPopulationTotal }} <small>[source: <a>DBpedia</a>]</small></span>

                <h2 style="margin-bottom: 5px;margin-top: 5px">Health Facilities <small>[source: <a>DHA</a>]</small></h2>
            </div>
            <div class="w-7/12">
                <div class="embed-responsive aspect-ratio-16/9">
                    <div id="map-area" wire:ignore  class="embed-responsive-item">

                    </div>
                </div>
            </div>
            <div class="prose" style="height: 20rem;">
                <h1 style="margin-bottom: 0rem;margin-top: 0.8rem">UAE</h1>
                <h2 style="margin: 5px 0px;margin-bottom: 0px;">Daily: COVID-19 Cases <small>[source: <a>MOHP</a>]</small></h2>
                <livewire:livewire-column-chart
                    :column-chart-model="$columnChartModel"
                />
            </div>
        </div>
        <div>
            <div class="prose">
                <h1 style="margin-bottom: 0rem">{{ $emirate }}</h1>
                <p style="margin-bottom: 0px;margin-top: 5px;">
                    {{ \Illuminate\Support\Str::limit($descriptionEmirate,150) }} <small>[source: <a>DBpedia</a>]</small>
                </p>
                <b>Population:</b> <span>{{ $emiratePopulationTotal }}</span> <small>[source: <a>DBpedia</a>]</small>
                <h2 style="margin-top:15px;margin-bottom: 5px;">Monthly: Percentage Change in Consumer Price Index <br/><small>[source: <a>FCSC</a>]</small></h2>
                <table class="table-auto" style="margin-bottom: 8px">
                    <thead>
                    <tr>
                        @foreach($priceStatistics as $priceStatistic)
                            <th>{{ $priceStatistic['month'] }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($priceStatistics as $priceStatistic)
                            <td>
                                @if($priceStatistic['percentage']<=0)
                                    <x-icons.entypo-triangle-down class="w-6 h-6 text-green-700"/>
                                @else
                                    <x-icons.entypo-triangle-up class="w-6 h-6 text-red-700"/>
                                @endif
                                {{ $priceStatistic['percentage'] }}
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
                <h2 style="margin-top: 0px;margin-bottom: 5px;">Crimes (2007) <small>[source: <a>MOI</a>]</small></h2>
                <table class="table-auto" style="width:65%">
                    @foreach($crimeStatistics as $crimeStatistic)
                    <tr>
                        <td class="bg-gray-200 px-2">{{ $crimeStatistic['type'] }}</td>
                        <td>{{ $crimeStatistic['count'] }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@push('body-start')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAmSbgPfqla7UjQjRaMmYOffTh3bL7_vQ"></script>
@endpush

@push('css-scripts')
    <style>
        svg{
            display: inline;
        }
    </style>
@endpush

@push('js-scripts')
    <script>
        (function () {
            var latitude={{ $areaLatitude }};
            var longitude={{ $areaLongitude }};
            var center=new google.maps.LatLng(latitude,longitude);

            function initialize() {
                var mapProp = {
                    center: center,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                };

                var map = new google.maps.Map(document.getElementById("map-area"), mapProp);

                var infowindow = new google.maps.InfoWindow();

                var marker, i;
                var locations =@json($facilitiesLocations);

                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map
                    });

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        })();
    </script>
@endpush
