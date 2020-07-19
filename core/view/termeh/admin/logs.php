<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'A > Logs';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <form id="add-user" action="users/add" data-reload="true" class="form-inline">
                    <input type="email" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Email" name="email" autocomplete="new-email" required>
                    <input type="text" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Username" name="username" autocomplete="new-username" required>
                    <input type="password" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Password" name="password" autocomplete="new-password" required>
                    <button type="submit" class="btn btn-primary mb-2 ">Add User</button>
                    <div class="cb-ltr w-100 d-block alerts"><br></div>
                </form>
            </div>
        </div>


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
                        <td><?= $item['user']; ?></td>
                        <td><?= $item['act']; ?></td>
                        <td><?= $item['rel']; ?></td>
                        <td><?= $item['status']; ?></td>
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