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
                    <?php foreach ((array) $this->data['plans'] as $plan) { ?>
                        <option value="<?= $plan['id'] ?>"> <?= $plan['plan_name'] ?> </option>
                    <?php } ?>
                </select>

                <button type="submit" class="btn btn-primary mx-3">Get rVPS</button>

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

                        <div id="creatVPS">
                            <h1>First Step</h1>
                            <div>First Content</div>

                            <h1>Second Step</h1>
                            <div>Second Content</div>
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