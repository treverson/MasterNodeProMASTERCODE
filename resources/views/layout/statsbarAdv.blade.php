<div class="row bar">
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-3">
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Total Masternodes</div>
                <div class="bardatadata"><span style="color:#FF8B41">{!! $firstNode['total'] !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Daily ION Earned</div>
                <div class="bardatadata"><span style="color:#1D82AD">{!! number_format($iondaily,'2','.','') !!}</span></div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">ION Price</div>
                <div class="bardatadata">$<span>{!! number_format($price_usd,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-2">
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Daily Income</div>
                <div class="bardatadata">$<span>{!! $income['daily'] !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Weekly Income</div>
                <div class="bardatadata">$<span>{!! $income['weekly'] !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Monthly Income</div>
                <div class="bardatadata">$<span>{!! $income['monthly'] !!}</span></div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">Yearly Income</div>
                <div class="bardatadata">$<span>{!! $income['yearly'] !!}</span></div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-1">
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">24hr Block Count</div>
                <div class="bardatadata"><span style="color:#FF8B41">{!! $block24hour !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Block Time</div>
                <div class="bardatadata"><span style="color:#008080">{!! number_format($avgblocktime,'1','.','') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Masternode Block Award</div>
                <div class="bardatadata"><span style="color:#1D82AD">{!! $blockreward / 2 !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Days to Award Drop</div>
                <div class="bardatadata"><span style="color:#008080">{!! $daytilldrop !!}</span></div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">Next MN Block Award</div>
                <div class="bardatadata"><span style="color:#1D82AD">{!! $nextbreward / 2 !!}</span></div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Daily Awards</div>
                <div class="bardatadata"><span style="color:#1D82AD">{!! number_format($avgblocks,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Award Freqency</div>
                <div class="bardatadata"><span style="color:#008080">{!! number_format($avgrewardfreq,'2','.',',') !!} <span style="font-size:69%;">hrs</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Daily Income</div>
                <div class="bardatadata">$<span>{!! number_format($dailyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Weekly Income</div>
                <div class="bardatadata">$<span>{!! number_format($weeklyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Monthly Income</div>
                <div class="bardatadata">$<span>{!! number_format($monthlyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">Masternode worth</div>
                <div class="bardatadata">$<span>{!! $MasternodeWorth !!}</span></div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
