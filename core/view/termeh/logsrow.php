<?php
    use function App\Core\getUsernameByID;
?>
<div class="card mt-4 py-4 px-1 cb-blg-0">
    <h4 class="text-center">Action Logs</h4>
    <table id="actlog" class="dTable-min table table-striped table-hover table-sm cb-ajax-u" >
        <thead>
        <tr>
            <th>#</th>
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
                <td colspan="5" class="text-center text-secondary">No Item</td>
            </tr>
        <?php } else { foreach ((array) $this->data['actlog'] as $item) { ?>
            <tr>
                <td><?= $item['id']; ?></td>
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