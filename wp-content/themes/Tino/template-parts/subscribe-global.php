<section class="section-subscribe">
    <div class="section-inner" style="background-color: <?php the_field('background_color_subscribe_gl','options'); ?>">
        <div class="container">
            <div class="row justify-content-center align-item-center subscribe-row">
                <div class="col subscribe-title-col title-block" style="max-width: 45%;flex: 0 0 100%">
                    <?php if(get_field('subscribe_title_gl','options')) { ?>
                        <h2 class="h3 title" style="<?php the_field('text_color_subscribe_gl','options'); ?>"><?php the_field('subscribe_title_gl','options'); ?></h2>
                    <?php } ?>
                </div>
                <?php if(get_field('subscribe_shortcode_gl','options')) { ?>
                    <div class="col subscribe-block" style="max-width: 55%; flex: 0 0 100%">
                        <?php echo do_shortcode(get_field('subscribe_shortcode_gl','options')); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>