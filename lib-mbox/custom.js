(function(a,b){"use strict";var c=typeof Element!="undefined"&&"ALLOW_KEYBOARD_INPUT"in Element,d=function(){var a=[["requestFullscreen","exitFullscreen","fullscreenchange","fullscreen","fullscreenElement","fullscreenerror"],["webkitRequestFullScreen","webkitCancelFullScreen","webkitfullscreenchange","webkitIsFullScreen","webkitCurrentFullScreenElement","webkitfullscreenerror"],["mozRequestFullScreen","mozCancelFullScreen","mozfullscreenchange","mozFullScreen","mozFullScreenElement","mozfullscreenerror"]],c=0,d=a.length,e={},f,g;for(;c<d;c++){f=a[c];if(f&&f[1]in b){for(c=0,g=f.length;c<g;c++)e[a[0][c]]=f[c];return e}}return!1}(),e={isFullscreen:b[d.fullscreen],element:b[d.fullscreenElement],request:function(a){var e=d.requestFullscreen;a=a||b.documentElement,a[e](c&&Element.ALLOW_KEYBOARD_INPUT),b.isFullscreen||a[e]()},exit:function(){b[d.exitFullscreen]()},toggle:function(a){this.isFullscreen?this.exit():this.request(a)},onchange:function(){},onerror:function(){}};if(!d){a.screenfull=null;return}b.addEventListener(d.fullscreenchange,function(a){e.isFullscreen=b[d.fullscreen],e.element=b[d.fullscreenElement],e.onchange.call(e,a)}),b.addEventListener(d.fullscreenerror,function(a){e.onerror.call(e,a)}),a.screenfull=e})(window,document);
mbox_fullscreen = 1;
mbox_play = 0;
mbox_fullscreen_exit = 0;
mbox_id_tot = 1;

mbox_ajaxing = 0;
mbox_pic_mode = 1;
mbox_slideshow = 0;
mbox_slideshow_time = 8;
mbox_slideshow_progress = 0;
mbox_opacity = 0.4;
mbox_mobile = 0;

