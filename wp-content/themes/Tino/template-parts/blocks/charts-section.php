<?php $colChart = get_sub_field('charts_section_columns_width'); ?>

<div class="section-inner" style="background-color: <?php the_sub_field('charts_section_background_color'); ?>">
	<div class="container">
		<?php if(get_sub_field('charts_section_title') || get_sub_field('charts_section_subtitle')) { ?>
			<div class="title-block" style="color: <?php the_sub_field('charts_section_title__subtitle_color'); ?>; text-align: <?php the_sub_field('charts_section_title__subtitle_align'); ?>; max-width: <?php the_sub_field('charts_section_title_columns_width'); ?>;">
				<?php if(get_sub_field('charts_section_title')) { ?>
					<h2 class="h1 title"><?php the_sub_field('charts_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('charts_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('charts_section_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<div class="charts-wrapper">
		<div class="charts-inner" style="background-color: <?php the_sub_field('charts_wrapper_background'); ?>">
			<div class="container">
				<?php if(get_sub_field('charts_section_title_chart_block')) { ?>
					<div class="h3 text-center title-chart"><?php the_sub_field('charts_section_title_chart_block'); ?></div>
				<?php } ?>
				<?php if( have_rows('charts_row') ): ?>
					<div class="row row-charts justify-content-center">
						<?php while ( have_rows('charts_row') ) : the_row(); ?>
							<div class="col-<?php echo $colChart; ?> item-chart">
								<div class="chart-block">
									<?php $chartImage = get_sub_field('chart_image'); ?>
									<div class="chart-image">
                                        <?php if(get_sub_field('chart_name')) { ?>
                                            <div class="charts-name" style="color:<?php the_sub_field('chart_name_color'); ?>;"><?php the_sub_field('chart_name'); ?></div>
                                        <?php } ?>
										<img src="<?php echo $chartImage['url']; ?>" alt="">
									</div>
									<?php if( have_rows('charts_values') ): ?>
										<div class="chart-values">
											<?php while ( have_rows('charts_values') ) : the_row(); ?>
												<div class="chart-value">
													<span class="color-circle" style="background-color: <?php the_sub_field('charts_color'); ?>"></span>
													<p><?php the_sub_field('charts_values_value'); ?></p>
												</div>
											<?php endwhile; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>