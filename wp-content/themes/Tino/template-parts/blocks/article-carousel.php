<div class="section-inner">
	<div class="container">
		<div class="title-block title-block-with-arrow">
			<?php if(get_sub_field('popular_articles_carousel_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('popular_articles_carousel_title'); ?></h2>
			<?php } ?>
			<div class="cource-carousel-navs article-nav">
				<div class="slider-button round-button-prev">
					<span class="icon-arrow-right"></span>
				</div>
				<div class="slider-button round-button-next">
					<span class="icon-arrow-right"></span>
				</div>
			</div>
		</div>
		<?php $posts = get_sub_field('popular_articles_carousel_rows'); ?>

		<?php if( $posts ): ?>
			<div class="swiper-container article-slider">
				<div class="swiper-wrapper">
					<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
						<?php setup_postdata($post); ?>
						<div class="swiper-slide">
							<div class="slider-article">
								<?php get_template_part('template-parts/article-loop'); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<!-- Add Pagination -->
                <div class="swiper-pagination swiper-pagination-article"></div>
			</div>

			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endif; ?>
	</div>
</div>