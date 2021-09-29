<?php $imageBg = get_sub_field('cta_section_background_image'); ?>

<div class="section-inner" style="
	background-color: <?php the_sub_field('cta_section_background_color'); ?>;
	<?php if($imageBg) { ?>
		background-image: url(<?php echo $imageBg['url']; ?>);
	<?php } ?>
	background-position: <?php the_sub_field('cta_section_background_postion_x'); ?> <?php
    if(get_sub_field('cta_section_background_postion_y')=='top' &&  get_sub_field('cta_section_background_size') !='cover') {
        echo '40px';
    } else {
        the_sub_field('cta_section_background_postion_y');
    }
    ?>;
    background-repeat: no-repeat;

    <?php if(get_sub_field('cta_section_background_size_x') || get_sub_field('cta_section_background_size_y')) { ?>
        <?php if(get_sub_field('cta_section_background_size_x') &&  !get_sub_field('cta_section_background_size_y')) { ?>
            background-size: <?php the_sub_field('cta_section_background_size_x'); ?> auto;
        <?php } elseif (!get_sub_field('cta_section_background_size_x') && get_sub_field('cta_section_background_size_y')) {?>
                background-size: auto <?php the_sub_field('cta_section_background_size_y'); ?> ;
	    <?php } elseif (!get_sub_field('cta_section_background_size_x') && get_sub_field('cta_section_background_size_y')) {?>
                background-size: <?php the_sub_field('cta_section_background_size_x'); ?>  <?php the_sub_field('cta_section_background_size_y'); ?> ;
        <?php } ?>
    <?php } else { ?>
            background-size: <?php the_sub_field('cta_section_background_size'); ?>;
    <?php }  ?>
	">
	<div class="container">
		<div class="title-block" style="
			color: <?php the_sub_field('cta_section_title__subtitle_color'); ?>;
			max-width: <?php the_sub_field('cta_section_title_columns_width'); ?>;
			text-align: <?php the_sub_field('cta_section_title__subtitle_align'); ?>">
			<?php if(get_sub_field('cta_section_title')) { ?>
				<h2 class="<?php the_sub_field('cta_section_font_size'); ?> title"><?php the_sub_field('cta_section_title'); ?></h2>
			<?php } ?>
			<?php if(get_sub_field('cta_section_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('cta_section_subtitle'); ?></p>
			<?php } ?>
		</div>
		<?php if(get_sub_field('cta_section_button_text') && get_sub_field('cta_section_button_link')) { ?>
			<div class="cta-block" style="text-align: <?php the_sub_field('cta_section_title__subtitle_align'); ?>">
			    <?php if(!get_sub_field('cta_is_custom_cta')){ ?>
                <a href="<?php the_sub_field('cta_section_button_link'); ?>" <?php if(!get_sub_field('cta_section_button_link') || get_sub_field('cta_section_button_link') == '#') { echo 'disabled'; } ?> class="btn btn-pink btn-medium"><?php the_sub_field('cta_section_button_text'); ?></a>
                <?php } else {  
                the_sub_field('cta_custom_cta');  
                } ?>
			</div>
		<?php } ?>
	</div>
</div>