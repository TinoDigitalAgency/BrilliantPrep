<div class="section-inner">
	<div class="container">
		<?php if(get_sub_field('program_details_section_title') || get_sub_field('program_details_section_subtitle')) { ?>
			<div class="title-block" style="text-align: <?php the_sub_field('program_details_section_title__subtitle_align'); ?>; max-width: <?php the_sub_field('program_details_section_title_columns_width'); ?>;">
				<?php if(get_sub_field('program_details_section_title')) { ?>
					<h2 class="h3 title"><?php the_sub_field('program_details_section_title'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('program_details_section_subtitle')) { ?>
					<p class="subtitle"><?php the_sub_field('program_details_section_subtitle'); ?></p>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php
	$flagMenu = get_sub_field('hide_sidebar_menu');
	$flagStat = get_sub_field('show_sidebar_statistics');
	$flagAutoCount = get_sub_field('auto_count_steps');
	?>

		<div class="program-details-wrapper">
			<div class="program-details-inner">
                <div class="container">
	                <div class="row">
		                <?php if(!$flagMenu || $flagStat) { ?>
			                <div class="col-4 program-details-navigation-wrapper">
				                <?php if(!$flagMenu) { ?>
					                <div class="program-details-navigation">
						                <?php $countNavItem = 1; ?>
						                <?php while ( have_rows('program_details') ) : the_row(); ?>
							                <?php if( have_rows('program_details_content') ): ?>
								                <?php while ( have_rows('program_details_content') ) : the_row(); ?>
									                <?php if( get_row_layout() == 'block_with_icon_and_text' ): ?>
										                <div class="program-details-navigation-item">
											                <a href="#program-item-<?php echo $countNavItem; ?>" class="ancor program-details-navigation-link <?php if($flagAutoCount) { echo 'auto-count-link'; } ?> <?php if ($countNavItem == 1) { echo 'active'; } ?>">
												                <?php if($flagAutoCount) { ?>
													                <span class="count-step"><?php if($countNavItem < 10) { echo '0'; } echo $countNavItem; ?>.</span>
												                <?php } ?>
												                <?php the_sub_field('program_details_title'); ?>
											                </a>
										                </div>
									                <?php endif; ?>
								                <?php endwhile; ?>
							                <?php endif; ?>
							                <?php $countNavItem++; ?>
						                <?php endwhile; ?>
					                </div>
				                <?php } ?>
				                <?php if($flagStat) {  ?>
					                <?php if( have_rows('sidebar_statistics') ): ?>
					                    <div class="sidebar-statistic">
						                    <div class="sidebar-statistic-inner">
							                    <?php while ( have_rows('sidebar_statistics') ) : the_row(); ?>
							                        <div class="sidebar-statistic-item">
								                        <?php $iconStat = get_sub_field('sidebar_statistics_icon'); ?>
								                        <?php if($iconStat) { ?>
									                        <div class="sidebar-statistic-icon">
										                        <img src="<?php echo $iconStat['url']; ?>" alt="">
									                        </div>
								                        <?php } ?>
								                        <?php if(get_sub_field('sidebar_statistics_title')) { ?>
									                        <div class="sidebar-statistic-title">
										                        <?php the_sub_field('sidebar_statistics_title'); ?>
									                        </div>
								                        <?php } ?>
								                        <?php if(get_sub_field('subsidebar_statistics_title')) { ?>
									                        <div class="sidebar-statistic-subtitle">
										                        <?php the_sub_field('subsidebar_statistics_title'); ?>
									                        </div>
								                        <?php } ?>
							                        </div>
							                    <?php endwhile; ?>
						                    </div>
					                    </div>

					                <?php endif; ?>
				                <?php } ?>
			                </div>
		                <?php } ?>
		                <div class="col-8 program-details-content">
			                <?php if( have_rows('program_details') ): ?>
			                <?php $countItem = 1; ?>
			                <?php while ( have_rows('program_details') ) : the_row(); ?>
								<div class="program-item" id="program-item-<?php echo $countItem; ?>">
									<?php if( have_rows('program_details_content') ): ?>
										<?php while ( have_rows('program_details_content') ) : the_row(); ?>
											<?php if( get_row_layout() == 'block_with_icon_and_text' ): ?>
												<?php $imageDetail = get_sub_field('program_details_icon'); //var_dump($imageDetail); ?>
												<div class="detail-text-block">
													<?php if($imageDetail) { ?>
														<div class="image-detail">
															<img src="<?php echo $imageDetail; ?>" alt="">
														</div>
													<?php } ?>
													<?php if(get_sub_field('program_details_title')) { ?>
														<div class="title-detail h3">
															<?php if($flagAutoCount) { ?>
																<span class="count-step"><?php if($countItem < 10) { echo '0'; } echo $countItem; ?>.</span>
															<?php } ?>
															<?php the_sub_field('program_details_title'); ?>
														</div>
													<?php } ?>
													<?php if(get_sub_field('program_details_text')) { ?>
														<div class="description-detail"><?php the_sub_field('program_details_text'); ?></div>
													<?php } ?>
												</div>
											<?php elseif( get_row_layout() == 'block_text' ): ?>
												<div class="block-text">
													<?php the_sub_field('program_details_block_text'); ?>
												</div>
											<?php elseif( get_row_layout() == 'sessions_shedule' ): ?>
												<?php
												$colorBgRound = get_sub_field('step_marker_color');
												$colorBgRoundSecond = get_sub_field('step_marker_color_second');
												$colorTextRound = get_sub_field('step_marker_text_color');
												$colorTextRoundSecond = get_sub_field('step_marker_text_color_second');
												$colorBgRoundTwo = get_sub_field('step_marker_color_two');
												$colorBgRoundTwoSecond = get_sub_field('step_marker_color_two_second');
												$colorTextRoundTwo = get_sub_field('step_marker_text_color_two');
												$colorTextRoundTwoSecond = get_sub_field('step_marker_text_color_two_second');
												$twoColFlag = get_sub_field('show_2_column_steps');
												$stepTitle = get_sub_field('steps_list_title_');
												$stepTitleTwo = get_sub_field('steps_list_title_two');
												$flagTwoColor = get_sub_field('step_use_2_colors_for_markers');
												$flagTwoColorTwo = get_sub_field('step_use_2_colors_for_markers_two');
												?>
												<div class="detail-steps-block ">
													<div class="detail-steps-block-inner <?php if($twoColFlag) { echo 'two-col-steps'; } ?>">
														<?php if( have_rows('program_details_steps') ): ?>
															<div class="steps-list">
																<?php if($stepTitle) { ?>
																	<div class="steps-list-title h4" style="color: <?php echo $colorBgRound; ?>"><?php echo $stepTitle; ?></div>
																<?php } ?>
																<?php $stepCoutList = 1; ?>
																<?php while ( have_rows('program_details_steps') ) : the_row(); ?>
																	<div class="step-item <?php if($stepCoutList == 1) { echo 'first-item'; } ?>">
																		<div class="dash-line" style="border-color: <?php echo $colorBgRound; ?>"></div>
																		<div class="step-item-inner">
																			<?php if(get_sub_field('program_details_round_text')) { ?>
																				<?php if($flagTwoColor) { ?>
																					<div class="round-marker" style="
																						background-color: <?php echo ($stepCoutList % 2) ? $colorBgRound : $colorBgRoundSecond; ?>;
																						color: <?php echo ($stepCoutList % 2) ? $colorTextRound : $colorTextRoundSecond; ?>;">
																						<?php the_sub_field('program_details_round_text'); ?>
																					</div>
																				<?php } else { ?>
																					<div class="round-marker" style="
																						background-color: <?php echo $colorBgRound; ?>;
																						color: <?php echo $colorTextRound; ?>;">
																						<?php the_sub_field('program_details_round_text'); ?>
																					</div>
																				<?php } ?>
																			<?php } ?>
																			<?php if(get_sub_field('program_detailsround_step_title')) { ?>
																				<div class="step-title h4"><?php  the_sub_field('program_detailsround_step_title'); ?></div>
																			<?php } ?>
																			<?php if(get_sub_field('program_detailsround_step_text')) { ?>
																				<div class="step-text"><?php  the_sub_field('program_detailsround_step_text'); ?></div>
																			<?php } ?>
                                                                        </div>
																	</div>
																	<?php $stepCoutList++; ?>
																<?php endwhile; ?>
															</div>
														<?php endif; ?>
														<?php if( have_rows('program_details_steps_two') ): ?>
															<div class="steps-list">
																<?php if($stepTitleTwo) { ?>
																	<div class="steps-list-title h5" style="color: <?php echo $colorBgRoundTwo; ?>"><?php echo $stepTitleTwo; ?></div>
																<?php } ?>
																<?php $stepCoutListTwo = 1; ?>
																<?php while ( have_rows('program_details_steps_two') ) : the_row(); ?>
																	<div class="step-item <?php if($stepCoutListTwo == 1) { echo 'first-item'; } ?>">
																		<div class="dash-line" style="border-color: <?php echo $colorBgRoundTwo; ?>"></div>
																		<div class="step-item-inner">
																			<?php if(get_sub_field('program_details_round_text_two')) { ?>
																				<?php if($flagTwoColorTwo) { ?>
																					<div class="round-marker" style="
																						background-color: <?php echo ($stepCoutListTwo % 2) ? $colorBgRoundTwo : $colorBgRoundTwoSecond; ?>;
																						color: <?php echo ($stepCoutListTwo % 2) ? $colorTextRoundTwo : $colorTextRoundTwoSecond; ?>;">
																						<?php the_sub_field('program_details_round_text_two'); ?>
																					</div>
																				<?php } else { ?>
																					<div class="round-marker" style="
																						background-color: <?php echo $colorBgRoundTwo; ?>;
																						color: <?php echo $colorTextRoundTwo; ?>;">
																						<?php the_sub_field('program_details_round_text_two'); ?>
																					</div>
																				<?php } ?>
																			<?php } ?>
																			<?php if(get_sub_field('program_detailsround_step_title_two')) { ?>
																				<div class="step-title h4"><?php  the_sub_field('program_detailsround_step_title_two'); ?></div>
																			<?php } ?>
																			<?php if(get_sub_field('program_detailsround_step_text_two')) { ?>
																				<div class="step-text"><?php  the_sub_field('program_detailsround_step_text_two'); ?></div>
																			<?php } ?>
																		</div>
																	</div>
																	<?php $stepCoutListTwo++; ?>
																<?php endwhile; ?>
															</div>
														<?php endif; ?>
													</div>
												</div>
											<?php elseif( get_row_layout() == 'head_with_separate' ): ?>
												<div class="title-separate-wrapper">
													<div class="title-separate-inner">
														<?php if(get_sub_field('head_with_separate_title')) { ?>
															<div class="title-separate"><?php the_sub_field('head_with_separate_title'); ?></div>
														<?php } ?>
														<?php if(get_sub_field('head_with_separate_subtitle')) { ?>
															<div class="subtitle-separate"><?php the_sub_field('head_with_separate_subtitle'); ?></div>
														<?php } ?>
													</div>
												</div>
											<?php endif; ?>
										<?php endwhile; ?>
									<?php endif; ?>
								</div>
				                <?php $countItem++; ?>
			                <?php endwhile; ?>
		                </div>
	                <?php endif; ?>
	                </div>
                </div>
            </div>
		</div>

</div>