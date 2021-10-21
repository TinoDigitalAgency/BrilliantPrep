<div class="section-inner">
	<div class="container">
		<?php if(get_sub_field('video_list_section_title') || get_sub_field('video_list_section_subtitle')) { ?>
			<div class="title-block">
				<?php if(get_sub_field('video_list_section_title')) { ?>
					<h2 class="h1 title"><?php the_sub_field('video_list_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('video_list_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('video_list_section_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
		<?php $videoCount = 1; ?>
		<?php if( have_rows('video_list_rows') ): ?>
			<div class="video-list">
				<?php while( have_rows('video_list_rows') ) : the_row(); ?>
				<?php
					$videoCover = get_sub_field('video_list_video_cover');
				    $videoLink = get_sub_field('video_list_video_link');
				    $videoFile = get_sub_field('video_list_video_file');
				    $videoUrl = '';
				    if($videoLink) {
					    $videoUrl = $videoLink;
				    } elseif ($videoFile) {
					    $videoUrl = $videoFile['url'];
				    }
				    ?>
					<div class="video-item">
						<div class="video-image">
							<a data-fancybox data-src="<?php  echo $videoUrl; ?>" href="javascript:;">
								<div class="image-title" style="background-color: <?php the_sub_field('video_list_video_color'); ?>">
									<?php the_sub_field('video_list_video_title'); ?>
								</div>
								<span class="play-image"></span>
								<img src="<?php echo $videoCover['url']; ?>" alt="">
							</a>
						</div>
						<div class="video-info">
							<a data-fancybox  class="h3" data-src="<?php  echo $videoUrl; ?>" href="javascript:;">
								<span class="count-video">
									<?php if($videoCount < 10) { echo 0; }  echo $videoCount; ?>.
								</span>
								<?php the_sub_field('video_list_video_title'); ?>
							</a>
							<?php if (get_sub_field('video_list_video_description')) { ?>
								<div class="video-description"><?php the_sub_field('video_list_video_description'); ?></div>
							<?php } ?>
						</div>
					</div>
					<?php $videoCount ++; ?>
				<?php endwhile; ?>

			</div>


		<?php endif; ?>
	</div>
</div>