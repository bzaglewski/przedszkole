<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package kadence
 */

namespace Kadence;

get_header();

kadence()->print_styles( 'kadence-content' );
/**
 * Hook for Hero Section
 */
do_action( 'kadence_hero_header' );

?>
<div id="primary" class="content-area">
	<div class="content-container site-container">
		<main id="main" class="site-main" role="main">
			<?php
			/**
			 * Hook for anything before main content
			 */
			do_action( 'kadence_before_main_content' );
			/**
			 * Hook for main content.
			 */
			do_action( 'kadence_single' );
			/**
			 * Hook for anything after main content.
			 */
			do_action( 'kadence_after_main_content' );
			?>
		</main><!-- #main -->
		<?php
		get_sidebar();
		?>
	</div>
</div><!-- #primary -->
<?php
get_footer();
