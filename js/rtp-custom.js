/**
 * Custom Scripts
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */
jQuery(document).ready(function () {
    jQuery('#footerbar .footerbar-widget:nth-child(3n+1)').css('border', '0');
    /* Show post edit and comment edit while over on post or comment */
    function rtp_edit_link(container) {
        jQuery(container).hover(
        function () {
            jQuery(this).find('.rtp-edit-link').css('visibility', 'visible');
        }, function () {
            jQuery(this).find('.rtp-edit-link').css('visibility', 'hidden');
        });
    }
    rtp_edit_link('.comment-body');
    rtp_edit_link('.hentry');

    /* Dropdown support for ie7 browsers (li:hover doesn't work in ie7 out of box) */
    jQuery('.ie7 #rtp-nav-menu li').hover(
        function() { jQuery(this).children('ul').css('display', 'block') },
        function() { jQuery(this).children('ul').css('display', 'none') }
    );
});

jQuery(window).load(function () {
    /* Sidebar Border */
    var sidebar_h = jQuery('#sidebar').height();
    if (sidebar_h != undefined) {
        var content_h = jQuery('#content').height() * 1 + jQuery('#content').css('padding-bottom').replace('px', '') * 1 + jQuery('#content').css('padding-top').replace('px', '') * 1 - (jQuery('#sidebar').css('padding-bottom').replace('px', '') * 1 + jQuery('#sidebar').css('padding-bottom').replace('px', '') * 1);
        if (content_h > sidebar_h) {
            jQuery('#sidebar').height(content_h);
        }
    }
    
    /* Sidebar height adjust on window resize  */
    jQuery(window).resize(function(){
        var sidebar_h = jQuery('#sidebar').height();
        if (sidebar_h != undefined) {
            var content_h = jQuery('#content').height() * 1 + jQuery('#content').css('padding-bottom').replace('px', '') * 1 + jQuery('#content').css('padding-top').replace('px', '') * 1 - (jQuery('#sidebar').css('padding-bottom').replace('px', '') * 1 + jQuery('#sidebar').css('padding-bottom').replace('px', '') * 1);
            if (content_h > sidebar_h) {
                jQuery('#sidebar').height(content_h);
            }
        }
    });

    /* immediately-Invoked Function Expression (IIFE) if you wanted to... */
    var currentTallest = 0,
        currentRowStart = 0,
        rowDivs = new Array();

    function setConformingHeight(el, newHeight) {
        /* set the height to something new, but remember the original height in case things change */
        el.data("originalHeight", (el.data("originalHeight") == undefined) ? (el.height()) : (el.data("originalHeight")));
        el.height(newHeight);
    }

    function getOriginalHeight(el) {
        /* if the height has changed, send the originalHeight */
        return (el.data("originalHeight") == undefined) ? (el.height()) : (el.data("originalHeight"));
    }

    function columnConform() {
        /* find the tallest DIV in the row, and set the heights of all of the DIVs to match it. */
        jQuery('.footerbar-widget').each(function() {
            /* "caching" */
            var $el = jQuery(this);
            var topPosition = $el.position().top;
                
            if (currentRowStart != topPosition) {
                /* we just came to a new row.  Set all the heights on the completed row */
                for(currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) setConformingHeight(rowDivs[currentDiv], currentTallest);

                /* set the variables for the new row */
                rowDivs.length = 0; /* empty the array */
                currentRowStart = topPosition;
                currentTallest = getOriginalHeight($el);
                rowDivs.push($el);
            } else {
                /* another div on the current row.  Add it to the list and check if it's taller */
                rowDivs.push($el);
                currentTallest = (currentTallest < getOriginalHeight($el)) ? (getOriginalHeight($el)) : (currentTallest);

            }
            /* do the last row */
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) setConformingHeight(rowDivs[currentDiv], currentTallest);
        });
    }

    jQuery(window).resize(function() {
            columnConform();
    });

    /* Dom Ready */
    /* You might also want to wait until window.onload if images are the things that */
    /* are unequalizing the blocks */
    jQuery(function() {
            columnConform();
    });
});