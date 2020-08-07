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
                IP List
            </h4>
            <!-- Row List -->
            <table id="lisr-networks" class="table table-striped table-hover table-sm table-DT-m" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>Loc</th>
                    <th>IP</th>
                    <th>MAC</th>
                    <th>Network</th>
                    <th>Server</th>
                    <th>Owner</th>
                    <th>IR.O</th>
                    <th>IR.B</th>
                    <th>Abuse</th>
                    <th>Note</th>
                    <th>status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ((array) $this->data['ips'] as $item) { ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><i title="<?= $item['country'] ?>" class="cb-flag cbf-<?= $item['flag'] ?>"></i></td>
                        <td> <?= $item['ip'] ?></td>
                        <td> <?= $item['mac'] ?></td>
                        <td>
                            <i title="<?= $item['network']['country'] ?>" class="cb-flag cbf-<?= $item['network']['flag'] ?>"></i>
                            <strong class="text-success"><?= $item['network']['subnet'] ?></strong>
                        </td>
                        <td>
                            <i title="<?= $item['server']['country'] ?>" class="cb-flag cbf-<?= $item['server']['flag'] ?>"></i>
                            <strong class="text-success"><?= $item['server']['nid'] ?></strong>
                        </td>
                        <td><small class="text-muted"><?= $item['owner'] ?></small></td>
                        <td><small class="text-muted"><?= $item['ir_access'] ?></small></td>
                        <td><small class="text-muted"><?= $item['ir_block'] ?></small></td>
                        <td><small class="text-muted"><?= $item['abuse'] ?></small></td>
                        <td><?= $item['note'] ?></td>
                        <td><?= $item['status'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <form id="add-ip" action="ipt/insertIPs" data-reload="true" class="form-inline">
                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="255" name="ip1" autocomplete="new-ip" required>
                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="255" name="ip2" autocomplete="new-ip" required>
                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="255" name="ip3" autocomplete="new-ip" required>
                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="0" name="ip4" autocomplete="new-ip" required>
                    -
                    <input type="number" min="0" max="256" class="form-control mb-2 mx-2 " placeholder="255" name="ip5" autocomplete="new-ip" required>
                    <input type="texxt" class="form-control mb-2 mr-sm-2" placeholder="MAC" name="mac" autocomplete="new-mac" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="Network ID" name="network_id" autocomplete="new-net" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Country" name="country" autocomplete="new-country" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Flag" name="flag" autocomplete="new-flag" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Owner" name="owner" autocomplete="new-owner" required>
                    <label class="col checkbox-inline"><input name="ir_access" type="checkbox" class="mr-sm-2" value="1"> IR.Access </label>
                    <label class="col checkbox-inline"><input name="ir_block" type="checkbox" class="mr-sm-2" value="1"> IR.Block </label>
                    <label class="col checkbox-inline"><input name="abuse" type="checkbox" class="mr-sm-2" value="1"> DC.Abuse </label>
                    <textarea class="form-control mb-2 mr-sm-2" placeholder="Note" name="note"></textarea>
                    <button type="submit" class="btn btn-primary mb-2 ">Add IP</button>
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