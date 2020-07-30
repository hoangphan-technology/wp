<?php
/**
 * Customizer shop settings controls.
 *
 * @package Hestia
 */

/**
 * Class Hestia_WooCommerce_Settings_Controls
 *
 * @since 1.1.85
 */
class Hestia_WooCommerce_Settings_Controls extends Hestia_Register_Customizer_Controls {

	/**
	 * Add customizer controls.
	 */
	public function add_controls() {
		$this->add_shop_settings_panel();
		$this->add_shop_settings_section();

		$this->add_shop_settings_controls();
		$this->add_checkout_settings_controls();
	}

	/**
	 * Add Shop customizer panel.
	 */
	private function add_shop_settings_panel() {
		$this->add_panel(
			new Hestia_Customizer_Panel(
				'hestia_shop_settings',
				array(
					'priority' => 46,
					'title'    => esc_html__( 'Shop Settings', 'hestia-pro' ),
				)
			)
		);
	}

	/**
	 * Add Shop settings sections
	 */
	private function add_shop_settings_section() {
		$this->add_section(
			new Hestia_Customizer_Section(
				'hestia_shop_settings',
				array(
					'title'    => apply_filters( 'hestia_shop_settings_control_label', esc_html__( 'Shop', 'hestia-pro' ) ),
					'priority' => 45,
					'panel'    => 'hestia_shop_settings',
				)
			)
		);

		$this->add_section(
			new Hestia_Customizer_Section(
				'hestia_checkout_settings',
				array(
					'title'    => apply_filters( 'hestia_checkout_settings_control_label', esc_html__( 'Checkout', 'hestia-pro' ) ),
					'priority' => 46,
					'panel'    => 'hestia_shop_settings',
				)
			)
		);
	}

