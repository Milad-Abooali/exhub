<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'IPT > VPS';
    $this->data['PAGE']['head'] = '<script defer src="'.JS.'ipt-vps.js"></script>';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');

?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <h4 class="text-center">
                Add New VPS
            </h4>
            <form id="new-vps" action="ipt/newVPS" class="col-md-12 form-inline justify-content-center my-3">
                IP.Loc:
                <select id="iploc" name="iploc" class="custom-select mx-2" required>
                    <?php foreach ((array) $this->data['ip_loc'] as $loc) { ?>
                        <option value="<?= $loc['country'] ?>"> <?= $loc['country'] ?> </option>
                    <?php } ?>
                </select>
                Plan:
                <select id="plan" name="plan" class="custom-select mx-2" required>

                </select>
                OS:
                <select id="os" name="os" class="custom-select mx-2" required>

                </select>
                <button type="submit" class="btn btn-primary mx-3">Get rVPS</button>

            </form>
        </div>

        <!-- Row List Pending VPS -->
        <div class="card mt-4 py-4 px-1">
            <h4 class="text-center">
                Pending VPS List
            </h4>
            <?php if ($this->data['vps_pending']) : ?>
            <table id="list-vps" class="table table-striped table-hover table-sm table-DT" >
                <thead>
                <tr>
                    <th>Status</th>
                    <th>IP</th>
                    <th>OS</th>
                    <th>Server</th>
                    <th>Plan</th>
                    <th>Note</th>
                    <th>Owner</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ((array) $this->data['vps_pending'] as $item) { ?>
                    <tr id="item-<?= $item['id']; ?>">
                        <td id="status-<?= $item['id']; ?>" class="bg-<?= $this->data['status_color'][$item['status']] ?>"><?= $this->data['status_text'][$item['status']] ?></td>
                        <td><i title="<?= $item['ip']['country'] ?>" class="cb-flag cbf-<?= $item['ip']['flag'] ?>" data-toggle="tooltip" data-placement="left"></i> <?= $item['ip']['ip'] ?></td>
                        <td>
                            <i title="<?= $item['os']['type'].' | '.$item['os']['name'].' '.$item['os']['version'] ?>"  data-toggle="tooltip" data-placement="left" class="fa fa-<?= $item['os']['type_ico'] ?>"></i>
                        </td>
                        <td>
                            <i title="<?= $item['server']['country'] ?>" class="cb-flag cbf-<?= $item['server']['flag'] ?>" data-toggle="tooltip" data-placement="left"></i>
                            <strong class="text-primary"><?= $item['server']['nid'] ?></strong>
                        </td>
                        <td><small class="text-muted"><?= $item['plan']['plan_name'] ?></small></td>
                        <td>
                            <?php if ($item['note']) { ?>
                                 <button class="btn btn-outline-dark btn-xs" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $item['note'] ?>">Show</button>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($item['owner']) { ?>
                                <button class="btn btn-outline-dark btn-xs" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $item['service_id'] ?>"><?= $item['owner'] ?></button>
                            <?php } ?>
                        </td>
                        <td>
                            <button data-vps="<?= $item['id']; ?>" class="btn btn-outline-info btn-sm btn-block float-left doA-manageVPS"> Load VPS</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php else: ?>
                No Pending VPS.
            <?php endif; ?>
        </div>


        <!-- Row List VPS by Server -->
        <div class="card mt-4 py-4 px-1">
            <h4 class="text-center">
                VPS List
            </h4>
            <form id="vps-filter" action="ipt/filterVPS" class="col-md-12 form-inline justify-content-center float-right">
                <small> Host </small>
                <select id="host-list" name="host-list" class="btn btn-light mx-2 text-primary">
                    <option disabled selected> Select Host </option>
                    <option value="0"> Show All </option>
                    <?php foreach ((array) $this->data['servers'] as $server) { ?>
                        <option value="<?= $server['nid'] ?>"> <?= $server['nid'] ?> </option>
                    <?php } ?>
                </select>
                <small> Loc </small>
                <select id="loc-list" name="loc-list" class="btn btn-light mx-2 text-primary">

                </select>
                <button type="submit" class="btn btn-outline-secondary mx-3">Filter List</button>
            </form>
            <?php if ($this->data['vps_pending']) : ?>
                <table id="list-vps" class="table table-striped table-hover table-sm table-DT" >
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>IP</th>
                        <th>OS</th>
                        <th>Server</th>
                        <th>Plan</th>
                        <th>Note</th>
                        <th>Owner</th>
                        <th>Manage</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ((array) $this->data['vps_pending'] as $item) { ?>
                        <tr id="item-<?= $item['id']; ?>">
                            <td id="status-<?= $item['id']; ?>" class="bg-<?= $this->data['status_color'][$item['status']] ?>"><?= $this->data['status_text'][$item['status']] ?></td>
                            <td><i title="<?= $item['ip']['country'] ?>" class="cb-flag cbf-<?= $item['ip']['flag'] ?>" data-toggle="tooltip" data-placement="left"></i> <?= $item['ip']['ip'] ?></td>
                            <td>
                                <i title="<?= $item['os']['type'].' | '.$item['os']['name'].' '.$item['os']['version'] ?>"  data-toggle="tooltip" data-placement="left" class="fa fa-<?= $item['os']['type_ico'] ?>"></i>
                            </td>
                            <td>
                                <i title="<?= $item['server']['country'] ?>" class="cb-flag cbf-<?= $item['server']['flag'] ?>" data-toggle="tooltip" data-placement="left"></i>
                                <strong class="text-primary"><?= $item['server']['nid'] ?></strong>
                            </td>
                            <td><small class="text-muted"><?= $item['plan']['plan_name'] ?></small></td>
                            <td>
                                <?php if ($item['note']) { ?>
                                    <button class="btn btn-outline-dark btn-xs" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $item['note'] ?>">Show</button>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($item['owner']) { ?>
                                    <button class="btn btn-outline-dark btn-xs" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $item['service_id'] ?>"><?= $item['owner'] ?></button>
                                <?php } ?>
                            </td>
                            <td>
                                <button data-vps="<?= $item['id']; ?>" class="btn btn-outline-info btn-sm btn-block float-left doA-manageVPS"> Load VPS</button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php else: ?>
                No Pending VPS.
            <?php endif; ?>
        </div>

        <div id="modal-main" class="modal fade mt-5" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close close-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div id="tabs">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">VPS</a></li>
                                    <li class="nav-item"><a class="nav-link text-secondary"  href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Hardware</a></li>
                                    <li class="nav-item"><a class="nav-link text-secondary"  href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Network</a></li>
                                    <li class="nav-item"><a class="nav-link text-secondary"  href="#tab-4" role="tab" aria-controls="tab-4" aria-selected="false">Password</a></li>
                                    <li class="nav-item"><a class="nav-link text-secondary"  href="#tab-5" role="tab" aria-controls="tab-5" aria-selected="false">WHMCS</a></li>
                                </ul>
                                <div id="vps-ribbon" class="row p-3 d-none">
                                    <div class="col-md-10">
                                        Plan:
                                        <span id="vps-plan" class="cb-copy-html rounded px-2 mr-2 badge-primary"></span>
                                        IP:
                                        <i id="vps-ip-flag" title=" " class="cb-flag"></i>
                                        <span id="vps-ip" class="cb-copy-html rounded px-2 mr-2 text-primary"></span>
                                        OS:
                                        <small id="vps-os" class="cb-copy-html rounded px-2 mr-2 text-success"></small>
                                        Status:
                                        <small id="vps-status" class=""></small>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button data-rel="vps" class="do-fine btn btn-outline-success btn-xs btn-block"><i class="fa fa-play"></i> Power ON</button>
                                        <button data-rel="vps" class="do-fine btn btn-outline-info btn-xs btn-block"><i class="fa fa-refresh"></i> Restart</button>
                                        <button data-rel="vps" class="do-fine btn btn-outline-danger btn-xs btn-block"><i class="fa fa-pause"></i> Susspend</button>
                                        <button data-rel="vps" class="do-fine btn btn-outline-dark btn-xs btn-block"><i class="fa fa-stop"></i> Power OFF</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-1" role="tabpanel">
                                        <div class="row">

                                            <div id="check-planr" class="col-md-12 mb-3 h5"> </div>
                                            <div class="col-md-12 mb-3">
                                                Plan:
                                                <span id="check-plan" class="cb-copy-html rounded px-2 mr-2 badge-primary"></span>
                                                IP:
                                                <i id="check-ip-flag" title=" " class="cb-flag"></i>
                                                <span id="check-ip" class="cb-copy-html rounded px-2 mr-2 badge-success"></span>
                                                OS:
                                                <small id="check-os" class="cb-copy-html rounded px-2 mr-2 badge-warning"></small>

                                                Status:
                                                <small id="check-status" class=""></small>
                                                <button id="doA-select-rvps" class="btn btn-sm btn-dark float-right">Select</button>
                                                <hr>
                                            </div>

                                            <div id="planR-O" class="row mb-3 px-1">
                                                <div id="oplan" class="col-md-5 float-left">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h4 class="plan-name panel-title text-primary text-center text-uppercase cb-copy-html"> </h4>
                                                                    <div class="list-group list-group">
                                                                        <span class="list-group-item">Ram: <strong class="ram float-right cb-copy-html"> </strong></span>
                                                                        <span class="list-group-item">CPU Core: <strong class="cpu float-right cb-copy-html"> </strong></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="list-group list-group">
                                                                        <span class="list-group-item">HDD: <strong class="hdd float-right cb-copy-html"> </strong></span>
                                                                        <span class="list-group-item">SSD: <strong class="ssd float-right cb-copy-html"> </strong></span>
                                                                        <span class="list-group-item">NVMe: <strong class="nvme float-right cb-copy-html"> </strong></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 border border-warning my-2">
                                                                    <div class="row">
                                                                        <span class="col bg-warning">Limits: </span>
                                                                        <span class="col text-center">RAM: <strong class="ram_limit text-danger cb-copy-html"> </strong></span>
                                                                        <span class="col text-center">CPU: <strong class="cpu_limit text-danger cb-copy-html"> </strong></span>
                                                                        <span class="col text-center">DISK: <strong class="disk_limit text-danger cb-copy-html"> </strong></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 float-left text-center pt-5">
                                                    Plan Change<br>
                                                    <i class="fa fa-arrow-right fa-3x"></i>
                                                </div>
                                                <div id="rplan" class="col-md-5 float-right">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h4 class="plan-name panel-title text-primary text-center text-uppercase cb-copy-html"> </h4>
                                                                    <div class="list-group list-group">
                                                                        <span class="list-group-item">Ram: <strong class="ram float-right cb-copy-html"> </strong></span>
                                                                        <span class="list-group-item">CPU Core: <strong class="cpu float-right cb-copy-html"> </strong></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="list-group list-group">
                                                                        <span class="list-group-item">HDD: <strong class="hdd float-right cb-copy-html"> </strong></span>
                                                                        <span class="list-group-item">SSD: <strong class="ssd float-right cb-copy-html"> </strong></span>
                                                                        <span class="list-group-item">NVMe: <strong class="nvme float-right cb-copy-html"> </strong></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 border border-warning my-2">
                                                                    <div class="row">
                                                                        <span class="col bg-warning">Limits: </span>
                                                                        <span class="col text-center">RAM: <strong class="ram_limit text-danger cb-copy-html"> </strong></span>
                                                                        <span class="col text-center">CPU: <strong class="cpu_limit text-danger cb-copy-html"> </strong></span>
                                                                        <span class="col text-center">DISK: <strong class="disk_limit text-danger cb-copy-html"> </strong></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-2" role="tabpanel">
                                        <button data-rel="rvps" class="do-fine btn btn-outline-success btn-xs"><i class="fa fa-check"></i> Fine</button>

                                        Finalize Hardware
                                    </div>
                                    <div class="tab-pane" id="tab-3" role="tabpanel">Finalize Network</div>
                                    <div class="tab-pane" id="tab-4" role="tabpanel">Change Password</div>
                                    <div class="tab-pane" id="tab-5" role="tabpanel">Sync WHMCS</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <div class="small text-muted">* Copy items to clipboard by click on them.</div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-top" class="modal bg-dark mt-5 pt-5" data-backdrop="static">
            <div class="modal-dialog modal-sm mt-5">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close close-right" data-dismiss="modal">×</button>
                    </div><div class="container"></div>
                    <div class="modal-body">


                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn">Close</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row Logs -->
        <?php include('core/view/termeh/logsrow.php'); ?>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>