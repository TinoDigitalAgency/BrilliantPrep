<div class="section-inner" style="background-color: <?php the_sub_field('library_section_background_color'); ?>">
	<div class="container">
		<div class="title-block" style="
			color: <?php the_sub_field('library_section_title__subtitle_color'); ?>;
			max-width: <?php the_sub_field('library_section_title_columns_width'); ?>;
			text-align: <?php the_sub_field('library_section_title__subtitle_align'); ?>">
			<?php if(get_sub_field('library_section_title')) { ?>
				<h2 class="h1 title"><?php the_sub_field('library_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('library_section_subtitle')) { ?>
				<div class="subtitle"><?php the_sub_field('library_section_subtitle'); ?></div>
			<?php } ?>
		</div>
		<?php if( have_rows('libraries_blocks') ): ?>
			<?php $countLib = 1; ?>
			<div class="row libraries-row">
				<?php while ( have_rows('libraries_blocks') ) : the_row(); ?>
					<?php $imageLib = get_sub_field('libraries_block_image'); ?>
					<?php $imageBigLib = get_sub_field('libraries_block_image_big'); ?>
					<?php $linkDetail = get_sub_field('libraries_block_detail_link'); ?>
					<div class="col-4 library-block">
						<div class="library-item">
							<?php if ($imageLib) { ?>
								<div class="library-image">
									<img src="<?php echo $imageLib['url']; ?>" alt="">
								</div>
							<?php } ?>
							<div class="h5 library-title"><?php echo wp_trim_words( get_sub_field('libraries_block_title'), 8, '...' ); ?></div>
							<div class="library-meta">
								<div class="library-detail">
									<a class="detail-link" href="<?php if($linkDetail) { echo $linkDetail; } else { echo '#library-'.$countLib; } ?>" <?php if(!$linkDetail) { echo 'data-fancybox'; } ?>><?php the_sub_field('libraries_block_detail_link_text'); ?></a>
								</div>
								<?php if (get_sub_field('libraries_block_buy_link')) { ?>
									<div class="library-shop">
										<a href="<?php the_sub_field('libraries_block_buy_link'); ?>" target="_blank" class="link-arrow-right"><?php the_sub_field('libraries_block_buy_text'); ?> <span class="icon-arrow-right"></span></a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="modal-library" id="library-<?php echo $countLib; ?>" style="display: none">
						<div class="modal-library-inner">
							<div class="modal-library-content row">
								<div class="modal-title h3 col-12"><?php the_sub_field('libraries_block_title'); ?></div>
								<?php if($imageBigLib || $imageLib) { ?>
									<?php if($imageBigLib) {
										$imageUrl = $imageBigLib['url'];
									} elseif($imageLib) {
										$imageUrl = $imageLib['url'];
									} ?>
									<div class="modal-library__detail-image col <?php if(get_sub_field('libraries_block_buy_link')) {echo 'shadow-img'; }?>">
										<img src="<?php echo $imageUrl; ?>" alt="">
										<?php if(get_sub_field('libraries_block_buy_link')) { ?>
											<div class="shop-btn">
												<a target="_blank" href="<?php the_sub_field('libraries_block_buy_link'); ?>" class="btn btn-pink">Buy on Amazon</a>
											</div>
										<?php } ?>
									</div>
								<?php } ?>
								<div class="modal-library__detail col">
									<div class="content">
										<?php the_sub_field('libraries_block_content'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $countLib++; ?>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</div>