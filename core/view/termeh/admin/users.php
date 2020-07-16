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
                <form class="form-inline" action="/action_page.php">
                    <label for="email" class="mr-sm-2">Email address:</label>
                    <input type="email" class="form-control mb-2 mr-sm-2" placeholder="Enter email" name="email">

                    <label for="email" class="mr-sm-2">Username:</label>
                    <input type="email" class="form-control mb-2 mr-sm-2" placeholder="Username" name="Username">

                    <label for="pwd" class="mr-sm-2">Password:</label>
                    <input type="password" class="form-control mb-2 mr-sm-2" placeholder="Enter password" name="password">

                    <div class="form-check mb-2 mr-sm-2">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>
            </div>
        </div>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>