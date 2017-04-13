@include('layout.header')
<body>
@include('layout.sidebar')
<div class="container-fluid">
    @include('layout.logo')
    @include('layout.statsbar')
    <div class="row middle">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="text-align: center;">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="col-md-12" class="pull-right">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12" class="pull-left">
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
                            <div class="col-md-12">
                                <div class="col-md-2 text-right" style="color:#1D82AD">{!! $blockstoday !!}</div>
                                <div class="col-md-10">Blocks Today</div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2 text-right" style="color:#1D82AD">{!! number_format($avgblocktime,'1','.','') !!}</div>
                                <div class="col-md-10">Avg. Block time</div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2 text-right" style="color:#1D82AD">{!! $blockreward / 2 !!}</div>
                                <div class="col-md-10">MN Block Reward</div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2 text-right" style="color:#1D82AD">{!! $daytilldrop !!}</div>
                                <div class="col-md-10">Days until Reward Drop</div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2 text-right" style="color:#1D82AD">{!! $nextbreward / 2 !!}</div>
                                <div class="col-md-10">Next MN Block Reward</div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2 text-right" style="color:#1D82AD">{!! number_format($avgrewardfreq,'2','.',',') !!}</div>
                                <div class="col-md-10">hrs Between Rewards</div>
                            </div>
                        </div>
                        <div class="col-md-6 pull-left">
                            <canvas id="barChart"></canvas><br>
                            Block Hit Percentage Per Day last 6 Days
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
@include('layout.doughnutchart')
@include('layout.barchart')
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[4, "desc"]]
        });
    });
</script>
@include('layout.map')
@include('layout.analytics')
</body>
</html>
