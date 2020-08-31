$(document).ready(function() {

    /**
     * IPT VPS
     */

    // Ajax Save rVPS  - ipt/vps
    $('body').on('submit','form#save-rvps', function(event){
        event.preventDefault();
        const id = $(this).attr('id');
        const reload = $(this).data('reload');
        const data = $(this).serialize();
        const classA = $(this).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, rVPS not added. '+obj.e : 'Success, rVPS Added.';
            ajaxAlert (id, type, text);
            // (reload) && ajaxReload ();
            if (!obj.e) {
                $("#modal-getRvps").modal('hide');
                setTimeout(function () {
                    location.reload(false);
                }, 633);
            }
        });
    })

    // Ajax Add IP Modal  - ipt/vps
    $('body').on('click','#addIP', function(event){
        const server_nid = $('#server_nid').val();
        const data = 'server_nid='+server_nid;
        const classA = 'ipt/getNetworkVPS'
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
           console.log(obj);
        });
    })

    // Ajax Get rVPS  - ipt/vps
    $('body').on('submit','form#get-rvps', function(event){
        event.preventDefault();
        const data = $(this).serialize();
        const classA = $(this).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);

            if (obj.e) {
                alert('No rVPS !');
            } else {

                $('#modal-getRvps #rvps_id').val(obj.res.id);

                $('#modal-getRvps #vm_name').val(obj.res.ip.ip+'_'+obj.res.plan.plan_name+'__r');

                $('#modal-getRvps #server_nid').val(obj.res.server_nid);
                $('#modal-getRvps #host-server').html(obj.res.server.nid);
                $('#modal-getRvps #idc').html(obj.res.server.datacenter);
                $('#modal-getRvps #host-flag').addClass('cbf-'+obj.res.server.flag);
                $('#modal-getRvps #host-flag').attr('title', obj.res.server.country);


                $('#modal-getRvps #plan_id').val(obj.res.plan_id);

                $('#modal-getRvps #ip_id').val(obj.res.ip.id);
                $('#modal-getRvps #ip').html(obj.res.ip.ip);
                $('#modal-getRvps #ip-flag').addClass('cbf-'+obj.res.ip.flag);
                $('#modal-getRvps #ip-flag').attr('title', obj.res.ip.country);
                $('#modal-getRvps #mac').html(obj.res.ip.mac);


                $('#modal-getRvps #network_id').val(obj.res.network.id);
                $('#modal-getRvps #net').html(obj.res.network.subnet);
                $('#modal-getRvps #net-flag').addClass('cbf-'+obj.res.network.flag);
                $('#modal-getRvps #net-flag').attr('title', obj.res.network.country);
                $('#modal-getRvps #gw').html(obj.res.network.gateway);
                $('#modal-getRvps #netmask').html(obj.res.network.netmask);
                $('#modal-getRvps #dns-1').html(obj.res.network.dns_1);
                $('#modal-getRvps #dns-2').html(obj.res.network.dns_2);

                $('#modal-getRvps #plan-name').html(obj.res.plan.flag+'.'+obj.res.plan.plan_name);
                $('#modal-getRvps .ram').html(obj.res.plan.ram);
                $('#modal-getRvps .cpu').html(obj.res.plan.cpu_core);
                $('#modal-getRvps .hdd').html(obj.res.plan.hdd);
                $('#modal-getRvps .ssd').html(obj.res.plan.ssd);
                $('#modal-getRvps .nvme').html(obj.res.plan.nvme);

                $('#modal-getRvps #ram_limit').html(obj.res.limits.ram_limit);
                $('#modal-getRvps #cpu_limit').html(obj.res.limits.cpu_limit);
                $('#modal-getRvps #disk_limit').html(obj.res.limits.disk_limit);


                $('#modal-getRvps #obj_id').val(obj.res.object_id);
                $('#modal-getRvps #uuid').val(obj.res.uuid);
                $('#modal-getRvps #os').val(obj.res.os.type+' '+obj.res.os.name+' '+obj.res.os.version);
                $('#modal-getRvps #vm_user').val(obj.res.os.username);
                $('#modal-getRvps #port').val(obj.res.port);
                $('#modal-getRvps #note').val(obj.res.note);

                $("#modal-getRvps").modal('show');
            }
        });
    })

    // Ajax remove rVPS Call - ipt/vps
    $('body').on('click','.doA-removeCall', function(){
        let ipid = $(this).data('ipid');
        let ip = $(this).data('ip');
        let rid = $(this).data('rid');
        let body ='Remove Item <b>'+rid+'</b> ?<br><div class="text-danger text-center">'+ip+'</div>';
        let footer ='<button data-rid="'+rid+'" data-ipid="'+ipid+'" type="button" class="btn btn-success doA-remove" data-dismiss="modal">Yes</button>';
        footer +='<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>';
        makeModal('Delete Item',body,'sm',footer);
    });

    // Ajax remove rVPS - ipt/vps
    $('body').on('click','.doA-remove', function(){
        let thisClick = $(this);
        let rid = thisClick.data('rid');
        let ipid = thisClick.data('ipid');
        data = "rid="+rid+"&ipid="+ipid;
        ajaxCall ('ipt/rvpsDelete', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, status updated.';
            ajaxAlert ('app-notify', type, text);
            if (obj.res) {
                $('#item-'+rid).remove();
            }
        });
    });

    // Ajax set status rVPS - ipt/vps
    $('body').on('click','.doA-setStatus', function(){
        let thisClick = $(this);
        let rid = thisClick.data('rid');
        let status = $('#new-status-'+rid).val();
        data = "rid="+rid+"&status="+status;
        ajaxCall ('ipt/rvpsStatus', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, status updated.';
            ajaxAlert ('app-notify', type, text);
            if (obj.res) {
                $('#status-'+rid).removeClass().addClass('bg-dark text-light').html(obj.res);
            }
        });
    });

})