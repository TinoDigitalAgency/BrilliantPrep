<div class="section-inner">
	<div class="container">
		<?php if(get_sub_field('achievers_section_title') || get_sub_field('achievers_section_subtitle')) { ?>
			<div class="title-block" style="text-align: center">
				<?php if(get_sub_field('achievers_section_title')) { ?>
					<h2 class="h1 title"><?php the_sub_field('achievers_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('achievers_section_subtitle')) { ?>
					<div class="subtitle"><?php the_sub_field('achievers_section_subtitle'); ?></div>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if( have_rows('achievers_rows') ): ?>
			<div class="row row-archivers">
				<?php while( have_rows('achievers_rows') ) : the_row(); ?>
				<?php $imageAva = get_sub_field('achievers_avatar'); ?>
					<div class="col-6 arciver-col">
						<div class="archive-item">
							<div class="archive-avatar">
								<div class="avatar">
                                    <div class="round-image">
	                                    <img src="<?php echo $imageAva['sizes']['medium']; ?>" alt="">
                                    </div>
								</div>
							</div>
							<div class="archive-info">
								<div class="name h4"><?php the_sub_field('achievers_name'); ?></div>
								<?php if(get_sub_field('achievers_school')) { ?>
									<div class="school">
										<?php the_sub_field('achievers_school'); ?>
									</div>
								<?php } ?>
								<div class="arch-stat">
									<?php if(get_sub_field('achievers_sat')) { ?>
										<div class="arch-stat-item">
											<span><?php the_sub_field('achievers_sat'); ?></span>
											<span class="lbl">SAT</span>
										</div>
									<?php } ?>
									<?php if(get_sub_field('achievers_act')) { ?>
										<div class="arch-stat-item">
											<span><?php the_sub_field('achievers_act'); ?></span>
											<span class="lbl">ACT</span>
										</div>
									<?php } ?>
									<?php if(get_sub_field('achievers_psat')) { ?>
										<div class="arch-stat-item">
											<span><?php the_sub_field('achievers_psat'); ?></span>
											<span class="lbl">PSAT</span>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</div>