jQuery(document).ready(function() {

setTimeout('mbox_popup_by_url()', 500);

jQuery('body').on("click", ".mbox-text-menu", function(){
jQuery(this).toggleClass('mbox-text-ready');
});

jQuery('body').on("click", ".mbox_down", function(){
jQuery('.mbox-download').trigger('click');
});

jQuery('body').on("click", ".mbox_slid", function(){
jQuery('.mbox-play, .mbox-pause').trigger('click');
});

jQuery('body').on("click", ".mbox_cmode", function(){
jQuery('.mbox-mode-1, .mbox-mode-0').trigger('click');
});

jQuery('body').on("click", ".mbox_quit", function(){
jQuery('.mbox-fullscreen').trigger('click');
});

jQuery('body').on("click", ".mbox_idata, .mbox_idata_hider", function(){
jQuery('.mbox-right').toggleClass('mbox_idata_box');
});

jQuery('body').on("click", ".mbox-mode-0, .mbox-mode-1", function(e){
if(mbox_pic_mode==0){
jQuery(this).addClass('mbox-mode-1').removeClass('mbox-mode-0');
mbox_pic_mode=1;
} else {
jQuery(this).addClass('mbox-mode-0').removeClass('mbox-mode-1');
mbox_pic_mode=0;
}
mbox_resize_image();
});



jQuery('body').on("click", ".mbox-play, .mbox-pause", function(e){
if(mbox_slideshow==0){
jQuery(this).addClass('mbox-pause').removeClass('mbox-play');
mbox_slideshow=1;
} else {
jQuery(this).addClass('mbox-play').removeClass('mbox-pause');
mbox_slideshow=0;
}
mbox_toggle_slideshow();
});


jQuery(window).resize(function(){
mbox_resize_image();
});

mbox_apply_ids();

jQuery(document).on("click", ".mbox-close", function(e){
if(jQuery('.mbox-pause').length==1){
mbox_slideshow = 0;
jQuery('.mbox-progress').stop();
if (typeof mbox_show != 'undefined'){clearTimeout(mbox_show);}
if (typeof mbox_wait != 'undefined'){clearTimeout(mbox_wait);}
}
jQuery('.mbox-packer').remove();
jQuery('body, html').removeClass('mbox-noflow');
jQuery('.mbox-current').removeClass('mbox-current');
});

jQuery("body").on("click", ".mbox", function(event){
event.preventDefault();

var img = jQuery(this).attr("href");
var mbid = jQuery(this).attr("data-mid");
var pg_url = jQuery(this).attr("data-page");
var img_id = jQuery(this).closest('li').attr("id");
if(pg_url===undefined){pg_url=img;}
var mbox_sharethis = '<div class="mbox_share">'+mbox_sharethis_tags+'</div>';

var titlex = jQuery(this).attr("title");
if(titlex=='' || titlex==" " || titlex===undefined){titlex='<i>No Title</i>';}
var title = titlex+''+mbox_sharethis;
var descr = jQuery(this).find(".mbox-descr").html();
if(descr===undefined && img_id===undefined){
var descr = '';
mbox_ajaxing = 0;
} else if(descr===undefined && img_id!==undefined){
var descr = 'Loading . . .';
mbox_ajaxing = 1;
} else {
mbox_ajaxing = 0;
}




var cmt_data = '';
var txt_dis = '';

descr = '<div class="mbox_info">'+descr+'</div>'+txt_dis+''+cmt_data;
jQuery('.mbox').removeClass('mbox-current');
jQuery(this).addClass('mbox-current');
jQuery('body, html').addClass('mbox-noflow');
mbox_create();
jQuery('.mbox-image-title').removeClass('mbox-yt-title');

if(mbid==jQuery('.mbox').length) {jQuery('.mbox-nav-next').hide();} else {jQuery('.mbox-nav-next').show();}
if(mbid==1) {jQuery('.mbox-nav-prev').hide();} else {jQuery('.mbox-nav-prev').show();}

var datatype = jQuery(this).attr('data-type');

if(datatype===undefined || datatype=='image'){
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-right-descr').html(descr+'<div class="mbox_idata_hider"></div>');
jQuery('.mbox-image-block').html('<div class="mbox-loading"></div><img style="width:1px;height:1px;" class="mbox-image-block-img" onload="mbox_resize_image()" src="'+img+'" />');
}

if(datatype=='iframe'){
jQuery('.mbox-image-block').html('<div class="mbox-iframe-outer"><iframe border="0" frameborder="0" class="mbox-iframe" src="'+img+'"></iframe></div>');
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-right-descr').html(descr);
}

if(datatype=='youtube'){
var ytid = mbox_ytid(img);
jQuery('.mbox-image-block').html('<div class="yt-box-outer"><object width="100%" height="100%"><param name="wmode" value="transparent" /><param name="movie" value="//www.youtube.com/v/'+ytid+'?version=3&amp;hl=en_US&amp;autoplay=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed WMODE="transparent" src="//www.youtube.com/v/'+ytid+'?version=3&amp;hl=en_US&amp;autoplay=0" type="application/x-shockwave-flash" width="100%" height="100%" allowscriptaccess="always" allowfullscreen="true"></embed></object></div>');
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-image-title').addClass('mbox-yt-title');
jQuery('.mbox-right-descr').html(descr);
}

if(datatype=='flash'){
jQuery('.mbox-image-block').html('<div class="yt-box-outer"><object width="100%" height="100%"><param name="wmode" value="transparent" /><param name="movie" value="'+img+'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed WMODE="transparent" src="'+img+'" type="application/x-shockwave-flash" width="100%" height="100%" allowscriptaccess="always" allowfullscreen="true"></embed></object></div>');
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-image-title').addClass('mbox-yt-title');
jQuery('.mbox-right-descr').html(descr);
}

if(datatype=='vimeo'){
var vid = getVimeoId(img);
jQuery('.mbox-image-block').html('<div class="yt-box-outer"><iframe border="0" frameborder="0" class="mbox-iframe" src="http://player.vimeo.com/video/'+vid+'"></iframe></div>');
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-image-title').addClass('mbox-yt-title');
jQuery('.mbox-right-descr').html(descr);
}

if(datatype=='html'){
var xhtml = jQuery(img+':first').html();
jQuery('.mbox-image-block').html('<div class="mbox-html-outer">'+xhtml+'</div>');
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-right-descr').html(descr);
}

if(datatype=='ajax'){
jQuery('.mbox-image-block').html('<div class="mbox-html-outer mbox-ajax-loading"></div>');
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-right-descr').html(descr);
var uparts = img.split("||||");

jQuery.get(uparts[0], function(data) {
jQuery('body').append('<div class="mbox-hidden-data">'+data+'</div>');
if(uparts[1]===undefined){ndata=data;} else {
var ndata = jQuery('.mbox-hidden-data '+uparts[1]).html();
}
jQuery('.mbox-html-outer').html(ndata);
jQuery('.mbox-hidden-data').remove();
jQuery('.mbox-html-outer').removeClass('mbox-ajax-loading');
});
}

if(datatype=='xajax'){
jQuery('.mbox-image-block').html('<div class="mbox-html-outer mbox-ajax-loading"></div>');
jQuery('.mbox-image-title').html(title);
jQuery('.mbox-right-descr').html(descr);
var uparts = img.split("||||");

jQuery.get('lib-mbox/ajax_load.php?url='+uparts[0], function(data) {

jQuery('body').append('<div class="mbox-hidden-data">'+data+'</div>');
if(uparts[1]===undefined){ndata=data;} else {
var ndata = jQuery('.mbox-hidden-data '+uparts[1]).html();
}
jQuery('.mbox-html-outer').html(ndata);
jQuery('mboxdisablescript').remove();
jQuery('.mbox-hidden-data').remove();
jQuery('.mbox-html-outer').removeClass('mbox-ajax-loading');
});
}

if(mbox_ajaxing==1){
jQuery.post(ajaxurl, {action:'wptf_ajax', mode:'descr', imgid:img_id}, function(response) {
jQuery('.mbox_info').html(response);
});
}

});


jQuery("body").on("click", ".mbox-nav-next", function(event){
var xid = parseInt(jQuery('.mbox-current').attr('data-mid'))+1;
jQuery('.mbox[data-mid="'+xid+'"]').trigger('click');
});

jQuery("body").on("click", ".mbox-nav-prev", function(event){
var xid = parseInt(jQuery('.mbox-current').attr('data-mid'))-1;
jQuery('.mbox[data-mid="'+xid+'"]').trigger('click');
});


if(screenfull!==null){
jQuery("body").on("click", ".mbox-fullscreen", function(event){
screenfull.toggle( jQuery('.mbox-left')[0] );
});

screenfull.onchange = function(e){

setTimeout("mbox_resize_image()", 200);
if(screenfull.isFullscreen){
jQuery('.mbox-left').addClass('mbox-full-mode');
} else {
if(mbox_fullscreen_exit==0){
jQuery('.mbox-left').removeClass('mbox-full-mode');
} else { jQuery('.mbox-left').removeClass('mbox-full-mode');jQuery('.mbox-close').trigger('click'); }
}
};
} else {
// Fullscreen not supported, going for alternative
mbox_fullscreen = 0;
}

jQuery("body").on("click", ".mbox-fullscreen", function(event){
if(mbox_fullscreen==0){
if(mbox_fullscreen_exit==1 && jQuery('.mbox-alternate-mode').length==1){

jQuery(".mbox-close").trigger('click');
} else {
jQuery(".mbox-left").toggleClass('mbox-alternate-mode');
}
}
setTimeout("mbox_resize_image()", 200);
});


jQuery("body").on("click", ".mbox-download", function(event){
var url = jQuery(".mbox-image-block-img").attr("src");
document.location.href=url;
});



});  /*  End document ready  */


