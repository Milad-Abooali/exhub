<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'A > Users';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="home">


        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <uponE>
                    (!$_POST) ?: $this->data['add_user'];
                </uponE>
                <form id="add-user" class="form-inline" method="post">
                    <input type="email" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Email" name="email" autocomplete="new-email">
                    <input type="text" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Username" name="username" autocomplete="new-username">
                    <input type="password" class="form-control mb-2 mr-sm-2 col-md-3" placeholder="Enter Password" name="password" autocomplete="new-password">
                    <button type="submit" class="btn btn-primary mb-2 ">Add User</button>
                </form>
            </div>
        </div>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>