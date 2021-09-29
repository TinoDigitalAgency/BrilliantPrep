<div class="section-inner" style="background-color: <?php the_sub_field('statistic_section_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="color: <?php the_sub_field('statistic_section_title__subtitle_color'); ?>; max-width: <?php the_sub_field('statistic_section_title_columns_width'); ?>; text-align: <?php the_sub_field('statistic_section_title__subtitle_align'); ?>">
			<?php if(get_sub_field('statistic_section_title')) { ?>
				<h2 class="h3 title"><?php the_sub_field('statistic_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('statistic_section_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('statistic_section_subtitle'); ?></p>
			<?php } ?>
		</div>
        <?php
            $mainStatisticImage = get_sub_field('main_infographic_image');
            $mainStatisticTitle = get_sub_field('main_infographic_text');
        ?>
        <?php if($mainStatisticImage && $mainStatisticTitle) { ?>
            <div class="main-statistic-infographic">
                <div class="main-statistic-infographic-image">
                    <img src="<?php echo $mainStatisticImage['url']; ?>" alt="">
                </div>
                <div class="main-statistic-infographic-title"><?php echo $mainStatisticTitle; ?></div>
            </div>
        <?php } ?>
		<?php if( have_rows('statistic_row') ): ?>
			<div class="row row-statistic">
				<?php while ( have_rows('statistic_row') ) : the_row(); ?>
					<div class="col-3 item-statistic">
						<div class="statistic-block">
							<?php $statisticImage = get_sub_field('statistic_icon'); ?>
							<?php if($statisticImage) { ?>
								<div class="statistic-icon">
									<div class="round-icon">
										<img src="<?php echo $statisticImage['url']; ?>" alt="<?php the_sub_field('benefit_title'); ?>">
									</div>
								</div>
							<?php } ?>
							<?php if(get_sub_field('statistic_title')) { ?>
								<div class="subcount"><?php the_sub_field('statistic_title'); ?></div>
							<?php } ?>

							<?php if(get_sub_field('statistic_description')) { ?>
								<div class="count"><?php the_sub_field('statistic_description'); ?></div>
							<?php } ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</div>