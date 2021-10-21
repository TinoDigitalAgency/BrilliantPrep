<div class="section-inner" style="background-color: <?php the_sub_field('image_block_with_text_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="color: <?php the_sub_field('image_block_with_text_title__subtitle_color'); ?>; max-width: <?php the_sub_field('image_block_with_text_title_columns_width'); ?>; text-align: <?php the_sub_field('image_block_with_text_title__subtitle_align'); ?>">
			<?php if(get_sub_field('image_block_with_text_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('image_block_with_text_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('image_block_with_text_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('image_block_with_text_subtitle'); ?></p>
			<?php } ?>
		</div>
		<?php $imageText = get_sub_field('image_block_with_text_image'); //var_dump($imageText); ?>
		<div class="row <?php the_sub_field('image_block_with_text_image_align'); ?>">
			<?php if($imageText) { ?>
				<div class="col image-col" style="max-width: <?php the_sub_field('image_block_with_text_image_width'); ?>; width: <?php the_sub_field('image_block_with_text_image_width'); ?>;">
					<img src="<?php echo $imageText['url']; ?>" alt="">
				</div>
			<?php } ?>
			<?php if(get_sub_field('image_block_with_text_text')) { ?>
				<div class="col text-col" style="max-width: <?php the_sub_field('image_block_with_text_text_width'); ?>; width: <?php the_sub_field('image_block_with_text_text_width'); ?>;">
					<div class="content" style="color: <?php the_sub_field('image_block_with_text_title__subtitle_color'); ?>;">
						<?php the_sub_field('image_block_with_text_text'); ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>