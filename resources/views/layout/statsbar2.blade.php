<div class="row bar">
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-1"></div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Block Rewards</div>
                <div class="bardatadata">{!! number_format($avgblocks,'2','.',',') !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Reward Freqency</div>
                <div class="bardatadata">{!! number_format($avgrewardfreq,'2','.',',') !!} hours</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Daily Income</div>
                <div class="bardatadata">$<span>{!! number_format($dailyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Weekly Income</div>
                <div class="bardatadata">$<span>{!! number_format($weeklyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">Avg. Monthly Income</div>
                <div class="bardatadata">$<span>{!! number_format($monthlyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-1"></div>
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
                <div class="bardatadata">{!! $block24hour !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avg. Block Time</div>
                <div class="bardatadata">{!! number_format($avgblocktime,'1','.','') !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Masternode Block Reward</div>
                <div class="bardatadata">{!! $blockreward / 2 !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Days Until Reward Drop</div>
                <div class="bardatadata">{!! $daytilldrop !!}</div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">Next MN Block Reward</div>
                <div class="bardatadata">{!! $nextbreward / 2 !!}</div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
