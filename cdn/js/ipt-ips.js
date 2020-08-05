$(document).ready(function() {

    /**
     * IPT IPs
     */

    // Ajax Add New IP  - ipt/ips
    $('body').on('submit','form#add-ip', function(event){
        event.preventDefault();
        const id = $(this).attr('id');
        const reload = $(this).data('reload');
        const data = $('#'+id).serialize();
        const classA = $('#'+id).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, Network not added. '+obj.res : 'Success, Network Added.';
            ajaxAlert (id, type, text);
            (reload) && ajaxReload ();
        });
    })

})