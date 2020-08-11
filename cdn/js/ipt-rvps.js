$(document).ready(function() {

    /**
     * IPT rVps
     */

    // Ajax Add New rVPS  - ipt/rvps
    $('body').on('submit','form#add-rvps', function(event){
        event.preventDefault();
        const data = $(this).serialize();
        const classA = $(this).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            alert(obj);

        });
    })


    // Ajax IP LOC  - ipt/rvps
    $('body').on('keyup change','#server', function(){
        const server = $(this).val();
        const data = 'server='+server
        const classA = 'ipt/getNetworksLoc'
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            let options;
            $.each(obj.res,function( key, value ) {
                options +='<option value="'+value['country']+'"> '+value['country']+' </option>'
            });
            $('#iploc').html(options);
        });
    })



})