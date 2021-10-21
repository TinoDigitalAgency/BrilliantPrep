<div class="section-inner" style="background-color: <?php the_sub_field('faq_section_background_color'); ?>">
	<div class="container">
		<?php if(get_sub_field('faq_section_title') || get_sub_field('faq_section_subtitle')) { ?>
			<div class="title-block" style="color: <?php the_sub_field('faq_section_title__subtitle_color'); ?>; text-align: <?php the_sub_field('faq_section_title__subtitle_align'); ?>; max-width: <?php the_sub_field('faq_section_title_columns_width'); ?>;">
				<?php if(get_sub_field('faq_section_title')) { ?>
					<h2 class="h3 title"><?php the_sub_field('faq_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('faq_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('faq_section_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if( have_rows('faq_blocks_row') ): ?>
			<div class="faq-wrapper">
				<div class="faq-inner">
					<?php while ( have_rows('faq_blocks_row') ) : the_row(); ?>
						<div class="parent-faq-item">
							<div class="parent-faq">
                                <?php if(get_sub_field('faq_block_title')) { ?>
	                                <div class="parent-faq-head">
		                                <button class="tiger-parent-faq"><?php the_sub_field('faq_block_title'); ?> <span class="faq-marker"></span></button>
	                                </div>
                                <?php } ?>
								<?php $hasTitle = get_sub_field('faq_block_title'); ?>
								<?php if( have_rows('faq_block') ): ?>
									<div class="parent-faq-content <?php if(!$hasTitle) { echo 'show-default'; } ?>">
										<?php while ( have_rows('faq_block') ) : the_row(); ?>
											<div class="child-faq-item">
												<div class="child-faq">
													<div class="child-faq-head">
														<button class="tiger-child-faq"><?php the_sub_field('faq_item_title'); ?> <span class="faq-marker"></span></button>
													</div>
													<div class="child-faq-content">
														<div class="child-faq-content-inner content">
															<?php  the_sub_field('faq_item_text'); ?>
														</div>
													</div>
												</div>
											</div>
										<?php endwhile; ?>
									</div>
								<?php endif; ?>

							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>