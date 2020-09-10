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
  $('body').tooltip({selector: '[data-toggle="tooltip"]'});
})

$(document).ajaxComplete(function() {
  $("[data-toggle=popover]").each(function(i, obj) {
    $(this).popover({
      html: true,
      content: function() {
        var id = $(this).attr('id')
        return $('#popover-content-' + id).html();
      }
    });
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

/* Copy Text */
function copyText(text) {
  $("#cb-copy").val(text).select();
  document.execCommand("copy");
  $('#cb-copy').remove();
}

$('body').on('click','.cb-copy-data', function(){
  $('<input id="cb-copy" value="test">').insertAfter($(this));
  copyText($(this).data('cb-copy'));
  console.log('Copy Done ...');
});
$('body').on('click','.cb-copy-html', function(){
  let _this = $(this);
  if (!_this.data('copy')) {
    _this.data('copy',1);
    $('<input id="cb-copy" value="test">').insertAfter($(this));
    let text = _this.html();
    copyText(text);
    _this.html('<small>Copy Done ...<small>');
    setTimeout(function(){
      _this.html(text);
    }, 300);
    setTimeout(function(){
      _this.data('copy',0);
    }, 300);
  }

});
$('body').on('click','.cb-copy-val', function(){
  let _this = $(this);
  if (!_this.data('copy')) {
    $('<input id="cb-copy" value="test">').insertAfter($(this));
    let text = _this.val();
    copyText(text);
    _this.val('Copy Done ...');
    setTimeout(function(){
      _this.val(text);
    }, 300);
    setTimeout(function(){
      _this.data('copy',0);
    }, 300);
  }
});




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
      $('#is-online')
          .removeClass('text-danger text-success text-warning')
          .addClass('text-danger');
      console.log(status);
    }
  });
  if (classAction!='users/login' && classAction!='users/logout' && classAction!='core/serverCheck') {
    afterAjax();
  }
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
  /* table DT - Core */
  $('.table-DT-m').DataTable( {
    "order": [[ 0, "desc" ]],
    "pageLength": 10,
  });
  /* table DT - Core */
  $('.table-DT').DataTable( {
    "order": [[ 0, "desc" ]],
    "pageLength": 25,
  });
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
  });


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

    } else {

    }
  }

  // Ajax Server Checker - Core
  async function serverCheck () {
    ajaxCall ('core/serverCheck', null,function(response) {
      let obj = JSON.parse(response);
      let serverStatus = (obj.res) ? 'text-success' : 'text-warning';
      $('#is-online').removeClass('text-danger text-success text-warning');
      $('#is-online').addClass(serverStatus);
      if (obj.res==false) {
        $('#app-body').addClass('cb-ob');
      } else {
        $('#app-body').removeClass('cb-ob');
      }
    });
  }
  setInterval(async function(){serverCheck();}, 75000);

  // Ajax Login - Core
  $('body').on('submit','form#login', function(event){
    event.preventDefault();
    const id = $(this).attr('id');
    const reload = $(this).data('reload');
    const data = $(this).serialize();
    const classA = $(this).attr('action');
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

});