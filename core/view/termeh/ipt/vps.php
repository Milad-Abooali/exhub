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
            <form id="add-vps" action="ipt/addvps" class="col-md-12 form-inline justify-content-center my-3">
                IP.Loc:
                <select id="iploc" name="iploc" class="custom-select mx-2" required>
                    <?php foreach ((array) $this->data['ip_loc'] as $loc) { ?>
                        <option value="<?= $loc['country'] ?>"> <?= $loc['country'] ?> </option>
                    <?php } ?>
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
                VPS List
            </h4>
            <?php if ($this->data['rvps']) : ?>
            <table id="lisr-networks" class="table table-striped table-hover table-sm table-DT" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>status</th>
                    <th>OS</th>
                    <th>Loc</th>
                    <th>IP</th>
                    <th>Server</th>
                    <th>Plan</th>
                    <th>Note</th>
                    <th>Manage Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ((array) $this->data['rvps'] as $item) { ?>
                    <tr id="item-<?= $item['id']; ?>">
                        <td><?= $item['id'] ?></td>
                        <td id="status-<?= $item['id']; ?>" class="bg-<?= $this->data['status_color'][$item['status']] ?>"><?= $this->data['status_text'][$item['status']] ?></td>
                        <td><?= $item['os']['type'].' | '.$item['os']['name'].' '.$item['os']['version'] ?></td>
                        <td><i title="<?= $item['ip']['country'] ?>" class="cb-flag cbf-<?= $item['ip']['flag'] ?>"></i></td>
                        <td> <?= $item['ip']['ip'] ?></td>
                        <td>
                            <i title="<?= $item['server']['country'] ?>" class="cb-flag cbf-<?= $item['server']['flag'] ?>"></i>
                            <strong class="text-primary"><?= $item['server']['nid'] ?></strong>
                        </td>
                        <td><small class="text-muted"><?= $item['plan']['plan_name'] ?></small></td>
                        <td>
                            <?php if ($item['note']) { ?>
                                 <button class="btn btn-outline-dark btn-xs" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $item['note'] ?>">Show</button>
                            <?php } ?>
                        </td>
                        <td>
                            <select id="new-status-<?= $item['id']; ?>" class="custom-select custom-select-sm col-md-7 float-left d-inline-block" required>
                                <?php
                                    for ($i=0;$i < count($this->data['status_text']);$i++) {
                                ?>
                                    <option value="<?= $i ?>" class="text-dark bg-<?= $this->data['status_color'][$i] ?>" <?= ($i==$item['status']) ? 'selected' : null ?>><?= $this->data['status_text'][$i] ?></option>
                                <?php
                                        }
                                ?>
                            </select>
                            <button data-rid="<?= $item['id']; ?>" class="btn btn-outline-dark btn-sm float-left doA-setStatus"> Set</button>

                            <button data-rid="<?= $item['id']; ?>" data-ip="<?= $item['ip']['ip'] ?>" data-ipid="<?= $item['ip']['id'] ?>"class="btn btn-danger btn-sm float-right doA-removeCall"> Delete</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php endif; ?>
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
                                            <span id="idc" class="float-left cb-copy-html"> </span>
                                            <strong class="float-right text-dark">
                                                <i id="host-flag" class="cb-flag" data-toggle="tooltip"data-placement="left"></i>
                                                <span id="host-server" class="cb-copy-html"></span>
                                            </strong>
                                            <hr>
                                            <h4 id="ip" class="panel-title text-success cb-copy-html"> </h4>
                                            <hr>
                                            <i id="net-flag" class="cb-flag" data-toggle="tooltip"data-placement="left"></i>
                                            <span id="net" class="text-muted cb-copy-html"></span>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                <span class="list-group-item">IP Country: <i id="ip-flag" class="float-right cb-flag cb-copy-html" data-toggle="tooltip"data-placement="left"></i></span>
                                                <span class="list-group-item">Mac: <strong id="mac" class="float-right cb-copy-html"> </strong></span>
                                                <span class="list-group-item">Gateway: <strong id="gw" class="float-right cb-copy-html"> </strong></span>
                                                <span class="list-group-item">Netmask: <strong id="netmask" class="float-right cb-copy-html"> </strong></span>
                                                <span class="list-group-item">DNS 1: <strong id="dns-1" class="float-right cb-copy-html"> </strong></span>
                                                <span class="list-group-item">DNS 2: <strong id="dns-2" class="float-right cb-copy-html"> </strong></span>
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
                                                    <h4 id="plan-name" class="panel-title text-primary text-center text-uppercase cb-copy-html"> </h4>
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
                                                        <span class="col text-center">RAM: <strong id="ram_limit" class="text-danger cb-copy-html"> </strong></span>
                                                        <span class="col text-center">CPU: <strong id="cpu_limit" class="text-danger cb-copy-html"> </strong></span>
                                                        <span class="col text-center">DISK: <strong id="disk_limit" class="text-danger cb-copy-html"> </strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-4">
                                        <div class="text-center text-muted">
                                         Creat VM Named <button id="vm_name" class="cb-copy-html btn-outline-info rounded"> </button>
                                         Set Password: <button id="vm_pass" class="cb-copy-html btn-outline-info rounded">r@VPS#12</button>
                                         <br>
                                         <button id="get-vm-data" class="btn btn-success my-3">Get VM Data</button>
                                         <div id="get-vm-data-error" class="w-100 d-block alerts alert-warning"><br></div>
                                        </div>
                                        <form id="save-rvps" action="ipt/saveRvps" data-reload="true" class="d-none">
                                            <input type="hidden" id="vm_name" name="vm_name">
                                            <input type="hidden" id="obj_id" name="obj_id">
                                            <input type="hidden" id="server_nid" name="server_nid">
                                            <input type="hidden" id="network_id" name="network_id">
                                            <input type="hidden" id="plan_id" name="plan_id">
                                            <input type="hidden" id="ip_id" name="ip_id">
                                            <input type="hidden" class="ram" name="ram">
                                            <input type="hidden" class="cpu" name="cpu_core">
                                            <input type="hidden" class="hdd" name="hdd">
                                            <input type="hidden" class="ssd" name="ssd">
                                            <input type="hidden" class="nvme" name="nvme">
                                            <input type="text" class="cb-copy-val form-control mb-3" id="uuid" name="uuid" placeholder="UUID" readonly>
                                            <select id="os" name="os" class="custom-select col-md-8 d-inline-block" required>
                                                <option> OS</option>
                                            </select>
                                            <input type="number" class="form-control col-md-3 d-inline-block" id="port" name="port" placeholder="Port" autocomplete="off">
                                            <textarea class="form-control my-3" placeholder="Note" name="note"></textarea>
                                            <select id="status" name="status" class="custom-select col-md-6 d-inline-block" required>
                                                <option value="0" selected>VM Created</option>
                                                <option value="1">OS Installed</option>
                                                <option value="2">Network Connected</option>
                                                <option value="3">Ezzz Done</option>
                                                <option value="4">Ready VPS</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary col-md-4 float-right">Save rVPS</button>
                                            <div class="cb-ltr w-100 d-block alerts"><br></div>
                                        </form>
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



        <!-- Row Logs -->
        <?php include('core/view/termeh/logsrow.php'); ?>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>