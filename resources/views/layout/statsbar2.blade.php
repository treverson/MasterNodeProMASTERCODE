<div class="row bar">
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-1">
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Average Blocks</div>
                <div class="bardatadata">{!! number_format($avgblocks,'2','.',',') !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Average Reward Freqency</div>
                <div class="bardatadata">{!! number_format($avgrewardfreq,'2','.',',') !!} hours</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Daily Income Average</div>
                <div class="bardatadata">$<span>{!! number_format($dailyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Weekly Income Average</div>
                <div class="bardatadata">$<span>{!! number_format($weeklyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-2 bardataend">
                <div class="bardatatitle">Monthly Income Average</div>
                <div class="bardatadata">$<span>{!! number_format($monthlyaverage,'2','.',',') !!}</span></div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="display: inline-block;">
            <div class="col-md-3">
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Avgerage Block time</div>
                <div class="bardatadata">{!! number_format($avgblocktime,'1','.','') !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">MasterNode Block Reward</div>
                <div class="bardatadata">{!! $mnreward / 2 !!}</div>
            </div>
            <div class="col-md-2 bardata">
                <div class="bardatatitle">Days until Reward Split</div>
                <div class="bardatadata">{!! $daytilldrop !!}</div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>