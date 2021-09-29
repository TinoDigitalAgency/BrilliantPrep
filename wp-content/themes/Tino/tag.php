<?php
/**
 * The template for displaying tag pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tino
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                <?php get_template_part( 'template-parts/blocks/content/breadcrumb' ); ?>
            </div>
            <?php if ( have_posts() ) : ?>
                <section class="head-section">
                    <div class="section-inner">
                        <div class="container">
                            <?php  the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                            <div class="description">
                                <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="articles-section">
                    <div class="section-inner">
                        <div class="container">
                            <div class="row blog-row filtering-content">
                                <?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
                                    <div class="col-3 sidebar blog-sidebar">
                                        <?php dynamic_sidebar( 'sidebar-blog' ); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="col-9 article-col">
                                    <?php while (have_posts()) : the_post(); ?>
                                        <?php get_template_part('template-parts/article-loop');  ?>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php the_posts_navigation();


            else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
