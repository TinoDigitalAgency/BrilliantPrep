<div class="section-inner" style="background-color: <?php the_sub_field('benefits_section_background_color'); ?>">
    <div class="container">
        <?php if(get_sub_field('benefits_section_title') || get_sub_field('benefits_section_subtitle')) { ?>
            <div class="title-block <?php if(get_sub_field('benefits_section_title_add_bg')) {echo 'title-block-bg'; } ?>" style="color: <?php the_sub_field('benefits_section_title__subtitle_color'); ?>; max-width: <?php the_sub_field('benefits_section_title_columns_width'); ?>; text-align: <?php the_sub_field('benefits_section_title__subtitle_align'); ?>">
                <?php if(get_sub_field('benefits_section_title')) { ?>
                    <h2 class="<?php the_sub_field('benefits_section_title_font_size'); ?> title"><?php the_sub_field('benefits_section_title'); ?></h2>
                <?php } ?>
                <?php if(get_sub_field('benefits_section_subtitle')) { ?>
                    <div class="subtitle"><?php the_sub_field('benefits_section_subtitle'); ?></div>
                <?php } ?>
            </div>
        <?php } ?>
	    <?php $colVal = get_sub_field('benefits_section_column_per_row');
//	    var_dump($colVal);
	    if($colVal == "1") {
		    $col = "12";
	    } elseif ($colVal == "2") {
		    $col = "6";
	    } elseif ($colVal == "3") {
		    $col = "4";
	    } elseif ($colVal == "4") {
		    $col = 3;
	    } elseif ($colVal == "5") {
		    $col = '20_percent';
	    } elseif ($colVal == "6") {
		    $col = 2;
	    } elseif ($colVal == "7") {
		    $col = '';
	    }
	    ?>
        <?php $titleBen = get_sub_field('benefits_title'); ?>
        <?php
            $titleBenSecond = get_sub_field('benefits_title_second');
            $classNoclass ='';
        ?>
        <?php $countItm = count(get_sub_field('benefits_rows')); //var_dump($countItm);
            if(($countItm == 2 && $col == "6") || ($countItm == 3 && $col == "4")) {
                $classNoclass = 'noMarginBottom';
                //var_dump($classNoclass);
            }
        ?>
        <style>
            @media (min-width: 767px) {
                .row-benefits .item-benefit.col-6 {
                    margin-bottom: 0;
                }
            }
            @media (min-width: 990px) {
                .row-benefits .item-benefit.col-4 {
                    margin-bottom: 0;
                }
            }
        </style>
	    <?php if( have_rows('benefits_rows') ): ?>
            <div class="row row-benefits">
                <?php if($titleBen) { ?>
                    <div class="col-12 row-benefits-title">
                        <div class="h3"><?php echo $titleBen; ?></div>
                    </div>
                <?php } ?>

	            <?php while ( have_rows('benefits_rows') ) : the_row(); ?>
		            <?php $ListColortext = get_sub_field('styled_list_dots_color'); //var_dump($ListColortext); ?>
		            <?php $flafStyledList = get_sub_field('styled_list_dots_color',get_the_ID()); ?>
                    <div class="col-<?php echo $col; ?> item-benefit <?php echo $classNoclass; ?>">
	                    <?php if( get_sub_field('benefit_image') || get_sub_field('benefit_title') || get_sub_field('benefits_text') ) { ?>
                            <div class="benefit-block" style="background-color: <?php the_sub_field('benefits_blocks_background'); ?>; padding-left: <?php the_sub_field('benefits_padding_left'); ?>; padding-top: <?php the_sub_field('benefits_padding_top'); ?>; padding-right: <?php the_sub_field('benefits_padding_right'); ?>; padding-bottom: <?php the_sub_field('benefits_padding_bottom'); ?>; ">
			                    <?php $benefitImage = get_sub_field('benefit_image'); ?>
			                    <?php if($benefitImage) { ?>
                                    <div class="benefit-image">
                                        <img style="width: <?php the_sub_field('benefit_image_width'); ?>; height:<?php the_sub_field('benefit_image_height'); ?>;" src="<?php echo $benefitImage['url']; ?>" alt="<?php the_sub_field('benefit_title'); ?>">
                                    </div>
			                    <?php } ?>
			                    <?php if(get_sub_field('benefit_title')) { ?>
                                    <div class="<?php the_sub_field('benefits_title_font_size'); ?>" style="color: <?php the_sub_field('benefits_text_color');?>"><?php the_sub_field('benefit_title'); ?></div>
			                    <?php } ?>

			                    <?php if(get_sub_field('benefits_text')) { ?>
                                    <div class="benefit-desc" style="color: <?php the_sub_field('benefits_text_color'); ?>;font-size:  <?php the_sub_field('benefits_subtitle_fontsize'); ?>;"><?php the_sub_field('benefits_text'); ?></div>
			                    <?php } ?>
                            </div>
                        <?php } ?>
                        <?php $flafTwoCol = get_sub_field('benefits_section_list_in_2_columns'); ?>
	                    <?php if( have_rows('styled_list') && $flafStyledList ): ?>
                            <ul class="styled-list <?php if($flafTwoCol) { echo 'styled-list__two-col'; } ?>">
			                    <?php while ( have_rows('styled_list') ) : the_row(); ?>
                                <?php  ?>
                                    <li class="styled-item">
                                        <div class="dot" style="background-color: <?php echo $ListColortext; ?>"></div>
                                        <div class="styled-item-content">
                                            <span class="default-text">
                                                <?php if(get_sub_field('styled_list_item_link')) { ?>
                                                    <a class="styled-item-link" href="<?php the_sub_field('styled_list_item_link'); ?>">
                                                <?php } ?>

                                                    <?php the_sub_field('styled_list_item'); ?>

	                                            <?php if(get_sub_field('styled_list_item_link')) { ?>
                                                    </a>
	                                            <?php } ?>
                                            </span>
                                            <span class="colored-text" style="color:<?php echo $ListColortext; ?>">&nbsp; &nbsp;<?php the_sub_field('styled_list_item_color_text'); ?></span>
                                        </div>
                                    </li>
			                    <?php endwhile; ?>
                            </ul>
	                    <?php endif; ?>
                    </div>
	            <?php endwhile; ?>
            </div>
	    <?php endif; ?>
	    <?php if( have_rows('benefits_rows_second') ): ?>
            <div class="row row-benefits">
			    <?php if($titleBenSecond) { ?>
                    <div class="col-12 row-benefits-title">
                        <div class="h3"><?php echo $titleBenSecond; ?></div>
                    </div>
			    <?php } ?>
			    <?php while ( have_rows('benefits_rows_second') ) : the_row(); ?>
				    <?php $ListColortext = get_sub_field('styled_list_dots_color_second'); //var_dump($ListColortext); ?>

                    <div class="col-<?php echo $col; ?> item-benefit">
					    <?php if( get_sub_field('benefit_image_second') || get_sub_field('benefit_title_second') || get_sub_field('benefits_text_second') ) { ?>
                            <div class="benefit-block" style="
                                    background-color: <?php the_sub_field('benefits_blocks_background_second'); ?>;
                                    padding-left: <?php the_sub_field('benefits_padding_left_second'); ?>;
                                    padding-top: <?php the_sub_field('benefits_padding_top_second'); ?>;
                                    padding-right: <?php the_sub_field('benefits_padding_right_second'); ?>;
                                    padding-bottom: <?php the_sub_field('benefits_padding_bottom_second'); ?>; ">
							    <?php $benefitImage = get_sub_field('benefit_image_second'); ?>
							    <?php if($benefitImage) { ?>
                                    <div class="benefit-image">
                                        <img style="width: <?php the_sub_field('benefit_image_width_second'); ?>; height:<?php the_sub_field('benefit_image_height_second'); ?>;" src="<?php echo $benefitImage['url']; ?>" alt="<?php the_sub_field('benefit_title_second'); ?>">
                                    </div>
							    <?php } ?>
							    <?php if(get_sub_field('benefit_title_second')) { ?>
                                    <div class="<?php the_sub_field('benefits_title_font_size_second'); ?>" style="color: <?php the_sub_field('benefits_text_color_second');?>"><?php the_sub_field('benefit_title_second'); ?></div>
							    <?php } ?>

							    <?php if(get_sub_field('benefits_text_second')) { ?>
                                    <div class="benefit-desc" style="color: <?php the_sub_field('benefits_text_color_second'); ?>;font-size:  <?php the_sub_field('benefits_subtitle_fontsize_second'); ?>;"><?php the_sub_field('benefits_text_second'); ?></div>
							    <?php } ?>
                            </div>
					    <?php } ?>
					    <?php $flafTwoCol = get_sub_field('benefits_section_list_in_2_columns_second'); ?>
					    <?php $flafStyledListSecond = get_sub_field('show_styled_list_second',get_the_ID()); ?>
					    <?php if( have_rows('styled_list_second') && $flafStyledListSecond ): ?>
                            <ul class="styled-list <?php if($flafTwoCol) { echo 'styled-list__two-col_second'; } ?>">
							    <?php while ( have_rows('styled_list_second') ) : the_row(); ?>
								    <?php  ?>
                                    <li class="styled-item">
                                        <div class="dot" style="background-color: <?php echo $ListColortext; ?>"></div>
                                        <div class="styled-item-content">
                                            <span class="default-text">
                                                <?php if(get_sub_field('styled_list_item_link_second')) { ?>
                                                    <a class="styled-item-link" href="<?php the_sub_field('styled_list_item_link_second'); ?>">
                                                <?php } ?>

                                                <?php the_sub_field('styled_list_item_second'); ?>

                                                <?php if(get_sub_field('styled_list_item_link_second')) { ?>
                                                    </a>
	                                            <?php } ?>
                                            </span>
                                            <span class="colored-text" style="color:<?php echo $ListColortext; ?>">&nbsp; &nbsp;<?php the_sub_field('styled_list_item_color_text_second'); ?></span>
                                        </div>
                                    </li>
							    <?php endwhile; ?>
                            </ul>
					    <?php endif; ?>
                    </div>
			    <?php endwhile; ?>
            </div>
	    <?php endif; ?>
	    <?php if(get_sub_field('content_after_benefits')) { ?>
            <div class="content-after-benefits">
                <div class="content">
	                <?php the_sub_field('content_after_benefits'); ?>
                </div>
            </div>
	    <?php } ?>
    </div>
</div>