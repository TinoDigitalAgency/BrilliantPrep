<?php $imageBg = get_sub_field('section_with_numbers_background_image'); ?>

<div class="section-inner" style="
	background-color: <?php the_sub_field('section_with_numbers_background_color'); ?>;
	<?php if($imageBg) { ?>
		background-image: url(<?php echo $imageBg['url']; ?>);
	<?php } ?>
	background-position: <?php the_sub_field('section_with_numbers_background_postion_x'); ?> <?php
    if(get_sub_field('section_with_numbers_background_postion_y')=='top' &&  get_sub_field('section_with_numbers_background_size') !='cover') {
        echo '40px';
    } else {
        the_sub_field('section_with_numbers_background_postion_y');
    }
    ?>;
    background-repeat: no-repeat;

    <?php if(get_sub_field('section_with_numbers_background_size_x') || get_sub_field('section_with_numbers_background_size_y')) { ?>
        <?php if(get_sub_field('section_with_numbers_background_size_x') &&  !get_sub_field('section_with_numbers_background_size_y')) { ?>
            background-size: <?php the_sub_field('section_with_numbers_background_size_x'); ?> auto;
        <?php } elseif (!get_sub_field('section_with_numbers_background_size_x') && get_sub_field('section_with_numbers_background_size_y')) {?>
                background-size: auto <?php the_sub_field('section_with_numbers_background_size_y'); ?> ;
	    <?php } elseif (!get_sub_field('section_with_numbers_background_size_x') && get_sub_field('section_with_numbers_background_size_y')) {?>
                background-size: <?php the_sub_field('section_with_numbers_background_size_x'); ?>  <?php the_sub_field('section_with_numbers_background_size_y'); ?> ;
        <?php } ?>
    <?php } else { ?>
            background-size: <?php the_sub_field('section_with_numbers_background_size'); ?>;
    <?php }  ?>
	">
	<div class="container">
		<div class="title-block" style="
			color: <?php the_sub_field('section_with_numbers_title__subtitle_color'); ?>;
			max-width: <?php the_sub_field('section_with_numbers_title_columns_width'); ?>;
			text-align: <?php the_sub_field('section_with_numbers_title__subtitle_align'); ?>">
			<?php if(get_sub_field('section_with_numbers_title')) { ?>
				<h3 class="h3 title"><?php the_sub_field('section_with_numbers_title'); ?></h3>
			<?php } ?>
			<?php if(get_sub_field('section_with_numbers_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('section_with_numbers_subtitle'); ?></p>
			<?php } ?>
		</div>
		<?php $columnClass = get_sub_field('section_with_numbers_numbers_column_per_row'); ?>
		<?php if( have_rows('section_with_numbers_numbers') ): ?>
			<div class="numbers-list row">
				<?php while ( have_rows('section_with_numbers_numbers') ) : the_row(); ?>
					<div class="col-<?php echo $columnClass; ?> numbers-list-item">
						<div class="number-list">
							<?php $imageIcon = get_sub_field('section_with_numbers_numbers_icon'); ?>
							<?php if($imageIcon) { ?>
								<div class="number-list-icon">
									<img src="<?php echo $imageIcon['url']; ?>" alt="">
								</div>
							<?php } ?>
							<?php if(get_sub_field('section_with_numbers_numbers_small_text')) { ?>
								<div class="number-list-small-text">
									<?php the_sub_field('section_with_numbers_numbers_small_text'); ?>
								</div>
							<?php } ?>
							<?php if(get_sub_field('section_with_numbers_numbers_big_text')) { ?>
								<div class="number-list-big-text">
									<?php the_sub_field('section_with_numbers_numbers_big_text'); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php if(get_sub_field('section_with_numbers_button_text') && get_sub_field('section_with_numbers_button_link')) { ?>
			<div class="cta-block" style="text-align: <?php the_sub_field('section_with_numbers_title__subtitle_align'); ?>">
                <a href="<?php the_sub_field('section_with_numbers_button_link'); ?>" class="btn btn-pink btn-medium"><?php the_sub_field('section_with_numbers_button_text'); ?></a>
			</div>
		<?php } ?>
	</div>
</div>