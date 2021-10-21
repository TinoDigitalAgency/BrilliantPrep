<div class="section-inner" style="background-color: <?php the_sub_field('video_section_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="color: <?php the_sub_field('video_section_title__subtitle_color'); ?>; max-width: <?php the_sub_field('video_section_title_columns_width'); ?>; text-align: <?php the_sub_field('video_section_title__subtitle_align'); ?>">
			<?php if(get_sub_field('video_section_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('video_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('video_section_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('video_section_subtitle'); ?></p>
			<?php } ?>
		</div>
		<?php if(get_sub_field('video_link')) { ?>
			<div class="video-block">
				<a href="<?php the_sub_field('video_link'); ?>" <?php if(get_sub_field('video_link_modal_tab')) { echo 'data-fancybox'; } else { echo 'target="_blank"'; } ?> class="video-cover">
					<?php $videoCover = get_sub_field('video_cover');
					if($videoCover) {
						$videoCoverUrl = $videoCover['url'];
					} else {
						$videoCoverUrl = get_template_directory_uri().'/assets/src/YouTube-cover.png';
					}
					?>
					<img src="<?php echo $videoCoverUrl; ?>" alt="">
					<span class="play-image"></span>
				</a>
			</div>
		<?php } ?>

	</div>
</div>