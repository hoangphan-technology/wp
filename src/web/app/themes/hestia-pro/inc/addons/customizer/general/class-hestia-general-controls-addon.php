<?php
/**
 * Customizer general controls.
 *
 * @package Hestia
 */

/**
 * Class Hestia_General_Controls
 */
class Hestia_General_Controls_Addon extends Hestia_General_Controls {

	/**
	 * Add controls
	 */
	public function add_controls() {
		parent::add_controls();
		$this->add_layout_width_controls();
	}

	/**
	 * Add sidebar and container width controls.
	 */
	private function add_layout_width_controls() {
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_sidebar_width',
				array(
					'sanitize_callback' => 'absint',
					'default'           => 25,
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'      => esc_html__( 'Sidebar width (%)', 'hestia-pro' ),
					'section'    => 'hestia_general',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 15,
						'max'  => 80,
						'step' => 1,
					),
					'priority'   => 25,
				),
				'Hestia_Customizer_Range_Value_Control'
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_container_width',
				array(
					'sanitize_callback' => 'hestia_sanitize_range_value',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'       => esc_html__( 'Container width (px)', 'hestia-pro' ),
					'section'     => 'hestia_general',
					'type'        => 'range-value',
					'media_query' => true,
					'input_attr'  => array(
						'mobile'  => array(
							'min'           => 200,
							'max'           => 748,
							'step'          => 0.1,
							'default_value' => 748,
						),
						'tablet'  => array(
							'min'           => 300,
							'max'           => 992,
							'step'          => 0.1,
							'default_value' => 992,
						),
						'desktop' => array(
							'min'           => 700,
							'max'           => 2000,
							'step'          => 0.1,
							'default_value' => 1170,
						),
					),
					'priority'    => 25,
				),
				'Hestia_Customizer_Range_Value_Control'
			)
		);
	}

}
