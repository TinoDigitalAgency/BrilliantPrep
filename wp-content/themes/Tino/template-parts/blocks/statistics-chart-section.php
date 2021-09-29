<div class="section-inner">
	<div class="container">
		<div class="title-block" style="text-align: <?php the_sub_field('statistics_title__subtitle_align'); ?>; max-width: <?php the_sub_field('statistics_title_columns_width'); ?>;">
			<?php if(get_sub_field('statistics_section_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('statistics_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('statistics_section_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('statistics_section_subtitle'); ?></p>
			<?php } ?>
		</div>

	</div>
	<?php if( have_rows('statistic_blocks') ): ?>
		<?php while ( have_rows('statistic_blocks') ) : the_row(); ?>
		<?php
			$leftValColor = get_sub_field('left_block_statistic_value_color_text');
			$leftlabColor = get_sub_field('left_block_statistic_small_color_text');
			$leftStatWidth = get_sub_field('left_block_statistic_block_width');
			$rightStatWidth = get_sub_field('right_block_statistic_block_width');
		?>
		<div class="statistic-block">
			<div class="statistic-block-inner" style="background-color: <?php the_sub_field('statistic_block_bacground_color'); ?>">
				<div class="container">
					<?php if(get_sub_field('statistic_block_title')) { ?>
						<div class="h1 statistic-block-title" style="color: <?php the_sub_field('statistic_block_title_color'); ?>; text-align: <?php the_sub_field('statistic_block_title_align'); ?>"><?php the_sub_field('statistic_block_title'); ?></div>
					<?php } ?>
					<div class="row stat-content">

						<?php if( have_rows('left_block_statistic') ): ?>
							<div class="statistic-block-left col" style="flex: 0 0 <?php echo $leftStatWidth; ?>; width: <?php echo $leftStatWidth; ?>; max-width: <?php echo $leftStatWidth; ?>">
								<?php while ( have_rows('left_block_statistic') ) : the_row(); ?>
									<div class="statistic-block-left-item">
										<div class="statistic-block-left-value" style="color:<?php echo $leftValColor; ?>;"><?php the_sub_field('statistic_value'); ?></div>
										<div class="statistic-block-left-label" style="color:<?php echo $leftlabColor; ?>;"><?php the_sub_field('statistic_label'); ?></div>
									</div>
								<?php endwhile; ?>
							</div>
						<?php endif; ?>
						<?php if( have_rows('right_block_statistic') ): ?>
							<div class="statistic-block-right col" style="flex: 0 0 <?php echo $rightStatWidth; ?>; width: <?php echo $rightStatWidth; ?>; max-width: <?php echo $rightStatWidth; ?>;">
								<?php while ( have_rows('right_block_statistic') ) : the_row(); ?>
									<div class="statistic-block-right-item" style="color:<?php the_sub_field('right_block_statistic_block_text_color'); ?>;">
										<div class="round-stat">
											<div class="circle-progress"  data-pct="<?php the_sub_field('right_block_statistic_value'); ?>">
												<svg  width="144" height="144" viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
													<circle r="68" cx="72" cy="72" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
													<circle class="bar" r="68" cx="72" cy="72" stroke="<?php the_sub_field('right_block_statistic_block_text_color'); ?>" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
												</svg>
											</div>
											<div class="round-stat-inner">

												<div class="bg" style="background-color: <?php the_sub_field('right_block_statistic_block_text_color'); ?>;"></div>
												<div class="center-val" ><?php the_sub_field('right_block_statistic_value'); ?>%</div>
											</div>
										</div>
										<div class="statistic-block-right-label" style=" color:<?php the_sub_field('right_block_statistic_block_text_color'); ?>;"><?php the_sub_field('right_block_statistic_label'); ?></div>
									</div>
								<?php endwhile; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</div>
		<?php endwhile; ?>
	<?php endif; ?>
</div>