<?php
/**
 * Template Name: Blog Page Template
 */

get_header();
?>
<?php while ( have_posts() ) :
	the_post(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
            <section class="section-hero section-hero-blog">
	            <div class="section-inner" style="background-color: #383373;">
		            <div class="hero-content">

			            <div class="container">
                            <div class="overlay-image" style="
				            <?php if(get_sub_field('hero_overlay_image_width')) { ?>
                                    max-width: <?php the_sub_field('hero_overlay_image_width'); ?>;
                            <?php } ?>
                                <?php if(get_sub_field('hero_overlay_image_width')) { ?>
                                        max-height: <?php the_sub_field('hero_overlay_image_height'); ?>;
                            <?php } ?>
                                    ">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/src/blog.svg" alt="">
                            </div>
				            <div class="content-col" style="max-width: <?php the_sub_field('hero_content_columns_width'); ?>;">
					            <div class="h1"><?php the_title(); ?></div>
					            <div class="search-blog">
						            <?php get_search_form(); ?>
					            </div>
				            </div>
			            </div>
		            </div>
	            </div>
            </section>
            <?php get_template_part('template-parts/acf-blocks'); ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php endwhile; // End of the loop. ?>
<?php
get_footer();
