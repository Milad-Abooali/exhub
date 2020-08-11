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
            <div class="col-md-12 form-inline justify-content-center my-3">
                Host:
                <select id="server" class="custom-select mx-2" required>
                    <?php foreach ((array) $this->data['servers'] as $server) { ?>
                        <option value="<?= $server['nid'] ?>"> <?= $server['nid'] ?> </option>
                    <?php } ?>
                </select>
                IP.Loc:
                <select id="iploc" class="custom-select mx-2" required>
                    <?php foreach ((array) $this->data['ip_loc'] as $loc) { ?>
                        <option value="<?= $loc['country'] ?>"> <?= $loc['country'] ?> </option>
                    <?php } ?>
                </select>
                Plan:
                <select id="plan" class="custom-select mx-2" required>
                    <?php foreach ((array) $this->data['plans'] as $plan) { ?>
                        <option value="<?= $plan['plan_name'] ?>"> <?= $plan['plan_name'] ?> </option>
                    <?php } ?>
                </select>

                <button type="submit" class="btn btn-primary mx-3">Add rVPS</button>

            </div>
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

        <div id="modal-rvps" class="modal fade mt-5" tabindex="-1" role="dialog">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> </h5>
                        <button type="button" class="close close-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <!-- Row Form -->
                        <div class="card mt-4 pt-4 cb-oa">
                            <div class="col-md-12 cb-ltr">
                                <form id="add-ip" action="ipt/insertIPs" data-reload="true" class="form-inline">
                                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="255" name="ip1" autocomplete="new-ip" required>
                                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="255" name="ip2" autocomplete="new-ip" required>
                                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="255" name="ip3" autocomplete="new-ip" required>
                                    <input type="number" min="0" max="256" class="form-control mb-2 mr-sm-2" placeholder="0" name="ip4" autocomplete="new-ip" required>
                                    -
                                    <input type="number" min="0" max="256" class="form-control mb-2 mx-2 text-primary" placeholder="0" name="ip5" autocomplete="new-ip" required>
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