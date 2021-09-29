<div class="section-inner" style="background-color: <?php the_sub_field('faq_filter_section_background_color'); ?>">
	<div class="container">
		<?php if(get_sub_field('faq_filter_section_title') || get_sub_field('faq_filter_section_subtitle')) { ?>
			<div class="title-block" style="color: <?php the_sub_field('faq_filter_section_title__subtitle_color'); ?>; text-align: <?php the_sub_field('faq_filter_section_title__subtitle_align'); ?>; max-width: <?php the_sub_field('faq_filter_section_title_columns_width'); ?>;">
				<?php if(get_sub_field('faq_filter_section_title')) { ?>
					<h2 class="h3 title"><?php the_sub_field('faq_filter_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('faq_filter_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('faq_filter_section_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
        <div class="row faq-filter-row">
	        <?php $titleFilter = get_sub_field('faq_filter_section_filter_name'); ?>
	        <?php if( have_rows('pages_for_faq_filter') ): ?>
		        <?php
			        $countFilter = 1;
		        ?>
	            <div class="col-4 filter-faq-col">
		            <div class="filter-faq filter-faq-btn" id="filters">
			            <?php if($titleFilter) { ?>
				            <div class="h3 filter-title"><?php echo $titleFilter; ?></div>
			            <?php } ?>
			            <?php while ( have_rows('pages_for_faq_filter') ) : the_row(); ?>
			                <?php $postsRows = get_sub_field('page_for_faq_filter'); ?>
				            <button class="button <?php if($countFilter == 1) { echo 'is-checked'; } ?>" data-filter="
								<?php if($postsRows) { ?>
									<?php foreach( $postsRows as $p) { // variable must be called $post (IMPORTANT) ?>
						                <?php echo '.filterID-'.$p->ID; ?>
					                <?php } ?>
				                <?php } elseif(!get_sub_field('make_general_faq_filter')) { ?>
				                    <?php echo '.otherID'; ?>
				                <?php } ?>
				                <?php if(get_sub_field('make_general_faq_filter')) { ?>
				                    <?php echo '.generalID'; ?>
								<?php } ?>
								">
					            <?php if(get_sub_field('title_for_faq_filter')) { ?>
						            <?php the_sub_field('title_for_faq_filter'); ?>
					            <?php } elseif($postsRows) { ?>
						            <?php foreach( $postsRows as $p): // variable must be called $post (IMPORTANT) ?>
							            <?php echo get_the_title( $p->ID ); ?>
						            <?php endforeach; ?>
					            <?php } ?>
				            </button>
				            <?php $countFilter++; ?>
			            <?php endwhile; ?>
		            </div>
	            </div>

	        <?php endif; ?>
	        <?php if( have_rows('faq_filter_blocks') ): ?>
		        <div class="faq-filter-wrapper col-8">
			        <div class="faq-filter-inner grid">

				        <?php while ( have_rows('faq_filter_blocks') ) : the_row(); ?>
					        <?php $postsFilter = get_sub_field('select_the_pages_matching_the_answer'); ?>
					        <div class="child-faq-item element-item <?php if($postsFilter) { ?> <?php foreach( $postsFilter as $p): // variable must be called $post (IMPORTANT) ?> <?php echo 'filterID-'.$p->ID; ?> <?php endforeach; ?> <?php } elseif(!get_sub_field('faq_filter_make_general')) { echo 'otherID'; } if(get_sub_field('faq_filter_make_general') && !$postsFilter) { echo ' generalID'; }  ?>">
						        <div class="child-faq">
							        <div class="child-faq-head">
								        <button class="tiger-child-faq"><?php the_sub_field('faq_filter_item_title'); ?> <span class="faq-marker"></span></button>
							        </div>
							        <div class="child-faq-content">
								        <div class="child-faq-content-inner">
									        <?php  the_sub_field('faq_filter_item_text'); ?>
								        </div>
							        </div>
						        </div>
					        </div>
				        <?php endwhile; ?>

			        </div>
		        </div>
	        <?php endif; ?>
        </div>

	</div>
</div>