/* Read width and height */
  (function($){
    var
    props = ['Width', 'Height'],
    prop;

    while (prop = props.pop()) {
    (function (natural, prop) {
      $.fn[natural] = (natural in new Image()) ? 
      function () {
      return this[0][natural];
      } : 
      function () {
      var 
      node = this[0],
      img,
      value;

      if (node.tagName.toLowerCase() === 'img') {
        img = new Image();
        img.src = node.src,
        value = img[prop];
      }
      return value;
      };
    }('natural' + prop, prop.toLowerCase()));
    }
  }(jQuery));
  

function mbox_replaceSubstring(inSource, inToReplace, inReplaceWith){
var outString = inSource;
while (true) {
var idx = outString.indexOf(inToReplace);
if (idx == -1) {
break;}
outString = outString.substring(0, idx) + inReplaceWith +
outString.substring(idx + inToReplace.length);
}return outString;
}
  
function mbox_ytid(url){
var youtube_id;
youtube_id = url.replace(/^[^v]+v.(.{11}).*/,"$1");
return youtube_id;
}

function getVimeoId(url) {
var match = /vimeo.*\/(\d+)/i.exec(url);
if (match){return match[1];}}

function mbox_create(){
if(jQuery('.mbox-packer').length==0){

var mbox_textmenu = '<div class="mbox-text-menu">\
<ul>\
<li class="mbox_down">Download Photo</li>\
<li class="mbox_idata">Toggle Description</li>\
<li class="mbox_slid">Toggle Slideshow</li>\
<li class="mbox_cmode">Toggle Crop Mode</li>\
<li class="mbox_quit">Exit</li>\
</ul>\
</div>';

var xhtml = '<div class="mbox-packer">\
<div class="mbox-bg"></div>\
\
<div class="mbox-packer-data">\
<div class="mbox-left">\
<div class="mbox-right">\
<div class="mbox-close">X</div>\
<div class="mbox-right-descr"></div>\
<div style="clear:both;"></div>\
</div>\
<div class="mbox-outer">\
<div class="mbox-download"></div>\
<div style="background-image:url('+wptf_domain+'/lib-mbox/img_bg.png)" class="mbox_preload_next" /><div style="background-image:url('+wptf_domain+'/lib-mbox/img_bg.png)" class="mbox_preload_prev" />\
<div class="mbox-image-block">\
<img onload="mbox_resize_image()" class="mbox-image-block-img" src="" />\
</div><div class="mbox-slideshow"><div class="mbox-progress"></div></div><div class="mbox-image-title"></div>\
</div>\
<div class="mbox-nav-next"></div>\
<div class="mbox-nav-prev"></div>\
'+mbox_textmenu+'<div class="mbox-fullscreen"></div>\
<div class="mbox-mode-'+mbox_pic_mode+'"></div>\
<div class="mbox-play"></div>\
</div>\
</div>';
jQuery("body").append(xhtml);
jQuery('.mbox-bg').fadeTo(1, mbox_opacity);
}



var screenw = jQuery(window).width();
if(screenw<800){
var stype = 'fullscreen';
mbox_mobile = 1;
jQuery('.mbox-packer').addClass('mbox-mobile');
jQuery('.mbox-download, .mbox-play, .mbox-pause, .mbox-mode-1, .mbox-mode-0, .mbox-fullscreen').hide();
} else {
var stype = jQuery('.mbox-current').attr('data-init');
jQuery('.mbox-packer').removeClass('mbox-mobile');
jQuery('.mbox-download, .mbox-play, .mbox-pause, .mbox-mode-1, .mbox-mode-0, .mbox-fullscreen').show();
}


if(stype=='fullscreen'){
mbox_fullscreen_exit = 1;
if(jQuery('.mbox-full-mode, .mbox-alternate-mode').length==0){jQuery('.mbox-fullscreen').trigger('click');}
} else {
mbox_fullscreen_exit = 0;
}
}

