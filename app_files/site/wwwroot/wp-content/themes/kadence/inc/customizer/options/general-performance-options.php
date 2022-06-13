<?php
/**
 * Header Builder Options
 *
 * @package Kadence
 */

namespace Kadence;

use Kadence\Theme_Customizer;
use function Kadence\kadence;

Theme_Customizer::add_settings(
	array(
		'enable_preload' => array(
			'control_type' => 'kadence_switch_control',
			'section'      => 'general_performance',
			'default'      => kadence()->default( 'enable_preload' ),
			'label'        => esc_html__( 'Enable CSS Preload', 'kadence' ),
		),
	)
);
