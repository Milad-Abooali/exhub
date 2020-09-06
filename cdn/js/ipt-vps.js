$(document).ready(function() {

    /**
     * IPT VPS
     */

    // Ajax Get rVPS  - ipt/vps
    $('body').on('submit','form#new-vps', function(event){
        event.preventDefault();
        const data = $(this).serialize();
        const classA = $(this).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);

            if (obj.e) {
                alert('No rVPS !');
            } else {
                $("#modal-main .modal-title").html('New VPS');


                $("#modal-main").modal('show');
            }
        });
    })


})