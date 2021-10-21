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
<?php wp_footer(); ?>

</body>
<?php if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// enqueue the javascript that performs in-link comment reply fanciness
	wp_enqueue_script( 'comment-reply' );
} ?>
</html>
