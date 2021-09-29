<div class="section-inner" style="background-color: <?php the_sub_field('chess_section_background_color'); ?>">
    <div class="container">
        <div class="title-block" style="color: <?php the_sub_field('chess_section_title__subtitle_color'); ?>; max-width: <?php the_sub_field('chess_section_title_columns_width'); ?>;">
            <?php if(get_sub_field('chess_section_title')) { ?>
                <h2 class="h1 title"><?php the_sub_field('chess_section_title'); ?></h2>
            <?php } ?>
	        <?php if(get_sub_field('chess_section_subtitle')) { ?>
                <p class="subtitle"><?php the_sub_field('chess_section_subtitle'); ?></p>
	        <?php } ?>
        </div>

        <div class="chess-wrapper">
            <div class="chess-main">
                <?php $chessImage = get_sub_field('chess_image'); ?>
                <div class="chess-image">
                    <img src="<?php echo $chessImage['url']; ?>" alt="">
                </div>
	            <?php if( have_rows('chess_left') ): ?>
                    <div class="chess-side chess-left">
                        <div class="chess-left-inner">
	                        <?php while ( have_rows('chess_left') ) : the_row(); ?>
                                <div class="chess-item chess-item-<?php the_sub_field('chess_left_step_number'); ?>">
                                    <div class="chess-item-inner ">
                                        <div class="chess-item__title"><?php the_sub_field('chess_left_step_title'); ?></div>
                                        <div class="chess-item__description"><?php the_sub_field('chess_left_step_text'); ?></div>
                                    </div>
                                </div>
	                        <?php endwhile; ?>
                            <div class="mobile-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/src/chess-left.svg" alt="">
                            </div>
                        </div>
                    </div>
	            <?php endif; ?>
	            <?php if( have_rows('chess_right') ): ?>
                    <div class="chess-side chess-right">
                        <div class="chess-left-inner">
				            <?php while ( have_rows('chess_right') ) : the_row(); ?>
                                <div class="chess-item chess-item-<?php the_sub_field('chess_right_step_number'); ?>">
                                    <div class="chess-item-inner ">
                                        <div class="chess-item__title"><?php the_sub_field('chess_right_step_title'); ?></div>
                                        <div class="chess-item__description"><?php the_sub_field('chess_right_step_text'); ?></div>
                                    </div>
                                </div>
				            <?php endwhile; ?>
                            <div class="mobile-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/src/chess-right.svg" alt="">
                            </div>
                        </div>
                    </div>
	            <?php endif; ?>

            </div>
        </div>
    </div>
</div>