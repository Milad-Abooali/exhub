$(document).ready(function() {

    /**
     * IPT Servers
     */


    // Ajax Add New Keyword  - seo/keywords
    $('body').on('submit','form#add-server', function(event){
        event.preventDefault();
        const id = $(this).attr('id');
        const reload = $(this).data('reload');
        const data = $('#'+id).serialize();
        const classA = $('#'+id).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, User not added. '+obj.res : 'Success, User Added.';
            ajaxAlert (id, type, text);
            (reload) && ajaxReload ();
        });
    })

})