<?php

// Check value exists.
if( have_rows('blocks_content') ): ?>
	<div class="blocks-content">
		<?php while ( have_rows('blocks_content') ) : the_row(); ?>
            <?php if ( get_row_layout() == 'fullpage_slider_wrapper_start' ) { ?>
                <div id="fullpage" class="<?php the_sub_field('custom_class'); ?>">
            <?php } elseif( get_row_layout() == 'fullpage_slider_item_start' ) { ?>
                <div class="section <?php the_sub_field('custom_class'); ?>">
            <?php } elseif( get_row_layout() == 'hero_section' ) { ?>
				<section class="section-hero <?php if(get_sub_field('show_benefits')) { echo 'has-benefits'; } ?>">
					<?php get_template_part('template-parts/blocks/hero-section'); ?>
				</section>
			<?php } elseif( get_row_layout() == 'tile_courses' ) { ?>
                <section class="section-courses">
					<?php get_template_part('template-parts/blocks/tile-courses'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'benefits_section' ) { ?>
                <section class="section-benefits">
					<?php get_template_part('template-parts/blocks/benefits-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'chess_section' ) { ?>
                <section class="section-chess">
					<?php get_template_part('template-parts/blocks/chess-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'popular_articles' ) { ?>
                <section class="section-popular-post">
					<?php get_template_part('template-parts/blocks/popular-post'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'shortcode_tabs' ) { ?>
                <section class="section-shortcode-tab">
					<?php get_template_part('template-parts/blocks/shortcode-tabs'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'statistic_section' ) { ?>
                <section class="section-statistic">
					<?php get_template_part('template-parts/blocks/statistic-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'video_section' ) { ?>
                <section class="section-video">
					<?php get_template_part('template-parts/blocks/video-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'library_section' ) { ?>
                <section class="library-video">
					<?php get_template_part('template-parts/blocks/library-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'media_text_section' ) { ?>
                <section class="media-text-video">
					<?php get_template_part('template-parts/blocks/text-media-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'reviews_section' ) { ?>
                <section class="section-review">
					<?php get_template_part('template-parts/blocks/review-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'subscribe_section' ) { ?>
                <section class="section-subscribe">
					<?php get_template_part('template-parts/blocks/subscribe-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'shortcode_section' ) { ?>
                <section class="section-shortcode">
					<?php get_template_part('template-parts/blocks/shortcode-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'achievers_section' ) { ?>
                <section class="section-achievers">
					<?php get_template_part('template-parts/blocks/archivers-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'video_list_section' ) { ?>
                <section class="section-video-list">
					<?php get_template_part('template-parts/blocks/video-list'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'courses_carousel_section' ) { ?>
                <section class="section-course-carousel">
					<?php get_template_part('template-parts/blocks/course-carousel'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'video_carousel_section' ) { ?>
                <section class="section-course-carousel">
					<?php get_template_part('template-parts/blocks/video-carousel'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'popular_articles_carousel' ) { ?>
                <section class="section-course-carousel">
					<?php get_template_part('template-parts/blocks/article-carousel'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'image_section' ) { ?>
                <section class="section-image">
					<?php get_template_part('template-parts/blocks/image-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'logos_section' ) { ?>
                <section class="section-logo">
					<?php get_template_part('template-parts/blocks/logo-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'location_section' ) { ?>
                <section class="section-location">
					<?php get_template_part('template-parts/blocks/location-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'cta_section' ) { ?>
                <section class="section-cta">
					<?php get_template_part('template-parts/blocks/cta-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'section_with_numbers' ) { ?>
                <section class="section-numbers">
					<?php get_template_part('template-parts/blocks/section-numbers'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'statistics_section' ) { ?>
                <section class="section-statistics-chart">
					<?php get_template_part('template-parts/blocks/statistics-chart-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'image_block_with_text' ) { ?>
                <section class="section-text-image">
					<?php get_template_part('template-parts/blocks/text-image-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'round_icon_with_text' ) { ?>
                <section class="section-round-list">
					<?php get_template_part('template-parts/blocks/round-list-text'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'text_anchor_blocks' ) { ?>
                <section class="section-text-ancor">
					<?php get_template_part('template-parts/blocks/text-anchor-blocks'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'picture_text_checkerboard' ) { ?>
                <section class="section-picture-chess">
					<?php get_template_part('template-parts/blocks/picture-chess-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'content_section' ) { ?>
                <section class="section-content">
					<?php get_template_part('template-parts/blocks/content-block'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'price_block' ) { ?>
                <section class="section-price">
					<?php get_template_part('template-parts/blocks/price-block'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'charts_section' ) { ?>
                <section class="section-chart">
					<?php get_template_part('template-parts/blocks/charts-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'faq_section' ) { ?>
                <section class="section-faq">
					<?php get_template_part('template-parts/blocks/faq-section'); ?>
                </section>
			<?php } elseif( get_row_layout() == 'faq_filter_section' ) { ?>
                <section class="section-faq-filter">
					<?php get_template_part('template-parts/blocks/faq-filter-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'head_with_icon' ) { ?>
                <section class="section-head-with-icon">
					<?php get_template_part('template-parts/blocks/head-w-icon-section'); ?>
                </section>
            <?php } elseif( get_row_layout() == 'program_details_section' ) { ?>
                <section class="section-program-detail">
					<?php get_template_part('template-parts/blocks/program-details-section'); ?>
                </section>
			<?php } elseif( get_row_layout() == 'tab_wrapper_start' ) { ?>
                <div class="tab-wrapper-content">
                    <div class="tab-inner">
			<?php } elseif( get_row_layout() == 'tab_item_settings' ) { ?>
                <?php $ptTab = get_sub_field('tab_item_settings_padding_top'); ?>
                <?php $prTab = get_sub_field('tab_item_settings_padding_right'); ?>
                <?php $pbTab = get_sub_field('tab_item_settings_padding_bottom'); ?>
                <?php $plTab = get_sub_field('tab_item_settings_padding_left'); ?>
				<?php if( have_rows('tab_titles') ): ?>
                    <div class="tabs-head" style="
                        <?php if ($ptTab) { echo 'padding-top: '. $ptTab;} ?>
                        <?php if ($prTab) { echo 'padding-right: '. $prTab;} ?>
                        <?php if ($pbTab) { echo 'padding-bottom: '. $pbTab;} ?>
                        <?php if ($plTab) { echo 'padding-left: '. $plTab;} ?>
                        ">
                        <div class="container">
                            <div class="tabs-head-inner">
		                        <?php while ( have_rows('tab_titles') ) : the_row(); ?>
                                    <div class="tabs-head-item">
                                        <button class="tab-trigger <?php if(get_sub_field('active_by_default_title')) { echo 'active'; } ?>" data-tab ="#<?php the_sub_field('tab_id_link'); ?>"><span><?php the_sub_field('tab_name'); ?></span></button>
                                    </div>
		                        <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
			<?php } elseif( get_row_layout() == 'tab_item_start' ) { ?>
                <div class="tab-item-wrapper <?php if(get_sub_field('active_by_default_tab')) { echo 'show'; } ?>" id="<?php the_sub_field('tab_id'); ?>">
                    <div class="tab-item-inner">

			<?php } elseif( get_row_layout() == 'tab_item_end' ) { ?>
                    </div>
                </div>
            <?php } elseif( get_row_layout() == 'tab_wrapper_end' ) { ?>
                    </div>
                </div>
            <?php } elseif( get_row_layout() == 'fullpage_slider_item_end' ) { ?>
                </div>
            <?php } elseif( get_row_layout() == 'fullpage_slider_wrapper_end' ) { ?>
                    <div class="section section-footer fp-auto-height fp-auto-height-responsive">
                        <?php get_template_part('template-parts/footer-content'); ?>
                    </div>
                </div>
			<?php } ?>
		<?php endwhile; ?>
	</div>
<?php endif; ?>