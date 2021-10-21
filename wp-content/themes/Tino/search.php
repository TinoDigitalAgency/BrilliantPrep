<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Tino
 */

get_header();
?>
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
                                <div class="h1">Blog</div>
                                <div class="subtitle" style="color:#fff;">
	                                <?php
	                                $allsearch = new WP_Query("s=$s&showposts=0");
	                                echo $allsearch ->found_posts.' Results for "'.get_search_query().'"';
	                                ?>
                                </div>
                                <div class="search-blog">
									<?php get_search_form(); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <section class="section-search-articles">
                <div class="section-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-4 article-sidebar">
		                        <?php if ( is_active_sidebar( 'search-sidebar' ) ) : ?>
                                    <div class="sidebar blog-sidebar">
				                        <?php dynamic_sidebar( 'search-sidebar' ); ?>
                                    </div>
		                        <?php endif; ?>
                            </div>
                            <div class="col-8 search-article-col">
                                <div class="row">
                                    <?php if (have_posts()) : while (have_posts()) : the_post();  ?>

                                        <?php get_template_part('template-parts/article-loop');  ?>

                                    <?php endwhile;  ?>
                                </div>
                                <?php else: ?>
                                    <div class="h1">Oh! Posts Not Found :(</div>
                                <?php  endif; ?>
                            </div>
	                        <?php pagination();  ?>
                        </div>
                    </div>
                </div>
            </section>
	        <?php get_template_part( 'template-parts/subscribe-global'); ?>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();
