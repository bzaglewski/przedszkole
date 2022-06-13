<?php
/**
 * Header Main Row Options
 *
 * @package Kadence
 */

namespace Kadence;

use Kadence\Theme_Customizer;
use function Kadence\kadence;

ob_start(); ?>
<div class="kadence-compontent-tabs nav-tab-wrapper wp-clearfix">
	<a href="#" class="nav-tab kadence-general-tab kadence-compontent-tabs-button nav-tab-active" data-tab="general">
		<span><?php esc_html_e( 'General', 'kadence' ); ?></span>
	</a>
	<a href="#" class="nav-tab kadence-design-tab kadence-compontent-tabs-button" data-tab="design">
		<span><?php esc_html_e( 'Design', 'kadence' ); ?></span>
	</a>
</div>
<?php
$compontent_tabs = ob_get_clean();
$settings = array(
	'mobile_button_tabs' => array(
		'control_type' => 'kadence_blank_control',
		'section'      => 'mobile_button',
		'settings'     => false,
		'priority'     => 1,
		'description'  => $compontent_tabs,
	),
	'mobile_button_style' => array(
		'control_type' => 'kadence_radio_icon_control',
		'section'      => 'mobile_button',
		'priority'     => 4,
		'default'      => kadence()->default( 'mobile_button_style' ),
		'label'        => esc_html__( 'Button Style', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'pattern'  => 'button-style-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'filled' => array(
					'name'    => __( 'Filled', 'kadence' ),
				),
				'outline' => array(
					'name'    => __( 'Outline', 'kadence' ),
					'icon'    => '',
				),
			),
			'responsive' => false,
		),
	),
	'mobile_button_size' => array(
		'control_type' => 'kadence_radio_icon_control',
		'section'      => 'mobile_button',
		'priority'     => 4,
		'default'      => kadence()->default( 'mobile_button_size' ),
		'label'        => esc_html__( 'Button Size', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'pattern'  => 'button-size-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'small' => array(
					'name'    => __( 'Small', 'kadence' ),
				),
				'medium' => array(
					'name'    => __( 'Medium', 'kadence' ),
					'icon'    => '',
				),
				'large' => array(
					'name'    => __( 'Large', 'kadence' ),
					'icon'    => '',
				),
			),
			'responsive' => false,
		),
	),
	'mobile_button_label' => array(
		'control_type' => 'kadence_text_control',
		'section'      => 'mobile_button',
		'priority'     => 4,
		'label'        => esc_html__( 'Label', 'kadence' ),
		'default'      => kadence()->default( 'mobile_button_label' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'html',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'pattern'  => '$',
				'key'      => '',
			),
		),
	),
	'mobile_button_link' => array(
		'control_type' => 'kadence_text_control',
		'section'      => 'mobile_button',
		'label'        => esc_html__( 'URL', 'kadence' ),
		'priority'     => 4,
		'default'      => kadence()->default( 'mobile_button_link' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'partial'      => array(
			'selector'            => '.mobile-header-button-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'Kadence\mobile_button',
		),
	),
	'mobile_button_target' => array(
		'control_type' => 'kadence_switch_control',
		'section'      => 'mobile_button',
		'priority'     => 6,
		'default'      => kadence()->default( 'mobile_button_target' ),
		'label'        => esc_html__( 'Open in New Tab?', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
	),
	'mobile_button_nofollow' => array(
		'control_type' => 'kadence_switch_control',
		'section'      => 'mobile_button',
		'priority'     => 6,
		'default'      => kadence()->default( 'mobile_button_nofollow' ),
		'label'        => esc_html__( 'Set link to nofollow?', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
	),
	'mobile_button_sponsored' => array(
		'control_type' => 'kadence_switch_control',
		'section'      => 'mobile_button',
		'priority'     => 6,
		'default'      => kadence()->default( 'mobile_button_sponsored' ),
		'label'        => esc_html__( 'Set link attribute Sponsored?', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
	),
	'mobile_button_visibility' => array(
		'control_type' => 'kadence_radio_icon_control',
		'section'      => 'mobile_button',
		'priority'     => 4,
		'default'      => kadence()->default( 'mobile_button_visibility' ),
		'label'        => esc_html__( 'Button Visibility', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'partial'      => array(
			'selector'            => '.mobile-header-button-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'Kadence\mobile_button',
		),
		'input_attrs'  => array(
			'layout' => array(
				'all' => array(
					'name'    => __( 'Everyone', 'kadence' ),
				),
				'loggedout' => array(
					'name'    => __( 'Logged Out Only', 'kadence' ),
				),
				'loggedin' => array(
					'name'    => __( 'Logged In Only', 'kadence' ),
				),
			),
			'responsive' => false,
		),
	),
	'mobile_button_color' => array(
		'control_type' => 'kadence_color_control',
		'section'      => 'mobile_button',
		'label'        => esc_html__( 'Colors', 'kadence' ),
		'default'      => kadence()->default( 'mobile_button_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.mobile-header-button-wrap .mobile-header-button:hover',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'kadence' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Color', 'kadence' ),
					'palette' => true,
				),
			),
		),
	),
	'mobile_button_background' => array(
		'control_type' => 'kadence_color_control',
		'section'      => 'mobile_button',
		'label'        => esc_html__( 'Background Colors', 'kadence' ),
		'default'      => kadence()->default( 'mobile_button_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.mobile-header-button-wrap .mobile-header-button:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'mobile_button_style',
				'operator'   => '=',
				'value'      => 'filled',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'kadence' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Color', 'kadence' ),
					'palette' => true,
				),
			),
		),
	),
	'mobile_button_border_colors' => array(
		'control_type' => 'kadence_color_control',
		'section'      => 'mobile_button',
		'label'        => esc_html__( 'Border Colors', 'kadence' ),
		'default'      => kadence()->default( 'mobile_button_border' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.mobile-header-button-wrap .mobile-header-button:hover',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'kadence' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Color', 'kadence' ),
					'palette' => true,
				),
			),
		),
	),
	'mobile_button_border' => array(
		'control_type' => 'kadence_border_control',
		'section'      => 'mobile_button',
		'label'        => esc_html__( 'Border', 'kadence' ),
		'default'      => kadence()->default( 'mobile_button_border' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css_border',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'property' => 'border',
				'pattern'  => '$',
				'key'      => 'border',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
			'color'      => false,
		),
	),
	'mobile_button_typography' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'mobile_button',
		'label'        => esc_html__( 'Font', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'default'      => kadence()->default( 'mobile_button_typography' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.mobile-header-button-wrap .mobile-header-button',
				'pattern'  => array(
					'desktop' => '$',
					'tablet'  => '$',
					'mobile'  => '$',
				),
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id' => 'mobile_button_typography',
			'options' => 'no-color',
		),
	),
	'mobile_button_margin' => array(
		'control_type' => 'kadence_measure_control',
		'section'      => 'mobile_button',
		'priority'     => 10,
		'default'      => kadence()->default( 'mobile_button_margin' ),
		'label'        => esc_html__( 'Margin', 'kadence' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.mobile-header-button-wrap .mobile-header-button-wrap',
				'property' => 'margin',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
);

Theme_Customizer::add_settings( $settings );

