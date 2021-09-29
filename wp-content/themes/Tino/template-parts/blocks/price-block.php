<div class="section-inner" style="background-color: <?php the_sub_field('price_block_background_color'); ?>">
    <div class="container">
        <div class="title-block" style="color: <?php the_sub_field('price_block_title__subtitle_color'); ?>; max-width: <?php the_sub_field('price_block_title_columns_width'); ?>;">
            <?php if(get_sub_field('price_block_title')) { ?>
                <h2 class="h1 title"><?php the_sub_field('price_block_title'); ?></h2>
            <?php } ?>
	        <?php if(get_sub_field('price_block_subtitle')) { ?>
                <p class="subtitle"><?php the_sub_field('price_block_subtitle'); ?></p>
	        <?php } ?>
        </div>
	    <?php if( have_rows('prices_row') ): ?>
            <div class="row row-prices">
	            <?php while ( have_rows('prices_row') ) : the_row(); ?>
                    <div class="col-4 item-price">
                        <div class="price-block">
	                        <?php $priceImage = get_sub_field('prices_row_icon'); ?>
	                        <?php if($priceImage) { ?>
                                <div class="price-image">
                                    <img src="<?php echo $priceImage['url']; ?>" alt="">
                                </div>
                            <?php } ?>
                            <div class="price-content">
	                            <?php if(get_sub_field('prices_row_title')) { ?>
                                    <div class="h3 price-content-title"><?php the_sub_field('prices_row_title'); ?></div>
	                            <?php } ?>

                                <?php if(get_sub_field('prices_row_subtitle')) { ?>
                                    <div class="price-content-text content"><?php the_sub_field('prices_row_subtitle'); ?></div>
	                            <?php } ?>
                            </div>
                        </div>
                    </div>
	            <?php endwhile; ?>
            </div>
	    <?php endif; ?>

    </div>
</div>