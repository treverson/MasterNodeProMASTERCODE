<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ION MasterNodes</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js" integrity="sha256-jYMHiFJgIHHSIyPp1uwI5iv5dYgQZIxaQ4RwnpEeEDQ=" crossorigin="anonymous"></script>
    <!-- Styles -->
    <style>
        #map{
            height: 500px;
            overflow: hidden;
            padding-bottom: 22.25%;
            padding-top: 30px;
            position: relative;
        }

        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: lightblue;
            cursor: pointer;
        }

        body {
            color: #FFFFFF;
            background-color: #041019;
            font-family: 'Roboto', sans-serif;
        }

        .vr {
            width: 1px;
            height: 90px;
            background-color: #fff;
            margin-left: 25px;
            margin-right: 25px;
        }

        .vr2 {
            width: 1px;
            height: 200px;
            background-color: #fff;
        }

        .mybar > div {
            float: left;
        }

        .bardata {
            margin-top: 25px;
        }

        .bardata {
            margin-top: 25px;
        }

        .bardatatitle {
            color: #FFFFFF;
            font-size: 10pt;
            font-weight: 300;
        }

        .bardatadata {
            color: #FFFFFF;
            font-size: 22pt;
            font-weight: 900;
        }

        .bardatadata > span {
            color: #78FEAB;
        }

        .bar {
            margin-top: 50px;
        }

        .middle {
            margin-top: 50px;
        }

        .logo {
            height: 90px;
        }

        .Labels {
            font-weight: 300;
            font-size: 22pt;
        }

        .blockdetails > div {
            margin-top: 5px;
        }

        .blockdetails > div > span {
            font-size: 10pt;
            font-weight: 900;
        }

        .mybar2 > .bardata > .bardatatitle {

        }

        .mybar2 > .bardata > .bardatadata {

        }

        footer {
            position: fixed;
            height: 50px;
            bottom: 0;
            width: 100%;
        }

        .modal {
            color: #000000;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
            <div class="col-md-12" style="text-align: center;">
            <div style="display: inline-block;">
                <a href="/"><img src="/img/ionmasternodes.png" class="logo"></a>
            </div>
        </div>
    </div>
    <div class="row bar">
        <div class="col-md-12" style="text-align: center;">
            <div class="mybar" style="display: inline-block;">
                <div class="bardata">
                    <div class="bardatatitle">TOTAL MASTERNODES</div>
                    <div class="bardatadata">{!! $totalnodes[0]['total'] !!}</div>
                </div>
                <div class="vr">&nbsp;</div>
                <div class="bardata">
                    <div class="bardatatitle">REWARDS DAILY</div>
                    <div class="bardatadata">{!! number_format($block24total,'8','.','') !!}</div>
                </div>
                <div class="vr">&nbsp;</div>
                <div class="bardata">
                    <div class="bardatatitle">24HR BLOCK COUNT</div>
                    <div class="bardatadata">{!! $block24hour !!}</div>
                </div>
                <div class="vr">&nbsp;</div>
                <div class="bardata">
                    <div class="bardatatitle">INCOME DAILY</div>
                    <div class="bardatadata">$<span>{!! number_format($incomedaily,'2','.',',') !!}</span></div>
                </div>
                <div class="vr">&nbsp;</div>
                <div class="bardata">
                    <div class="bardatatitle">INCOME PER MONTH</div>
                    <div class="bardatadata">$<span>{!! number_format($incomemonth,'2','.',',') !!}</span></div>
                </div>
                <div class="vr">&nbsp;</div>
                <div class="bardata">
                    <div class="bardatatitle">PRICE PER ION</div>
                    <div class="bardatadata">$<span>{!! number_format($price_usd,'2','.',',') !!}</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row middle">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="text-align: center;">
                    <div id="map"></div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <footer class="navbar-fixed-bottom" style="text-align: center">
        <div>
            <div class="col-md-6 pull-right">
                Help Make this software Better: <a href="https://github.com/JSponaugle/IONMasterNode">GitHub</a>
            </div>
            <div class="col-md-6">Donate: iqnAhcDqzMuHTotvEUrCCoXBQWCuz7NZ8i</div>
        </div>
    </footer>
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    </div>
</div>
<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(15, 10),
            zoom: 2,
            minZoom: 1,
            disableDefaultUI: true,
            maxWidth: 500,
            styles: [{"featureType": "all", "elementType": "labels.text.fill", "stylers": [{"color": "#ffffff"}, {"weight": "0.20"}, {"lightness": "28"}, {"saturation": "23"}, {"visibility": "off"}]}, {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [{"color": "#494949"}, {"lightness": 13}, {"visibility": "off"}]
            }, {"featureType": "all", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#000000"}]}, {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#144b53"}, {"lightness": 14}, {"weight": 1.4}]
            }, {"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#08304b"}]}, {"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#0c4152"}, {"lightness": 5}]}, {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#000000"}]
            }, {"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#0b434f"}, {"lightness": 25}]}, {"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#000000"}]}, {
                "featureType": "road.arterial",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#0b3d51"}, {"lightness": 16}]
            }, {"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#000000"}]}, {"featureType": "transit", "elementType": "all", "stylers": [{"color": "#146474"}]}, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#021019"}]}]
        });
        setMarkers(map);
    }

    var beaches = [
            @foreach($mnl as $key => $value)
        ['{{$value['addr']}}',{!! $value['ipData']['latitude'] !!},{!! $value['ipData']['longitude'] !!}, @if($value['status'] == "NEW") {!! $key+200 !!} @elseif($value['status'] == "active") {!! $key+100 !!} @else {!! $key !!} @endif, '{{$value['status']}}'],
        @endforeach
    ];

    function setMarkers(map) {
        var shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: 'poly'
        };
        var ACTIVE = {
            url: '/img/masternodepinactive.png',
            scaledSize: new google.maps.Size(30, 40)
        };
        var NEW = {
            url: '/img/masternodepinnew.png',
            scaledSize: new google.maps.Size(30, 40)
        };
        var OFFLINE = {
            url: '/img/masternodepinoffline.png',
            scaledSize: new google.maps.Size(30, 40)
        };
        for (var i = 0; i < beaches.length; i++) {
            var beach = beaches[i];
            if (beach[4] == "ACTIVE") {
                var marker = new google.maps.Marker({
                    position: {lat: beach[1], lng: beach[2]},
                    map: map,
                    icon: ACTIVE,
                    title: beach[0],
                    zIndex: beach[3]
                });
            }
            if (beach[4] == "NEW") {
                var marker = new google.maps.Marker({
                    position: {lat: beach[1], lng: beach[2]},
                    map: map,
                    icon: NEW,
                    title: beach[0],
                    zIndex: beach[3]
                });
            }
            if (beach[4] == "OFFLINE") {
                var marker = new google.maps.Marker({
                    position: {lat: beach[1], lng: beach[2]},
                    map: map,
                    icon: OFFLINE,
                    title: beach[0],
                    zIndex: beach[3]
                });
            }
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    var key = i;
                    clickMe(beaches[key][0]);
                }
            })(marker, i));
        }
    }
    function clickMe(key) {
        $('#mainModal').load('{!! route('nodedetails') !!}/?addr=' + key);
        $('#mainModal').modal('show')
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARlZhGFPC7Wy9s7ywjNZII7JbqiPfGH-E&callback=initMap"
        async defer></script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-74038061-2', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
