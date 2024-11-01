jQuery( document ).ready(function() {

jQuery('body').on('click', '.tabs li a', function(event){
event.preventDefault();
jQuery(this).closest('.tabs').find('li').removeClass('active-tab');
jQuery(this).closest('li').addClass('active-tab');
var xid = jQuery(this).attr('href');
jQuery('.box-wrap div').hide();
jQuery(xid).show();
});


});


function alertx(a,b){
closex();
if(b==null || b==''){ var b='Message from server';}
var data = '<div class="dbg"></div><div class="dbug"><div align="center"><div class="dbugbox"><span class="dbugh">'+b+'</span><b class="dbugx" onclick="closex()"></b><span class="dbugm">'+a+'</span></div></div></div>';
jQuery("body").append(data);
jQuery('.dbug').fadeTo("slow","1");
}

function ajaxbox(a,b){
if(b==null || b==''){var b='Message from server';}
alertx('<h2 style="margin:0;color:red;padding:0">Loading. Please wait . . . . . . .</h2><br><img src="images/ishareload.gif" width="100%">',b);
jQuery.get(a,function(data){jQuery('.dbugm').html(data);});
}

function confirmx(action, msg){
alertx('<h2 style="margin:0;padding:0;">'+msg+'</h2><br /><br /><a onclick="'+action+'" class="button red">CONTINUE</a> &nbsp; <a onclick="closex()" class="button blue">CANCEL</a>','Please confirm . . .');
}

function closex(){
jQuery('.dbg').remove();
jQuery('.dbug').remove();
}

function wptf_delete_image(xid){
confirmx('wptf_deleted(\''+xid+'\')','You are about to permanently delete this image. This action cannot be reversed.');
}

function wptf_deleted(xid){
document.location.href=window.location.href+'&deleteimage='+xid;
}

function wptf_del_gallery(xid){
confirmx('wptf_gal_deleted(\''+xid+'\')','You are about to delete a whole gallery. All images inside this gallery will also be deleted permanently. This action cannot be reversed. ');
}

function wptf_gal_deleted(xid){
document.location.href=window.location.href+'&deletegal='+xid;
}

function wptf_img_go_back(){
var y = new Array();
var x = window.location.href;
y = x.split('&deleteimage=');
document.location.href=y[0];
}

function wptf_gal_go_back(){
var y = new Array();
var x = window.location.href;
y = x.split('&deletegal=');
document.location.href=y[0];
}

function wptf_edit_image(xid){
jQuery('#wptf-edit-image input[name="etitle"]').attr('value', jQuery('#'+xid).find('h3:first').html());
jQuery('#wptf-edit-image textarea[name="edescr"]').html(jQuery('#'+xid).find('p:first').html());
jQuery('#wptf-edit-image input[name="upd_id"]').attr('value', xid);
jQuery('.hidden-trigger').attr('href','#TB_inline?&inlineId=wptf-edit-image');
jQuery('.hidden-trigger').trigger('click');
}


function wptf_edit_gallery(xid){
jQuery('#wptf-edit-gallery input[name="ctitle"]').attr('value', jQuery('#'+xid).find('.wptf_name').html());
jQuery('#wptf-edit-gallery input[name="ctw"]').attr('value', jQuery('#'+xid).find('.wptf_w').html());
jQuery('#wptf-edit-gallery input[name="cth"]').attr('value', jQuery('#'+xid).find('.wptf_h').html());
var tx = jQuery('#'+xid).find('.wptf_type').html();

jQuery('#wptf-edit-gallery select[name="ctmode"] option').each(function() { 
if(jQuery(this).html()==tx){
jQuery('#wptf-edit-gallery select[name="ctmode"] option').removeAttr('selected');
jQuery(this).attr('selected', true);
}
});
jQuery('#wptf-edit-gallery input[name="upd_idx"]').attr('value', xid);
jQuery('.hidden-triggerx').attr('href','#TB_inline?&inlineId=wptf-edit-gallery');
jQuery('.hidden-triggerx').trigger('click');
}