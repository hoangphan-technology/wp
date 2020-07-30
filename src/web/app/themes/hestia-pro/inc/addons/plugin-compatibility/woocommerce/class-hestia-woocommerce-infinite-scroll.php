<?php
/**
 * Class that handle infinite scroll on blog.
 *
 * @package Hestia
 */

/**
 * Class Hestia_Infinite_Scroll
 */
class Hestia_WooCommerce_Infinite_Scroll extends Hestia_Abstract_Main {

	/**
	 * Initialize the control. Add all the hooks necessary.
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_woo_infinite_scroll', array( $this, 'infinite_scroll' ) );
		add_action( 'wp_ajax_nopriv_woo_infinite_scroll', array( $this, 'infinite_scroll' ) );
	}

	/**
	 * Determine if infinite scroll script should be loaded.
	 *
	 * @return bool
	 */
	private function should_enqueue_infinite_scroll() {
		if ( is_shop() === false ) {
			return false;
		}
		$hestia_pagination_type = get_theme_mod( 'hestia_shop_pagination_type', 'number' );

		return $hestia_pagination_type === 'infinite';
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		if ( $this->should_enqueue_infinite_scroll() ) {
			wp_enqueue_script(
				'hestia-woo-infinit-scroll',
				get_template_directory_uri() . '/inc/addons/plugin-compatibility/woocommerce/script.js',
				array(
					'jquery',
					'masonry',
				),
				HESTIA_VERSION,
				true
			);

			$script_options = $this->get_infinite_scroll_options();
			wp_localize_script( 'hestia-woo-infinit-scroll', 'wooInfinite', $script_options );
		}
	}

	/**
	 * Get variables that should be passed to infinite scroll js script
	 *
	 * @return array
	 */
	public function get_infinite_scroll_options() {
		global $wp_query;
		$max_pages = $wp_query->max_num_pages;

		$result = array(
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'max_page' => $max_pages,
			'nonce'    => wp_create_nonce( 'hestia-woo-infinite-scroll' ),
		);

		return $result;
	}

	/**
	 * Infinite scroll ajax callback function.
	 * Trying to replicate the woo query as mush as possible, otherwise the pagination will bring duplicate results.
	 */
	public function infinite_scroll() {
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'hestia-woo-infinite-scroll' ) ) {
			return;
		}

		global $woocommerce;

		if ( ! isset( $_POST['page'] ) ) {
			wp_send_json( 'missing page number' );
		}

		$page = $_POST['page'];

		// in order to replicate perfectly the woocommerce query ( with all the args and options) we'll replicate the
		// pre get posts filter. This way the $args param is pretty useless except the `paged` arg.
		add_action( 'pre_get_posts', array( $woocommerce->query, 'product_query' ) );

		$args = array(
			'post_type' => 'product',
			'paged'     => $page,
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {
				$query->the_post();
				/**
				 * Hook: woocommerce_shop_loop.
				 *
				 * @hooked WC_Structured_Data::generate_product_data() - 10
				 */
				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' );
			}
			wp_reset_postdata();
		}
		wp_die();
	}

}
