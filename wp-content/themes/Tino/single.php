<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Tino
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post(); ?>
            <?php $thumbUrl = get_the_post_thumbnail_url(get_the_ID(),'large'); //var_dump($thumbUrl);
                if ($thumbUrl) {
                    $heroUrl = $thumbUrl;
                } else {
                    $heroUrl = get_template_directory_uri().'/assets/images/src/blog/blog-placeholder.jpg';
                }
                $categories = get_the_category();
                $cat_ID = $categories[0]->term_id;
                $cat_name = $categories[0]->name;
                $colorLabel = get_field('label_color_category','term_'.$cat_ID);
                $cat_Link = get_category_link( $cat_ID );
            ?>
            <section class="section-hero section-hero-blog">
                <div class="section-inner" style="background-image: url(<?php echo $heroUrl; ?>);">
                    <div class="overlay-bg" style="background-color: <?php echo $colorLabel; ?>"></div>
                    <div class="hero-content">
                        <div class="container">
                            <div class="content-col" style="max-width: <?php the_sub_field('hero_content_columns_width'); ?>;">
                                <div class="meta-article">
                                    <?php if ($cat_name) { ?>
                                        <div class="article-category">
                                            <a href="<?php echo $cat_Link; ?>"><?php echo $cat_name?></a> -
                                        </div>
                                    <?php } ?>
                                    <div class="date-article">
                                         &nbsp;<?php the_date() ?>
                                    </div>
                                </div>
                                <div class="h1"><?php the_title(); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="article-content-section">
                <div class="section-inner">
                    <div class="container">
                        <div class="row article-content-row">
                            <div class="col-8 article-content">
                                <div class="content">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class="col-4 article-sidebar">
                                <div class="article-blog__author">
                                    <div class="avatar">
                                        <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="">
                                    </div>
                                    <div class="name">
                                        <span class="lbl">Author</span>
                                        <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?>
                                    </div>
                                </div>
                                <?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
                                    <div class="sidebar blog-sidebar">
                                        <?php dynamic_sidebar( 'sidebar' ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
			<?php get_template_part( 'template-parts/acf-blocks' ); ?>
            <section class="comment-section">
                <div class="section-inner">
                    <div class="container">
                        <div class="row comment-row">
                            <div class="col-8 comment-col">
	                            <?php if (comments_open() || get_comments_number()) { ?>
                                    <div class="comments-post">
                                        <div class="comments-post-inner">
<!--				                            --><?php //comment_form(); ?>
				                            <?php comments_template('/comments.php'); ?>
                                        </div>
                                    </div>
	                            <?php } ?>
                            </div> 
                        </div>
                    </div>
                </div>
            <section>
		<?php endwhile; // End of the loop.
		?>
            <?php get_template_part( 'template-parts/subscribe-global'); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
