<div class="section-inner" style="background-color: <?php the_sub_field('reviews_section_background_color'); ?>">
    <div class="container">
        <div class="title-block" style="color: <?php the_sub_field('reviews_section_title__subtitle_color'); ?>; text-align: <?php the_sub_field('reviews_section_title__subtitle_align'); ?>; max-width: <?php the_sub_field('reviews_section_title_columns_width'); ?>;">
            <?php if(get_sub_field('reviews_section_title')) { ?>
                <h2 class="h1 title"><?php the_sub_field('reviews_section_title'); ?></h2>
            <?php } ?>
	        <?php if(get_sub_field('reviews_section_subtitle')) { ?>
                <p class="subtitle"><?php the_sub_field('reviews_section_subtitle'); ?></p>
	        <?php } ?>
        </div>
	    <?php $count = count(get_sub_field('reviews_row')); ?>
	    <?php if( have_rows('reviews_row') ): ?>

            <div class="review-slider-wrapper">
                <div class="review-slider  swiper-container">
                    <div class="swiper-wrapper">
			            <?php while ( have_rows('reviews_row') ) : the_row(); ?>
                            <div class="swiper-slide">
                                <div class="review-block">
                                    <div class="review-inner">
                                        <div class="review-left">
								            <?php if(get_sub_field('review_name')) { ?>
                                                <div class="name"><?php the_sub_field('review_name'); ?></div>
								            <?php } ?>
								            <?php if(get_sub_field('review_position')) { ?>
                                                <div class="position"><?php the_sub_field('review_position'); ?></div>
								            <?php } ?>
								            <?php if((get_sub_field('review_arrow_cta_link') && get_sub_field('review_arrow_cta_text')) || (get_sub_field('review_cta_text') && get_sub_field('review_cta_link'))) { ?>
                                                <div class="review-links">
										            <?php if(get_sub_field('review_arrow_cta_link') && get_sub_field('review_arrow_cta_text')) { ?>
                                                        <div class="review-link-item">
                                                            <a href="<?php the_sub_field('review_arrow_cta_link'); ?>" class="review-link link-arrow-right"><?php the_sub_field('review_arrow_cta_text'); ?> <span class="icon-arrow-right"></span></a>
                                                        </div>
										            <?php } ?>
										            <?php if(get_sub_field('review_cta_text') && get_sub_field('review_cta_link')) { ?>
                                                        <div class="review-link-item">
                                                            <a href="<?php the_sub_field('review_cta_link'); ?>" class="review-link"><?php the_sub_field('review_cta_text'); ?></a>
                                                        </div>
										            <?php } ?>
                                                </div>
								            <?php } ?>
								            <?php if(get_sub_field('review_text')) { ?>
                                                <div class="review-text">
										            <?php the_sub_field('review_text'); ?>
                                                </div>
								            <?php } ?>
	                                        <?php if(get_sub_field('review_read_more_text') && get_sub_field('review_read_more_link')) { ?>
                                                <div class="review-btn">
                                                    <a href="<?php the_sub_field('review_read_more_link'); ?>" class="btn btn-pink btn-medium"><?php the_sub_field('review_read_more_text'); ?></a>
                                                </div>
	                                        <?php } ?>
                                        </div>
							            <?php $reviewImage = get_sub_field('review_portrait'); ?>
							            <?php if($reviewImage) { ?>
                                            <div class="review-right">
                                                <div class="image-reviewer">
                                                    <img src="<?php echo $reviewImage['url']; ?>" alt="">
                                                </div>
                                            </div>
							            <?php } ?>
                                    </div>

                                </div>
                            </div>
			            <?php endwhile; ?>
                    </div>
                </div>
                <?php  ?>
	            <?php if($count != 1) { ?>
                    <div class="swiper-pagination swiper-pagination-review"></div>
                    <!-- Add Arrows -->
                    <div class="review-arrow">
                        <div class="slider-button round-button-next">
                            <span class="icon-arrow-right"></span>
                        </div>
                        <div class="slider-button round-button-prev">
                            <span class="icon-arrow-right"></span>
                        </div>
                    </div>
	            <?php } ?>
            </div>

	    <?php endif; ?>
        <?php if(get_sub_field('reviews_section_cta_link') && get_sub_field('reviews_section_cta_text')) { ?>
            <div class="cta-section text-center">
                <a href="<?php the_sub_field('reviews_section_cta_link'); ?>" class="btn btn-large btn-pink"><?php the_sub_field('reviews_section_cta_text'); ?></a>
            </div>
        <?php } ?>
    </div>
</div>