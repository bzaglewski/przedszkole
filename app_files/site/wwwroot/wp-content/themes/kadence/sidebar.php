<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kadence
 */

namespace Kadence;

if ( ! kadence()->has_sidebar() ) {
	return;
}
kadence()->print_styles( 'kadence-sidebar' );

?>
<aside id="secondary" role="complementary" class="primary-sidebar widget-area <?php echo esc_attr( kadence()->sidebar_id_class() ); ?>">
	<?php kadence()->display_sidebar(); ?>
</aside><!-- #secondary -->
