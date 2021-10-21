<div class="section-inner" style="background-color: <?php the_sub_field('image_section_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="color: <?php the_sub_field('image_section_title__subtitle_color'); ?>; max-width: <?php the_sub_field('image_section_title_columns_width'); ?>; text-align: <?php the_sub_field('image_section_title__subtitle_align'); ?>">
			<?php if(get_sub_field('image_section_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('image_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('image_section_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('image_section_subtitle'); ?></p>
			<?php } ?>
		</div>
		<?php if(get_sub_field('ifographic_image')) { ?>
			<?php $imageBlock = get_sub_field('ifographic_image'); ?>
			<div class="image-block">
				<img src="<?php echo $imageBlock['url']; ?>" alt="">
			</div>
		<?php } ?>

	</div>
</div>