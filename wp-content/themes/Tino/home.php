<?php
/**
 * Template Name: Home Page Template
 */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post(); ?>
            <?php get_template_part('template-parts/acf-blocks'); ?>
		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
//get_footer();
get_template_part( 'template-parts/footer-lib' );