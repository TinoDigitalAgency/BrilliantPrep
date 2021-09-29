<div class="section-inner" style="
        background-color: <?php the_sub_field('content_section_background_color'); ?>;
        <?php if(get_sub_field('content_section_title_pt')) { ?>
                padding-top: <?php the_sub_field('content_section_title_pt'); ?>;
        <?php } ?>
        <?php if(get_sub_field('content_section_title_pr')) { ?>
            padding-right: <?php the_sub_field('content_section_title_pr'); ?>;
        <?php } ?>
        <?php if(get_sub_field('content_section_title_pb')) { ?>
            padding-bottom: <?php the_sub_field('content_section_title_pb'); ?>;
        <?php } ?>
        <?php if(get_sub_field('content_section_title_pl')) { ?>
            padding-left: <?php the_sub_field('content_section_title_pl'); ?>;
        <?php } ?>

        ">
    <div class="container">
	    <?php if(get_sub_field('content_section_title')|| get_sub_field('content_section_subtitle')) { ?>
            <div class="title-block" style="color: <?php the_sub_field('content_section_title__subtitle_color'); ?>; max-width: <?php the_sub_field('content_section_title_columns_width'); ?>;">
			    <?php if(get_sub_field('content_section_title')) { ?>
                    <h2 class="h1 title"><?php the_sub_field('content_section_title'); ?></h2>
			    <?php } ?>
			    <?php if(get_sub_field('content_section_subtitle')) { ?>
                    <p class="subtitle"><?php the_sub_field('content_section_subtitle'); ?></p>
			    <?php } ?>
            </div>
	    <?php } ?>
        <div class="content">
            <?php the_sub_field('content_section_text_block'); ?>
        </div>
    </div>
</div>