function mbox_resize_image(){

mbox_init_preload();

jQuery('.mbox-loading').remove();
jQuery('.mbox-image-block-img').attr("style","");

if(jQuery('.mbox-iframe-outer').length==1){
var ihtml  = jQuery('.mbox-iframe-outer').html();
jQuery('.mbox-iframe-outer').html('');
jQuery('.mbox-iframe-outer').html(ihtml);
} // reloading maps

if(jQuery('.mbox-image-block-img').length==0){return false;}
var imgw = jQuery('.mbox-image-block-img').naturalWidth();
var imgh = jQuery('.mbox-image-block-img').naturalHeight();

var rh = jQuery(window).height();
var rw = jQuery(window).width();
if(jQuery('.mbox-full-mode, .mbox-alternate-mode').length==0){
newh = rh;
neww = rw-400;
var eh = ((imgh*neww)/imgw); // estimated height
var ew = (imgw/imgh)*eh; // estimated width
ch = eh-newh; // cropped height
} else {
newh = rh;
neww = rw;
var eh = ((imgh*rw)/imgw); // estimated height
var ew = (imgw/imgh)*eh; // estimated width
ch = eh-rh; // cropped height
}


if(mbox_pic_mode==1){

if(imgh>imgw){

if(ch>0){
jQuery('.mbox-image-block-img').css('height',newh);
jQuery('.mbox-image-block-img').css('width','auto');
} else {
jQuery('.mbox-image-block-img').css('height','auto');
jQuery('.mbox-image-block-img').css('width',neww);
}

} else {

if(ch<=0){
jQuery('.mbox-image-block-img').css('height','auto');
jQuery('.mbox-image-block-img').css('width',neww);
} else {
jQuery('.mbox-image-block-img').css('height',newh);
jQuery('.mbox-image-block-img').css('width','auto');
}

}

} else {

		if(imgh>imgw){

				if(ch>0){
				var xnewh = imgh*neww/imgw;
				var xh = (xnewh-newh)/2;
				jQuery('.mbox-image-block-img').css('height','auto');
				jQuery('.mbox-image-block-img').css('width',neww);
				jQuery('.mbox-image-block-img').css('margin-left','0');
				jQuery('.mbox-image-block-img').css('margin-top','-'+xh+'px');
				} else {
				var xneww = imgw*newh/imgh;
				var xw = (xneww-neww)/2;
				jQuery('.mbox-image-block-img').css('height',newh+'px');
				jQuery('.mbox-image-block-img').css('width','auto');
				jQuery('.mbox-image-block-img').css('margin-left','-'+xw+'px');
				jQuery('.mbox-image-block-img').css('margin-top','0');
				}

		} else {
		
				if(ch<0){
				var xneww = imgw*newh/imgh;
				var xw = (xneww-neww)/2;
				jQuery('.mbox-image-block-img').css('height',newh+'px');
				jQuery('.mbox-image-block-img').css('width','auto');
				jQuery('.mbox-image-block-img').css('margin-left','-'+xw+'px');
				jQuery('.mbox-image-block-img').css('margin-top','0');
				} else {
				var xnewh = imgh*neww/imgw;
				var xh = (xnewh-newh)/2;
				jQuery('.mbox-image-block-img').css('height','auto');
				jQuery('.mbox-image-block-img').css('width',neww);
				jQuery('.mbox-image-block-img').css('margin-left','0');
				jQuery('.mbox-image-block-img').css('margin-top','-'+xh+'px');
				}
		}




}








}






