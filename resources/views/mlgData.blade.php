<script>
    function runit() {
        console.log('{!! json_encode($totalnodeslist) !!}');
        var ctxa = $("#lineChart");
        var myChart = new Chart(ctxa, {
            type: 'line',
            data: {
                labels: [
                    @foreach($totalnodeslist as $value)
                        "@if ($type == "1hour" or $type == "1day") {!! date('h:i a',strtotime($value['created_at'])) !!} @else {!! date('m-d-y',strtotime($value['created_at'])) !!} @endif",
                    @endforeach
                ],
                datasets: [{
                    radius: .25,
                    label: 'activeNodes',
                    data: [
                            @foreach($totalnodeslist as $value)
                        {
                            x: '@if ($type == "1hour" or $type == "1day") {!! date('h:i a',strtotime($value['created_at'])) !!} @else {!! date('m-d-y',strtotime($value['created_at'])) !!} @endif',
                            y: {!! number_format($value['total'],'0','.','') !!}
                        },
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(129, 57, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(129, 57, 192,1)'
                    ],
                    borderWidth: 1
                }, {
                    radius: .25,
                    label: 'Daily (usd)',
                    data: [
                            @foreach($totalnodeslist as $value)
							<?php $datapack = json_decode($value['data'], true); ?>
                        {
                            x: '@if ($type == "1hour" or $type == "1day") {!! date('h:i a',strtotime($value['created_at'])) !!} @else {!! date('m-d-y',strtotime($value['created_at'])) !!} @endif',
                            y: {!! number_format($datapack['incomedaily'],'2','.','') !!}
                        },
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 255, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)'
                    ],
                    borderWidth: 1
                }, {
                    radius: .25,
                    label: 'Weekly (usd)',
                    data: [
                            @foreach($totalnodeslist as $value)
							<?php $datapack = json_decode($value['data'], true); ?>
                        {
                            x: '@if ($type == "1hour" or $type == "1day") {!! date('h:i a',strtotime($value['created_at'])) !!} @else {!! date('m-d-y',strtotime($value['created_at'])) !!} @endif',
                            y: {!! number_format($datapack['incomeweekly'],'2','.','') !!}
                        },
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(0, 222, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(0, 222, 255, 1)'
                    ],
                    borderWidth: 1
                }, {
                    radius: .25,
                    label: 'Monthly (usd)',
                    data: [
                            @foreach($totalnodeslist as $value)
							<?php $datapack = json_decode($value['data'], true); ?>
                        {
                            x: '@if ($type == "1hour" or $type == "1day") {!! date('h:i a',strtotime($value['created_at'])) !!} @else {!! date('m-d-y',strtotime($value['created_at'])) !!} @endif',
                            y: {!! number_format($datapack['incomemonth'],'2','.','') !!}
                        },
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(73, 255, 124, 0.2)'
                    ],
                    borderColor: [
                        'rgba(73, 255, 124, 1)'
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
                                    @if ($type == "1day")
                                        return index % 1 === 0 ? dataLabel : '';
                                    @elseif ($type == "1hour")
                                        return index % 1 === 0 ? dataLabel : '';
                                    @else
                                        return index % 30 === 0 ? dataLabel : '';
                                    @endif
                                }
                            }
                        }
                    ]

                }
            }
        });
    }
    runit();
</script>
