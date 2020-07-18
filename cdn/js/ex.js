/* Pass URLs - C.js */
var cbURL = $("meta[name=codebox-url]").attr('content');
var cbToken = $("#app-body").data('token');
var cbCDN = $("meta[name=codebox-cdn]").attr('content');
var cbIMG = $("meta[name=codebox-img]").attr('content');
var cbJS = $("meta[name=codebox-js]").attr('content');

/* Scroll To End & Top - C.js */
function scrollToBottom() {
  window.scrollTo(0,document.body.scrollHeight);
}
function scrollToTop() {
  window.scrollTo(0,document.body);
}

/* Bootstrap Basic - C.js */
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

/* Mobile Header Menu - C.js */
function showMobMenu() { 
  $('#mob-menu').animate({
    height:"toggle",
  }, 250, function() {
    // Animation complete.
  });
}

/* Random Range - C.js */
function randRange( minNum, maxNum) {return (Math.floor(Math.random() * (maxNum - minNum + 1)) + minNum);}

$(document).ready(function() {

/* CB AM - C.js */
	$("#cb-menu .collapse").on('shown.bs.collapse', function(e) {
    scrollToBottom();
  });
  
  /* Mdal OB - C.js */
  $('.cb-ob').on('show.bs.modal || hide.bs.modal', function() {
    $('#app-body>div').toggleClass('cb-ob');
  });
  
  /* Mobile Footer Menu - C.js */
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
  
  /* Mobile Rotate Logo on Footer - C.js */
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

  /* Auto Fading - C.js */
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

  /* Action By Scroll - C.js */
  function actByScroll (obj,target,remove=null,add=null,revers=0) {
    let obj_offset = $(obj).position().top + $(obj).outerHeight();
    let scrolled = $(window).scrollTop() + $(window).height()*0.85;
    if(scrolled > obj_offset) {
      $(target).removeClass(remove).addClass(add);
    } else if (revers) {
      $(target).removeClass(add).addClass(remove);
    }
  }

  /* Page Group - C.js */
  const pageG = $('#app-body').data('g');

  /* Screen Checker - C.js */
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

  /* Ajax Actions */

  // Ajax Alert
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
  // Ajax Call
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
        alert(status);
      }
    });
  }
  // Ajax reload
  function ajaxReload () {
    $('.cb-ajax-u').each(function() {
      $('#'+this.id).load(' #'+this.id);
    });
  }
  // Ajax form
  $("form").submit(function(event){
    event.preventDefault();
    const id = $(this).attr('id');
    const data = $('#'+id).serialize();
    const classA = $('#'+id).attr('action');
    ajaxCall (classA, data,function(response) {
      let obj = JSON.parse(response);
      let type = (obj.e) ? 'danger' : 'success';
      let text = (obj.e) ? 'Error, User not added. '+obj.res : 'Success, User Added.';
      ajaxAlert (id, type, text);
      ajaxReload ();
    });
  });

  // Ajax Change status
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

  // Ajax Rest Pass
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
        $( "<span>"+obj.res+"</span>" ).insertAfter(thisClick);
      }
    });
  });

});

