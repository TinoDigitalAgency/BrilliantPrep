<div class="section-inner" style="background-color: <?php the_sub_field('subscribe_section_background_color'); ?>">
	<div class="container">
		<div class="row justify-content-center align-item-center subscribe-row">
			<div class="col subscribe-title-col title-block">
				<style>
					.subscribe-title-col {
						color: <?php the_sub_field('subscribe_section_title__subtitle_color'); ?>;
						max-width: <?php the_sub_field('subscribe_section_title_columns_width'); ?>;
						text-align: <?php the_sub_field('subscribe_section_title__subtitle_align'); ?>;
						flex: 0 0 <?php the_sub_field('subscribe_section_title_columns_width'); ?>;
					}
					.subscribe-block {
						max-width: <?php the_sub_field('subscribe_section_form_columns_width'); ?>;
						flex: 0 0 <?php the_sub_field('subscribe_section_form_columns_width'); ?>;
					}
				</style>
				<?php if(get_sub_field('subscribe_section_title')) { ?>
					<h2 class="h3 title"><?php the_sub_field('subscribe_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('subscribe_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('subscribe_section_subtitle'); ?></p>
				<?php } ?>
			</div>
			<?php if(get_sub_field('subscribe_form_shortcode')) { ?>
				<div class="col subscribe-block">
					<?php echo do_shortcode(get_sub_field('subscribe_form_shortcode')); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>