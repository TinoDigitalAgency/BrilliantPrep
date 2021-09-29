<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tino
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

    <style>
        /* Fix YouTube Embed Not Displaying */
        .wp-block-embed__wrapper {
            position: revert !important;
        }
        .statcounter {
            display: none;
        }
    </style>

    <!--[if IE]>-->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/css/ie.css" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
</head>

<body <?php body_class(); ?>>
<?php $logo = get_field('logo_gl','options'); ?>
<div class="menu-wrapper">
    <div class="menu-inner">
        <div class="btn-menu-container">
            <div class="container">
	            <?php if($logo) { ?>
                    <div class="mobile-logo-col">
			            <?php if(is_front_page()) { ?>
                            <div class="logo">
                                <img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </div>
			            <?php } else { ?>
                            <a href="<?php bloginfo( 'url' ); ?>" class="logo">
                                <img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
			            <?php } ?>
                    </div>
	            <?php } ?>
                <button class="close-menu"><span class="icon-close"></span> <span>Close</span></button>
            </div>
        </div>
        <div class="menu-content">
            <div class="container">
                <div class="row menu-row">
	                <?php if ( is_active_sidebar( 'main_menu1' ) ) : ?>

                        <div id="menu-col-1" class="menu-col col-3">

			                <?php dynamic_sidebar( 'main_menu1' ); ?>

                        </div>

	                <?php endif; ?>
	                <?php if ( is_active_sidebar( 'main_menu2' ) ) : ?>

                        <div id="menu-col-2" class="menu-col col-6">

			                <?php dynamic_sidebar( 'main_menu2' ); ?>

                        </div>

	                <?php endif; ?>
	                <?php if ( is_active_sidebar( 'main_menu3' ) ) : ?>

                        <div id="menu-col-3" class="menu-col col-3">

			                <?php dynamic_sidebar( 'main_menu3' ); ?>

                        </div>

	                <?php endif; ?>
	                <?php if ( is_active_sidebar( 'main_menu5' ) ) : ?>

                        <div id="menu-col-5" class="menu-col col-3">

			                <?php dynamic_sidebar( 'main_menu5' ); ?>

                        </div>

	                <?php endif; ?>
	                <?php if ( is_active_sidebar( 'main_menu4' ) ) : ?>

                        <div id="menu-col-4" class="menu-col col-12">

			                <?php dynamic_sidebar( 'main_menu4' ); ?>


                        </div>

	                <?php endif; ?>
                    <div class="col-12 main-menu-info">
		                <?php if(get_field('header_phone_gl','options') || get_field('header_phone_gl','options')) { ?>
                            <div class="phone-col">
                                <a href="tel:<?php the_field('header_phone_gl','options'); ?>">
                                    <?php if(get_field('header_phone_text_gl','options')) { ?>
	                                    <?php the_field('header_phone_text_gl','options'); ?>
                                    <?php } elseif (get_field('header_phone_gl','options')) { ?>
	                                    <?php the_field('header_phone_gl','options'); ?>
                                    <?php } ?>
                                </a>
                            </div>
		                <?php } ?>
		                <?php if(get_field('login_text_gl','options') && get_field('login_link_gl','options')) { ?>
                            <div class="user-col">
                                <a class="btn btn-border" href="<?php the_field('login_link_gl','options'); ?>" <?php if(get_field('login_open_in_new_window_gl','options')){ echo 'target="_blank"'; } ?>><span class="icon-log-in"></span> <?php the_field('login_text_gl','options'); ?></a>
                            </div>
		                <?php } ?>
		                <?php if(get_field('cta_text_gl','options') && get_field('cta_link_gl','options')) { ?>
                            <div class="cta-col">
                                <?php if(!get_field('global_is_custom_cta','options')) { ?>
                                <a class="cta-header btn btn-pink" href="<?php the_field('cta_link_gl','options'); ?>" <?php if(get_field('open_in_new_window_gl','options')){ echo 'target="_blank"'; } ?>><?php the_field('cta_text_gl','options'); ?></a>
                                <?php } else { ?>
                                <a class="cta-header btn btn-pink" href="" onclick="window.enrollsy.openWidget({type:'ENROLL',slug:'brilliant-prep'});return false;">Get Started</a> <script>!function(n,e){var t,s;n.enrollsy||(n.enrollsy={},n.enrollsy._c=[],["init"].forEach(function(e){n.enrollsy[e]=function(){n.enrollsy._c.push([e,arguments])}}),(t=e.createElement("script")).type="text/javascript",t.async=!0,t.src="https://assets.enrollsy.com/external/widget.js",(s=e.getElementsByTagName("script")[0]).parentNode.insertBefore(t,s))}(window,document),window.setTimeout(function(){window.enrollsy.init()},1e3);</script>
                                <?php }?>
                            </div>
		                <?php } ?>
                    </div>
	                <?php if(get_field('show_social_links_in_footer_gl','options')) { ?>
                        <div class="col-12 social-menu">
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
                        </div>
	                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<header class="header <?php if(is_front_page()) { echo 'header-transparent'; } if(get_field('sticky_header_gl','options')) { echo ' header-sticky'; } ?>">
    <div class="header-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-left-side-header">

	                <?php if($logo) { ?>
                        <div class="logo-col">
			                <?php if(is_front_page()) { ?>
                                <div class="logo">
                                    <img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
                                </div>
			                <?php } else { ?>
                                <a href="<?php bloginfo( 'url' ); ?>" class="logo">
                                    <img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
                                </a>
			                <?php } ?>
                        </div>
	                <?php } ?>
	                <?php if (has_nav_menu('privacy-menu')){ ?>
                        <div class="menu-primary-wrapper">
                            <div class="menu">
	                            <?php wp_nav_menu( array(
			                            'container' => '',
			                            'theme_location' => 'primary',
			                            'menu_class' => 'menu-primary')
	                            ); ?>
                            </div>
                        </div>
	                <?php } else { ?>
                        <div class="menu-col">
                            <button class="menu-trigger">
                                <span class="icon-menu"></span>
                                <span class="hide-mob"><?php _e('Menu','Tino'); ?></span>
                            </button>
                        </div>
	                <?php } ?>
                </div>
                <div class="col col-right-side-header">
	                <?php if(get_field('header_phone_gl','options') || get_field('header_phone_gl','options')) { ?>
                        <div class="phone-col">
                            <a href="tel:<?php the_field('header_phone_gl','options'); ?>">
				                <?php if(get_field('header_phone_text_gl','options')) { ?>
					                <?php the_field('header_phone_text_gl','options'); ?>
				                <?php } elseif (get_field('header_phone_gl','options')) { ?>
					                <?php the_field('header_phone_gl','options'); ?>
				                <?php } ?>
                            </a>
                        </div>
	                <?php } ?>
                    <?php if(get_field('login_text_gl','options') && get_field('login_link_gl','options')) { ?>
                        <div class="user-col">
	                        <?php if (has_nav_menu('privacy-menu')){ ?>
                                <div class="menu-primary-wrapper">
                                    <div class="menu">
				                        <?php wp_nav_menu( array(
						                        'container' => '',
						                        'theme_location' => 'login_menu',
						                        'menu_class' => 'menu-primary')
				                        ); ?>
                                    </div>
                                </div>
	                        <?php } else { ?>
                                <a href="<?php the_field('login_link_gl','options'); ?>" <?php if(get_field('login_open_in_new_window_gl','options')){ echo 'target="_blank"'; } ?>><span class="icon-log-in"></span> <?php the_field('login_text_gl','options'); ?></a>
	                        <?php } ?>
                        </div>
	                <?php } ?>
	                <?php if(get_field('cta_text_gl','options') && get_field('cta_link_gl','options')) { ?>
                        <div class="cta-col">
                            <?php if(!get_field('global_is_custom_cta','options')) { ?>
                            <a class="cta-header btn btn-border" href="<?php the_field('cta_link_gl','options'); ?>" <?php if(get_field('open_in_new_window_gl','options')){ echo 'target="_blank"'; } ?>><?php the_field('cta_text_gl','options'); ?></a>
                            <?php } else { ?>
                                <a class="cta-header btn btn-border" href="" onclick="window.enrollsy.openWidget({type:'ENROLL',slug:'brilliant-prep'});return false;">Get Started</a> <script>!function(n,e){var t,s;n.enrollsy||(n.enrollsy={},n.enrollsy._c=[],["init"].forEach(function(e){n.enrollsy[e]=function(){n.enrollsy._c.push([e,arguments])}}),(t=e.createElement("script")).type="text/javascript",t.async=!0,t.src="https://assets.enrollsy.com/external/widget.js",(s=e.getElementsByTagName("script")[0]).parentNode.insertBefore(t,s))}(window,document),window.setTimeout(function(){window.enrollsy.init()},1e3);</script>
                                <?php }?>
                        </div>
	                <?php } ?>
                    <div class="menu-col">
                        <button class="menu-trigger">
                            <span class="icon-menu"></span>
                            <span class="hide-mob"><?php _e('Menu','Tino'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


