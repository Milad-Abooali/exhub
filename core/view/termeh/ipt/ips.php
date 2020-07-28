<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'IPT > IPs';
    $this->data['PAGE']['head'] = '<script defer src="'.JS.'ipt-ips.js"></script>';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');


?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">
        <div class="card mt-4 py-4 px-1">
            <h4 class="text-center">
                Networks List
            </h4>
            <!-- Row List -->
            <table id="lisr-networks" class="table table-striped table-hover table-sm table-DT-m" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>Loc</th>
                    <th>Datacenter</th>
                    <th>Server</th>
                    <th>Owner</th>
                    <th>NIC</th>
                    <th>Net</th>
                    <th>SubNet</th>
                    <th>Gateway</th>
                    <th>DNS</th>
                    <th>Note</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ((array) $this->data['networks'] as $item) { ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><i title="<?= $item['country'] ?>" class="cb-flag cbf-<?= $item['flag'] ?>"></i></td>
                        <td> <?= $item['datacenter'] ?></td>
                        <td>
                            <i title="<?= $item['country'] ?>" class="cb-flag cbf-<?= $item['server_flag'] ?>"></i>
                            <strong class="text-success"><?= $item['server_nid'] ?></strong>
                        </td>
                        <td><small class="text-muted"><?= $item['owner'] ?></small></td>
                        <td><?= $item['nic'] ?></td>
                        <td><small class="text-muted"><?= $item['network'] ?></small></td>
                        <td>
                            <span class="text-muted"><?= $item['subnet'] ?></span>
                            <br>
                            <?= $item['netmask'] ?>
                        </td>
                        <td><span class="text-primary"><?= $item['gateway'] ?></span></td>
                        <td><?= $item['dns_1'] ?> <br> <?= $item['dns_2'] ?></td>
                        <td><?= $item['note'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <form id="add-network" action="core/dbInsert" data-reload="true" class="form-inline">
                    <input type="hidden" class="form-control mb-2 mr-sm-2"  name="table" value="ipt_networks" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Datacenter" name="datacenter" autocomplete="new-datacenter" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Country" name="country" autocomplete="new-country" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Flag" name="flag" autocomplete="new-flag" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="Server" name="server_nid" autocomplete="new-server" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Owner" name="owner" autocomplete="new-owner" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="NIC" name="nic" autocomplete="new-nic" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Network" name="network" autocomplete="new-network" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Subnet" name="subnet" autocomplete="new-subnet" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Netmask" name="netmask" autocomplete="new-netmask" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Gateway" name="gateway" autocomplete="new-gateway" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="DNS 1" name="dns_1" autocomplete="new-dns" required>
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