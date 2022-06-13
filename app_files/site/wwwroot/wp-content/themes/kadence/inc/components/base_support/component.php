<?php
/**
 * Kadence\Base_Support\Component class
 *
 * @package kadence
 */

namespace Kadence\Base_Support;

use Kadence\Component_Interface;
use Kadence\Templating_Component_Interface;
use function Kadence\kadence;
use function add_action;
use function add_filter;
use function add_theme_support;
use function is_singular;
use function pings_open;
use function esc_url;
use function get_bloginfo;
use function wp_scripts;
use function wp_get_theme;
use function get_template;

/**
 * Class for adding basic theme support, most of which is mandatory to be implemented by all themes.
 *
 * Exposes template tags:
 * * `kadence()->get_version()`
 * * `kadence()->get_post_types()`
 * * `kadence()->get_asset_version( string $filepath )`
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Holds post types.
	 *
	 * @var values of all the post types.
	 */
	protected static $post_types = null;

	/**
	 * Holds post types.
	 *
	 * @var values of all the post types.
	 */
	protected static $post_types_objects = null;

	/**
	 * Holds ignore post types.
	 *
	 * @var values of all the post types.
	 */
	protected static $ignore_post_types = null;

	/**
	 * Holds ignore post types.
	 *
	 * @var values of all the post types.
	 */
	protected static $public_ignore_post_types = null;

	/**
	 * Holds ignore post types.
	 *
	 * @var values of all the post types.
	 */
	protected static $transparent_ignore_post_types = null;

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'base_support';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_essential_theme_support' ) );
		add_action( 'wp_head', array( $this, 'action_add_pingback_header' ) );
		add_filter( 'body_class', array( $this, 'filter_body_classes_add_hfeed' ) );
		add_filter( 'embed_defaults', array( $this, 'filter_embed_dimensions' ) );
		add_filter( 'theme_scandir_exclusions', array( $this, 'filter_scandir_exclusions_for_optional_templates' ) );
		add_filter( 'script_loader_tag', array( $this, 'filter_script_loader_tag' ), 10, 2 );
		add_filter( 'body_class', array( $this, 'filter_body_classes_add_link_style' ) );
		add_filter( 'get_search_form', array( $this, 'add_search_icon' ), 99 );
		add_filter( 'get_product_search_form', array( $this, 'add_search_icon' ), 99 );
		add_filter( 'embed_oembed_html', array( $this, 'classic_embed_wrap' ), 90, 4 );
		add_filter( 'excerpt_length', array( $this, 'custom_excerpt_length' ) );
		add_filter( 'the_author_description', 'wpautop' );
	}
	/**
	 * Filter the excerpt length to 30 words.
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	public function custom_excerpt_length( $length ) {
		if ( 'post' === get_post_type() ) {
			$length = intval( kadence()->sub_option( 'post_archive_element_excerpt', 'words' ) );
		}
		return $length;
	}
	/**
	 * Remove comment date.
	 *
	 * @param string|int $date      The comment time, formatted as a date string or Unix timestamp.
	 * @param string     $format    Date format.
	 * @param bool       $gmt       Whether the GMT date is in use.
	 * @param bool       $translate Whether the time is translated.
	 * @param WP_Comment $comment   The comment object.
	 */
	public function remove_comment_time( $date, $format, $gmt, $translate, $comment ) {
		if ( ! is_admin() ) {
			return '';
		}
		return $date;
	}
	/**
	 * Remove comment date.
	 *
	 * @param string|int $date    Formatted date string or Unix timestamp.
	 * @param string     $format  The format of the date.
	 * @param WP_Comment $comment The comment object.
	 */
	public function remove_comment_date( $date, $format, $comment ) {
		if ( ! is_admin() ) {
			return '';
		}
		return $date;
	}
	/**
	 * Wrap embedded media for responsive embeds, pre blocks.
	 *
	 * @param  string $cache The oEmbed markup.
	 * @param  string $url The URL being embedded.
	 * @param  array  $attr An array of attributes.
	 * @param  string $post_ID the post id.
	 */
	public function classic_embed_wrap( $cache, $url, $attr = array(), $post_ID = '' ) {
		if ( ! has_blocks() && ! empty( $cache ) ) {
			$cache = '<div class="entry-content-asset videofit">' . $cache . '</div>';
		}
		return $cache;
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `kadence()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return array(
			'get_version'                          => array( $this, 'get_version' ),
			'get_asset_version'                    => array( $this, 'get_asset_version' ),
			'get_post_types'                       => array( $this, 'get_post_types' ),
			'get_post_types_objects'               => array( $this, 'get_post_types_objects' ),
			'get_post_types_to_ignore'             => array( $this, 'get_post_types_to_ignore' ),
			'get_transparent_post_types_to_ignore' => array( $this, 'get_transparent_post_types_to_ignore' ),
			'get_public_post_types_to_ignore'      => array( $this, 'get_public_post_types_to_ignore' ),
			'customizer_quick_link'                => array( $this, 'customizer_quick_link' ),
		);
	}
	/**
	 * If in customizer output the quicklink.
	 */
	public static function customizer_quick_link() {
		if ( is_customize_preview() ) {
			?>
			<div class="customize-partial-edit-shortcut kadence-custom-partial-edit-shortcut">
				<button aria-label="<?php esc_attr_e( 'Click to edit this element.', 'kadence' ); ?>" title="<?php esc_attr_e( 'Click to edit this element.', 'kadence' ); ?>" class="customize-partial-edit-shortcut-button item-customizer-focus"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path></svg></button>
			</div>
			<?php
		}
	}
	/**
	 * Get array of post types we want to exclude from use in customizer custom post type settings.
	 *
	 * @return array of post types.
	 */
	public static function get_post_types_to_ignore() {
		if ( is_null( self::$ignore_post_types ) ) {
			$ignore_post_types = array(
				'post',
				'page',
				'product',
				'elementor_library',
				'kt_size_chart',
				'kt_reviews',
				'course',
				'lesson',
				'llms_quiz',
				'llms_membership',
				'llms_certificate',
				'llms_my_certificate',
				'sfwd-quiz',
				'sfwd-certificates',
				'sfwd-lessons',
				'sfwd-topic',
				'sfwd-transactions',
				'sfwd-essays',
				'sfwd-assignment',
				'sfwd-courses',
				'courses',
				'groups',
			);
			self::$ignore_post_types = apply_filters( 'kadence_customizer_post_type_ignore_array', $ignore_post_types );
		}

		return self::$ignore_post_types;
	}

	/**
	 * Get array of post types we want to exclude from use in customizer transparent header settings.
	 *
	 * @return array of post types.
	 */
	public static function get_transparent_post_types_to_ignore() {
		if ( is_null( self::$transparent_ignore_post_types ) ) {
			$transparent_ignore_post_types = array(
				'post',
				'page',
				'product',
				'elementor_library',
				'fl-theme-layout',
				'kt_size_chart',
				'kt_reviews',
				'llms_certificate',
				'llms_my_certificate',
				'sfwd-quiz',
				'sfwd-certificates',
				'sfwd-lessons',
				'sfwd-topic',
				'sfwd-transactions',
				'sfwd-essays',
				'sfwd-assignment',
			);
			self::$transparent_ignore_post_types = apply_filters( 'kadence_transparent_post_type_ignore_array', $transparent_ignore_post_types );
		}

		return self::$transparent_ignore_post_types;
	}

	/**
	 * Get array of post types we want to exclude from use in non public areas.
	 *
	 * @return array of post types.
	 */
	public static function get_public_post_types_to_ignore() {
		if ( is_null( self::$public_ignore_post_types ) ) {
			$public_ignore_post_types = array(
				'elementor_library',
				'fl-theme-layout',
				'kt_size_chart',
				'kt_reviews',
				'llms_certificate',
				'llms_my_certificate',
				'sfwd-certificates',
				'sfwd-transactions',
			);
			self::$public_ignore_post_types = apply_filters( 'kadence_public_post_type_ignore_array', $public_ignore_post_types );
		}

		return self::$public_ignore_post_types;
	}

	/**
	 * Get all public post types.
	 *
	 * @return array of post types.
	 */
	public static function get_post_types() {
		if ( is_null( self::$post_types ) ) {
			$args             = array(
				'public' => true,
				'show_in_rest' => true,
				'_builtin' => false,
			);
			$builtin = array(
				'post',
				'page',
			);
			$output           = 'names'; // names or objects, note names is the default.
			$operator         = 'and';
			$post_types       = get_post_types( $args, $output, $operator );
			self::$post_types = apply_filters( 'kadence_public_post_type_array', array_merge( $builtin, $post_types ) );
		}

		return self::$post_types;
	}

	/**
	 * Get all public post types.
	 *
	 * @return array of post types.
	 */
	public static function get_post_types_objects() {
		if ( is_null( self::$post_types_objects ) ) {
			$args             = array(
				'public' => true,
				'_builtin' => false,
			);
			$output           = 'objects'; // names or objects, note names is the default.
			$operator         = 'and';
			$post_types       = get_post_types( $args, $output, $operator );
			self::$post_types_objects = apply_filters( 'kadence_public_post_type_objects', $post_types );
		}

		return self::$post_types_objects;
	}

	/**
	 * Adds theme support for essential features.
	 */
	public function action_essential_theme_support() {
		if ( 'em' === kadence()->sub_option( 'content_width', 'unit' ) || 'rem' === kadence()->sub_option( 'content_width', 'unit' ) ) {
			$kadence_content_width = intval( kadence()->sub_option( 'content_width', 'size' ) * 17 );
		} else {
			$kadence_content_width = kadence()->sub_option( 'content_width', 'size' );
		}
		$GLOBALS['content_width'] = intval( $kadence_content_width ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound

		// Add default RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Ensure WordPress manages the document title.
		add_theme_support( 'title-tag' );

		// Ensure WordPress theme features render in HTML5 markup.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		// Add support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		if ( ! kadence()->option( 'post_comments_date' ) ) {
			add_filter( 'get_comment_date', array( $this, 'remove_comment_date' ), 20, 3 );
			add_filter( 'get_comment_time', array( $this, 'remove_comment_time' ), 20, 5 );
		}

	}

	/**
	 * Adds a pingback url auto-discovery header for singularly identifiable articles.
	 */
	public function action_add_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
	/**
	 * Add
	 *
	 * @param string $markup search form markup.
	 *
	 * @return mixed
	 */
	public function add_search_icon( $markup ) {
		$markup = str_replace( '</form>', '<div class="kadence-search-icon-wrap">' . kadence()->get_icon( 'search', '', false ) . '</div></form>', $markup );
		return $markup;
	}
	/**
	 * Adds a 'hfeed' class to the array of body classes for non-singular pages.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes_add_hfeed( array $classes ) : array {
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}

	/**
	 * Adds a link style class to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes_add_link_style( array $classes ) : array {
		$classes[] = 'hide-focus-outline';
		$classes[] = 'link-style-' . kadence()->sub_option( 'link_color', 'style' );

		return $classes;
	}

	/**
	 * Sets the embed width in pixels, based on the theme's design and stylesheet.
	 *
	 * @param array $dimensions An array of embed width and height values in pixels (in that order).
	 * @return array Filtered dimensions array.
	 */
	public function filter_embed_dimensions( array $dimensions ) : array {
		$dimensions['width'] = 720;
		return $dimensions;
	}

	/**
	 * Excludes any directory named 'optional' from being scanned for theme template files.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/theme_scandir_exclusions/
	 *
	 * @param array $exclusions the default directories to exclude.
	 * @return array Filtered exclusions.
	 */
	public function filter_scandir_exclusions_for_optional_templates( array $exclusions ) : array {
		return array_merge(
			$exclusions,
			array( 'optional' )
		);
	}

	/**
	 * Adds async/defer attributes to enqueued / registered scripts.
	 *
	 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12009
	 *
	 * @param string $tag    The script tag.
	 * @param string $handle The script handle.
	 * @return string Script HTML string.
	 */
	public function filter_script_loader_tag( $tag, $handle ) {

		foreach ( array( 'async', 'defer' ) as $attr ) {
			if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
				continue;
			}

			// Prevent adding attribute when already added in #12009.
			if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
				$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
			}

			// Only allow async or defer, not both.
			break;
		}

		return $tag;
	}

	/**
	 * Gets the theme version.
	 *
	 * @return string Theme version number.
	 */
	public function get_version() : string {
		static $theme_version = null;

		if ( null === $theme_version ) {
			$theme_version = wp_get_theme( get_template() )->get( 'Version' );
		}

		return $theme_version;
	}

	/**
	 * Gets the version for a given asset.
	 *
	 * Returns filemtime when WP_DEBUG is true, otherwise the theme version.
	 *
	 * @param string $filepath Asset file path.
	 * @return string Asset version number.
	 */
	public function get_asset_version( string $filepath ) : string {
		if ( WP_DEBUG ) {
			return (string) filemtime( $filepath );
		}

		return $this->get_version();
	}
}
