$(document).ready(function() {

    /**
     * Admin Users
     */

    // Ajax Add New User  - admin/users
    $('body').on('submit','form#add-user', function(event){
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


    // Ajax Set Groups - admin/users
    $('body').on('submit','form#user-groups', function(event){
        event.preventDefault();
        const id = $(this).attr('id');
        const reload = $(this).data('reload');
        const data = $('#'+id).serialize();
        const classA = $('#'+id).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, Groups not Change. '+obj.res : 'Success, Groups Saved.';
            ajaxAlert (id, type, text);
            (reload) && ajaxReload ();
        });
    });

    // Ajax Change status - admin/users
    $('body').on('click','.doA-updatestatus', function(){
        let rid = $(this).data('rid');
        let status = $(this).is(":checked")  ? 1 : 0;
        data = "rid="+rid+"&status="+status;
        ajaxCall ('users/updateStatus', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
            ajaxAlert ('app-notify', type, text);
        });
    });

    // Ajax Rest Pass - admin/users
    $('body').on('click','.doA-resetPass', function(){
        let thisClick = $(this);
        let rid = thisClick.data('rid');
        data = "rid="+rid;
        ajaxCall ('users/resetPass', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
            ajaxAlert ('app-notify', type, text);
            if (obj.res) {
                makeModal('Reset Password','<p class="text-center">New Password:</p> <h3 class="text-center text-danger">'+obj.res+'</h3>','sm');
            }
        });
    });

    // Ajax Get Groups - admin/users
    $('body').on('click','.doA-groups', function(){
        let thisClick = $(this);
        let rid = thisClick.data('rid');
        data = "rid="+rid;
        ajaxCall ('users/getGroups', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
            ajaxAlert ('app-notify', type, text);
            if (obj.res) {
                console.log(obj.res);
                let body = '<form id="user-groups" action="users/setGroups" data-reload="false" class="form">';
                body += '<input name="rid" type="hidden" value="'+obj.res.user_id+'" />';
                body += '<label class="col checkbox-inline"><input name="admin" type="checkbox" '+((obj.res.admin==1) && 'checked')+'> Admin </label>';
                body += '<label class="col checkbox-inline"><input name="staff" type="checkbox" '+((obj.res.staff==1) && 'checked')+'> Staff </label>';
                body += '<label class="col checkbox-inline"><input name="ipt" type="checkbox" '+((obj.res.ipt==1) && 'checked')+'> IPT </label>';
                body += '<label class="col checkbox-inline"><input name="seo" type="checkbox" '+((obj.res.seo==1) && 'checked')+'> SEO </label>';
                body += '<button type="submit" class="btn btn-primary btn-block">Save Groups</button>';
                body += '<div class="cb-ltr w-100 d-block alerts"><br></div></form>';
                makeModal('Set User Groups',body);
            }
        });
    });

});

