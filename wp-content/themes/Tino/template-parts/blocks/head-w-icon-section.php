<?php $imageBg = get_sub_field('head_with_bg_image'); ?>

<div class="section-inner" style="
	background-color: <?php the_sub_field('head_with_icon_color_bg'); ?>;
	<?php if($imageBg) { ?>
		background-image: url(<?php echo $imageBg['url']; ?>);
	<?php } ?>
	background-position: <?php the_sub_field('head_with_icon_background_postion_x'); ?> <?php


        if(get_sub_field('head_with_icon_background_postion_y')=='top' &&  get_sub_field('head_with_icon_background_size') !='cover') {
            echo '40px';
        } else {
	        the_sub_field('head_with_icon_background_postion_y');
        }
        ?>;
    background-repeat: no-repeat;

    <?php if(get_sub_field('head_with_icon_background_size_x') || get_sub_field('head_with_icon_background_size_y')) { ?>
        <?php if(get_sub_field('head_with_icon_background_size_x') &&  !get_sub_field('head_with_icon_background_size_y')) { ?>
            background-size: <?php the_sub_field('head_with_icon_background_size_x'); ?> auto;
        <?php } elseif (!get_sub_field('head_with_icon_background_size_x') && get_sub_field('head_with_icon_background_size_y')) { ?>
                background-size: auto <?php the_sub_field('head_with_icon_background_size_y'); ?>;
	    <?php } elseif (get_sub_field('head_with_icon_background_size_x') && get_sub_field('head_with_icon_background_size_y')) { ?>
                background-size: <?php the_sub_field('head_with_icon_background_size_x'); ?>  <?php the_sub_field('head_with_icon_background_size_y'); ?> ;
        <?php } ?>
    <?php } else { ?>
            background-size: <?php the_sub_field('head_with_icon_background_size'); ?>;
    <?php }  ?>
	">
	<div class="container">
		<div class="title-block" style="
			color: <?php the_sub_field('head_with_icon_title__subtitle_color'); ?>;
			max-width: <?php the_sub_field('head_with_icon_title_columns_width'); ?>;
			text-align: <?php the_sub_field('head_with_icon_title__subtitle_align'); ?>">
            <?php $iconField = get_sub_field('head_with_icon_image'); ?>
			<?php if($iconField) { ?>
				<div class="title-icon">
                    <img src="<?php echo $iconField['url']; ?>" alt="">
                </div>
			<?php } ?>
            <?php if(get_sub_field('head_with_icon_title')) { ?>
				<<?php the_sub_field('head_with_icon_title_size'); ?> class=" <?php the_sub_field('head_with_icon_title_size'); ?> title"><?php the_sub_field('head_with_icon_title'); ?></<?php the_sub_field('head_with_icon_title_size'); ?>>
			<?php } ?>
			<?php if(get_sub_field('head_with_icon_subtitle')) { ?>
				<p class="subtitle"><?php the_sub_field('head_with_icon_subtitle'); ?></p>
			<?php } ?>
		</div>
	</div>
</div>