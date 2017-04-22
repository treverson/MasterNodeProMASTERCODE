<div class="row bar">
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Total Masternodes</div>
                <div class="bardatadata"><span style="color:#FF8B41">{!! $firstNode['total'] !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Daily ION Earned</div>
                <div class="bardatadata"><span style="color:#1D82AD">{!! number_format($iondaily,'2','.','') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Daily Income</div>
                <div class="bardatadata">$<span>{!! number_format($income['daily'],'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Weekly Income</div>
                <div class="bardatadata">$<span>{!! number_format($income['weekly'],'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Monthly Income</div>
                <div class="bardatadata">$<span>{!! number_format($income['monthly'],'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">ION Price</div>
                <div class="bardatadata">$<span>{!! number_format($price_usd,'2','.',',') !!}</span></div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
