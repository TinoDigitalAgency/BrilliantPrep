<div class="section-inner">
    <?php
    $colorBg = get_sub_field('hero_background_color');
    $imageHero = get_sub_field('hero_image');
    $vAlign = get_sub_field('hero_vertical_align');
    $hAlign = get_sub_field('hero_horizontal_align');

    ?>

    <div class="hero-content">

        <div class="container">
	        <?php $overlayImage = get_sub_field('hero_overlay_image'); ?>
	        <?php if($overlayImage) { ?>
                <div class="overlay-image" style="
		        <?php if(get_sub_field('hero_overlay_image_width')) { ?>
                        max-width: <?php the_sub_field('hero_overlay_image_width'); ?>;
            <?php } ?>
		        <?php if(get_sub_field('hero_overlay_image_width')) { ?>
                        max-height: <?php the_sub_field('hero_overlay_image_height'); ?>;
            <?php } ?>
                        ">
                    <img src="<?php echo $overlayImage['url']; ?>" alt="">
                </div>
	        <?php } ?>
            <div class="content-col" style="max-width: <?php the_sub_field('hero_content_columns_width'); ?>;">
	            <?php if(get_sub_field('hero_title_before')) { ?>
                    <div class="title-before" style="color:<?php the_sub_field('hero_title__subtitle_color'); ?>"><?php the_sub_field('hero_title_before'); ?></div>
	            <?php } ?>

                <?php if(get_sub_field('hero_title')) { ?>
<!--                        --><?php //if (get_sub_field('hero_title_text_typing')) { ?>
<!--                           -->
<!--                        --><?php //} ?>
                    <div class="h1 text" style="color:<?php the_sub_field('hero_title__subtitle_color'); ?>"><?php the_sub_field('hero_title'); ?> <?php if(get_sub_field('hero_title_text_typing')) { ?><span
                                class="txt-rotate"
                                data-period="2000"
                                data-rotate='["SATs & ACTs", "academic courses", "college applications"]'></span><?php } ?></div>
	            <?php } ?>
	            <?php if(get_sub_field('hero_subtitle')) { ?>
                    <div class="subtitle" style="color:<?php the_sub_field('hero_title__subtitle_color'); ?>"><?php the_sub_field('hero_subtitle'); ?></div>
	            <?php } ?>
	            <?php if(get_sub_field('hero_cta_text') && !get_sub_field('hero_is_custom_cta')) { ?>
                    <div class="hero-cta">
                        <a href="<?php the_sub_field('hero_cta_link'); ?>" <?php if(!get_sub_field('hero_cta_link')) {echo 'disabled'; } ?> class="btn btn-large btn-<?php the_sub_field('hero_cta_style'); ?>"><?php the_sub_field('hero_cta_text'); ?></a>
                    </div>
	            <?php } else{ ?>
	                <div class="hero-cta">
	                    <?php the_sub_field('hero_custom_cta'); ?>
	                </div>
	            <?php } ?>
            </div>
        </div>
    </div>
    <div class="hero-image <?php echo $vAlign . ' ' . $hAlign; if(get_sub_field('hero_cover_image')) { echo ' cover'; } ?>" style="background-color: <?php if($colorBg) { echo $colorBg; } ?>">
		<?php if($imageHero) { ?>
            <img src="<?php echo $imageHero['sizes']['hero-size']; ?>" alt="">
		<?php } ?>
    </div>
</div>
<?php if(get_sub_field('show_benefits') && get_sub_field('benefits_hero')) { ?>
	<?php

// Check rows exists.
	if( have_rows('benefits_hero') ): ?>
        <div class="benefits-hero">
            <div class="container">
                <div class="row row-benefits">
	                <?php while( have_rows('benefits_hero') ) : the_row(); ?>
                        <div class="col-4 item-benefit ">
                            <?php
                            $link = get_sub_field('benefits_hero_link');
                            $imageBenefits = get_sub_field('benefits_hero_icon');
                            if($link) { ?>
                                <a href="<?php echo $link['url']; ?>" class="benefit-block">
                            <?php } else { ?>
                                <div class="benefit-block">
                            <?php } ?>
                                <?php if($imageBenefits) { ?>
                                    <div class="benefit-image">
                                        <img src="<?php echo $imageBenefits['url']; ?>" alt="">
                                    </div>
                                <?php } ?>
                                <div class="h3"><?php the_sub_field('benefits_hero_title'); ?></div>
                            <?php if($link) { ?>
                                </a>
                            <?php } else { ?>
                                </div>
                            <?php } ?>
                        </div>
	                <?php endwhile; ?>
                </div>
            </div>
        </div>
	<?php endif; ?>
<?php } ?>