function mbox_apply_ids(){
jQuery( ".mbox" ).each(function(){
var x = jQuery(this).attr('data-mid');
if(x===undefined){
jQuery(this).attr('data-mid',mbox_id_tot);
mbox_id_tot = mbox_id_tot + 1;
}

var y = jQuery(this).attr('data-page');
if(y===undefined){

var loc = window.location.href;
var xloc = loc.split('#mbox-view-');
var url = xloc[0];
var xid = jQuery(this).closest('li').attr('id');
var pid = xid.replace('wptf-img-','');
var newurl = wptf_domain+'/wptf-view.php?id='+pid+'&url='+url;

jQuery(this).attr('data-page',newurl);
}

});
setTimeout("mbox_apply_ids()", 3000);
}


function mbox_toggle_slideshow(){
if(mbox_slideshow == 1){
jQuery('.mbox-nav-prev, .mbox-nav-next').addClass('mbox-nav-hide');
jQuery('.mbox-slideshow').show();
mbox_progress();
} else {
jQuery('.mbox-nav-prev, .mbox-nav-next').removeClass('mbox-nav-hide');
jQuery('.mbox-slideshow').hide();
jQuery('.mbox-progress').stop();
if (typeof mbox_show != 'undefined'){clearTimeout(mbox_show);}
if (typeof mbox_wait != 'undefined'){clearTimeout(mbox_wait);}
}

}

