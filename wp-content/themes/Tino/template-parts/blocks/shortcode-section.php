<div class="section-inner" style="
<?php if(get_sub_field('shortcode_section_margin_top')) { ?>
	margin-top: <?php the_sub_field('shortcode_section_margin_top'); ?>;
<?php } ?>
<?php if(get_sub_field('shortcode_section_margin_bottom')) { ?>
	margin-bottom: <?php the_sub_field('shortcode_section_margin_bottom'); ?>;
<?php } ?>
<?php if(get_sub_field('shortcode_section_margin_left')) { ?>
	margin-left: <?php the_sub_field('shortcode_section_margin_left'); ?>;
<?php } ?>
<?php if(get_sub_field('shortcode_section_margin_right')) { ?>
	margin-right: <?php the_sub_field('shortcode_section_margin_right'); ?>;
<?php } ?>
	">
	<div class="container">
		<?php if(get_sub_field('shortcode_section_title')) { ?>
			<div class="title-block">

				<h2 class="h1 title"><?php the_sub_field('shortcode_section_title'); ?></h2>

			</div>
		<?php } ?>
		<?php if(get_sub_field('shortcode_section_content')) { ?>
			<div class="content"><?php the_sub_field('shortcode_section_content'); ?></div>
		<?php } ?>

		<?php if(get_sub_field('shortcode_value')) { ?>
			<div class="shortcode-wrapper"><?php echo do_shortcode(get_sub_field('shortcode_value')); ?></div>
		<?php } ?>
	</div>
</div>