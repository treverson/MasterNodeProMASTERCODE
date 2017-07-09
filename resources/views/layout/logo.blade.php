<div class="row"  style="text-align: center;">
    <div class="col-lg-5 col-md-5 hidden-sm hidden-xs"></div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <a href="/"><img src="/img/logo.png" class="logo"></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs"></div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <div class="bardatatitle">{!! strtoupper(env('COIN')) !!} Price</div>
        <div class="bardatadata">$<span class="green">{!! number_format($price_usd,'2','.',',') !!}</span></div>
    </div>
</div>