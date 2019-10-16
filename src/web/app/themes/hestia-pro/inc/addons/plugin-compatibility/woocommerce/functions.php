<?php
/**
 * Functions for WooCommerce which only needs to be used when WooCommerce and Hestia Pro are active.
 *
 * @package Hestia
 * @since   Hestia 1.0
 */

/**
 * This function adds the front-end effects for the checkout options created in
 * `customizer/class-hestia-woocommerce-settings-controls.php`.
 */
function hestia_apply_shop_checkout_settings() {
	$disable_coupon = get_theme_mod( 'hestia_disable_coupon' );
	if ( (bool) $disable_coupon === true ) {
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	}

	$disable_order_notes = get_theme_mod( 'hestia_disable_order_note' );
	if ( (bool) $disable_order_notes === true ) {
		remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
	}

	if ( is_checkout() ) {

		$hestia_distraction_free_checkout = get_theme_mod( 'hestia_distraction_free_checkout' );
		if ( (bool) $hestia_distraction_free_checkout === true ) {
			add_filter( 'hestia_header_show_primary_menu', '__return_false' );
			add_filter(
				'body_class',
				function ( $classes ) {
					$classes[] = 'hestia-checkout-no-distraction';

					return $classes;
				}
			);
		}
	}

}

add_action( 'wp', 'hestia_apply_shop_checkout_settings' );

/**
 * This function adds the front-end effects for shop the options created in
 * `customizer/class-hestia-woocommerce-settings-controls.php`.
 */
function hestia_apply_shop_settings() {
	add_filter( 'hestia_shop_product_card_classes', 'hestia_shop_add_product_card_class', 10, 1 );
	add_filter( 'hestia_shop_sidebar_card_classes', 'hestia_shop_sidebar_add_card_class', 10, 1 );

	$show_product_category = get_theme_mod( 'hestia_shop_hide_categories' );

	if ( (bool) $show_product_category === true ) {
		add_filter( 'hestia_show_category_on_product_card', '__return_false' );
	}

	$pagination_type = get_theme_mod( 'hestia_shop_pagination_type' );
	if ( 'infinite' === $pagination_type ) {
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	}
}

/**
 * We are adding this function at `wp` instead of `init` since some globals are not ready at init.
 */
add_action( 'wp', 'hestia_apply_shop_settings' );
/**
 * Because some product-cards templates will be requested via wp-admin/admin-ajax.php we also need to apply
 * these settings on the admin side.
 * There will be no effects on dashboard since we are adding them to front-end filters.
 */
add_action( 'admin_init', 'hestia_apply_shop_settings' );

/**
 * Applies body classes for our shop settings.
 *
 * @param array $classes Array of body classes.
 *
 * @return mixed
 */
function hestia_shop_add_body_classes( $classes ) {
	$pagination_type = get_theme_mod( 'hestia_shop_pagination_type' );
	$product_style   = get_theme_mod( 'hestia_product_style' );

	if ( ! empty( $product_style ) ) {
		array_push( $classes, 'product-card-style-' . $product_style );
	}
	if ( $pagination_type === 'infinite' ) {
		array_push( $classes, 'shop-pagination-type-' . $pagination_type );
	}

	return $classes;
}

add_action( 'body_class', 'hestia_shop_add_body_classes' );

/**
 * This filter manages the product card class according to the `hestia_product_hover_style` theme mod.
 * Also, handles the `hestia_product_style` theme mod.
 *
 * @param string $classes The classes string.
 *
 * @return string
 */
function hestia_shop_add_product_card_class( $classes ) {
	$hestia_product_style = get_theme_mod( 'hestia_product_style', 'boxed' );

	if ( in_array( $hestia_product_style, array( 'plain', 'boxed' ) ) ) {
		$classes = $classes . ' card-' . $hestia_product_style;
	}

	$hestia_product_hover_style = get_theme_mod( 'hestia_product_hover_style', 'pop-and-glow' );

	if ( in_array( $hestia_product_hover_style, array( 'pop-and-glow', 'swap-images' ) ) ) {
		$classes = $classes . ' card-hover-style-' . $hestia_product_hover_style;
	}

	return $classes;
}

/**
 * This filter manages the shop sidebar card class according to the `hestia_product_style` theme mod.
 *
 * @return string
 */
function hestia_shop_sidebar_add_card_class() {

	$hestia_product_style = get_theme_mod( 'hestia_product_style', 'boxed' );

	if ( $hestia_product_style == 'boxed' ) {
		return ' card-raised ';
	}

	return '';
}

/**
 * In case the product hover style requires a double image, we'll fetch it here.
 */
function hestia_shop_add_secondary_thumbnail() {
	global $product;

	$hestia_product_hover_style = get_theme_mod( 'hestia_product_hover_style', 'pop-and-glow' );

	if ( 'swap-images' !== $hestia_product_hover_style ) {
		return;
	}

	$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

	if ( function_exists( 'method_exists' ) && method_exists( $product, 'get_gallery_image_ids' ) ) {
		$shop_isle_gallery_attachment_ids = $product->get_gallery_image_ids();

		if ( ! empty( $shop_isle_gallery_attachment_ids[0] ) ) {
			echo wp_get_attachment_image( $shop_isle_gallery_attachment_ids[0], $image_size, '', 'data-secondary' );
		}
	}
}

add_action( 'hestia_shop_after_product_thumbnail', 'hestia_shop_add_secondary_thumbnail' );
