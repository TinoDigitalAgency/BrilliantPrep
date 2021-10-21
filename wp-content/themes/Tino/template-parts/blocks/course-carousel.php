<div class="section-inner">
	<div class="container">
		<div class="title-block title-block-with-arrow">
			<?php if(get_sub_field('courses_carousel_section_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('courses_carousel_section_title'); ?></h2>
			<?php } ?>
			<div class="cource-carousel-navs cource-nav">
				<div class="slider-button round-button-prev">
					<span class="icon-arrow-right"></span>
				</div>
				<div class="slider-button round-button-next">
					<span class="icon-arrow-right"></span>
				</div>
			</div>
		</div>
		<?php if( have_rows('carousel_courses_rows') ): ?>
			<div class="swiper-container course-slider">
				<div class="swiper-wrapper">
					<?php while ( have_rows('carousel_courses_rows') ) : the_row(); ?>
						<div class="swiper-slide">
							<div class="course-tile carousel-cource-tile">
								<div class="course-image">
									<div class="cource-card-image">
										<div class="cource-card-image-inner" style="
											background-color: <?php the_sub_field('courses_rows_background_color'); ?>;
											color: <?php the_sub_field('courses_rows_color_text'); ?>;
											">
											<?php $imageCard = get_sub_field('courses_rows_icon'); ?>
											<?php if($imageCard) { ?>
												<div class="image-card">
													<?php if(get_sub_field('courses_rows_cta_link')) { ?>
														<a href="<?php the_sub_field('courses_rows_cta_link'); ?>">
															<img src="<?php echo $imageCard['url']; ?>" alt="">
														</a>
													<?php } else { ?>
														<img src="<?php echo $imageCard['url']; ?>" alt="">
													<?php } ?>
												</div>
											<?php } ?>
											<?php if(get_sub_field('courses_rows_title_image')) { ?>
												<div class="h4">
													<?php the_sub_field('courses_rows_title_image'); ?>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="course-meta">
									<?php if(get_sub_field('courses_rows_cta_link')) { ?>
										<a class="course-title" href="<?php the_sub_field('courses_rows_cta_link'); ?>">
											<?php the_sub_field('courses_rows_title'); ?>
										</a>
									<?php } else { ?>
										<h3 class="course-title"><?php the_sub_field('courses_rows_title'); ?></h3>
									<?php } ?>
									<div class="course-meta-link">
										<?php if(get_sub_field('courses_rows_cta_link')) { ?>
											<div class="more-block">
												<a href="<?php the_sub_field('courses_rows_cta_link'); ?>" class="more-link"><?php the_sub_field('courses_rows_cta_text'); ?></a>
											</div>
										<?php } ?>

										<?php if(get_sub_field('courses_rows_price')) { ?>
											<div class="price-block">
												<div class="price"><?php the_sub_field('courses_rows_price'); ?></div>
											</div>
										<?php } ?>
										<?php if(get_sub_field('courses_find_class_link')) { ?>
											<div class="find-class-block">
												<a href="<?php the_sub_field('courses_find_class_link'); ?>" <?php if(get_sub_field('courses_open_link_in_new_tab')){ echo 'target="_blank"'; } ?> class="link-arrow-right"><?php the_sub_field('courses_find_class_text'); ?> <span class="icon-arrow-right"></span></a>
											</div>
										<?php } ?>
										<?php if(get_sub_field('show_notification_button')) { ?>
											<div class="notify-block">
												<a href="" class="link-notif"><?php the_sub_field('notification_button_text'); ?> <span class="icon-notification"></span></a>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>

				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination course-pagination"></div>
			</div>


		 <?php  endif; ?>
	</div>
</div>