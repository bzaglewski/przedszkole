<?php
/**
 * Kadence\LearnDash\Component class
 *
 * @package kadence
 */

namespace Kadence\LearnDash;

use Kadence\Component_Interface;
use function Kadence\kadence;
use function add_action;
use function add_filter;
use function add_theme_support;
use function have_posts;
use function the_post;
use function is_search;
use function get_template_part;
use function get_post_type;

/**
 * Class for adding LearnDash plugin support.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'learndash';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'wp_enqueue_scripts', array( $this, 'learndash_styles' ), 60 );
	}

	/**
	 * Add some css styles for learndash
	 */
	public function learndash_styles() {
		wp_enqueue_style( 'kadence-learndash', get_theme_file_uri( '/assets/css/learndash.min.css' ), array(), KADENCE_VERSION );
	}
}
