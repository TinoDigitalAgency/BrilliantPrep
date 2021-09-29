<div class='col-4 article-block '>
	<div class="article-element">
		<div class="article-image">
			<?php $categories = get_the_category();
			$cat_ID = $categories[0]->term_id;
			$cat_name = $categories[0]->name;
			$colorLabel = get_field('label_color_category','term_'.$cat_ID);
			$cat_Link = get_category_link( $cat_ID );
			?>
			<a href="<?php echo $cat_Link; ?>" class="category-label <?php echo 'category-label-'.$categories[0]->slug; ?>" style="background-color: <?php echo $colorLabel; ?>">
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