<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ request()->getUri() }}</title>
</head>
<body>
    @php
        $results=collect(iterator_to_array($results));
        $label=$results->filter(fn($value)=>$value->property->getUri()=="http://www.w3.org/2000/01/rdf-schema#label")->first();
    @endphp
    @if($label)
        <h2>{{ $label->value->getValue() }}</h2>
    @endif
    <div>
        <div style="width:50%;float: left">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $result)
                    @if(in_array($result->property->getUri(),["http://www.w3.org/2002/07/owl#topObjectProperty","http://www.w3.org/2002/07/owl#topDataProperty"]))
                        @continue
                    @endif
                    <tr>
                        <td>
                            <a href="{{ $result->property->getUri() }}">
                                @if(isset($result->propertyText))
                                    {{ $result->propertyText->getValue() }}
                                @else
                                    {{ $result->property->getUri() }}
                                @endif
                            </a>
                        </td>
                        <td>
                            @if($result->value instanceof \EasyRdf\Resource)
                                <a href="{{ $result->value->getUri() }}">
                                    @if(isset($result->valueText))
                                        {{ $result->valueText->getValue() }}
                                    @else
                                        {{ $result->value->getUri() }}
                                    @endif
                                </a>
                            @else
                                {{ $result->value->getValue() }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="width: 50%;float: left">
            @php
                $latitudeObject=$results->filter(fn($value)=>$value->property->getUri()=="http://www.semanticweb.org/asus/ontologies/2021/0/location#latitude")->first();
                $longitudeObject=$results->filter(fn($value)=>$value->property->getUri()=="http://www.semanticweb.org/asus/ontologies/2021/0/location#longitude")->first();
                $latitude=$latitudeObject?$latitudeObject->value->getValue():null;
                $longitude=$longitudeObject?$longitudeObject->value->getValue():null;
            @endphp

            @if($latitude && $longitude)
                <div class="map_container">
                    <div id="map" class="map_canvas" style="width:600px;height: 350px">

                    </div>
                </div>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAmSbgPfqla7UjQjRaMmYOffTh3bL7_vQ"></script>
                <script>
                    var latitude={{ $latitude }};
                    var longitude={{ $longitude }};
                    var center=new google.maps.LatLng(latitude,longitude);
                    var marker=new google.maps.Marker({
                        position:center
                    });
                    function initialize() {
                        var mapProp = {
                            center:center,
                            zoom:{{ $zoom ?? 15 }},
                            mapTypeId:'hybrid',
                        };

                        var map=new google.maps.Map(document.getElementById("map"),mapProp);
                        marker.setMap(map);
                    }
                    google.maps.event.addDomListener(window, 'load', initialize);
                </script>
            @endif
        </div>
    </div>
</body>
</html>
