<div class="section-inner">
	<div class="container">
		<?php if(get_sub_field('video_carousel_section_title') || get_sub_field('video_carousel_section_subtitle')) { ?>
		<div class="title-block title-block-with-arrow">
			<div class="wrap">
				<?php if(get_sub_field('video_carousel_section_title')) { ?>
					<h2 class="h1 title"><?php the_sub_field('video_carousel_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('video_carousel_section_subtitle')) { ?>
					<div class="subtitle"><?php the_sub_field('video_carousel_section_subtitle'); ?></div>
				<?php } ?>
			</div>
			<div class="cource-carousel-navs video-nav">
				<div class="slider-button round-button-prev">
					<span class="icon-arrow-right"></span>
				</div>
				<div class="slider-button round-button-next">
					<span class="icon-arrow-right"></span>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if( have_rows('video_carousel_rows') ): ?>
			<div class="swiper-container video-slider">
				<div class="swiper-wrapper">
					<?php while ( have_rows('video_carousel_rows') ) : the_row(); ?>
						<?php
                            $videoCover = get_sub_field('video_carousel_video_cover');
							$videoLink = get_sub_field('video_carousel_link');
							$videoFile = get_sub_field('video_carousel_file');
							$videoUrl = '';
							if($videoLink) {
								$videoUrl = $videoLink;
							} elseif ($videoFile) {
								$videoUrl = $videoFile['url'];
							}
                            ?>
						<div class="swiper-slide">
							<div class="video-image">
								<a data-fancybox data-src="<?php  echo $videoUrl; ?>" href="javascript:;">
									<div class="image-title" style="background-color: <?php the_sub_field('video_carousel_title_background_color'); ?>">
										<?php the_sub_field('video_carousel_title'); ?>
									</div>
									<span class="play-image"></span>
									<img src="<?php echo $videoCover['sizes']['large']; ?>" alt="">
								</a>
							</div>
						</div>
					<?php endwhile; ?>

				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination video-pagination"></div>
			</div>
		 <?php  endif; ?>
		<?php if( get_sub_field('video_cta_text') && get_sub_field('video_cta_link') ) { ?>
			<div class="cta-block text-center">
				<a href="<?php the_sub_field('video_cta_link'); ?>" class="btn btn-pink"><?php the_sub_field('video_cta_text'); ?></a>
			</div>
		<?php } ?>
	</div>
</div>