<?php
$imageColWidth = get_sub_field('picture_text_checkerboard_image_width');
$contentColWidth = get_sub_field('picture_text_checkerboard_text_width');
?>


<div class="section-inner" style="background-color: <?php the_sub_field('picture_text_checkerboard_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="color: <?php the_sub_field('picture_text_checkerboard_title__subtitle_color'); ?>; max-width: <?php the_sub_field('picture_text_checkerboard_title_columns_width'); ?>; text-align: <?php the_sub_field('picture_text_checkerboard_title__subtitle_align'); ?>">
			<?php if(get_sub_field('picture_text_checkerboard_section_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('picture_text_checkerboard_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('picture_text_checkerboard_section_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('picture_text_checkerboard_section_subtitle'); ?></p>
			<?php } ?>
		</div>

	</div>
	<?php if( have_rows('checkerboard_rows') ): ?>
		<div class="checkerboard">
			<div class="container">
				<?php $countRows = 1; ?>
				<?php while ( have_rows('checkerboard_rows') ) : the_row(); ?>
					<?php $imageCheckerboard = get_sub_field('picture_text_checkerboard_image'); ?>
					<div class="row checkerboard-row <?php echo $countRows; ?>">
						<?php if($imageCheckerboard) { ?>
							<div class="image-col col " style="max-width: <?php echo $imageColWidth; ?>;">
								<div class="checkerboard-image">
									<img src="<?php echo $imageCheckerboard['sizes']['large']; ?>" alt="">
								</div>
							</div>
						<?php } ?>
						<div class="checkerboard-content-col col" style="max-width: <?php echo $contentColWidth; ?>;">
							<div class="checkerboard-content">
								<?php if(get_sub_field('picture_text_checkerboard_title')) { ?>
									<div class="h3"><?php the_sub_field('picture_text_checkerboard_title'); ?></div>
								<?php } ?>

								<?php if(get_sub_field('picture_text_checkerboard_subtitle')) { ?>
									<div class="subtitle" <?php if(get_sub_field('picture_text_checkerboard_subtitle_color')) { ?>style="
										color: <?php the_sub_field('picture_text_checkerboard_subtitle_color'); ?>"<?php } ?>>

										<?php the_sub_field('picture_text_checkerboard_subtitle'); ?>
									</div>
								<?php } ?>

								<?php if(get_sub_field('picture_text_checkerboard_content')) { ?>
									<div class="content <?php if(get_sub_field('picture_text_checkerboard_collapse_text')) { echo 'collapse-text-block';} ?>"><?php the_sub_field('picture_text_checkerboard_content'); ?></div>
								<?php } ?>

								<?php if(get_sub_field('picture_text_checkerboard_cta_text')) { ?>
									<div class="checkerboard-cta">
										<a class="btn btn-<?php the_sub_field('picture_text_checkerboard_cta_style'); ?> <?php if(get_sub_field('picture_text_checkerboard_collapse_text')) { echo 'collapse-text-btn';} ?>" href="<?php the_sub_field('picture_text_checkerboard_cta_link'); ?>">
											<?php the_sub_field('picture_text_checkerboard_cta_text'); ?>
										</a>

									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php $countRows++; ?>
				<?php endwhile; ?>
			</div>
		</div>
	<?php endif; ?>
</div>