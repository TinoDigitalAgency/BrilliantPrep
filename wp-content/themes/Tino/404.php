<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Tino
 */

get_header('404');
?>


	<div class="not-found">
		<?php $logo = get_field('logo_gl','options'); ?>
		<?php if($logo) { ?>
            <div class="logo-404">
                <img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
            </div>
		<?php } ?>
        <div class="container">
            <div class="not-found-wrapper">
                <div class="left-side">
                    <h1 class="h1">Oh no! The page<br> was not found :(</h1>
                    <p>Sorry, this page does not exist or has been deleted. <br>
                        Check the link or go to the home page.</p>
                    <a href="<?php echo home_url();?>" class="btn btn-pink">Go to Home Page</a>
                </div>
                <div class="right-side">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/src/404.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
