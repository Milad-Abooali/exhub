<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'A > Users';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="home">

        <!-- Row Map -->
        <div id="cb-map" class="row cb-oh">

        </div>

        <!-- Row Domain -->
        <div id="cb-domian" class="card mt-4 pt-4 d-none d-md-block cb-oh">

        </div>


        <!-- Row Hosting Tip -->
        <div id="cb-host-tip" class="cb-blg-0 my-4 pt-2 cb-oh">

        </div>

        <!-- Row CMS -->
        <div id="cb-cms" class="row mb-5 cb-oh">

        </div>

        <!-- Row Puls -->
        <div id="cb-dev" class="row mt-5 mb-4 mx-1 py-5 px-3 cb-blg-4 cb-rtl cb-oh" dir="rtl">

        </div>

        <!-- Row VPS Tip -->
        <div id="cb-vps-tip" class="cb-blg-5 mb-5 pt-2 cb-oh">

        </div>

        <!-- Row Content -->
        <div id="cb-posts" class="row mb-5 d-md-down-none cb-oh">

        </div>

        <!-- Row Staff -->
        <div id="cb-staff" class="row my-5 mx-1 pt-5 px-3 cb-blg-0  d-none d-md-flex cb-oh">

        </div>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>