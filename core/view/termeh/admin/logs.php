<?php

    use function App\Core\getUsernameByID;

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'A > Logs';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

          <!-- Row Logs -->
        <div class="card mt-4 py-4 px-1 cb-oa">
            <h2 class="text-center">Action Logs</h2>

            <table id="actlog" class="dTable-full table table-striped table-hover table-sm" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>Call</th>
                    <th>Func</th>
                    <th>By</th>
                    <th>Action</th>
                    <th>On</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!is_array($this->data['actlog'])) { ?>
                    <tr>
                        <td colspan="8" class="text-center text-secondary">No Item</td>
                    </tr>
                <?php } else { foreach ((array) $this->data['actlog'] as $item) { ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['call_path']; ?></td>
                        <td><?= $item['class_act']; ?></td>
                        <td><?= getUsernameByID($item['user']); ?></td>
                        <td><?= $item['act']; ?>
                            <?php if ($item['data']): ?>
                                <button data-logdata='<?= $item['data']; ?>' class="btn btn-outline-info btn-xs doM-logdata float-right">Console</button>
                            <?php endif; ?>
                        </td>
                        <td><?= $item['rel']; ?></td>
                        <td><small class="<?php if ($item['status']): ?>text-success">OK<?php else: ?>text-danger">Error<?php endif;?></small></td>
                        <td><?= $item['timestamp']; ?></td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>