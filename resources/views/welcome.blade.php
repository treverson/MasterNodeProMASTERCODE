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
    <link href="/css/custom.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" style="text-align: center;">
            <div style="display: inline-block;">
                <img src="/img/ionmasternodes.png" class="logo">
            </div>
        </div>
    </div>
    <div class="row bar">
        <div class="col-md-12" style="text-align: center;">
            <div class="col-md-1"></div>
            <div class="col-md-10" style="display: inline-block;">
                <div class="col-md-2 bardata">
                    <div class="bardatatitle">TOTAL MASTERNODES</div>
                    <div class="bardatadata">{!! $totalnodes[0]['total'] !!}</div>
                </div>
                <div class="col-md-2 bardata">
                    <div class="bardatatitle">REWARDS DAILY</div>
                    <div class="bardatadata">{!! number_format($block24total,'8','.','') !!}</div>
                </div>
                <div class="col-md-2 bardata">
                    <div class="bardatatitle">24HR BLOCK COUNT</div>
                    <div class="bardatadata">{!! $block24hour !!}</div>
                </div>
                <div class="col-md-2 bardata">
                    <div class="bardatatitle">INCOME DAILY</div>
                    <div class="bardatadata">$<span>{!! number_format($incomedaily,'2','.',',') !!}</span></div>
                </div>
                <div class="col-md-2 bardata">
                    <div class="bardatatitle">INCOME PER MONTH</div>
                    <div class="bardatadata">$<span>{!! number_format($incomemonth,'2','.',',') !!}</span></div>
                </div>
                <div class="col-md-2 bardataend">
                    <div class="bardatatitle">PRICE PER ION</div>
                    <div class="bardatadata">$<span>{!! number_format($price_usd,'2','.',',') !!}</span></div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
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
                            <div style="height: 200px; width: 200px;">
                                <canvas id="barChart" height="200" width="300"></canvas>
                            </div>
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
    <footer class="navbar-fixed-bottom" style="text-align: center">
        <div>
            <div class="col-md-4">
                Help Make this software Better: <a href="https://github.com/JSponaugle/IONMasterNode">GitHub</a>
            </div>
            <div class="col-md-4">Create a Masternode: <a href="https://ionomy.com/masternodes" target="_blank">Ionomy.com</a></div>
            <div class="col-md-4">Donate: iqnAhcDqzMuHTotvEUrCCoXBQWCuz7NZ8i</div>
        </div>
    </footer>
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[4, "desc"]]
        });
    });
    var ctxa = $("#lineChart");
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
    var myChart = new Chart(ctxa, {
        type: 'line',
        data: {
            labels: [
                @foreach($totalnodeslist as $value)
                    "{!! date('m-d-y',strtotime($value['created_at'])) !!}",
                @endforeach
            ],
            datasets: [{
                radius: .25,
                label: 'activeNodes',
                data: [
                        @foreach($totalnodeslist as $value)
                    {
                        x: '{!! date('m-d-y',strtotime($value['created_at'])) !!}',
                        y: {!! number_format($value['total'],'0','.','') !!}
                    },
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 1
            }, {
                radius: .25,
                label: 'Daily (usd)',
                data: [
                        @foreach($totalnodeslist as $value)
						<?php $datapack = json_decode($value['data'], true); ?>
                    {
                        x: '{!! date('m-d-y',strtotime($value['created_at'])) !!}',
                        y: {!! number_format($datapack['incomedaily'],'2','.','') !!}
                    },
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }, {
                radius: .25,
                label: 'Weekly (usd)',
                data: [
                        @foreach($totalnodeslist as $value)
						<?php $datapack = json_decode($value['data'], true); ?>
                    {
                        x: '{!! date('m-d-y',strtotime($value['created_at'])) !!}',
                        y: {!! number_format($datapack['incomeweekly'],'2','.','') !!}
                    },
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }, {
                radius: .25,
                label: 'Monthly (usd)',
                data: [
                        @foreach($totalnodeslist as $value)
						<?php $datapack = json_decode($value['data'], true); ?>
                    {
                        x: '{!! date('m-d-y',strtotime($value['created_at'])) !!}',
                        y: {!! number_format($datapack['incomemonth'],'2','.','') !!}
                    },
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [
                    {
                        display: true,
                        ticks: {
                            callback: function (dataLabel, index) {
                                return index % 30 === 0 ? dataLabel : '';
                            }
                        }
                    }
                ]

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
                    display: false
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
        ['{{$value['addr']}}',{!! $value['ipData']['latitude'] !!},{!! $value['ipData']['longitude'] !!}, {!! $key !!}],
        @endforeach
    ];

    function setMarkers(map) {
        var shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: 'poly'
        };
        var markerimg = {
            url: 'img/masternodepin.png',
            scaledSize: new google.maps.Size(30, 40)
        }
        for (var i = 0; i < beaches.length; i++) {
            var beach = beaches[i];
            var marker = new google.maps.Marker({
                position: {lat: beach[1], lng: beach[2]},
                map: map,
                icon: markerimg,
                title: beach[0],
                zIndex: beach[3]
            });
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
