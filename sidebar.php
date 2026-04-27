<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Iran_News
 */

if ( ! is_active_sidebar( 'main-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area lg:col-span-4 hidden md:block">
    <div class="sticky top-8">
	    <?php dynamic_sidebar( 'main-sidebar' ); ?>
    </div>
</aside><!-- #secondary -->
