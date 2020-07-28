<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'IPT > Networks';
    $this->data['PAGE']['head'] = '<script defer src="'.JS.'ipt-networks.js"></script>';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');


?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row List -->

        <!-- Row List -->
        <div id="server-list" class="row mt-4 py-4 px-1 cb-ajax-u cb-oa">
            <?php foreach ((array) $this->data['servers'] as $item) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <a data-toggle="collapse" href="#key-<?= $item['id'] ?>">
                                <span class="float-left"><?= $item['datacenter'] ?></span>
                                <strong class="float-right text-dark">€ <?= $item['price'] ?></strong>
                                <hr>
                                <h4 class="panel-title">
                                    <i class="cb-flag-logo cbf-<?= $item['flag'] ?>"></i> <?= $item['nid'] ?>
                                </h4><hr>
                                next Payment:
                                <strong class="text-danger">
                                    <?php
                                        $today = date('d');
                                        if ($item['invoice_date'] < $today ) {
                                            echo 29 + $item['invoice_date'] - $today;
                                        } else {
                                            echo $item['invoice_date'] - $today;
                                        }
                                    ?>
                                </strong> days
                            </a>
                        </div>
                        <div id="key-<?= $item['id'] ?>" data-parent="#server-list" class="panel-collapse collapse">
                            <div class="card-body">
                                <div class="list-group">
                                    <span class="list-group-item">
                                        IP:
                                        <a href="https://<?= $item['main_ip'] ?>" target="_blank"class="float-right ml-2"><i class="fa fa-link"></i></a>
                                        <strong class="float-right"><?= $item['main_ip'] ?></strong>
                                    </span>
                                    <span class="list-group-item">RAM: <strong class="float-right"><?= $item['ram'] ?> GB</strong></span>
                                    <span class="list-group-item">CPU: <strong class="float-right"><?= $item['cpu_core'] ?> Core - <?= $item['cpu_ghz'] ?> GHz</strong></span>
                                    <span class="list-group-item">HDD: <strong class="float-right"><?= $item['hdd'] ?> GB</strong></span>
                                    <span class="list-group-item">SSD: <strong class="float-right"><?= $item['ssd'] ?> GB</strong></span>
                                    <span class="list-group-item">NVMe: <strong class="float-right"><?= $item['nvme'] ?> GB</strong></span>
                                </div>
                                <div class="list-group list-group-flush small">
                                    <span class="list-group-item">id: <strong class="float-right"><?= $item['id'] ?></strong></span>
                                    <span class="list-group-item">N.ID: <strong class="float-right"><?= $item['nid'] ?></strong></span>
                                    <span class="list-group-item">WHMCS: <strong class="float-right"><?= $item['whmcs_id'] ?></strong></span>
                                    <span class="list-group-item">Country: <strong class="float-right"><?= $item['country'] ?></strong></span>
                                    <span class="list-group-item">Note: <strong class="float-right"><?= $item['note'] ?></strong></span>
                                </div>
                            </div>
                            <div class="card-footer wa">
                                <button class="btn btn-xs btn-primary">Detail</button>
                                <button class="btn btn-xs btn-success">Networks</button>
                                <button class="btn btn-xs btn-danger float-right">Remove</button>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <form id="add-network" action="core/dbInsert" data-reload="true" class="form-inline">
                    <input type="hidden" class="form-control mb-2 mr-sm-2"  name="table" value="ipt_networks" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Datacenter" name="datacenter" autocomplete="new-datacenter" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Country" name="country" autocomplete="new-country" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Flag" name="flag" autocomplete="new-flag" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="Server ID" name="server_id" autocomplete="new-server" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Owner" name="owner" autocomplete="new-owner" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="NIC" name="nic" autocomplete="new-nic" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Network" name="network" autocomplete="new-network" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Gateway" name="gateway" autocomplete="new-gateway" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="DNS 1" name="dns_1" autocomplete="new-dns" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="DNS 2" name="dns_2" autocomplete="new-dns" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="DNS 2" name="dns_2" autocomplete="new-dns" required>
                    <textarea class="form-control mb-2 mr-sm-2" placeholder="Note" name="note"></textarea>
                    <button type="submit" class="btn btn-primary mb-2 ">Add Network</button>
                    <div class="cb-ltr w-100 d-block alerts"><br></div>
                </form>
            </div>
        </div>


        <!-- Row Logs -->
        <?php include('core/view/termeh/logsrow.php'); ?>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>