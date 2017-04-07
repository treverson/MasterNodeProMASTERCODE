@include('layout.header')
</head>
<body>
@include('layout.sidebar')
<div class="container-fluid">
    @include('layout.logo')
    @include('layout.statsbar')
    @include('layout.statsbar2')
    @include('layout.footer')
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    </div>
</div>
@include('layout.analytics')
</body>
</html>
