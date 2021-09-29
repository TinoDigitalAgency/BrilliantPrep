<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tino
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();
//            if (get_field('page_global_show_default_title') =='show') {
//                get_template_part( 'template-parts/blocks/content/default-title' );
//            }
			get_template_part( 'template-parts/acf-blocks' );

		endwhile; // End of the loop.
		?>
		<?php if(get_field('show_global_subscribe_section','options')) {
			get_template_part( 'template-parts/subscribe-global');
		} ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
