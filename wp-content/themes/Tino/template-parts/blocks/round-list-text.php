<?php
$firstColor = get_sub_field('round_icon_with_text_round_bg_color');
$secondColor = get_sub_field('round_icon_with_text_round_bg_color_second');
$listingIcon = get_sub_field('round_icon_with_text_round_icon');
?>

<div class="section-inner" style="
	background-color: <?php the_sub_field('round_icon_with_text_background_color'); ?>;
	<?php if(get_sub_field('round_icon_with_text_section_padding_top')) { ?>
		padding-top: <?php the_sub_field('round_icon_with_text_section_padding_top'); ?>;
	<?php } ?>
	<?php if(get_sub_field('round_icon_with_text_section_padding_bottom')) { ?>
		padding-bottom: <?php the_sub_field('round_icon_with_text_section_padding_bottom'); ?>;
	<?php } ?>
	">
	<div class="container">
		<?php if(get_sub_field('round_icon_with_text_title') || get_sub_field('round_icon_with_text_subtitle')) { ?>
			<div class="title-block" style="color: <?php the_sub_field('round_icon_with_text_title__subtitle_color'); ?>; max-width: <?php the_sub_field('round_icon_with_text_title_columns_width'); ?>; text-align: <?php the_sub_field('round_icon_with_text_title__subtitle_align'); ?>">
				<?php if(get_sub_field('round_icon_with_text_title')) { ?>
					<h2 class="h1 title"><?php the_sub_field('round_icon_with_text_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('round_icon_with_text_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('round_icon_with_text_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if( have_rows('round_icon_with_text_row') ): ?>
			<?php $stepCoutList = 1; ?>
			<div class="detail-steps-block ">
				<div class="detail-steps-block-inner">
					<div class="steps-list">
						<?php while ( have_rows('round_icon_with_text_row') ) : the_row(); ?>
							<div class="step-item <?php if($stepCoutList == 1) { echo 'first-item'; } ?>">
								<div class="dash-line" style="border-color: <?php echo $firstColor; ?>"></div>
								<div class="step-item-inner">
									<?php if($secondColor) { ?>
										<div class="round-marker" style="
											background-color: <?php echo ($stepCoutList % 2) ? $firstColor : $secondColor; ?>;">
											<?php if($listingIcon) { ?>
												<img src="<?php echo $listingIcon['url']; ?>" alt="">
											<?php } else { echo $stepCoutList; } ?>
										</div>
									<?php } else { ?>
										<div class="round-marker" style="
											background-color: <?php echo $firstColor; ?>;">
											<?php if($listingIcon) { ?>
												<img src="<?php echo $listingIcon['url']; ?>" alt="">
											<?php } else { echo $stepCoutList; } ?>
										</div>
									<?php } ?>
									<?php if(get_sub_field('round_icon_title')) { ?>
										<div class="step-title h3"><?php  the_sub_field('round_icon_title'); ?></div>
									<?php } ?>
									<?php if(get_sub_field('round_icon_subtitle')) { ?>
										<div class="step-text"><?php  the_sub_field('round_icon_subtitle'); ?></div>
									<?php } ?>
								</div>
							</div>
							<?php $stepCoutList++; ?>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>