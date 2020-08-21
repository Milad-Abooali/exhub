<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'IPT > rVPS';
    $this->data['PAGE']['head'] = '<script defer src="'.JS.'ipt-rvps.js"></script>';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');

?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <h4 class="text-center">
                New rVPS
            </h4>
            <form id="add-rvps" action="ipt/addRvps" class="col-md-12 form-inline justify-content-center my-3">
                Host:
                <select id="server" name="server" class="custom-select mx-2" required>
                    <option disabled selected> Server ID </option>

                    <?php foreach ((array) $this->data['servers'] as $server) { ?>
                        <option value="<?= $server['nid'] ?>"> <?= $server['nid'] ?> </option>
                    <?php } ?>
                </select>
                IP.Loc:
                <select id="iploc" name="iploc" class="custom-select mx-2" required>

                </select>
                Plan:
                <select id="plan" name="plan" class="custom-select mx-2" required>
                    <?php foreach ((array) $this->data['plans'] as $plan) { ?>
                        <option value="<?= $plan['id'] ?>"> <?= $plan['plan_name'] ?> </option>
                    <?php } ?>
                </select>

                <button type="submit" class="btn btn-primary mx-3">Add rVPS</button>

            </form>
        </div>

        <!-- Row List -->
        <div class="card mt-4 py-4 px-1">
            <h4 class="text-center">
                Reserved VPS List
            </h4>
            <table id="lisr-networks" class="table table-striped table-hover table-sm table-DT" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>UUID</th>
                    <th>Loc</th>
                    <th>IP</th>
                    <th>MAC</th>
                    <th>Network</th>
                    <th>Server</th>
                    <th>Plan</th>
                    <th>Note</th>
                    <th>status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ((array) $this->data['rvps'] as $item) { ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['uuid'] ?></td>
                        <td><i title="<?= $item['ip']['country'] ?>" class="cb-flag cbf-<?= $item['ip']['flag'] ?>"></i></td>
                        <td> <?= $item['ip']['ip'] ?></td>
                        <td> <?= $item['ip']['mac'] ?></td>
                        <td>
                            <i title="<?= $item['network']['country'] ?>" class="cb-flag cbf-<?= $item['network']['flag'] ?>"></i>
                            <strong class="text-secondary"><?= $item['network']['subnet'] ?></strong>
                        </td>
                        <td>
                            <i title="<?= $item['server']['country'] ?>" class="cb-flag cbf-<?= $item['server']['flag'] ?>"></i>
                            <strong class="text-primary"><?= $item['server']['nid'] ?></strong>
                        </td>
                        <td><small class="text-muted"><?= $item['plan']['plan_name'] ?></small></td>
                        <td><small class="text-muted"><?= $item['note'] ?></small></td>
                        <td class="bg-<?= $this->data['status_color'][$item['status']] ?>"><?= $this->data['status_text'][$item['status']] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="modal-newRvps" class="modal fade mt-5" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Creat rVPS </h5>
                        <button type="button" class="close close-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <!-- Row Form -->
                            <div class="row">

                                <div class="col-md-5 mb-4">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <span id="idc" class="float-left"> </span>
                                            <strong class="float-right text-dark">
                                                <i id="host-flag" class="cb-flag" data-toggle="tooltip"data-placement="left"></i>
                                                <span id="host-server"></span>
                                            </strong>
                                            <hr>
                                            <h4 id="ip" class="panel-title text-success"> </h4>
                                            <hr>
                                            <i id="net-flag" class="cb-flag" data-toggle="tooltip"data-placement="left"></i>
                                            <span id="net" class="text-muted"></span>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                <span class="list-group-item">IP Country: <i id="ip-flag" class="float-right cb-flag" data-toggle="tooltip"data-placement="left"></i></span>
                                                <span class="list-group-item">Mac: <strong id="mac" class="float-right"> </strong></span>
                                                <span class="list-group-item">Gateway: <strong id="gw" class="float-right"> </strong></span>
                                                <span class="list-group-item">Netmask: <strong id="netmask" class="float-right"> </strong></span>
                                                <span class="list-group-item">DNS 1: <strong id="dns-1" class="float-right"> </strong></span>
                                                <span class="list-group-item">DNS 2: <strong id="dns-2" class="float-right"> </strong></span>
                                            </div>
                                        </div>
                                        <div class="card-footer wa">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 id="plan-name" class="panel-title text-primary text-center text-uppercase"> </h4>
                                                    <div class="list-group list-group">
                                                        <span class="list-group-item">Ram: <strong id="ram" class="float-right"> </strong></span>
                                                        <span class="list-group-item">CPU Core: <strong id="cpu" class="float-right"> </strong></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="list-group list-group">
                                                        <span class="list-group-item">HDD: <strong id="hdd" class="float-right"> </strong></span>
                                                        <span class="list-group-item">SSD: <strong id="ssd" class="float-right"> </strong></span>
                                                        <span class="list-group-item">NVMe: <strong id="nvme" class="float-right"> </strong></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 border border-warning my-2">
                                                    <div class="row">
                                                        <span class="col bg-warning">Limits: </span>
                                                        <span class="col text-center">RAM: <strong id="ram_limit" class="text-danger"> </strong></span>
                                                        <span class="col text-center">CPU: <strong id="cpu_limit" class="text-danger"> </strong></span>
                                                        <span class="col text-center">DISK: <strong id="disk_limit" class="text-danger"> </strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-3">
                                        <div class="text-center pv-3 text-muted">
                                            Get virtual machine data from host server after created:
                                         <button id="get-vm-data" class="btn btn-success my-3">Get VM Data</button>
                                        </div>
                                        <form id="creat-rvps" action="ipt/insertIPs" data-reload="true" class="d-none">
                                            <input type="hidden" id="server_nid" name="server_nid">
                                            <input type="hidden" id="network_id" name="network_id">
                                            <input type="hidden" id="plan_id" name="plan_id">
                                            <input type="hidden" id="ip_id" name="ip_id">
                                            <input type="text" class="form-control mb-2" id="uuid" name="uuid" placeholder="UUID">

                                            <select id="os" name="os" class="custom-select mb-2" required>
                                                <option> OS</option>

                                            </select>

                                            <textarea class="form-control mb-2" placeholder="Note" name="note"></textarea>
                                            <button type="submit" class="btn btn-primary mb-2 ">Add IP</button>
                                            <div class="cb-ltr w-100 d-block alerts"><br></div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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