<div class="section-inner" style="background-color: <?php the_sub_field('popular_articles_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="color: <?php the_sub_field('popular_articles_title__subtitle_color'); ?>; max-width: <?php the_sub_field('popular_articles_title_columns_width'); ?>; text-align: <?php the_sub_field('popular_articles_title__subtitle_align'); ?>">
			<?php if(get_sub_field('popular_articles_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('popular_articles_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('popular_articles_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('popular_articles_subtitle'); ?></p>
			<?php } ?>
			<div class="slider-nav">
				<div class="slider-button round-button-prev">
					<span class="icon-arrow-right"></span>
				</div>
				<div class="slider-button round-button-next">
					<span class="icon-arrow-right"></span>
				</div>
			</div>
		</div>
		<?php $posts = get_sub_field('articles_rows');
			$slicePosts = array_chunk($posts,3,true);
		?>
		<?php if( $posts ): ?>
			<div class="swiper-container popular-article-slider">
				<div class="swiper-wrapper">
					<?php foreach( $slicePosts as $slicePost): // variable must be called $post (IMPORTANT) ?>
						<?php setup_postdata($slicePost); ?>
						<div class="swiper-slide">
							<div class="article-tile article-tile-3 row">
							<?php $countInnerPost = 1; ?>
							<?php $countPostArray = count($slicePost); ?>
							<?php foreach( $slicePost as $post): // variable must be called $post (IMPORTANT) ?>
								<?php if($countInnerPost == 1) { ?>
									<div class="col slider-article-col">
										<div class='popular-article-block '>
											<div class="article-element">
												<div class="article-image">
													<?php $categories = get_the_category();
													$cat_ID = $categories[0]->term_id;
													$cat_name = $categories[0]->name;
													$colorLabel = get_field('label_color_category','term_'.$cat_ID);
													$cat_Link = get_category_link( $cat_ID );
													//											var_dump($colorLabel);
													?>
													<a href="<?php echo $cat_Link; ?>" class="category-label" style="background-color: <?php echo $colorLabel; ?>">
														<span><?php echo $cat_name; ?></span>
													</a>
													<a href="<?php the_permalink(); ?>" class="image-overlay">
														<img src="<?php echo get_the_post_thumbnail_url($post->ID,'large'); ?>" alt="<?php the_title(); ?>">
													</a>
												</div>
												<div class="article-meta">
													<div class="h3"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></div>
													<div class="more-block">
														<a href="<?php the_permalink(); ?>" class="link-arrow-right">Read More <span class="icon-arrow-right"></span></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($countInnerPost == 2) { ?>
									<div class="col slider-two-article-col">
								<?php } ?>
								<?php if($countInnerPost > 1) { ?>
									<div class='popular-article-block '>
										<div class="article-element">
											<div class="article-image">
												<?php $categories = get_the_category();
												$cat_ID = $categories[0]->term_id;
												$cat_name = $categories[0]->name;
												$colorLabel = get_field('label_color_category','term_'.$cat_ID);
												$cat_Link = get_category_link( $cat_ID );
												?>
												<a href="<?php echo $cat_Link; ?>" class="category-label" style="background-color: <?php echo $colorLabel; ?>">
													<span><?php echo $cat_name; ?></span>
												</a>
												<a href="<?php the_permalink(); ?>" class="image-overlay">
													<img src="<?php echo get_the_post_thumbnail_url($post->ID,'blog-thumb'); ?>" alt="<?php the_title(); ?>">
												</a>
											</div>
											<div class="article-meta">
												<div class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
												<div class="more-block">
													<a href="<?php the_permalink(); ?>" class="link-arrow-right">Read More <span class="icon-arrow-right"></span></a>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($countInnerPost == 3 || $countInnerPost == $countPostArray) { ?>
									</div>
								<?php } ?>
								<?php $countInnerPost++; ?>
							<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>

				</div>
				<div class="swiper-pagination popular-article-pagination"></div>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endif; ?>
	</div>
</div>