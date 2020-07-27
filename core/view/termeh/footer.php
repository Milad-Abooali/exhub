<!--- Page Footer -->            
    <div id="cb-menu" class="container-fluid cb-blg-6 mb-5 mt-5">
        <div class="container text-secondary" dir="ltr">
            <div class="row cb-endbox">
                <div class="col-md col-sm-12 py-3">
                    <h5>SEO Tools</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= APP_URL ?>seo/keywords">Keywords</a></li>
                        <li><a href="<?= APP_URL ?>seo/fis">Find In Search (FIS)</a></li>
                       </ul>
                </div>
                <div class="col-md col-sm-12 py-3">
                    <h5>IP Table</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= APP_URL ?>ipt/vps">VPS Panel</a></li>
                        <li><a href="<?= APP_URL ?>ipt/rVPS">rVPS Panel</a></li>
                        <li><a href="<?= APP_URL ?>ipt/ips">IP Manager</a></li>
                        <li><a href="<?= APP_URL ?>ipt/networks">Network Manager</a></li>
                        <li><a href="<?= APP_URL ?>ipt/servers">Server Manager</a></li>
                     </ul>
                </div>
                <div class="col-md col-sm-12 py-3">       3      </div>
                <div class="col-md col-sm-12 py-3">
                    <h5>Admin</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= APP_URL ?>admin/users">Users</a></li>
                        <li><a href="<?= APP_URL ?>admin/logs">Logs</a></li>
                        <li>
                            <a class="text-secondary" data-toggle="collapse" href=".cert" role="button" aria-expanded="false" aria-controls="cert">
                                <i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i> More...
                            </a>
                        </li>
                        <li class="collapse cert"><a href="<?= APP_URL ?>">Adminer</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="modal" class="modal fade mt-5" tabindex="-1" role="dialog">
    <div class="modal-dialog mt-5" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> </h5>
                <button type="button" class="close close-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</body></html>