	/**
	 * Add shop layout controls
	 */
	private function add_shop_settings_controls() {
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_product_style',
				array(
					'default'           => 'boxed',
					'sanitize_callback' => array( $this, 'sanitize_shop_settings_control' ),
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Product Style', 'hestia-pro' ),
					'section'  => 'hestia_shop_settings',
					'priority' => 15,
					'choices'  => array(
						'boxed' => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAAG1BMVEUAyv+fn5+3t7fDw8PV1dXf39/n5+f39/f///9JXZIaAAAA0UlEQVR4Ae3bsarDQAxE0Y0djfb/vzhF0gqPEAQb7u3ncR5s1HntWwYLFqxvuZxyD/ddlpaT9nDfZcVyij3e+6xUxLmczgjlfO+x1PpvNd97rGj92RjvYcGCBQsWLFiwYMGCBQsWLFiwYMGCBQsWLFhFsGDBgqXjdd2hktXfW6xUXKcsWf29xfKL+R5WFSxYb6ea5e9hPZzFL5EDwZOHxYGAxZOHxYH4LwsWrPXLYBn7wYFosuo9LFh3fPJ+3C3tTprv7c+P/JTzPR8C+sGCBesDvVBbUhWXtrMAAAAASUVORK5CYII=',
						),
						'plain' => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAACVBMVEUAyv/V1dX////o4eoDAAAAfklEQVR4Ae3VMQqAAAwDwOr/H62D4OAU6lDKZRQiN9RY58hgYWHdD7N0+1hYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWFhYWAOChZUFC+vI0u0vYGHt+BKxnDyWgcAyEFgGwkBgYWFh1ZNf+vnPJ3vtt4+FNffk39gtLCysC43dUGnuqLwbAAAAAElFTkSuQmCC',
						),
					),
				),
				'Hestia_Customize_Control_Radio_Image'
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_product_hover_style',
				array(
					'default'           => 'pop-and-glow',
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Product Hover Style', 'hestia-pro' ),
					'section'  => 'hestia_shop_settings',
					'priority' => 20,
					'choices'  => array(
						'pop-and-glow' => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAANlBMVEUAyv+fn5+3t7fCwsLDw8PExMTR0dHS0tLU1NTV1dXf39/j4+Pn5+fw8PDx8fH39/f9/f3///+H8UZOAAABDElEQVR4Ae3bwWrDMBBFUdVNHHU81jj//7OF0qWF3hAqTHPv/sHBcWbn8rxkb8cqSrNZR0isOOayYpNYW8xltSqxakuyxB+hN99Xab/uSZYXJZ/NsqJkM1nhZreidDPzONs/Fmm/PMxDZXnqafnJPvO0XGVZimUn+wzLYMGCBQuWwYIFCxYsWLBgwYIFCxYsWLBgwYIFC9an0g8LVqt3QXWvbS4rtrqOq1skWb58jFu8xzqi7eNaHElWuI3z6LH0ciw9WLBg/SHrS6nP0vew/g+LfyIHglceFgcCFq88LA4ELFgTWOU3nSXt8wcizertYcG64iuvx93yZyZ/fS9/fqTn8fqerzn1YMGC9Q3zsNmXS6AlLgAAAABJRU5ErkJggg==',
						),
						'swap-images'  => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAARVBMVEUAyv8mzv9C0v9Y1f9r2f993f+N4P+c5P+fn5+q5/+3t7e46//Dw8PF7v/R8v/V1dXd9f/f39/n5+fp+P/0/P/39/f///+I3whKAAABkElEQVR4Ae3b64rrMAwEYOXS+KSXnlqN/f6PujQWpCw4dYRgRZn5ZRCzfBu7LhRC2WXAKgELrEQtSdm8v89iagln8/4+K1JLYrbvV1mJY7xSS64xcjLvV1h86L9l836FFQ/92Wjb/34WWGCBBdZpzr2SNYblNbkEa9YYXiMdq79vw8mQNawmLWtc3qfBiNWXDVCz+q2+ZrRhZYmWdf81vrtgjXnNraPhUZadB9acX3ms2ym7aMaaJzWrPKLTun7K2oK1hFFwGpZQBlmbPS2JmtXRtlzkbDlgvWWSY+aLJQ9rcsa6rdMn+WKFMh18sUQVyBVrKrOZXLFEdSFXrNOmcsPavq7JFUtUD3LFEtWzc8UayuW+9OSJJar3eGBNGSyw/vQ3CLDAAgsssMDi87/POXONpe/vsxLHz+FUY+n7+6z2ROs+WFvAAut/S+osfR+sL2b5/ySChSMPFi4IsHBBgIULwj8LLLBIUmEp+4oL4hCr0gcLLLdHvj24tzgfCZv3668ftYeTeR8vAoIFFlg7+QFTIP64t6BzhwAAAABJRU5ErkJggg==',
						),
					),
				),
				'Hestia_Customize_Control_Radio_Image'
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_shop_pagination_type',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => 'number',
				),
				array(
					'type'     => 'select',
					'section'  => 'hestia_shop_settings',
					'label'    => esc_html__( 'Shop Pagination:', 'hestia-pro' ),
					'choices'  => array(
						'number'   => esc_html__( 'Number', 'hestia-pro' ),
						'infinite' => esc_html__( 'Infinite Scroll', 'hestia-pro' ),
					),
					'priority' => 25,
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_shop_hide_categories',
				array(
					'sanitize_callback' => 'hestia_sanitize_checkbox',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Hide categories', 'hestia-pro' ),
					'section'  => 'hestia_shop_settings',
					'priority' => 40,
					'type'     => 'checkbox',
				)
			)
		);
	}

	/**
	 * Add checkout layout controls.
	 */
	private function add_checkout_settings_controls() {
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_disable_order_note',
				array(
					'sanitize_callback' => 'hestia_sanitize_checkbox',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Disable Order Note', 'hestia-pro' ),
					'section'  => 'hestia_checkout_settings',
					'priority' => 40,
					'type'     => 'checkbox',
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_disable_coupon',
				array(
					'sanitize_callback' => 'hestia_sanitize_checkbox',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Disable Coupon', 'hestia-pro' ),
					'section'  => 'hestia_checkout_settings',
					'priority' => 40,
					'type'     => 'checkbox',
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_distraction_free_checkout',
				array(
					'sanitize_callback' => 'hestia_sanitize_checkbox',
				),
				array(
					'label'    => esc_html__( 'Distraction Free Checkout', 'hestia-pro' ),
					'section'  => 'hestia_checkout_settings',
					'priority' => 40,
					'type'     => 'checkbox',
				)
			)
		);
	}

	/**
	 * Sanitize Shop Layout control.
	 *
	 * @param string $value Control output.
	 *
	 * @return string
	 */
	function sanitize_shop_settings_control( $value ) {
		$value        = sanitize_text_field( $value );
		$valid_values = array(
			'boxed',
			'plain',
		);

		if ( ! in_array( $value, $valid_values ) ) {
			wp_die( 'Invalid value, go back and try again.' );
		}

		return $value;
	}
}
