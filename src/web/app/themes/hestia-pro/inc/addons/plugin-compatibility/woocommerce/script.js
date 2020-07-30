/**
 * Infinit scroll
 *
 * @package Hestia
 */

/* global wooInfinite */
/* global console */

jQuery(document).ready(function($){

    /**
     * Append button after all posts
     */
    var productsWrap = $('.shop-pagination-type-infinite ul.products'),
        page = 2,
        lock = false;

    productsWrap.append( '<div class="trigger"></div>' );

    $(window).scroll(function(){
        var button = productsWrap.find('.trigger');
        var processing = isElementInViewport(button);

        if ( processing === true && lock === false ) {
            if( page <= wooInfinite.max_page ){
                productsWrap.after( '<div class="loading text-center"><i class="fa fa-3x fa-spin fa-spinner" aria-hidden="true"></i></div>' );
            }

            lock = true;
            var data = {
                action: 'woo_infinite_scroll',
                page: page,
                nonce: wooInfinite.nonce
            };
            $.post(wooInfinite.ajaxurl, data, function(res) {
                if( res ) {
                    productsWrap.siblings('.loading').remove();
                    button.before( res );
                    page++;
                    lock = false;
                } else {
                    console.log(res);
                }
            }).fail(function(xhr) {
                console.log(xhr.responseText);
            });

        }


    });
});

/**
 * Detect if an element is in viewport or not
 *
 * @param el
 * @returns {boolean}
 */
function isElementInViewport (el) {

    //special bonus for those using jQuery
    if (typeof jQuery === 'function' && el instanceof jQuery) {
        el = el[0];
    }

    var rect = el.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
        rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
    );
}
