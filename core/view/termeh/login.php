<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'Login';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row Form -->
        <div class="d-flex justify-content-center mt-5 pt-5 cb-oa">
            <div class="card col-md-4 mt-5 text-center">
                <form id="login" action="users/login" data-reload="true" class="form p-3">
                    <fieldset id="login-box" class="cb-ajax-u">
                        <?php if (isset($_SESSION['M']['user'])): ?>
                            <a onclick="location.reload()" class="btn btn-success btn-block">Opeen Page</a>
                        <?php else: ?>
                            <legend>Login to Codebox eX</legend>
                            <input type="text" class="form-control d-block mb-3" placeholder="Enter Username" name="username" required>
                            <input type="password" class="form-control d-block mb-3" placeholder="Enter Password" name="password" required>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <?php endif; ?>
                    </fieldset>
                    <div class="cb-ltr w-100 d-block alerts"><br></div>
                </form>
            </div>
        </div>

    </div>


</div></body></html>