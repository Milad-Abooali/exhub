<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'IPT > Networks';
    $this->data['PAGE']['head'] = '<script defer src="'.JS.'ipt-networks.js"></script>';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');


?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row List -->
        <div id="server-list" class="row mt-4 py-4 px-1 cb-ajax-u cb-oa">
            <?php foreach ((array) $this->data['servers'] as $item) { ?>

            <?php } ?>

        </div>
        <!-- Row Form -->
        <div class="card mt-4 pt-4 cb-oa">
            <div class="col-md-12 cb-ltr">
                <form id="add-network" action="core/dbInsert" data-reload="true" class="form-inline">
                    <input type="hidden" class="form-control mb-2 mr-sm-2"  name="table" value="ipt_networks" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Datacenter" name="datacenter" autocomplete="new-datacenter" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Country" name="country" autocomplete="new-country" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Flag" name="flag" autocomplete="new-flag" required>
                    <input type="number" class="form-control mb-2 mr-sm-2" placeholder="Server" name="server_nid" autocomplete="new-server" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Owner" name="owner" autocomplete="new-owner" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="NIC" name="nic" autocomplete="new-nic" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Network" name="network" autocomplete="new-network" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Subnet" name="subnet" autocomplete="new-subnet" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Netmask" name="netmask" autocomplete="new-netmask" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Gateway" name="gateway" autocomplete="new-gateway" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="DNS 1" name="dns_1" autocomplete="new-dns" required>
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="DNS 2" name="dns_2" autocomplete="new-dns" required>
                    <textarea class="form-control mb-2 mr-sm-2" placeholder="Note" name="note"></textarea>
                    <button type="submit" class="btn btn-primary mb-2 ">Add Network</button>
                    <div class="cb-ltr w-100 d-block alerts"><br></div>
                </form>
            </div>
        </div>


        <!-- Row Logs -->
        <?php include('core/view/termeh/logsrow.php'); ?>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>