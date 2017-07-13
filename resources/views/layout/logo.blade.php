<div class="row" style="text-align: center;">
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <div class="bardatatitle">{!! strtoupper(env('COIN')) !!} Locked in MasterNodes</div>
            <div class="bardatadata"><span class="green">{!! number_format($firstNode['total'] * env('MASTERNODE_COINS_REQUIRED'),'0','',',') !!}</span></div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <a href="/"><img src="/img/logo.png" class="logo"></a><br>
            <a href="https://masternodes.pro" target="_blank">MasterNodes.pro</a>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <div class="bardatatitle">{!! strtoupper(env('COIN')) !!}->BTC Price</div>
            <div class="bardatadata"><span class="green">{!! number_format($priceListCore['price_btc'],'8','.',',') !!}</span></div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <div class="bardatatitle">{!! strtoupper(env('COIN')) !!}->USD Price</div>
            <div class="bardatadata"><span class="green">{!! number_format($priceListCore['price_usd'],'2','.',',') !!}</span></div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <div class="bardatatitle">{!! strtoupper(env('COIN')) !!}->GBP Price</div>
            <div class="bardatadata"><span class="green">{!! number_format($priceListCore['price_gbp'],'2','.',',') !!}</span></div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <div class="bardatatitle">{!! strtoupper(env('COIN')) !!}->AUD Price</div>
            <div class="bardatadata"><span class="green">{!! number_format($priceListCore['price_aud'],'2','.',',') !!}</span></div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
        <div style="display: inline-block;">
            <div class="bardatatitle">{!! strtoupper(env('COIN')) !!}->CNY Price</div>
            <div class="bardatadata"><span class="green">{!! number_format($priceListCore['price_cny'],'2','.',',') !!}</span></div>
        </div>
    </div>
</div>