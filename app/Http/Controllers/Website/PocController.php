<?php

namespace App\Http\Controllers\Website;

use AliSyria\LDOG\UriBuilder\UriBuilder;
use App\Http\Controllers\Controller;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use BorderCloud\SPARQL\SparqlClient;
use Exception;
use Illuminate\Http\Request;

class PocController extends Controller
{
    public function index()
    {
        $areaURI='http://general.ldog.test/resoucre/area/al-mankhoul';
        $endpoint=route('ldog.sparql');
        $dbpediaEndpoint="https://dbpedia.org/sparql";

        $title=$areaURI;
        $rdfNamespace=UriBuilder::PREFIX_RDF;
        $rdfsNamespace=UriBuilder::PREFIX_RDFS;
        $owlNamespace=UriBuilder::PREFIX_OWL;
        $ldogNamespace=UriBuilder::PREFIX_LDOG;

        $sparqlSharedNamespaces="
            PREFIX rdf: <$rdfNamespace>
            PREFIX rdfs: <$rdfsNamespace>
            PREFIX owl: <$owlNamespace>
            PREFIX dbo: <http://dbpedia.org/ontology/>
            PREFIX loc: <http://www.semanticweb.org/asus/ontologies/2021/0/location#>
            PREFIX con: <http://www.semanticweb.org/asus/ontologies/2021/0/contact-address#>
            PREFIX pos: <http://www.w3.org/2003/01/geo/wgs84_pos#>
            PREFIX hef: <http://www.semanticweb.org/asus/ontologies/2021/0/health-facility#>
            PREFIX cri: <http://www.semanticweb.org/asus/ontologies/2021/4/crime#>
            PREFIX pin: <http://www.semanticweb.org/asus/ontologies/2021/4/price-indices#>
            PREFIX ldog: <$ldogNamespace>
            PREFIX ctype: <http://government.ldog.test/resoucre/crime-type/>
            PREFIX c19s: <http://www.semanticweb.org/asus/ontologies/2021/4/covid-19-statistics#>
        ";
        $sc=new SparqlClient();
        $sc->setEndpointRead('http://localhost:7200/repositories/open');
        $q=$sparqlSharedNamespaces."
            SELECT ?area ?areaPopulationTotal ?areaLatitude ?areaLongitude ?emirate ?sameAsEmirate ?emirateLable
            ?descriptionEmirate ?description ?sameAsArea ?emiratePopulationTotal
            WHERE
            {
                <$areaURI> rdfs:label ?area ;
                           owl:sameAs ?sameAsArea ;
                           loc:belongsToEmirate ?emirate .
                ?emirate rdfs:label ?emirateLable ;
                         owl:sameAs ?sameAsEmirate .

                 SERVICE <$dbpediaEndpoint> {
                    ?sameAsArea rdfs:comment ?description ;
                                pos:lat ?areaLatitude ;
                                pos:long ?areaLongitude ;
                                dbo:populationTotal ?areaPopulationTotal .
                    ?sameAsEmirate rdfs:comment ?descriptionEmirate ;
                                   dbo:populationTotal ?emiratePopulationTotal .

                    FILTER ( lang(?description)='en' && lang(?descriptionEmirate)='en' )
                 }
            }
         ";
        $row=$sc->query($q,'rows')['result']['rows'][0] ?? [];
        $err = $sc->getErrors();
        if ($err) {
            print_r($err);
            throw new Exception(print_r($err, true));
        }

        $title=$row['area'];
        $emirateURI=$row['emirate'];
        $areaDesc=$row['description'];
        $areaPopulationTotal=$row['areaPopulationTotal'];
        $emirate=$row['emirateLable'];
        $descriptionEmirate=$row['descriptionEmirate'];
        $emiratePopulationTotal=$row['emiratePopulationTotal'];
        $areaLatitude=$row['areaLatitude'];
        $areaLongitude=$row['areaLongitude'];

        $q=$sparqlSharedNamespaces."
            SELECT ?facility ?facility_name ?category ?category_name ?telephone ?email ?latitude ?longitude
            WHERE
            {
                ?facility loc:area <$areaURI> ;
                          a hef:HealthFacility ;
                          rdfs:label ?facility_name .
                          OPTIONAL{
                              ?facility hef:category ?category ;
                              loc:latitude ?latitude ;
                              loc:longitude ?longitude .
                              ?category rdfs:label ?category_name .
                          }
                          OPTIONAL{
                              ?facility con:telephone ?telephone ;
                              con:email ?email .
                          }
            }
         ";
        $rows=$sc->query($q,'rows')['result']['rows'] ?? [];
        $err = $sc->getErrors();
        if ($err) {
            print_r($err);
            throw new Exception(print_r($err, true));
        }

        $facilitiesLocations=[];
        foreach ($rows as $row)
        {
            $telephone=data_get($row,'telephone');
            $email=data_get($row,'email');

            $facilitiesLocations[]=[
                "
                    <h2 style='font-size: 15px;margin:3px 0px'>".data_get($row,'facility_name')."</h2>
                    <span>".data_get($row,'category_name')."</span> <br/><br/>
                    <a href='tel:$telephone' style='font-weight: 500;'>$telephone</a> <br/>
                    <a href='mailto:$email' style='font-weight: 500;'>$email</a>
                ",
                data_get($row,'latitude'),
                data_get($row,'longitude'),
            ];
        }

        $crimeTypesRequired="ctype:crimes-against-alcoholic-drinks-law,ctype:crimes-against-immigration-and-passports-law,ctype:crimes-against-the-security-and-interests-of-the-state,ctype:crimes-causing-public-danger,ctype:crimes-against-religious-faith-and-rites,ctype:crimes-against-property,ctype:crimes-against-dangerous-drugs-law";
        $q=$sparqlSharedNamespaces."
            SELECT ?crime_type_name ?count
            WHERE {
                ?report ldog:basedOnTemplate <http://government.ldog.test/template/crime-statistics> ;
                        ldog:publisher <http://organizations.ldog.test/resoucre/institution/police-forces/branch/dubai-police> ;
                        ldog:fromDate \"2007\" .
                GRAPH ?report{
                    ?crime_statistic cri:crimeType ?crime_type ;
                                     cri:count ?count .
                }
                ?crime_type rdfs:label ?crime_type_name .
                FILTER (?crime_type IN ($crimeTypesRequired))
            }
         ";
        $rows=$sc->query($q,'rows')['result']['rows'] ?? [];
        $err = $sc->getErrors();
        if ($err) {
            print_r($err);
            throw new Exception(print_r($err, true));
        }

        $crimeStatistics=[];
        foreach ($rows as $row)
        {
            $crimeStatistics[]=[
                'type'=>data_get($row,'crime_type_name'),
                'count'=>data_get($row,'count'),
            ];
        }


        $q=$sparqlSharedNamespaces."
            SELECT ?month ?percentage
              WHERE {
                ?report ldog:basedOnTemplate <http://government.ldog.test/template/monthly-percentage-change-in-consumer-price-index-by-emirate> ;
                        ldog:publisher <http://organizations.ldog.test/resoucre/independent-agency/the-federal-competitiveness-and-statistics-centre>     ;
                        ldog:fromDate ?month .
                FILTER (?month IN (\"2021-02\",\"2021-01\",\"2020-12\",\"2020-11\",\"2020-10\",\"2020-09\"))
                GRAPH ?report{
                    ?statistic loc:emirate <$emirateURI> ;
                               pin:percentage ?percentage .
                }
              }

            ORDER BY DESC(?month)
         ";
        $rows=$sc->query($q,'rows')['result']['rows'] ?? [];
        $err = $sc->getErrors();
        if ($err) {
            print_r($err);
            throw new Exception(print_r($err, true));
        }

        $priceStatistics=[];
        foreach ($rows as $row)
        {
            $priceStatistics[]=[
                'month'=>data_get($row,'month'),
                'percentage'=>data_get($row,'percentage'),
            ];
        }

        $q=$sparqlSharedNamespaces."
            SELECT ?day ?confirmedCases
              WHERE {
                ?report ldog:basedOnTemplate <http://health.ldog.test/template/covid-19-daily-statistics> ;
                        ldog:publisher <http://organizations.ldog.test/resoucre/ministry/ministry-of-health/department/statistics-and-research-center-src> ;
                        ldog:fromDate ?day .
                FILTER (?day IN (\"2021-05-20\",\"2021-05-19\",\"2021-05-18\",\"2021-05-17\",\"2021-05-16\",\"2021-05-15\",\"2021-05-14\",
                    \"2021-05-13\",\"2021-05-12\",\"2021-05-11\"))
                GRAPH ?report{
                    ?statistic c19s:confirmedCases ?confirmedCases .
                }
              }

            ORDER BY DESC(?day)
         ";
        $rows=$sc->query($q,'rows')['result']['rows'] ?? [];
        $err = $sc->getErrors();
        if ($err) {
            print_r($err);
            throw new Exception(print_r($err, true));
        }
        $columnChartModel =
            (new ColumnChartModel())
                ->setTitle('COVID-19 Daily Cases')->withoutLegend();
        foreach ($rows as $row)
        {
            $columnChartModel->addColumn(data_get($row,'day'),data_get($row,'confirmedCases'),'#90cdf4');
        }

        return view('poc',compact('title','areaDesc','areaLatitude','areaLongitude',
            'areaPopulationTotal','emirate','descriptionEmirate','emiratePopulationTotal','facilitiesLocations',
            'crimeStatistics','priceStatistics','columnChartModel'));
    }
}
