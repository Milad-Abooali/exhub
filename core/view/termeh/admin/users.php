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
                <form id="add-user" action="users/add" class="form-inline">
                    <input type="email" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Email" name="email" autocomplete="new-email" required>
                    <input type="text" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Username" name="username" autocomplete="new-username" required>
                    <input type="password" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Password" name="password" autocomplete="new-password" required>
                    <button id="test" type="submit" class="btn btn-primary mb-2 ">Add User</button>
                    <div class="cb-ltr w-100 d-block alerts"><br></div>
                </form>
            </div>
        </div>

        <!-- Row List -->
        <div class="card mt-4 py-4 px-1 cb-oa">
            <h2 class="text-center">User List <small id="users-title" class="cb-ajax-u">Count: <?= $this->data['user_count']; ?></small></h2>
            <table id="users-list" class="table table-striped table-hover cb-ajax-u" >
                <thead>
                <tr>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Registerd</th>
                    <th>Last Login</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!is_array($this->data['users'])) { ?>
                <tr>
                    <td colspan="5" class="text-center text-secondary">No Item</td>
                </tr>
                <?php } else { foreach ((array) $this->data['users'] as $item) { ?>
                <tr>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input cb-ajax-a" data-rid="<?= $item['id']; ?>" id="status-<?= $item['id']; ?>" <?= $item['status'] ? 'checked' : null; ?>>
                            <label class="custom-control-label" for="status-<?= $item['id']; ?>"> </label>
                        </div>
                    </td>
                    <td><?= $item['email']; ?></td>
                    <td><?= $item['username']; ?></td>
                    <td><?= $item['timestamp']; ?></td>
                    <td data-toggle="tooltip" data-placement="left" title="<?= $item['last_login']; ?>"><?= $item['last_ip']; ?></td>
                    <td>
                        <button id="test" type="submit" class="btn btn-secondary btn-sm">Rest Password</button>
                    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>