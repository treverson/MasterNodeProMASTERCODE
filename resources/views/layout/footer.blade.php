<footer class="navbar-fixed-bottom" style="text-align: center">
    <div>
        <div class="col-md-3 col-xs-12">
            Help Make this software Better: <a href="{!! env('GITHUB') !!}" target="_blank">GitHub</a>
        </div>
        <div class="col-md-3 dateupdated hidden-xs hidden-sm">Data Updated: {!! $lastUpdated !!}</div>
        <div class="col-md-3 col-xs-12">Create a Masternode: <a href="{!! env('MASTERNODE_LINK') !!}" target="_blank">{!! env('MASTERNODE_LINK_NAME') !!}</a></div>
        <div class="col-md-3 col-xs-12">Donate: {!! env('DONATION_ADDRESS') !!}</div>
    </div>
</footer>
