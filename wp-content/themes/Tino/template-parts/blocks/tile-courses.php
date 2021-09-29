<div class="section-inner" style="background-color: <?php the_sub_field('tile_courses_background_color'); ?>">
    <div class="container">
        <div class="title-block" style="color: <?php the_sub_field('tile_courses_title__subtitle_color'); ?>; max-width: <?php the_sub_field('tile_courses_title_columns_width'); ?>;">
            <?php if(get_sub_field('tile_courses_title')) { ?>
                <h2 class="h1 title"><?php the_sub_field('tile_courses_title'); ?></h2>
            <?php } ?>
	        <?php if(get_sub_field('tile_courses_subtitle')) { ?>
                <p class="subtitle"><?php the_sub_field('tile_courses_subtitle'); ?></p>
	        <?php } ?>
        </div>
	    <?php if( have_rows('courses_rows') ): ?>
            <div class="row row-courses-tile">
	            <?php while ( have_rows('courses_rows') ) : the_row(); ?>
                    <div class="col-4 item-course-tile">
                        <div class="course-tile">
	                        <?php $courseImage = get_sub_field('courses_image'); ?>
	                        <?php if($courseImage) { ?>
                                <div class="course-image">
                                    <?php if(get_sub_field('courses_label')) { ?>
                                        <div class="label-c" style="color:<?php the_sub_field('courses_label_text_color'); ?>; background-color: <?php the_sub_field('courses_label_bg'); ?>"><?php the_sub_field('courses_label'); ?></div>
                                    <?php } ?>
	                                <?php if(get_sub_field('courses_enable_bookmark_label')) { ?>
                                        <div class="label-bookmark"></div>
	                                <?php } ?>
			                        <?php if(get_sub_field('courses_cta_link')) { ?>
                                        <a href="<?php the_sub_field('courses_cta_link'); ?>">
                                            <img src="<?php echo $courseImage['url']; ?>" alt="">
                                        </a>
                                    <?php } else { ?>
                                        <img src="<?php echo $courseImage['url']; ?>" alt="">
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="course-meta">
	                            <?php if(get_sub_field('courses_cta_link')) { ?>
                                    <a class="course-title" href="<?php the_sub_field('courses_cta_link'); ?>">
	                                    <?php the_sub_field('courses_title'); ?>
                                    </a>
	                            <?php } else { ?>
                                    <h3 class="course-title"><?php the_sub_field('courses_title'); ?></h3>
	                            <?php } ?>
                                <div class="course-meta-link">
	                                <?php if(get_sub_field('courses_cta_link')) { ?>
                                        <div class="more-block">
                                            <a href="<?php the_sub_field('courses_cta_link'); ?>" class="more-link"><?php the_sub_field('courses_cta_text'); ?></a>
                                        </div>
	                                <?php } ?>

                                    <?php if(get_sub_field('courses_price')) { ?>
                                        <div class="price-block">
                                            <div class="price"><?php the_sub_field('courses_price'); ?></div>
                                        </div>
	                                <?php } ?>
	                                <?php if(get_sub_field('courses_find_class_text')) { ?>
                                        <div class="find-class-block">
                                            <?php if(!get_sub_field('courses_is_custom_cta')) { ?>
                                            <a href="<?php the_sub_field('courses_find_class_link'); ?>" <?php if(!get_sub_field('courses_find_class_link')) echo 'disabled'; ?> <?php if(get_sub_field('courses_open_link_in_new_tab')){ echo 'target="_blank"'; } ?> class="link-arrow-right"><?php the_sub_field('courses_find_class_text'); ?> <span class="icon-arrow-right"></span></a>
                                            <?php } else { 
                                            the_sub_field('courses_custom_cta'); 
                                            }?>
                                        </div>
	                                <?php } ?>
	                                <?php if(get_sub_field('show_notification_button')) { ?>
                                        <div class="notify-block">
                                            <a href="" class="link-notif"><?php the_sub_field('notification_button_text'); ?> <span class="icon-notification"></span></a>
                                        </div>
	                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
	            <?php endwhile; ?>
            </div>
	    <?php endif; ?>

    </div>
</div>