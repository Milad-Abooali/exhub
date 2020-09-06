$(document).ready(function() {

    /**
     * IPT VPS
     */

    // Ajax Plan OS  - ipt/vps
    $('body').on('keyup change','#plan', function(){
        const plan = $(this).val();
        const data = 'plan='+plan
        const classA = 'ipt/getPlanOS'
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            let options;
            $.each(obj.res,function( key, v ) {
                options +='<option value="'+v['id']+'">'+v['type']+' '+v['name']+' '+v['version']+'</option>'
            });
            $('#os').html(options);
        });
    })

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