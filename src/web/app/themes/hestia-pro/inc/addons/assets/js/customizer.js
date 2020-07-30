/**
 * Main customize js file
 *
 * @package Hestia
 */

(function ($) {

    wp.customize(
        'hestia_product_style', function (value) {
            value.bind(
                function (newval) {
                    var card_selector = $('.card.card-product'),
                        wrapperSelector = $('.hestia-shop, .woocommerce.archive .main'),
                        sidebar_selector = $('.shop-sidebar');

                    card_selector.removeClass('card-boxed card-plain');
                    card_selector.addClass('card-' + newval);

                    // update the wrapper background color
                    if ( 'plain' === newval ) {
                        sidebar_selector.removeClass( 'card-raised' );
                        wrapperSelector.css('background-color', '#ffffff');
                    } else {
                        wrapperSelector.css('background-color', '#f0f0f0');
                        sidebar_selector.addClass( 'card-raised' );
                    }
                }
            );
        }
    );

    wp.customize(
        'hestia_product_hover_style', function (value) {

            value.bind(
                function (newval) {
                    var box_selector = $('.card.card-product');

                    box_selector.removeClass(function (index, className) {
                        return (className.match(/(^|\s)card-hover-style-\S+/g) || []).join(' ');
                    });

                    box_selector.addClass( 'card-hover-style-' + newval );

                    // if we want to have a `swap-images` effect but there are no products with two images, force a refresh
                    if ( newval === 'swap-images' && $('.card.card-product a img:nth-of-type(2)' ).length < 1 ) {
                        wp.customize.preview.send('refresh');
                    }
                }
            );
        }
    );

    wp.customize(
        'hestia_shop_hide_categories', function (value) {
            value.bind(
                function (newval) {
                    var card_selector = $('.card-product .category');

                    if ( card_selector.length < 1 ) {
                        wp.customize.preview.send('refresh');
                        return;
                    }

                    if (newval) {
                        card_selector.css('display', 'none');
                    } else {
                        card_selector.css('display', 'block');
                    }
                }
            );
        }
    );

    wp.customize(
        'hestia_disable_order_note', function (value) {
            value.bind(
                function (newval) {
                    var selector = $('.shop_table.woocommerce-checkout-review-order-table');

                    if ( selector.length < 1 ) {
                        wp.customize.preview.send('refresh');
                        return;
                    }

                    if (newval) {
                        selector.css('display', 'none');
                    } else {
                        selector.css('display', 'block');
                    }
                }
            );
        }
    );

    wp.customize(
        'hestia_disable_coupon', function (value) {
            value.bind(
                function (newval) {
                    var coupon_selector = $('#hestia-checkout-coupon');

                    if ( coupon_selector.children().length < 1 ) {
                        wp.customize.preview.send('refresh');
                        return;
                    }

                    if (newval) {
                        coupon_selector.css('display', 'none');
                    } else {
                        coupon_selector.css('display', 'block');
                    }
                }
            );
        }
    );

})(jQuery);