function mbox_progress(){
if(jQuery('.mbox-loading').length!=1){

if(jQuery('.mbox-current').attr('data-mid')!=jQuery('.mbox-current').closest('.wptf-gallery').find('.mbox').length==1){
jQuery('.mbox-progress').stop();
jQuery('.mbox-progress').animate({width: '0%'}, 0);
jQuery('.mbox-progress').animate({width: '100%'}, mbox_slideshow_time*1000);
mbox_show = setTimeout("mbox_slideshow_next_click()", mbox_slideshow_time*1000);
} else {
if (typeof mbox_show != 'undefined'){clearTimeout(mbox_show);}
if (typeof mbox_wait != 'undefined'){clearTimeout(mbox_wait);}
jQuery('.mbox-pause').trigger('click');
alert('Reached the last slide. Stopping the slideshow.');
}
} else {
console.log('loading screen...wait 1 second');
jQuery('.mbox-progress').stop();
jQuery('.mbox-progress').animate({width: '0%'}, 0);
if (typeof mbox_show != 'undefined'){clearTimeout(mbox_show);}
if (typeof mbox_wait != 'undefined'){clearTimeout(mbox_wait);}
mbox_wait = setTimeout("mbox_waiting()", 1000);
}
}

function mbox_slideshow_next_click(){
if (typeof mbox_show != 'undefined'){clearTimeout(mbox_show);}
jQuery('.mbox-nav-next').trigger('click');
mbox_wait = setTimeout("mbox_waiting()", 1000);
}

function mbox_waiting(){
if(jQuery('.mbox-loading').length==1){
if (typeof mbox_wait != 'undefined'){clearTimeout(mbox_wait);}
mbox_wait = setTimeout("mbox_waiting()", 1000);
} else {
if (typeof mbox_wait != 'undefined'){clearTimeout(mbox_wait);}
mbox_progress();
}
}

// preloader

function mbox_init_preload(){

var next = parseInt(jQuery('.mbox-current').attr('data-mid'))+1;
var prev = next-2;

if(jQuery('.mbox[data-mid="'+next+'"]').length==1){
var xsrc = jQuery('.mbox[data-mid="'+next+'"]').attr('href');
jQuery('.mbox_preload_next').css('background-image', 'url('+xsrc+')');
}

if(jQuery('.mbox[data-mid="'+prev+'"]').length==1){
var xsrc = jQuery('.mbox[data-mid="'+prev+'"]').attr('href');
jQuery('.mbox_preload_prev').css('background-image', 'url('+xsrc+')');
}

}




function mbox_popup_by_url(){
var loc = window.location.href;
if (loc.indexOf("#mbox-view-") !=-1) {
var x = loc.split("#mbox-view-");
jQuery('#wptf-img-'+x[1]+' .mbox:first-child').trigger('click');
}
}