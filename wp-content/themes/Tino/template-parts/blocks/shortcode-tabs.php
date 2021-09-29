<div class="section-inner">
	<div class="container">
		<?php $title = get_sub_field('shortcode_tabs_ttl'); ?>
		<?php if( have_rows('tabs_rows') ): ?>
			<?php $countTab = 1; ?>
			<?php $countTabItem = 1; ?>
			<div class="title-block title-with-tab">
				<div class="title-with-tab-left">
					<?php if($title) { ?>
						<h2 class="h1 title"><?php echo $title; ?></h2>
					<?php } ?>
				</div>
				<div class="title-with-tab-right">
					<div class="shortcode-tab-head-wrapper">
						<div class="shortcode-tab-head">
							<?php while ( have_rows('tabs_rows') ) : the_row(); ?>
								<div class="shortcode-tab-head-item">
									<a href="#shortcode-tab-content-item-<?php echo $countTab; ?>" class="shortcode-tab-link <?php if($countTab == 1) { echo 'active'; } ?>">
										<?php the_sub_field('tab_name_item'); ?>
									</a>
								</div>
								<?php $countTab++; ?>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="shortcode-tab-content">
				<div class="shortcode-tab-content-inner">
					<?php while ( have_rows('tabs_rows') ) : the_row(); ?>
						<div class="shortcode-tab-content-item <?php if($countTabItem == 1) { echo 'show'; } ?>" id="shortcode-tab-content-item-<?php echo $countTabItem; ?>" >
							<div class="shortcode-tab-content-item-inner">
								<?php if(get_sub_field('tabs_rows_title')) { ?>
									<div class="shortcode-tab-content-title">
										<div class="h3"><?php the_sub_field('tabs_rows_title'); ?></div>
									</div>
								<?php } ?>
								<?php if(get_sub_field('shortcode_item')) { ?>
									<div class="shortcode-tab-content-block">
										<?php echo do_shortcode(get_sub_field('shortcode_item')); ?>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php $countTabItem++; ?>
					<?php endwhile; ?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>