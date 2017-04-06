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
        #map {
            height: 300px;
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
        <div class="col-md-3"></div>
        <div class="col-md-6" style="text-align: center;">
            {{--<div class="col-md-6" class="pull-right" style="height:75%">--}}
            <canvas id="lineChart"></canvas>
            {{--</div>--}}
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row middle">
        <div class="col-md-3"></div>
        <div class="col-md-6" style="text-align: center;">
            <ul class="nav nav-pills">
                <li id="90day" role="presentation" class="glist"><a href="#" onclick="loadit('90day')">90 days</a></li>
                <li id="30day" role="presentation" class="glist active"><a href="#" onclick="loadit('30day')">30 days</a></li>
                <li id="1day" role="presentation" class="glist"><a href="#" onclick="loadit('1day')">1 day</a></li>
                <li id="1hour" role="presentation" class="glist"><a href="#" onclick="loadit('1hour')">1 Hour</a></li>
                <li id="trendline" role="presentation" class="glist"><a href="#" onclick="loadit('trendline')">TendLine</a></li>
            </ul>
        </div>
        <div class="col-md-3"></div>
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
    function loadit(type) {
        $('.glist').removeClass('active');
        $('#' + type).addClass('active');
        $('#DataSet').load('{!! route('mlgdata') !!}/?data=' + type);
    }
</script>
<div id="DataSet">
    <script>
        var ctxa = $("#lineChart");
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
    </script>
</div>
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
