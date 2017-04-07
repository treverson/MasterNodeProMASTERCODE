@include('layout.header')
<body>
<div class="container-fluid">
    @include('layout.logo')
    @include('layout.statsbar')
    <div class="row middle">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="text-align: center;">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="col-md-12" class="pull-right">
                        <a class="btn btn-success" href="{!! route('advgraph') !!}">Advanced</a><br>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12" class="pull-left">
                    <a class="btn btn-success" href="{!! route('advmap') !!}">Advanced</a><Br>
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row" style="margin-top: 50px;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="text-align: center;">
            <div class="mybar col-md-12">
                <div class="col-md-5" style="text-align: center;">
                    <div class="Labels col-md-12">BLOCK DETAILS</div>
                    <div class="col-md-12">
                        <div class="col-md-6 pull-left blockdetails" style="text-align: left;">
                            <div style="height: 200px; width: 200px;">
                                <div class="col-md-12"><span>{!! $block24hour !!}</span> Blocks Today</div>
                                <div class="col-md-12"><span>{!! number_format($avgblocktime,'1','.','') !!}</span> Avg. Block time</div>
                                <div class="col-md-12"><span>{!! $mnreward / 2 !!}</span> MN Block Reward</div>
                                <div class="col-md-12"><span>{!! $daytilldrop !!}</span> Days until Reward Split</div>
                            </div>
                        </div>
                        <div class="col-md-6 pull-left">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-2" style="text-align: center;">
                    <div class="vr2" style="display: inline-block;">&nbsp;</div>
                </div>
                <div class="col-md-5" style="text-align: center;">
                    <div class="Labels col-md-12">NODES BY COUNTRY</div>
                    <div class="col-md-12">
						<?php $i = 1; ?>
                        @foreach ($country as $key => $value)
                            @if ($i <= 4)
                                <div class="col-md-3">
                                    <div style="height: 100px; width: 100px;">
                                        <canvas id="do{!! $i !!}Chart" width="400" height="400"></canvas>
                                        <br>
                                        {!! $value['country_name'] !!}
                                    </div>
                                </div>
                            @endif
							<?php $i++; ?>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    @include('layout.footer')
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    </div>
</div>
@include('mlgData',['type' => '30day'])
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[4, "desc"]]
        });
    });
    var ctxb = $("#barChart");
    var ctxd1 = $("#do1Chart");
    var ctxd2 = $("#do2Chart");
    var ctxd3 = $("#do3Chart");
    var ctxd4 = $("#do4Chart");

		<?php $i = 1; ?>
            @foreach ($country as $key => $value)
            @if ($i <= 4)
    var datadc{!! $i !!} = [{!! $value['countb'] !!},{!! $value['count'] !!}];
            @endif
		<?php $i++; ?>
            @endforeach

    var myDoughnutChart = new Chart(ctxd1, {
            type: 'doughnut',
            data: {
                labels: [
                    "Red",
                    "Blue"
                ],
                datasets: [
                    {
                        data: datadc1,
                        backgroundColor: [
                            "#DDDDDC",
                            "#DC2B2E"
                        ],
                        hoverBackgroundColor: [
                            "#DDDDDC",
                            "#DC2B2E"
                        ]
                    }]
            },
            options: {
                cutoutPercentage: 70,
                hover: {
                    animationDuration: 0
                },
                animation: {
                    duration: 1,
                    onComplete: function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        ctx.font = Chart.helpers.fontString(25, 'normal', 'Oswald');
                        ctx.fillStyle = '#FFFFFF';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[1];
                                ctx.fillText(data + '%', bar._model.x, bar._model.y + 15);
                            });
                        });
                    }
                },
                tooltips: {
                    enabled: false
                },
                legend: {
                    display: false
                },
                elements: {
                    arc: {
                        borderWidth: 0
                    }
                },
                scales: {
                    xAxes: [{
                        display: false,
                        categoryPercentage: 1.0,
                        barPercentage: 1.0
                    }], yAxes: [{
                        display: false
                    }]
                }
            }
        });
    var myDoughnutChart = new Chart(ctxd2, {
        type: 'doughnut',
        data: {
            labels: [
                "Red",
                "Blue"
            ],
            datasets: [
                {
                    data: datadc2,
                    backgroundColor: [
                        "#DDDDDC",
                        "#B675FF"
                    ],
                    hoverBackgroundColor: [
                        "#DDDDDC",
                        "#B675FF"
                    ]
                }]
        },
        options: {
            cutoutPercentage: 70,
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                    ctx.font = Chart.helpers.fontString(25, 'normal', 'Oswald');
                    ctx.fillStyle = '#FFFFFF';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[1];
                            ctx.fillText(data + '%', bar._model.x, bar._model.y + 15);
                        });
                    });
                }
            },
            tooltips: {
                enabled: false
            },
            legend: {
                display: false
            },
            elements: {
                arc: {
                    borderWidth: 0
                }
            },
            scales: {
                xAxes: [{
                    display: false,
                    categoryPercentage: 1.0,
                    barPercentage: 1.0
                }], yAxes: [{
                    display: false
                }]
            }
        }
    });
    var myDoughnutChart = new Chart(ctxd3, {
        type: 'doughnut',
        data: {
            labels: [
                "Red",
                "Blue"
            ],
            datasets: [
                {
                    data: datadc3,
                    backgroundColor: [
                        "#DDDDDC",
                        "#51A5DC"
                    ],
                    hoverBackgroundColor: [
                        "#DDDDDC",
                        "#51A5DC"
                    ]
                }]
        },
        options: {
            cutoutPercentage: 70,
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                    ctx.font = Chart.helpers.fontString(25, 'normal', 'Oswald');
                    ctx.fillStyle = '#FFFFFF';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[1];
                            ctx.fillText(data + '%', bar._model.x, bar._model.y + 15);
                        });
                    });
                }
            },
            tooltips: {
                enabled: false
            },
            legend: {
                display: false
            },
            elements: {
                arc: {
                    borderWidth: 0
                }
            },
            scales: {
                xAxes: [{
                    display: false,
                    categoryPercentage: 1.0,
                    barPercentage: 1.0
                }], yAxes: [{
                    display: false
                }]
            }
        }
    });
    var myDoughnutChart = new Chart(ctxd4, {
        type: 'doughnut',
        data: {
            labels: [
                "Red",
                "Blue"
            ],
            datasets: [
                {
                    data: datadc4,
                    backgroundColor: [
                        "#DDDDDC",
                        "#56F3A4"
                    ],
                    hoverBackgroundColor: [
                        "#DDDDDC",
                        "#56F3A4"
                    ]
                }]
        },
        options: {
            cutoutPercentage: 70,
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                    ctx.font = Chart.helpers.fontString(25, 'normal', 'Oswald');
                    ctx.fillStyle = '#FFFFFF';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[1];
                            ctx.fillText(data + '%', bar._model.x, bar._model.y + 15);
                        });
                    });
                }
            },
            tooltips: {
                enabled: false
            },
            legend: {
                display: false
            },
            elements: {
                arc: {
                    borderWidth: 0
                }
            },
            scales: {
                xAxes: [{
                    display: false,
                    categoryPercentage: 1.0,
                    barPercentage: 1.0
                }], yAxes: [{
                    display: false
                }]
            }
        }
    });
    var myBarChart = new Chart(ctxb, {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [
                {
                    backgroundColor: [
                        '#6E20F3',
                        '#4EBDE4',
                        '#6E20F3',
                        '#4EBDE4',
                        '#6E20F3',
                        '#4EBDE4'
                    ],
                    borderColor: [
                        '#6E20F3',
                        '#4EBDE4',
                        '#6E20F3',
                        '#4EBDE4',
                        '#6E20F3',
                        '#4EBDE4'
                    ],
                    borderWidth: 1,
                    data: [
                        @foreach ($blockdetails as $value)
                        {!! $value['percent'] !!},
                        @endforeach
                    ],
                }
            ]
        },
        options: {
            responsive: true,
            hover: {
                animationDuration: 0
            },
            animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', 'Oswald');
                    ctx.fillStyle = '#FFFFFF';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (bar, index) {
                            var data = dataset.data[index];
                            ctx.fillText(data + '%', bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            },
            tooltips: {
                enabled: false
            },
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false,
                    categoryPercentage: 1.0,
                    barPercentage: 1.0
                }], yAxes: [{
                    display: false,
                    ticks: {
                        beginAtZero: true,
                        max: 150
                    }
                }]
            }
        }
    });


    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(15, 10),
            zoom: 1,
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
@include('layout.analytics')
</body>
</html>
