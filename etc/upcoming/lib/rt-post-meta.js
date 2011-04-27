/* 
 * This is jQuery needed to make postmeta form fieldset dymanic.
 * It will make it easy for a user to add/remove fieldsets from form on the fly.
 *
 * @param #rt_postmeta_main is id of postmeta-form.
 *      Must match with first argument passed to add_meta_box() function in 'php/rt-post-meta.php'
 */


jQuery("#rt_postmeta_main fieldset").append('<a class="rt-field-add" href="#">[+]</a>/<a class="rt-field-remove" href="#">[-]</a>');

jQuery.fn.outerHTML = function(s) {
return (s) ? this.before(s).remove() : jQuery("<p>").append(this.eq(0).clone()).html();
}

jQuery("#rt_postmeta_main fieldset .rt-field-add").live('click',function(e){
    e.preventDefault(); var pa = jQuery(this).parent();
    pa.after(pa.outerHTML()).next().find(':input').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected').reflowForm();
});

jQuery("#rt_postmeta_main fieldset .rt-field-remove").live('click',function(e){
    e.preventDefault(); var pa = jQuery(this).parent(); pa.remove().reflowForm();
});


jQuery.fn.reflowForm = function(s) {
    jQuery("#rt_postmeta_main fieldset").each(function(index){
        jQuery(this).find(':input').each(function(){
            var og = jQuery(this).attr('name');
            if(og.indexOf('[')){
               var tmparr = og.split('[');
               jQuery(this).attr('name', tmparr[0] + "[" + index + "][" + tmparr[2]);
            }
        });

        jQuery(this).find('label').each(function(){
            var og = jQuery(this).attr('for');
            if(og.indexOf('[')){
               var tmparr = og.split('[');
               jQuery(this).attr('for', tmparr[0] + "[" + index + "][" + tmparr[2]);
            }
        });
    })//end of jQuery
}

