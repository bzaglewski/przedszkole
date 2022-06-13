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
$compontent_tabs   = ob_get_clean();
$all_post_types    = kadence()->get_post_types_objects();
$extras_post_types = array();
$add_extras        = false;
foreach ( $all_post_types as $post_type_item ) {
	$post_type_name  = $post_type_item->name;
	$post_type_label = $post_type_item->label;
	$ignore_type     = kadence()->get_post_types_to_ignore();
	if ( ! in_array( $post_type_name, $ignore_type, true ) ) {
		$settings = array(
			// $post_type_name . '_layout_tabs' => array(
			// 	'control_type' => 'kadence_blank_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'settings'     => false,
			// 	'priority'     => 1,
			// 	'description'  => $compontent_tabs,
			// ),
			'info_' . $post_type_name . '_title' => array(
				'control_type' => 'kadence_title_control',
				'section'      => $post_type_name . '_layout',
				'priority'     => 2,
				'label'        => $post_type_label . ' ' . esc_html__( 'Title', 'kadence' ),
				'settings'     => false,
			),
			$post_type_name . '_title' => array(
				'control_type' => 'kadence_switch_control',
				'section'      => $post_type_name . '_layout',
				'priority'     => 3,
				'default'      => kadence()->default( $post_type_name . '_title', true ),
				'label'        => esc_html__( 'Show Title?', 'kadence' ),
				'transport'    => 'refresh',
				// 'context'      => array(
				// 	array(
				// 		'setting' => '__current_tab',
				// 		'value'   => 'general',
				// 	),
				// ),
			),
			$post_type_name . '_title_layout' => array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'label'        => $post_type_label . ' ' . esc_html__( 'Title Layout', 'kadence' ),
				'transport'    => 'refresh',
				'priority'     => 4,
				'default'      => kadence()->default( $post_type_name . '_title_layout', 'normal' ),
				'context'      => array(
					// array(
					// 	'setting' => '__current_tab',
					// 	'value'   => 'general',
					// ),
					array(
						'setting'    => $post_type_name . '_title',
						'operator'   => '=',
						'value'      => true,
					),
				),
				'input_attrs'  => array(
					'layout' => array(
						'normal' => array(
							'tooltip' => __( 'In Content', 'kadence' ),
							'icon'    => 'incontent',
						),
						'above' => array(
							'tooltip' => __( 'Above Content', 'kadence' ),
							'icon'    => 'abovecontent',
						),
					),
					'responsive' => false,
					'class'      => 'kadence-two-col',
				),
			),
			$post_type_name . '_title_inner_layout' => array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'priority'     => 4,
				'default'      => kadence()->default( $post_type_name . '_title_inner_layout', 'standard' ),
				'label'        => esc_html__( 'Container Width', 'kadence' ),
				'context'      => array(
					// array(
					// 	'setting' => '__current_tab',
					// 	'value'   => 'general',
					// ),
					array(
						'setting'    => $post_type_name . '_title',
						'operator'   => '=',
						'value'      => true,
					),
					array(
						'setting'    => $post_type_name . '_title_layout',
						'operator'   => '=',
						'value'      => 'above',
					),
				),
				'live_method'     => array(
					array(
						'type'     => 'class',
						'selector' => '.' . $post_type_name . '-hero-section',
						'pattern'  => 'entry-hero-layout-$',
						'key'      => '',
					),
				),
				'input_attrs'  => array(
					'layout' => array(
						'standard' => array(
							'tooltip' => __( 'Background Fullwidth, Content Contained', 'kadence' ),
							'name'    => __( 'Standard', 'kadence' ),
							'icon'    => '',
						),
						'fullwidth' => array(
							'tooltip' => __( 'Background & Content Fullwidth', 'kadence' ),
							'name'    => __( 'Fullwidth', 'kadence' ),
							'icon'    => '',
						),
						'contained' => array(
							'tooltip' => __( 'Background & Content Contained', 'kadence' ),
							'name'    => __( 'Contained', 'kadence' ),
							'icon'    => '',
						),
					),
					'responsive' => false,
				),
			),
			$post_type_name . '_title_align' => array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'label'        => $post_type_label . ' ' . esc_html__( 'Title Align', 'kadence' ),
				'priority'     => 4,
				'default'      => kadence()->default( $post_type_name . '_title_align' ),
				'context'      => array(
					// array(
					// 	'setting' => '__current_tab',
					// 	'value'   => 'general',
					// ),
					array(
						'setting'    => $post_type_name . '_title',
						'operator'   => '=',
						'value'      => true,
					),
				),
				'live_method'     => array(
					array(
						'type'     => 'class',
						'selector' => '.' . $post_type_name . '-title',
						'pattern'  => array(
							'desktop' => 'title-align-$',
							'tablet'  => 'title-tablet-align-$',
							'mobile'  => 'title-mobile-align-$',
						),
						'key'      => '',
					),
				),
				'input_attrs'  => array(
					'layout' => array(
						'left' => array(
							'tooltip'  => __( 'Left Align Title', 'kadence' ),
							'dashicon' => 'editor-alignleft',
						),
						'center' => array(
							'tooltip'  => __( 'Center Align Title', 'kadence' ),
							'dashicon' => 'editor-aligncenter',
						),
						'right' => array(
							'tooltip'  => __( 'Right Align Title', 'kadence' ),
							'dashicon' => 'editor-alignright',
						),
					),
					'responsive' => true,
				),
			),
			// $post_type_name . '_title_height' => array(
			// 	'control_type' => 'kadence_range_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'priority'     => 5,
			// 	'label'        => esc_html__( 'Container Min Height', 'kadence' ),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'general',
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title',
			// 			'operator'   => '=',
			// 			'value'      => true,
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title_layout',
			// 			'operator'   => '=',
			// 			'value'      => 'above',
			// 		),
			// 	),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css',
			// 			'selector' => '#inner-wrap .page-hero-section .entry-header',
			// 			'property' => 'min-height',
			// 			'pattern'  => '$',
			// 			'key'      => 'size',
			// 		),
			// 	),
			// 	'default'      => kadence()->default( $post_type_name . '_title_height' ),
			// 	'input_attrs'  => array(
			// 		'min'     => array(
			// 			'px'  => 10,
			// 			'em'  => 1,
			// 			'rem' => 1,
			// 			'vh'  => 2,
			// 		),
			// 		'max'     => array(
			// 			'px'  => 800,
			// 			'em'  => 12,
			// 			'rem' => 12,
			// 			'vh'  => 40,
			// 		),
			// 		'step'    => array(
			// 			'px'  => 1,
			// 			'em'  => 0.01,
			// 			'rem' => 0.01,
			// 			'vh'  => 1,
			// 		),
			// 		'units'   => array( 'px', 'em', 'rem', 'vh' ),
			// 	),
			// ),
			// $post_type_name . '_title_elements' => array(
			// 	'control_type' => 'kadence_sorter_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'priority'     => 6,
			// 	'default'      => kadence()->default( $post_type_name . '_title_elements' ),
			// 	'label'        => esc_html__( 'Title Elements', 'kadence' ),
			// 	'transport'    => 'refresh',
			// 	'settings'     => array(
			// 		'elements'   => $post_type_name . '_title_elements',
			// 		'title'      => $post_type_name . '_title_element_title',
			// 		'breadcrumb' => $post_type_name . '_title_element_breadcrumb',
			// 		'meta'       => $post_type_name . '_title_element_meta',
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'general',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'group' => $post_type_name . '_title_element',
			// 	),
			// ),
			// $post_type_name . '_title_font' => array(
			// 	'control_type' => 'kadence_typography_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => $post_type_label . ' ' . esc_html__( 'Title Font', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_font' ),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css_typography',
			// 			'selector' => '.' . $post_type_name . '-title h1',
			// 			'property' => 'font',
			// 			'key'      => 'typography',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'id'             => $post_type_name . '_title_font',
			// 		'headingInherit' => true,
			// 	),
			// ),
			// $post_type_name . '_title_breadcrumb_color' => array(
			// 	'control_type' => 'kadence_color_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Breadcrumb Colors', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_breadcrumb_color' ),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css',
			// 			'selector' => '.' . $post_type_name . '-title .kadence-breadcrumbs',
			// 			'property' => 'color',
			// 			'pattern'  => '$',
			// 			'key'      => 'color',
			// 		),
			// 		array(
			// 			'type'     => 'css',
			// 			'selector' => '.' . $post_type_name . '-title .kadence-breadcrumbs a:hover',
			// 			'property' => 'color',
			// 			'pattern'  => '$',
			// 			'key'      => 'hover',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'colors' => array(
			// 			'color' => array(
			// 				'tooltip' => __( 'Initial Color', 'kadence' ),
			// 				'palette' => true,
			// 			),
			// 			'hover' => array(
			// 				'tooltip' => __( 'Link Hover Color', 'kadence' ),
			// 				'palette' => true,
			// 			),
			// 		),
			// 	),
			// ),
			// $post_type_name . '_title_breadcrumb_font' => array(
			// 	'control_type' => 'kadence_typography_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Breadcrumb Font', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_breadcrumb_font' ),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css_typography',
			// 			'selector' => '.' . $post_type_name . '-title .kadence-breadcrumbs',
			// 			'property' => 'font',
			// 			'key'      => 'typography',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'id'      => $post_type_name . '_title_breadcrumb_font',
			// 		'options' => 'no-color',
			// 	),
			// ),
			// $post_type_name . '_title_meta_color' => array(
			// 	'control_type' => 'kadence_color_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Meta Colors', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_meta_color' ),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css',
			// 			'selector' => '.' . $post_type_name . '-title .entry-meta',
			// 			'property' => 'color',
			// 			'pattern'  => '$',
			// 			'key'      => 'color',
			// 		),
			// 		array(
			// 			'type'     => 'css',
			// 			'selector' => '.' . $post_type_name . '-title .entry-meta a:hover',
			// 			'property' => 'color',
			// 			'pattern'  => '$',
			// 			'key'      => 'hover',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'colors' => array(
			// 			'color' => array(
			// 				'tooltip' => __( 'Initial Color', 'kadence' ),
			// 				'palette' => true,
			// 			),
			// 			'hover' => array(
			// 				'tooltip' => __( 'Link Hover Color', 'kadence' ),
			// 				'palette' => true,
			// 			),
			// 		),
			// 	),
			// ),
			// $post_type_name . '_title_meta_font' => array(
			// 	'control_type' => 'kadence_typography_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Meta Font', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_meta_font' ),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css_typography',
			// 			'selector' => '.' . $post_type_name . '-title .entry-meta',
			// 			'property' => 'font',
			// 			'key'      => 'typography',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'id'      => $post_type_name . '_title_breadcrumb_font',
			// 		'options' => 'no-color',
			// 	),
			// ),
			// $post_type_name . '_title_background' => array(
			// 	'control_type' => 'kadence_background_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => $post_type_label . ' ' . esc_html__( 'Title Background', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_background' ),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title',
			// 			'operator'   => '=',
			// 			'value'      => true,
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title_layout',
			// 			'operator'   => '=',
			// 			'value'      => 'above',
			// 		),
			// 	),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css_background',
			// 			'selector' => '#inner-wrap .page-hero-section .entry-hero-container-inner',
			// 			'property' => 'background',
			// 			'pattern'  => '$',
			// 			'key'      => 'base',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'tooltip'  => $post_type_name . ' ' . __( 'Title Background', 'kadence' ),
			// 	),
			// ),
			// $post_type_name . '_title_featured_image' => array(
			// 	'control_type' => 'kadence_switch_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'default'      => kadence()->default( $post_type_name . '_title_featured_image' ),
			// 	'label'        => esc_html__( 'Use Featured Image for Background?', 'kadence' ),
			// 	'transport'    => 'refresh',
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title',
			// 			'operator'   => '=',
			// 			'value'      => true,
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title_layout',
			// 			'operator'   => '=',
			// 			'value'      => 'above',
			// 		),
			// 	),
			// ),
			// $post_type_name . '_title_overlay_color' => array(
			// 	'control_type' => 'kadence_color_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Background Overlay Color', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_overlay_color' ),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css',
			// 			'selector' => '.' . $post_type_name . '-hero-section .hero-section-overlay',
			// 			'property' => 'background',
			// 			'pattern'  => '$',
			// 			'key'      => 'color',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title',
			// 			'operator'   => '=',
			// 			'value'      => true,
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title_layout',
			// 			'operator'   => '=',
			// 			'value'      => 'above',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'colors' => array(
			// 			'color' => array(
			// 				'tooltip' => __( 'Overlay Color', 'kadence' ),
			// 				'palette' => true,
			// 			),
			// 		),
			// 	),
			// ),
			// $post_type_name . '_title_top_border' => array(
			// 	'control_type' => 'kadence_border_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Top Border', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_top_border' ),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title',
			// 			'operator'   => '=',
			// 			'value'      => true,
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title_layout',
			// 			'operator'   => '=',
			// 			'value'      => 'above',
			// 		),
			// 	),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css_border',
			// 			'selector' => '.' . $post_type_name . '-hero-section .entry-hero-container-inner',
			// 			'pattern'  => '$',
			// 			'property' => 'border-top',
			// 			'pattern'  => '$',
			// 			'key'      => 'border',
			// 		),
			// 	),
			// ),
			// $post_type_name . '_title_bottom_border' => array(
			// 	'control_type' => 'kadence_border_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Bottom Border', 'kadence' ),
			// 	'default'      => kadence()->default( $post_type_name . '_title_bottom_border' ),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title',
			// 			'operator'   => '=',
			// 			'value'      => true,
			// 		),
			// 		array(
			// 			'setting'    => $post_type_name . '_title_layout',
			// 			'operator'   => '=',
			// 			'value'      => 'above',
			// 		),
			// 	),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css_border',
			// 			'selector' => '.' . $post_type_name . '-hero-section .entry-hero-container-inner',
			// 			'pattern'  => '$',
			// 			'property' => 'border-bottom',
			// 			'pattern'  => '$',
			// 			'key'      => 'border',
			// 		),
			// 	),
			// ),
			'info_' . $post_type_name . '_layout' => array(
				'control_type' => 'kadence_title_control',
				'section'      => $post_type_name . '_layout',
				'priority'     => 10,
				'label'        => $post_type_label . ' ' . esc_html__( 'Layout', 'kadence' ),
				'settings'     => false,
			),
			$post_type_name . '_layout' => array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'label'        => $post_type_label . ' ' . esc_html__( 'Layout', 'kadence' ),
				'transport'    => 'refresh',
				'priority'     => 10,
				'default'      => kadence()->default( $post_type_name . '_layout', 'normal' ),
				// 'context'      => array(
				// 	array(
				// 		'setting' => '__current_tab',
				// 		'value'   => 'general',
				// 	),
				// ),
				'input_attrs'  => array(
					'layout' => array(
						'normal' => array(
							'tooltip' => __( 'Normal', 'kadence' ),
							'icon' => 'normal',
						),
						'narrow' => array(
							'tooltip' => __( 'Narrow', 'kadence' ),
							'icon' => 'narrow',
						),
						'fullwidth' => array(
							'tooltip' => __( 'Fullwidth', 'kadence' ),
							'icon' => 'fullwidth',
						),
						'left' => array(
							'tooltip' => __( 'Left Sidebar', 'kadence' ),
							'icon' => 'leftsidebar',
						),
						'right' => array(
							'tooltip' => __( 'Right Sidebar', 'kadence' ),
							'icon' => 'rightsidebar',
						),
					),
					'responsive' => false,
					'class'      => 'kadence-three-col',
				),
			),
			$post_type_name . '_sidebar_id' => array(
				'control_type' => 'kadence_select_control',
				'section'      => $post_type_name . '_layout',
				'label'        => esc_html__( 'Default Sidebar', 'kadence' ),
				'transport'    => 'refresh',
				'priority'     => 10,
				'default'      => kadence()->default( $post_type_name . '_sidebar_id' ),
				// 'context'      => array(
				// 	array(
				// 		'setting' => '__current_tab',
				// 		'value'   => 'general',
				// 	),
				// ),
				'input_attrs'  => array(
					'options' => kadence()->sidebar_options(),
				),
			),
			$post_type_name . '_content_style' => array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'label'        => esc_html__( 'Content Style', 'kadence' ),
				'priority'     => 10,
				'default'      => kadence()->default( $post_type_name . '_content_style', 'boxed' ),
				// 'context'      => array(
				// 	array(
				// 		'setting' => '__current_tab',
				// 		'value'   => 'general',
				// 	),
				// ),
				'live_method'     => array(
					array(
						'type'     => 'class',
						'selector' => 'body.' . str_replace( '_', '-', $post_type_name ),
						'pattern'  => 'content-style-$',
						'key'      => '',
					),
					array(
						'type'     => 'class',
						'selector' => 'body.single-' . str_replace( '_', '-', $post_type_name ),
						'pattern'  => 'content-style-$',
						'key'      => '',
					),
				),
				'input_attrs'  => array(
					'layout' => array(
						'boxed' => array(
							'tooltip' => __( 'Boxed', 'kadence' ),
							'icon' => 'boxed',
						),
						'unboxed' => array(
							'tooltip' => __( 'Unboxed', 'kadence' ),
							'icon' => 'narrow',
						),
					),
					'responsive' => false,
					'class'      => 'kadence-two-col',
				),
			),
			$post_type_name . '_vertical_padding' => array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'label'        => esc_html__( 'Content Vertical Padding', 'kadence' ),
				'priority'     => 10,
				'default'      => kadence()->default( $post_type_name . '_vertical_padding', 'show' ),
				// 'context'      => array(
				// 	array(
				// 		'setting' => '__current_tab',
				// 		'value'   => 'general',
				// 	),
				// ),
				'live_method'     => array(
					array(
						'type'     => 'class',
						'selector' => 'body.' . str_replace( '_', '-', $post_type_name ),
						'pattern'  => 'content-vertical-padding-$',
						'key'      => '',
					),
					array(
						'type'     => 'class',
						'selector' => 'body.single-' . str_replace( '_', '-', $post_type_name ),
						'pattern'  => 'content-vertical-padding-$',
						'key'      => '',
					),
				),
				'input_attrs'  => array(
					'layout' => array(
						'show' => array(
							'name' => __( 'Enable', 'kadence' ),
						),
						'hide' => array(
							'name' => __( 'Disable', 'kadence' ),
						),
					),
					'responsive' => false,
				),
			),
			// $post_type_name . '_background' => array(
			// 	'control_type' => 'kadence_background_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Site Background', 'kadence' ),
			// 	'default'      => kadence()->default( 'site_background' ),
			// 	'live_method'     => array(
			// 		array(
			// 			'type'     => 'css_background',
			// 			'selector' => 'body.' . str_replace( '_', '-', $post_type_name ),
			// 			'property' => 'background',
			// 			'pattern'  => '$',
			// 			'key'      => 'base',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'tooltip' => $post_type_label . ' ' . __( 'Background', 'kadence' ),
			// 	),
			// ),
			// $post_type_name . '_content_background' => array(
			// 	'control_type' => 'kadence_background_control',
			// 	'section'      => $post_type_name . '_layout',
			// 	'label'        => esc_html__( 'Content Background', 'kadence' ),
			// 	'default'      => kadence()->default( 'content_background' ),
			// 	'live_method'  => array(
			// 		array(
			// 			'type'     => 'css_background',
			// 			'selector' => 'body.' . str_replace( '_', '-', $post_type_name ) . ' .content-bg, body.' . str_replace( '_', '-', $post_type_name ) . '.content-style-unboxed .site',
			// 			'property' => 'background',
			// 			'pattern'  => '$',
			// 			'key'      => 'base',
			// 		),
			// 	),
			// 	'context'      => array(
			// 		array(
			// 			'setting' => '__current_tab',
			// 			'value'   => 'design',
			// 		),
			// 	),
			// 	'input_attrs'  => array(
			// 		'tooltip' => $post_type_label . ' ' . __( 'Content Background', 'kadence' ),
			// 	),
			// ),
		);
		$add_extras = false;
		$extras     = array();
		if ( post_type_supports( $post_type_name, 'thumbnail' ) ) {
			$add_extras = true;
			$extras[ $post_type_name . '_feature' ] = array(
				'control_type' => 'kadence_switch_control',
				'section'      => $post_type_name . '_layout',
				'priority'     => 20,
				'default'      => kadence()->default( $post_type_name . '_feature' ),
				'label'        => esc_html__( 'Show Featured Image?', 'kadence' ),
				'transport'    => 'refresh',
				// 'context'      => array(
				// 	array(
				// 		'setting' => '__current_tab',
				// 		'value'   => 'general',
				// 	),
				// ),
			);
			$extras[ $post_type_name . '_feature_position' ] = array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'label'        => esc_html__( 'Featured Image Position', 'kadence' ),
				'priority'     => 20,
				'transport'    => 'refresh',
				'default'      => kadence()->default( $post_type_name . '_feature_position', 'above' ),
				'context'      => array(
					// array(
					// 	'setting' => '__current_tab',
					// 	'value'   => 'general',
					// ),
					array(
						'setting'    => $post_type_name . '_feature',
						'operator'   => '=',
						'value'      => true,
					),
				),
				'input_attrs'  => array(
					'layout' => array(
						'above' => array(
							'name' => __( 'Above', 'kadence' ),
						),
						'behind' => array(
							'name' => __( 'Behind', 'kadence' ),
						),
						'below' => array(
							'name' => __( 'Below', 'kadence' ),
						),
					),
					'responsive' => false,
				),
			);
			$extras[ $post_type_name . '_feature_ratio'] = array(
				'control_type' => 'kadence_radio_icon_control',
				'section'      => $post_type_name . '_layout',
				'label'        => esc_html__( 'Featured Image Ratio', 'kadence' ),
				'priority'     => 20,
				'default'      => kadence()->default( $post_type_name . '_feature_ratio' ),
				'context'      => array(
					array(
						'setting' => '__current_tab',
						'value'   => 'general',
					),
					array(
						'setting'    => $post_type_name . '_feature',
						'operator'   => '=',
						'value'      => true,
					),
				),
				'live_method'     => array(
					array(
						'type'     => 'class',
						'selector' => 'body.' . str_replace( '_', '-', $post_type_name ) . ' .article-post-thumbnail',
						'pattern'  => 'kadence-thumbnail-ratio-$',
						'key'      => '',
					),
					array(
						'type'     => 'class',
						'selector' => 'body.single-' . str_replace( '_', '-', $post_type_name ) . ' .article-post-thumbnail',
						'pattern'  => 'kadence-thumbnail-ratio-$',
						'key'      => '',
					),
				),
				'input_attrs'  => array(
					'layout' => array(
						'inherit' => array(
							'name' => __( 'Inherit', 'kadence' ),
						),
						'1-1' => array(
							'name' => __( '1:1', 'kadence' ),
						),
						'3-4' => array(
							'name' => __( '3:4', 'kadence' ),
						),
						'2-3' => array(
							'name' => __( '2:3', 'kadence' ),
						),
						'9-16' => array(
							'name' => __( '9:16', 'kadence' ),
						),
						'1-2' => array(
							'name' => __( '2:1', 'kadence' ),
						),
					),
					'responsive' => false,
					'class' => 'kadence-three-col-short',
				),
			);
		}
		if ( post_type_supports( $post_type_name, 'comments' ) ) {
			$add_extras = true;
			$extras[ $post_type_name . '_comments' ] = array(
				'control_type' => 'kadence_switch_control',
				'section'      => $post_type_name . '_layout',
				'priority'     => 20,
				'default'      => kadence()->default( $post_type_name . '_comments' ),
				'label'        => esc_html__( 'Show Comments?', 'kadence' ),
				'transport'    => 'refresh',
				// 'context'      => array(
				// 	array(
				// 		'setting' => '__current_tab',
				// 		'value'   => 'general',
				// 	),
				// ),
			);
		}
		if ( $add_extras ) {
			$settings = array_merge(
				$settings,
				$extras
			);
		}
		Theme_Customizer::add_settings( $settings );
	}
}

