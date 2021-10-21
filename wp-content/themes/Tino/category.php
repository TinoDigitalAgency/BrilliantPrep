<?php
/**
 * Category Template (category.php)
 * @package WordPress
 * @subpackage Navisite
 */
get_header(); ?>
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
                                <div class="h1"><?php single_cat_title(); ?></div>
                                <div class="search-blog">
							        <?php get_search_form(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <section class="articles-section">
                <div class="section-inner">
                    <div class="container">
                        <div class="row blog-row">
                            <div class="col-12 title-block" style="color: <?php the_sub_field('tile_courses_title__subtitle_color'); ?>; max-width: <?php the_sub_field('tile_courses_title_columns_width'); ?>;">
                                <h2 class="h1 title">Latest Posts</h2>
                            </div>
                            <div class="col-12 article-col">
                                <?php if (have_posts()) :
	                                $queried_category = get_term( get_query_var('cat'), 'category' );
                                    $categorySlug = $queried_category->slug; ?>
                                    <?php echo do_shortcode('[ajax_load_more id="3293456581" container_type="div" post_type="post" posts_per_page="9" category="'.$categorySlug.'" scroll="false" transition_container_classes="shortcode-content" button_label="Show More"]');  ?>
                                <?php endif;  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
<?php get_footer(); ?>
