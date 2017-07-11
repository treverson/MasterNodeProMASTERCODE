@include('layout.header')
<body>
@include('layout.sidebar')
<div class="container-fluid">
    @include('layout.logo')
    @include('layout.statsbar')
    <div class="row middle">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="overflow:hidden;">
            <table id="myTable" class="display table table-hover">
                <thead>
                <tr>
                    <th>Status</th>
                    <th>{!! strtoupper(env('COIN')) !!} Address</th>
                    <th>Tag</th>
                    <th>City</th>
                    <th>Region</th>
                    <th>Country</th>
                    <th>{!! strtoupper(env('COIN')) !!} Generated</th>
                </tr>
                </thead>
                @foreach($mnl as $key => $value)
                    <tr onclick="clickMe({!! $key !!})">
                        <td>{!! $value['status'] !!}</td>
                        <td>{!! $value['addr'] !!}</td>
                        <td><kbd>Not Tagged</kbd></td>
                        <td>@if(isset($value['ipData']) && isset($value['ipData']['city'])) {!! $value['ipData']['city'] !!} @endif</td>
                        <td>@if(isset($value['ipData']) && isset($value['ipData']['region_name'])) {!! substr($value['ipData']['region_name'], 0, 15) !!} @endif</td>
                        <td>@if(isset($value['ipData']) && isset($value['ipData']['country_name'])) {!! $value['ipData']['country_name'] !!} @endif</td>
                        <td>{!! $value['total'] !!}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>
    @include('layout.footer')
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[6, "desc"]]
        });
    });
</script>
@include('layout.analytics')
</body>
</html>