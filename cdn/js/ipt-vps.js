$(document).ready(function() {

    /**
     * IPT VPS
     */

    // Ajax Loc Plan - ipt/vps
    $('body').on('keyup change','#iploc', function(){
        let data = {
            loc: $(this).val()
        };
        const classA = 'ipt/getLocPlan';
        ajaxCall (classA, data,function(response) {
            let obj = JSON.parse(response);
            let options;
            if (obj.res) {
                options += '<option disabled selected> Select Plan </option>';
                $.each(obj.res,function( key, v ) {
                    options +='<option value="'+v['id']+'">'+v['plan_name']+'</option>'
                });
            }
            $('#plan').html(options);
        });
    })

    // Ajax Plan OS  - ipt/vps
    $('body').on('keyup change','#plan', function(){
        let data = {
            plan: $(this).val()
        };
        const classA = 'ipt/getPlanOS';
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
    var rvps;
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
                $('#modal-main .nav-link').attr('data-toggle','');
                $('#modal-main .nav-link').addClass('text-secondary');
                $('#modal-main #vps-ribbon').addClass('d-none');
                $('#modal-main #tab-1').removeClass('d-none');
                rvps = obj.res.rvps
                const o_plan = $('#plan option:selected').text();
                const o_os = $('#os option:selected').text();
                const planR = (obj.res.plan_r) ? '<span class="text-danger">Plan Need Change To <i>'+o_plan+'</i></span>' :'<span class="text-success">Same Plan.</span>';
                $("#modal-main #check-planr").html(planR);
                $("#modal-main #doA-select-rvps").data('planR',obj.res.plan_r && rvps.plan.plan_name);
                $("#modal-main #doA-select-rvps").data('plan',o_plan);
                $("#modal-main #doA-select-rvps").data('rvps',rvps.id);
                $("#modal-main #check-ip").html(rvps.ip.ip);
                $("#modal-main #check-ip-flag").addClass('cbf-'+rvps.ip.flag);
                $("#modal-main #check-ip-flag").attr('title',rvps.ip.country);
                $("#modal-main #check-plan").html(rvps.plan.plan_name);
                $("#modal-main #check-os").html(o_os);
                $("#modal-main #check-status").html(rvps.status);
                $("#modal-main #check-status").html(rvps.status_text[rvps.status]);
                $("#modal-main #check-status").removeClass();
                $("#modal-main #check-status").addClass('cb-copy-html rounded px-2 bg-'+rvps.status_color[rvps.status]);
                $("#modal-main #planR-O").addClass("d-none");
                if (obj.res.plan_r) {
                    $("#modal-main #planR-O").removeClass("d-none");

                    $('#modal-main #oplan .plan-name').html(rvps.plan.flag+'.'+rvps.plan.plan_name);
                    $('#modal-main #oplan .ram').html(rvps.plan.ram);
                    $('#modal-main #oplan .cpu').html(rvps.plan.cpu_core);
                    $('#modal-main #oplan .hdd').html(rvps.plan.hdd);
                    $('#modal-main #oplan .ssd').html(rvps.plan.ssd);
                    $('#modal-main #oplan .nvme').html(rvps.plan.nvme);
                    $('#modal-main #oplan .ram_limit').html(rvps.limits.ram_limit);
                    $('#modal-main #oplan .cpu_limit').html(rvps.limits.cpu_limit);
                    $('#modal-main #oplan .disk_limit').html(rvps.limits.disk_limit);

                    $('#modal-main #rplan .plan-name').html(obj.res.o_plan.flag+'.'+obj.res.o_plan.plan_name);
                    $('#modal-main #rplan .ram').html(obj.res.o_plan.ram);
                    $('#modal-main #rplan .cpu').html(obj.res.o_plan.cpu_core);
                    $('#modal-main #rplan .hdd').html(obj.res.o_plan.hdd);
                    $('#modal-main #rplan .ssd').html(obj.res.o_plan.ssd);
                    $('#modal-main #rplan .nvme').html(obj.res.o_plan.nvme);
                    $('#modal-main #rplan .ram_limit').html(obj.res.o_limits.ram_limit);
                    $('#modal-main #rplan .cpu_limit').html(obj.res.o_limits.cpu_limit);
                    $('#modal-main #rplan .disk_limit').html(obj.res.o_limits.disk_limit);

                }
                $("#modal-main").modal('show');
            }
        });
    })



    // Ajax Select rVPS  - ipt/vps
    $('body').on('click','#doA-select-rvps', function(){
        const plan =$(this).data('plan');
        const planR = $(this).data('planR');
        const rvps = $(this).data('rvps');
        if (planR){
            let body ='Are you changed VM plan from "'+planR+'" to "'+plan+'"?';
            let footer ='<button type="button" class="btn btn-success" data-dismiss="modal" onclick="convertRvps('+rvps+');">Yes</button>';
            footer +='<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>';
            makeModal('Change Plan',body,'sm',footer);
        } else {
            convertRvps(rvps);
        }
    })



})

// Ajax Convert rVPS  - ipt/vps
function convertRvps(id) {
    let data = {
        rvps: id
    };
    const classA = 'ipt/rVPS2VPS';
    ajaxCall (classA, data,function(response) {
        let obj = JSON.parse(response);
        (obj.e) && alert('Error, Check Console !');
        (obj.res) && loadVPS(obj.res);
    });
}

// Ajax Load VPS  - ipt/vps
var vps;
function loadVPS(id) {
    $('#modal-main .nav-link').attr('data-toggle','tab');
    $('#modal-main .nav-link').removeClass('text-secondary');
    $('#modal-main #vps-ribbon').removeClass('d-none');
    $('#modal-main #tab-1').addClass('d-none');
    let data = {
        vps: id
    };
    const classA = 'ipt/loadVPS';
    ajaxCall (classA, data,function(response) {
        let obj = JSON.parse(response);
        (obj.e) && alert('Error, Check Console !');
        if (obj.res.vps) {
            vps = obj.res.vps
            $("#modal-main #vps-ip").html(vps.ip.ip);
            $("#modal-main #vps-ip-flag").addClass('cbf-'+vps.ip.flag);
            $("#modal-main #vps-ip-flag").attr('title',vps.ip.country);
            $("#modal-main #vps-plan").html(vps.plan.plan_name);
            $("#modal-main #vps-os").html(vps.os.name);
            $("#modal-main #vps-status").html(vps.status);
            $("#modal-main #vps-status").html(vps.status_text[vps.status]);
            $("#modal-main #vps-status").removeClass();
            $("#modal-main #vps-status").addClass('cb-copy-html rounded px-2 bg-'+vps.status_color[vps.status]);
        }
    });
}