/* Pass URLs - Core */
var cbURL = $("meta[name=codebox-url]").attr('content');
var cbToken = $("#app-body").data('token');
var cbCDN = $("meta[name=codebox-cdn]").attr('content');
var cbIMG = $("meta[name=codebox-img]").attr('content');
var cbJS = $("meta[name=codebox-js]").attr('content');


/* Scroll To End & Top - Core */
function scrollToBottom() {
  window.scrollTo(0,document.body.scrollHeight);
}
function scrollToTop() {
  window.scrollTo(0,document.body);
}

/* Bootstrap Basic - Core */
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
$("[data-toggle=popover]").each(function(i, obj) {
    $(this).popover({
      html: true,
      content: function() {
        var id = $(this).attr('id')
        return $('#popover-content-' + id).html();
      }
    });
});

/* Mobile Header Menu - Core */
function showMobMenu() { 
  $('#mob-menu').animate({
    height:"toggle",
  }, 250, function() {
    // Animation complete.
  });
}

/* Random Range - Core */
function randRange( minNum, maxNum) {return (Math.floor(Math.random() * (maxNum - minNum + 1)) + minNum);}

/* DT Actions - Core */
function tableReload(table) {
  $('#'+table).DataTable().ajax.reload(null, false);
}

$(document).ready(function() {


  // Ajax Refresh DataTables - Core
  $('body').on('click','.doP-refresh', function(){
    $(this).addClass('fa-spin');
    const table = $(this).data('table');
    $.when(
     tableReload(table)
    ).then(
      $(this).removeClass('fa-spin')
    );
  });

  /* DT Actions - Core */
  $('#actlogs').DataTable( {
    "order": [[ 0, "desc" ]],
    "pageLength": 10,
    "processing": true,
    "serverSide": true,
    "ajax":  {
      url: cbURL+"ajax/core/getPathLogs&token="+cbToken,
      type: 'POST'
    }
  } );

  /* DT Actions - admin/logs */
  $('#actlog').DataTable( {
    "order": [[ 0, "desc" ]],
    "pageLength": 25,
    "processing": true,
    "serverSide": true,
    "ajax":  {
      url: cbURL+"ajax/core/getAllLogs&token="+cbToken,
      type: 'POST'
    }
  } );

  /* CB AM - Core */
	$("#cb-menu .collapse").on('shown.bs.collapse', function(e) {
    scrollToBottom();
  });
  
  /* Modal OB - Core */
  $('.cb-ob').on('show.bs.modal || hide.bs.modal', function() {
    $('#app-body>div').toggleClass('cb-ob');
  });
  
  /* Mobile Footer Menu - Core */
  $(".f-nav-open").click(function(){
    $(this).fadeOut();
    $(".f-nav-close").fadeIn();
    $(".f-nav-m").animate({
      bottom: 0,
      opacity:1
    }, 400, function() {
      // Animation complete.
    });
  });
  $(".f-nav-close").click(function(){
    $(this).fadeOut();
    $(".f-nav-open").fadeIn();
    $(".f-nav-m").animate({
      bottom: -235,
      opacity:0.9
    }, 250, function() {
      // Animation complete.
    });
  });
  
  /* Mobile Rotate Logo on Footer - Core */
  $(window).scroll( function(){
    var Top_of_object = $('#cb-menu').position().top;
    var Top_of_endbox = $('.cb-endbox').position().top;
    var Top_of_window = $(window).scrollTop();
    if( (Top_of_window > Top_of_object) && (Top_of_window+$(window).height() < Top_of_endbox) ) {
      $('.showMobMenu span').hide();
      $('.h-nav').addClass('rot-menu');
    } else {
      $('.h-nav').removeClass('rot-menu');
      $('.showMobMenu span').fadeIn();
    }
  });

  /* Auto Fading - Core */
  $(window).scroll( function(){
    var bottom_of_window = $(window).scrollTop() + $(window).height();
    $('.cb-oh').each( function(i){
      var bottom_of_object = $(this).position().top + $(this).outerHeight()/4;
      if( bottom_of_window > bottom_of_object ) {
        $(this).removeClass('cb-oh').addClass('cb-os');
      }
    }); 
    if( bottom_of_window > $(window).height()+250 ) {
      $('#gotop').fadeIn();
    } else {
      $('#gotop').fadeOut();
    }
  });
  $('#app-body>div:first-child,.cb-oa').removeClass('cb-oh cb-oa').addClass('cb-os');;

  /* Action By Scroll - Core */
  function actByScroll (obj,target,remove=null,add=null,revers=0) {
    let obj_offset = $(obj).position().top + $(obj).outerHeight();
    let scrolled = $(window).scrollTop() + $(window).height()*0.85;
    if(scrolled > obj_offset) {
      $(target).removeClass(remove).addClass(add);
    } else if (revers) {
      $(target).removeClass(add).addClass(remove);
    }
  }

  /* Page Group - Core */
  const pageG = $('#app-body').data('g');

  /* Screen Checker - Core */
  $(window).on("resize", function (e) {
    checkScreenSize();
  });
  checkScreenSize();
  function checkScreenSize() {
    const newWindowWidth = $(window).width();
    if (newWindowWidth < 575) { // mobile
    
      if (pageG=="vps") {

        /* Hide SSD switch - vps.js */
        $(window).scroll( function(){
          actByScroll ('#cb-pbox','.ssd-hdd.alert, .de-fr.alert','cb-os','cb-oh',1); // ssd-hdd
        });
      }
    } else {
    
      if (pageG=="vps") {   
        /* Auto BLink Flag - vps.js */
        $('.cb-flag.cbf-'+vpsCountry).addClass(' animated flash infinite');
      }
    }
  }

  /* Modal */

  // Modal Maker - Core
  function makeModal(title,body,size='md',footer=null) {
    $("#modal .modal-dialog").removeClass().addClass('modal-dialog modal-'+size);
    $("#modal .modal-title").html(title);
    $("#modal .modal-body").html(body);
    if (footer) $("#modal .modal-footer").html(footer);
    $("#modal").modal('show');
  }

  /* Ajax Actions */

  // Ajax Alert - Core
  let alertID = 0;
  function ajaxAlert (id, type, text) {
    alertID++;
    let resAlert = '<div id="'+alertID+'" class="alert alert-'+type+'" role="alert">#'+alertID+' '+text;
    resAlert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    $('#'+id+' .alerts').append(resAlert);
    $('#'+id+' #'+alertID).fadeTo(2000, 500).slideUp(2800, function() {
      $('#'+id+' #'+alertID).slideUp(2800);
    });
  }
  // Ajax Call- Core
  function ajaxCall (classAction, data, callback) {
    $.ajax({
      type: "POST",
      url: cbURL+"ajax/"+classAction+'&token='+cbToken,
      data: data,
      cache: false,
      global: false,
      async: true,
      success: callback,
      error: function(request, status, error) {
        console.log(request);
        console.log(status);
        console.log(error);
      }
    });
    afterAjax();
  }
  // Ajax logs reload - Core
  function afterAjax () {
    tableReload('actlogs');
  }
  // Ajax reload Id - Core
  function ajaxReloadId (id) {
    $('#'+id).load(' #'+id);
  }
  // Ajax reload - Core
  function ajaxReload () {
    $('.cb-ajax-u').each(function() {
      $('#'+this.id).load(' #'+this.id);
    });
  }


  /**
   * User
   */
  // Ajax Login - Core
  $('body').on('submit','form#login', function(event){
    event.preventDefault();
    const id = $(this).attr('id');
    const reload = $(this).data('reload');
    const data = $('#'+id).serialize();
    const classA = $('#'+id).attr('action');
    ajaxCall (classA, data,function(response) {
      let obj = JSON.parse(response);
      let type = (obj.e) ? 'danger' : 'success';
      let text = (obj.e) ? 'Data is wrong !' : 'Success, Loged In';
      ajaxAlert (id, type, text);
      (reload) && ajaxReload ();
      (obj.e) || location.reload();
    });
  });

  // Ajax Logout - Core
  $('body').on('click','.doA-logout', function(){
    let thisClick = $(this);
    let rid = thisClick.data('rid');
    data = "rid="+rid;
    ajaxCall ('users/logout', data,function(response) {
      let obj = JSON.parse(response);
      let type = (obj.e) ? 'danger' : 'success';
      let text = (obj.e) ? 'Error !' : 'Success, User Loged out.';
      ajaxAlert ('app-notify', type, text);
      if (obj.res) {
        location.reload();
      }
    });
  });


  // Ajax Change fis - seo/keywords
  $('body').on('click','.doM-logdata', function(){
    console.log($(this).data('logdata'));
  });


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


  /**
   * FIS
   */

  // Progress Circle  - seo/fis
  $('.p-circle').each(function() {
    let ratio = $(this).data('ratio');
    $(this).circleProgress({
      value: ratio,
      size: 95,
      fill: {color: 'rgb('+((ratio>0.37)?0:255)+','+(ratio*200)+',0)'}
    }).on('circle-animation-progress', function(event, progress, stepValue) {
      $(this).find('strong').text(stepValue.toFixed(2));
    });
  });
  // Ajax Add Fis - seo/fis
  $('body').on('click','.doA-fisopen', function(){
    let thisClick = $(this);
    let rid = thisClick.data('rid');
    let eid = thisClick.data('eid');
    data = "keyword_id="+rid+"&engin="+eid;
    ajaxCall ('seo/addFis', data,function(response) {
      let obj = JSON.parse(response);
      let type = (obj.e) ? 'danger' : 'success';
      let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
      if (obj.res) {
        // thisClick.removeAttr('href');
        thisClick.removeClass('doA-fisopen').addClass('cb-ob-1');
        let ratio = $('#circle-'+rid).data('ratio')+0.09;
        $('#circle-'+rid).data('ratio',ratio);
        $('#ratio-'+rid).text(ratio);
        $('#circle-'+rid).circleProgress({value: ratio});
        $('#circle-'+rid).circleProgress({fill: {color: 'rgb('+((ratio>0.37)?0:255)+','+(ratio*200)+',0)'}});
      }
    });
  });


});

