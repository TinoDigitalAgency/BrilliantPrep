<div class="section-inner" style="background-color: <?php the_sub_field('logos_section_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="color: <?php the_sub_field('logos_section_title__subtitle_color'); ?>; text-align: <?php the_sub_field('logos_section_title__subtitle_align'); ?>; max-width: <?php the_sub_field('logos_section_title_columns_width'); ?>;">
			<?php if(get_sub_field('logos_section_title')) { ?>
				<h2 class="h3 title"><?php the_sub_field('logos_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('logos_section_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('logos_section_subtitle'); ?></p>
			<?php } ?>
		</div>
		<?php $colClass = get_sub_field('logos_section_column_per_row'); ?>
		<?php $maxWidth = get_sub_field('logos_section_max_width'); ?>
		<?php if( have_rows('logos_row') ): ?>
	        <div class="row-logos-wrapper" style="max-width: <?php echo $maxWidth; ?>">
		        <div class="row row-logos ">
			        <?php while ( have_rows('logos_row') ) : the_row(); ?>
				        <div class="col-<?php echo $colClass; ?> item-logo">
					        <div class="logo-block">
						        <?php $logoImage = get_sub_field('logo_item'); ?>
						        <?php if(get_sub_field('logo_link_item')) { ?>
							        <a href="<?php the_sub_field('logo_link_item'); ?>" class="logo-image">
								        <img src="<?php echo $logoImage['url']; ?>" alt="<?php the_sub_field('benefit_title'); ?>">
							        </a>
						        <?php } else { ?>
							        <div class="logo-image">
								        <img src="<?php echo $logoImage['url']; ?>" alt="<?php the_sub_field('benefit_title'); ?>">
							        </div>
						        <?php } ?>
					        </div>
				        </div>
			        <?php endwhile; ?>
		        </div>
	        </div>
		<?php endif; ?>
	</div>
</div>