jQuery(document).ready(function() {


jQuery('.wptf-gallery').show();

jQuery("body").on("mouseover", ".wptf-simple .mbox img", function(){
jQuery(this).fadeTo("slow", 0.3);
});

jQuery("body").on("mouseout", ".wptf-simple .mbox img", function(){
jQuery(this).fadeTo("slow", 1);
});

jQuery("body").on("mouseover", ".wptf-black .mbox img", function(){
jQuery(this).fadeTo(1000, 0.01);
});

jQuery("body").on("mouseout", ".wptf-black .mbox img", function(){
jQuery( ".wptf-black .mbox img" ).stop();
jQuery(this).fadeTo(1, 1);
});

jQuery("body").on("mouseover", ".wptf-blur .mbox img", function(){
jQuery(this).fadeTo("slow", 0.01);
});

jQuery("body").on("mouseout", ".wptf-blur .mbox img", function(){
jQuery(this).fadeTo("slow", 1);
});

jQuery("body").on("mouseover", ".wptf-zoomin .mbox", function(){
jQuery('.wptf-zoomin .mbox img').css('width','');
jQuery(this).find('img').addClass("wptf-zoomin-hover").animate({width:'+=100px', marginLeft:'-50px', marginTop:'-50px'}, "medium");
});

jQuery("body").on("mouseout", ".wptf-zoomin .mbox", function(){
jQuery( ".wptf-zoomin .mbox img" ).stop();
jQuery('.wptf-zoomin .mbox img').css('width','');
jQuery('.wptf-zoomin .mbox img').css('margin-left','');
jQuery('.wptf-zoomin .mbox img').css('margin-top','');
jQuery('.wptf-zoomin .mbox img').removeClass("wptf-zoomin-hover");
});

});


function wptf_init_startup(){

jQuery( ".wptf-gallery" ).each(function(i) {
var cid = jQuery(this).attr('id');
jQuery(this).find('.mbox').closest('li').each(function(i) {
jQuery(this).attr('data-count',i);
jQuery(this).fadeOut(0);
});

for(var j=0;j<wptf_items_per_page;++j){
jQuery('#'+cid+' li[data-count="'+j+'"]').fadeIn("slow");
}

});

}


function wptf_navigate(num, evx){
var xpage = (num-1)*wptf_items_per_page;
jQuery('.wptf-gallery .mbox').closest('li').fadeOut(0);
for(var j=xpage;j<(xpage+wptf_items_per_page);++j){
jQuery('.wptf-gallery li[data-count="'+j+'"]').fadeIn("slow");
}
}