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
            <h2 class="text-center">
                Action Logs
                <sup>
                    <small class="btn btn-xs doP-refresh" data-table="actlog"><i class="fa fa-refresh"></i></small>
                </sup>
            </h2>

            <table id="actlog" class="table table-striped table-hover table-sm" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>Call Path</th>
                    <th>Class Act</th>
                    <th>By</th>
                    <th>Action</th>
                    <th>Data</th>
                    <th>On</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
                </thead>
            </table>

        </div>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>