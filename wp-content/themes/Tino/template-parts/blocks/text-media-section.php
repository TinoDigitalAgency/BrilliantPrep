<div class="section-inner" style="background-color: <?php the_sub_field('media_text_section_background_color'); ?>">
	<div class="container">
		<?php if(get_sub_field('media_text_section_title') || get_sub_field('media_text_section_subtitle')) { ?>
			<div class="title-block" style="
				color: <?php the_sub_field('media_text_section_title__subtitle_color'); ?>;
				max-width: <?php the_sub_field('media_text_section_title_columns_width'); ?>;
				text-align: <?php the_sub_field('media_text_section_title__subtitle_align'); ?>">

				<?php if(get_sub_field('media_text_section_title')) { ?>
					<h2 class="h1 title"><?php the_sub_field('media_text_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('media_text_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('media_text_section_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
		<?php $mediaBlock = get_sub_field('media_text_image'); ?>
		<div class="media-text-block content">
			<?php if($mediaBlock) { ?>
				<div class="image-block">
					<img src="<?php echo $mediaBlock['url']; ?>" alt="">
				</div>
			<?php } ?>
			<?php if(get_sub_field('media_text_content')) { ?>
				<?php the_sub_field('media_text_content'); ?>
			<?php } ?>
		</div>
	</div>
</div>