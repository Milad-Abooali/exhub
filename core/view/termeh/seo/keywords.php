<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'A > Users';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <form id="add-keyword" action="core/dbInsert" data-reload="true" class="form-inline">
                    <input type="hidden" name="table" value="seo_keywords" required>
                    <input type="text" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Keyword" name="keyword" autocomplete="new-email" required>
                    <input type="url" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter URL" name="url" autocomplete="new-username" required>
                    <input type="number" class="form-control mb-2 mr-sm-2 col-md-1" value="0" name="priority">
                    <label class="col checkbox-inline"><input name="fis" type="checkbox" class="mr-sm-2" value="1"> FIS </label>
                    <button type="submit" class="btn btn-primary mb-2 ">Add Keyword</button>
                    <div class="cb-ltr w-100 d-block alerts"><br></div>
                </form>
            </div>
        </div>

        <!-- Row List -->
        <div class="card mt-4 py-4 px-1 cb-oa">
            <h2 class="text-center">User List <small id="users-title" class="cb-ajax-u">Count: <?= $this->data['keywords_count']; ?></small></h2>
            <table id="users-list" class="table table-striped table-hover cb-ajax-u" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>Keyword</th>
                    <th>Link</th>
                    <th>FIS</th>
                    <th>Priority</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!is_array($this->data['keywords'])) { ?>
                    <tr>
                        <td colspan="4" class="text-center text-secondary">No Item</td>
                    </tr>
                <?php } else { foreach ((array) $this->data['keywords'] as $item) { ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['keyword']; ?></td>
                        <td><a target="_blank" href="<?= $item['url']; ?>"><i class="fa fa-link"></i> Open</a></td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input doA-setfis" data-rid="<?= $item['id']; ?>" id="fis-<?= $item['id']; ?>" <?= $item['fis'] ? 'checked' : null; ?>>
                                <label class="custom-control-label" for="fis-<?= $item['id']; ?>"> </label>
                            </div>
                        </td>
                        <td><input data-rid="<?= $item['id']; ?>" type="number" class="mb-2 mr-sm-2" value="<?= $item['priority']; ?>" name="priority"></td>
                        <td>
                            <button data-rid="<?= $item['id']; ?>" class="btn btn-outline-danger btn-sm doA-resetPass">Remove</button>
                        </td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>

        <!-- Row Logs -->
        <div class="card mt-4 py-4 px-1 cb-blg-0">
            <h4 class="text-center">Keywords Logs</h4>
            <table id="actlog" class="dTable-min table table-striped table-hover table-sm" >
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
                        <td><?= $item['user']; ?></td>
                        <td><?= $item['act']; ?>
                            <?php if ($item['data']): ?>
                            <button data-logdata="<?= $item['data']; ?>" class="btn btn-outline-info btn-xs doM-logdata float-right">Show Data</button>
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