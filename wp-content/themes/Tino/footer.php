<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tino
 */

?>
<footer id="colophon" class="site-footer">
    <div class="site-footer_inner">
        <div class="container-fluid">
            <div class="row row-footer">
                <?php if ( is_active_sidebar( 'footer1' ) ) : ?>

                    <div id="top-footer-col-1" class="footer-col col-3">

                        <?php dynamic_sidebar( 'footer1' ); ?>

                    </div>

                <?php endif; ?>
	            <?php if ( is_active_sidebar( 'footer2' ) ) : ?>

                    <div id="top-footer-col-2" class="footer-col col-3">

			            <?php dynamic_sidebar( 'footer2' ); ?>

                    </div>

	            <?php endif; ?>
	            <?php if ( is_active_sidebar( 'footer3' ) ) : ?>

                    <div id="top-footer-col-3" class="footer-col col-3">

			            <?php dynamic_sidebar( 'footer3' ); ?>

                    </div>

	            <?php endif; ?>
	            <?php if ( is_active_sidebar( 'footer4' ) ) : ?>

                    <div id="top-footer-col-4" class="footer-col col-3">

			            <?php dynamic_sidebar( 'footer4' ); ?>

                        <?php if(get_field('show_social_links_in_footer_gl','options')) { ?>
                            <?php if(get_field('fb_link_gl','options') || get_field('youtube_link_gl','options') || get_field('inst_link_gl','options') || get_field('twitter_link_gl','options') || get_field('in_link_gl','options')) { ?>
                                <div class="footer-social">
                                    <ul class="social">
                                        <?php if(get_field('fb_link_gl','options')) { ?>
                                            <li>
                                                <a class="social-item social-item-fb" href="<?php the_field('fb_link_gl','options'); ?>"></a>
                                            </li>
                                        <?php } ?>
	                                    <?php if(get_field('youtube_link_gl','options')) { ?>
                                            <li>
                                                <a class="social-item social-item-you" href="<?php the_field('youtube_link_gl','options'); ?>"></a>
                                            </li>
	                                    <?php } ?>
	                                    <?php if(get_field('inst_link_gl','options')) { ?>
                                            <li>
                                                <a class="social-item social-item-inst" href="<?php the_field('inst_link_gl','options'); ?>"></a>
                                            </li>
	                                    <?php } ?>
	                                    <?php if(get_field('twitter_link_gl','options')) { ?>
                                            <li>
                                                <a class="social-item social-item-tw" href="<?php the_field('twitter_link_gl','options'); ?>"></a>
                                            </li>
	                                    <?php } ?>
	                                    <?php if(get_field('in_link_gl','options')) { ?>
                                            <li>
                                                <a class="social-item social-item-in" href="<?php the_field('in_link_gl','options'); ?>"></a>
                                            </li>
	                                    <?php } ?>
                                    </ul>
                                </div>
	                        <?php } ?>
                        <?php } ?>
                    </div>

	            <?php endif; ?>
            </div>
	        <?php if(get_field('copy_text_gl','options') || has_nav_menu('privacy-menu')) { ?>
                <div class="row copy-row">
                    <?php if(get_field('copy_text_gl','options')) { ?>
                        <div class="col-copy col">
                            <?php the_field('copy_text_gl','options'); ?>
                        </div>
                    <?php } ?>
                    <?php if (has_nav_menu('privacy-menu')){ ?>
                        <div class="col col-privacy-menu">
                            <?php wp_nav_menu( array(
                                    'container' => '',
                                    'theme_location' => 'privacy-menu',
                                    'menu_class' => 'menu-privacy')
                            ); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</footer><!-- #colophon -->
<a href="#" id="top-btn"><span class="icon-arrow-right"></span></a>
<?php wp_footer(); ?>

</body>
<?php if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// enqueue the javascript that performs in-link comment reply fanciness
	wp_enqueue_script( 'comment-reply' );
} ?>
</html>
