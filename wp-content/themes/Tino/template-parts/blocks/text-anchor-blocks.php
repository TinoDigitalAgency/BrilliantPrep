<div class="section-inner" style="
        background-color: <?php the_sub_field('text_anchor_blocks_background_color'); ?>;
        <?php if(get_sub_field('text_anchor_blocks_title_pt')) { ?>
                padding-top: <?php the_sub_field('text_anchor_blocks_title_pt'); ?>;
        <?php } ?>
        <?php if(get_sub_field('text_anchor_blocks_title_pr')) { ?>
            padding-right: <?php the_sub_field('text_anchor_blocks_title_pr'); ?>;
        <?php } ?>
        <?php if(get_sub_field('text_anchor_blocks_title_pb')) { ?>
            padding-bottom: <?php the_sub_field('text_anchor_blocks_title_pb'); ?>;
        <?php } ?>
        <?php if(get_sub_field('text_anchor_blocks_title_pl')) { ?>
            padding-left: <?php the_sub_field('text_anchor_blocks_title_pl'); ?>;
        <?php } ?>

        ">
    <div class="container">
	    <?php if(get_sub_field('text_anchor_blocks_title')|| get_sub_field('text_anchor_blocks_subtitle')) { ?>
            <div class="title-block" style="color: <?php the_sub_field('text_anchor_blocks_title__subtitle_color'); ?>; max-width: <?php the_sub_field('text_anchor_blocks_title_columns_width'); ?>;">
			    <?php if(get_sub_field('text_anchor_blocks_title')) { ?>
                    <h2 class="h1 title"><?php the_sub_field('text_anchor_blocks_title'); ?></h2>
			    <?php } ?>
			    <?php if(get_sub_field('text_anchor_blocks_subtitle')) { ?>
                    <p class="subtitle"><?php the_sub_field('text_anchor_blocks_subtitle'); ?></p>
			    <?php } ?>
            </div>
	    <?php } ?>
	    <?php if( have_rows('text_anchor_content_blocks') ): ?>
            <?php $countMenuItem = 1; ?>
            <?php $countContentItem = 1; ?>
            <div class="row ancor-text-blocks-row">
                <div class="col-4 ancor-menu-col">
                    <div class="ancor-menu-scroll">
                        <div class="ancor-menu-wrapper">
                            <div class="ancor-menu-inner">
                                <div class="h4">Navigation</div>
                                <ul class="ancor-menu">
		                            <?php while ( have_rows('text_anchor_content_blocks') ) : the_row(); ?>
			                            <?php if(get_sub_field('text_anchor_menu_item_title')) { ?>
                                            <li>
                                                <a href="#content-block-<?php echo $countMenuItem; ?>" class="ancor-menu-link h5 ancor <?php if($countMenuItem == 1) { echo 'active'; } ?>">
                                                    <span class="count-block"><?php if($countMenuItem < 10) { echo '0'; } ?><?php echo $countMenuItem?>.</span>
						                            <?php the_sub_field('text_anchor_menu_item_title'); ?>
                                                </a>
                                            </li>
				                            <?php $countMenuItem++; ?>
			                            <?php } ?>
		                            <?php endwhile; ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-8 ancor-text-blocks-col">
                    <div class="ancor-text-blocks">
	                    <?php while ( have_rows('text_anchor_content_blocks') ) : the_row(); ?>
                            <div class="ancor-text-block" <?php if(get_sub_field('text_anchor_menu_item_title')) { ?>id="content-block-<?php echo $countContentItem; ?>" <?php } ?>>
                                <div class="ancor-text-block-inner">
                                    <?php if(get_sub_field('text_anchor_content_block_title')) { ?>
                                        <h3 class="ancor-text-block-title <?php the_sub_field('text_anchor_content_block_title_size'); ?>"><?php the_sub_field('text_anchor_content_block_title'); ?></h3>
                                    <?php } ?>
	                                <?php if(get_sub_field('text_anchor_content_block_text')) { ?>
                                        <div class="content ancor-text-block-content">
                                            <?php the_sub_field('text_anchor_content_block_text'); ?>
                                        </div>
	                                <?php } ?>
                                </div>
                            </div>
		                    <?php if(get_sub_field('text_anchor_menu_item_title')) { ?>
			                    <?php $countContentItem++; ?>
		                    <?php } ?>
	                    <?php endwhile; ?>

                    </div>
                </div>

            </div>
	    <?php endif; ?>
    </div>
</div>