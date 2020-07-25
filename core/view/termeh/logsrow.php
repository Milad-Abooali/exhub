<?php
    use function App\Core\getUsernameByID;
?>

<div class="card mt-4 py-4 px-1 cb-blg-0">
    <h4 class="text-center">
        Action Logs
        <sup>
            <small class="btn btn-xs doP-refresh" data-table="actlogs"><i class="fa fa-refresh"></i></small>
        </sup>
    </h4>

    <table id="actlogs" class="table table-striped table-hover table-sm" >
        <thead>
        <tr>
            <th>#</th>
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