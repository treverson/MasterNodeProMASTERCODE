<div class="row bar">
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-2 bardata">
                <div class="bardatatitle">TOTAL MASTERNODES</div>
                <div class="bardatadata">{!! $totalnodes[0]['total'] !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">ION INCOME DAILY</div>
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