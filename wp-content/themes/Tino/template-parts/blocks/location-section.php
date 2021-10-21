<div class="section-inner" style="background-color: <?php the_sub_field('location_section_background_color'); ?>">
	<div class="container">
		<?php if(get_sub_field('location_section_title') || get_sub_field('location_section_subtitle')) { ?>
			<div class="title-block" style="color: <?php the_sub_field('location_section_title__subtitle_color'); ?>; text-align: <?php the_sub_field('location_section_title__subtitle_align'); ?>; max-width: <?php the_sub_field('location_section_title_columns_width'); ?>;">
				<?php if(get_sub_field('location_section_title')) { ?>
					<h2 class="h3 title"><?php the_sub_field('location_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('location_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('location_section_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
		<?php $columns = get_sub_field('locations_per_row') ?>
		<?php if( have_rows('locations_row') ): ?>
			<div class="row row-locations">
				<?php while ( have_rows('locations_row') ) : the_row(); ?>
					<div class="col-<?php echo $columns; ?> item-location">
						<div class="location-block">
							<?php $locationImage = get_sub_field('marker_item'); ?>
							<div class="location-marker">
								<img src="<?php echo $locationImage['url']; ?>" alt="">
							</div>
							<div class="h3"><?php the_sub_field('title_location'); ?></div>
							<div class="address"><?php the_sub_field('address_location'); ?></div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</div>