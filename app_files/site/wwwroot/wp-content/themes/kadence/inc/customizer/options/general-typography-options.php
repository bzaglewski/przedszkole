<?php
/**
 * Header Builder Options
 *
 * @package Kadence
 */

namespace Kadence;

use Kadence\Theme_Customizer;
use function Kadence\kadence;

$settings = array(
	'base_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'Base Font', 'kadence' ),
		'default'      => kadence()->default( 'base_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'body',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'         => 'base_font',
			'canInherit' => false,
		),
	),
	'info_heading' => array(
		'control_type' => 'kadence_title_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'Headings', 'kadence' ),
		'settings'     => false,
	),
	'heading_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'Heading Font Family', 'kadence' ),
		'default'      => kadence()->default( 'heading_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'h1,h2,h3,h4,h5,h6',
				'property' => 'font',
				'key'      => 'family',
			),
		),
		'input_attrs'  => array(
			'id'      => 'heading_font',
			'options' => 'family',
		),
	),
	'h1_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'H1 Font', 'kadence' ),
		'default'      => kadence()->default( 'h1_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'h1',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'             => 'h1_font',
			'headingInherit' => true,
		),
	),
	'h2_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'H2 Font', 'kadence' ),
		'default'      => kadence()->default( 'h2_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'h2',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'             => 'h2_font',
			'headingInherit' => true,
		),
	),
	'h3_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'H3 Font', 'kadence' ),
		'default'      => kadence()->default( 'h3_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'h3',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'             => 'h3_font',
			'headingInherit' => true,
		),
	),
	'h4_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'H4 Font', 'kadence' ),
		'default'      => kadence()->default( 'h4_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'h4',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'             => 'h4_font',
			'headingInherit' => true,
		),
	),
	'h5_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'H5 Font', 'kadence' ),
		'default'      => kadence()->default( 'h5_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'h5',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'             => 'h5_font',
			'headingInherit' => true,
		),
	),
	'h6_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'H6 Font', 'kadence' ),
		'default'      => kadence()->default( 'h6_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => 'h6',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'             => 'h6_font',
			'headingInherit' => true,
		),
	),
	'info_above_title_heading' => array(
		'control_type' => 'kadence_title_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'Title Above Content', 'kadence' ),
		'settings'     => false,
	),
	'title_above_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'H1 Title', 'kadence' ),
		'default'      => kadence()->default( 'title_above_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.entry-hero h1',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'             => 'title_above_font',
			'headingInherit' => true,
		),
	),
	'title_above_breadcrumb_font' => array(
		'control_type' => 'kadence_typography_control',
		'section'      => 'general_typography',
		'label'        => esc_html__( 'Breadcrumbs', 'kadence' ),
		'default'      => kadence()->default( 'title_above_breadcrumb_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.entry-hero .kadence-breadcrumbs',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id'      => 'title_above_breadcrumb_font',
		),
	),
);

Theme_Customizer::add_settings( $settings );

