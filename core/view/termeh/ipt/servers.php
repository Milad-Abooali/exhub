<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'A > Users';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row List -->

        <!-- Row List -->
        <div id="fis-list" class="row mt-4 py-4 px-1 cb-oa">
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
                                next Payment
                                <strong class="text-danger">
                                    <?php
                                        $today = date('d');
                                        if ($item['invoice_date'] < $today ) {
                                            echo 29 + $item['invoice_date'] - $today;
                                        } else {
                                            echo $item['invoice_date'] - $today;
                                        }
                                    ?>
                                </strong> day
                            </a>
                        </div>
                        <div id="key-<?= $item['id'] ?>"  data-parent="#fis-list" class="panel-collapse collapse">
                            <div class="card-body">

                            </div>
                            <div class="card-footer wa">
                                Today Ratio:
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <form id="add-server" action="core/dbInsert" data-reload="true" class="form-inline">
                    <input type="hidden" class="form-control mb-2 mr-sm-2"  name="table" value="ipt_servers" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="New ID" name="nid" autocomplete="new-id" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="WHMCS ID" name="whmcs_id" autocomplete="new-id" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="Price in EU" name="price" autocomplete="new-price" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="Invoice Date" name="invoice_date" autocomplete="new-price" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Country" name="country" autocomplete="new-country" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="flag" name="flag" autocomplete="new-flag" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Datacenter" name="datacenter" autocomplete="new-datacenter" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Main IP" name="main_ip" autocomplete="new-ip" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="Ram" name="ram" autocomplete="new-ram" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="CPU Core" name="cpu_core" autocomplete="new-cpu" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="CPU GHz" name="cpu_ghz" autocomplete="new-cpu" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="HDD" name="hdd" autocomplete="new-hdd" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="SSD" name="ssd" autocomplete="new-ssd" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="NVMe" name="nvme" autocomplete="new-nvme" required>
                    <textarea class="form-control mb-2 mr-sm-2" placeholder="Note" name="note"></textarea>
                    <button type="submit" class="btn btn-primary mb-2 ">Add server</button>
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