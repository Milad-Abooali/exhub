$(document).ready(function() {

    /**
     * IPT rVps
     */

    // Ajax Save rVPS  - ipt/rvps
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
                $("#modal-newRvps").modal('hide');
                setTimeout(function () {
                    location.reload(false);
                }, 633);
            }
        });
    })

    // Ajax Get VM Data  - ipt/rvps
    $('body').on('click','#get-vm-data', function(event){
        $('#get-vm-data').html(' <span class="spinner-border " role="status" aria-hidden="true"></span> Looking for VM... ');
        const name = $('#vm_name').html();
        const server_nid = $('#server_nid').val();
        const data = 'server_nid='+server_nid+'&name='+name;
        const classA = 'ipt/getVM'
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            if (obj.e) {
                $('#get-vm-data-error').html(obj.res);
                $('#get-vm-data').html('Get VM Data');
            } else {
                if (obj.res) {
                    let vm = obj.res;
                    $('#get-vm-data-error').html('Object '+vm.object_id+' loaded, VM is '+vm.state);
                    $('#modal-newRvps #save-rvps').removeClass('d-none')
                    $('#modal-newRvps #obj_id').val(vm.object_id);
                    $('#modal-newRvps #uuid').val(vm.uuid);
                    $('#modal-newRvps #vm_name').val(vm.name);
                } else {
                    $('#get-vm-data-error').html('No result, Is VM created?');
                }
                $('#get-vm-data').html('Update VM Data');
            }
        });
    })

    // Ajax Add New rVPS  - ipt/rvps
    $('body').on('submit','form#add-rvps', function(event){
        event.preventDefault();
        $('#get-vm-data').html('Get VM Data');
        const data = $(this).serialize();
        const classA = $(this).attr('action');
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);

            if (obj.e) {
                alert('No Free IP !');
            } else {
                let server = $('#server').val();
                let plan = $('#plan').val();

                $('#modal-newRvps #vm_name').html(obj.res.ip.ip+'_'+obj.res.plan.plan_name+'__r');

                $('#modal-newRvps #server_nid').val(server);
                $('#modal-newRvps #host-server').html(obj.res.server.nid);
                $('#modal-newRvps #idc').html(obj.res.server.datacenter);
                $('#modal-newRvps #host-flag').addClass('cbf-'+obj.res.server.flag);
                $('#modal-newRvps #host-flag').attr('title', obj.res.server.country);


                $('#modal-newRvps #plan_id').val(plan);

                $('#modal-newRvps #ip_id').val(obj.res.ip.id);
                $('#modal-newRvps #ip').html(obj.res.ip.ip);
                $('#modal-newRvps #ip-flag').addClass('cbf-'+obj.res.ip.flag);
                $('#modal-newRvps #ip-flag').attr('title', obj.res.ip.country);
                $('#modal-newRvps #mac').html(obj.res.ip.mac);


                $('#modal-newRvps #network_id').val(obj.res.network.id);
                $('#modal-newRvps #net').html(obj.res.network.subnet);
                $('#modal-newRvps #net-flag').addClass('cbf-'+obj.res.network.flag);
                $('#modal-newRvps #net-flag').attr('title', obj.res.network.country);
                $('#modal-newRvps #gw').html(obj.res.network.gateway);
                $('#modal-newRvps #netmask').html(obj.res.network.netmask);
                $('#modal-newRvps #dns-1').html(obj.res.network.dns_1);
                $('#modal-newRvps #dns-2').html(obj.res.network.dns_2);

                $('#modal-newRvps #plan-name').html(obj.res.plan.flag+'.'+obj.res.plan.plan_name);
                $('#modal-newRvps .ram').html(obj.res.plan.ram);
                $('#modal-newRvps .cpu').html(obj.res.plan.cpu_core);
                $('#modal-newRvps .hdd').html(obj.res.plan.hdd);
                $('#modal-newRvps .ssd').html(obj.res.plan.ssd);
                $('#modal-newRvps .nvme').html(obj.res.plan.nvme);

                $('#modal-newRvps #ram_limit').html(obj.res.limits.ram_limit);
                $('#modal-newRvps #cpu_limit').html(obj.res.limits.cpu_limit);
                $('#modal-newRvps #disk_limit').html(obj.res.limits.disk_limit);

                let options;
                $.each(obj.res.os,function( key, value ) {
                    options +='<option value="'+value['id']+'"> '+value['type']+' '+value['name']+' '+value['version']+' '+' </option>'
                });
                $('#modal-newRvps #os').html(options);
                $("#modal-newRvps").modal('show');
            }
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


    // Ajax remove rVPS Call - ipt/rvps
    $('body').on('click','.doA-removeCall', function(){
        let ipid = $(this).data('ipid');
        let ip = $(this).data('ip');
        let rid = $(this).data('rid');
        let body ='Remove Item <b>'+rid+'</b> ?<br><div class="text-danger text-center">'+ip+'</div>';
        let footer ='<button data-rid="'+rid+'" data-ipid="'+ipid+'" type="button" class="btn btn-success doA-remove" data-dismiss="modal">Yes</button>';
        footer +='<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>';
        makeModal('Delete Item',body,'sm',footer);
    });

    // Ajax remove rVPS - ipt/rvps
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


    // Ajax set status rVPS - ipt/rvps
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