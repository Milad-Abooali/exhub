$(document).ready(function() {

     /**
     * SEO Keywords
     */

    // Ajax Add New Keyword  - seo/keywords
    $('body').on('submit','form#add-keyword', function(event){
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
    });

    // Ajax remove Keyword Call - seo/keywords
    $('body').on('click','.doA-removeCall', function(){
        let keyword = $(this).data('keyword');
        let rid = $(this).data('rid');
        let body ='Remove Item <b>'+rid+'</b> ?<br><div class="text-danger text-center">'+keyword+'</div>';
        let footer ='<button data-rid="'+rid+'" type="button" class="btn btn-success doA-remove" data-dismiss="modal">Yes</button>';
        footer +='<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>';
        makeModal('Delete Item',body,'sm',footer);
    });

    // Ajax remove Keyword - seo/keywords
    $('body').on('click','.doA-remove', function(){
        let thisClick = $(this);
        let rid = thisClick.data('rid');
        data = "table=seo_keywords&rid="+rid;
        ajaxCall ('core/dbDelete', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
            ajaxAlert ('app-notify', type, text);
            if (obj.res) {
                $('#item-'+rid).remove();
            }
        });
    });

    // Ajax Change priority - seo/keywords
    $('body').on('change','input.doA-setprio', function(){
        let rid = $(this).data('rid');
        let prio = $(this).val();
        data = "rid="+rid+"&prio="+prio;
        ajaxCall ('seo/setPrio', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
            ajaxAlert ('app-notify', type, text);
            ajaxReload();
        });
    });

    // Ajax Change fis - seo/keywords
    $('body').on('change','input.doA-setfis', function(){
        let rid = $(this).data('rid');
        let fis = $(this).is(":checked")  ? 1 : 0;
        data = "rid="+rid+"&fis="+fis;
        ajaxCall ('seo/setFis', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
            ajaxAlert ('app-notify', type, text);
        });
    });
});
