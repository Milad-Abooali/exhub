$(document).ready(function() {

    /**
     * IPT rVps
     */

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
                if (obj.res.length==1) {
                    $('#get-vm-data-error').html('Data loaded, VM is '+obj.res.state);
                    $('#modal-newRvps #creat-rvps').removeClass('d-none')
                    $('#modal-newRvps #uuid').val(obj.res.uuid);
                    $('#modal-newRvps #vm_name').val(obj.res.name);
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
                alert(obj.res);
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
                $('#modal-newRvps #ram').html(obj.res.plan.ram);
                $('#modal-newRvps #cpu').html(obj.res.plan.cpu_core);
                $('#modal-newRvps #hdd').html(obj.res.plan.hdd);
                $('#modal-newRvps #ssd').html(obj.res.plan.ssd);
                $('#modal-newRvps #nvme').html(obj.res.plan.nvme);

                $('#modal-newRvps #ram_limit').html(obj.res.limits.ram_limit);
                $('#modal-newRvps #cpu_limit').html(obj.res.limits.cpu_limit);
                $('#modal-newRvps #disk_limit').html(obj.res.limits.disk_limit);

                let options;
                $.each(obj.res.os,function( key, value ) {
                    options +='<option value="'+value['id']+'"> '+value['type']+' '+value['name']+' '+value['version']+' '+' </option>'
                });
                $('#modal-newRvps #os').html(options);

            }
            $("#modal-newRvps").modal('show');
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