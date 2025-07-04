<?php global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$msg_author = get_user_meta( $current_user_id, 'freelancer_id' , true );
$project_id = $_GET['project-id'];
$alt_id = '';
$limit = get_option( 'posts_per_page' );
$start_from ='1';
if (isset($_GET["pageno"])) 
{  
  $pageno  = $_GET["pageno"];  
}  
else {  
  $pageno=1;  
}
$start_from = ($pageno-1) * $limit; 
	if( is_user_logged_in() )
	 {
		if(get_post_status ( $project_id ) == 'ongoing')
		{
			$results_count = get_project_bids_freelancer($project_id,$msg_author);
			if(isset($results_count))
			{
				$freelancer_id = $results_count[0]->freelancer_id;
				if($freelancer_id == $msg_author)
				{
					$total_count =0;
					if(isset($results_count))
					{
						$total_count = count($results_count);	
					}	 

					// The Query
					$post = get_post($project_id);
					$fl_id = get_post_meta( $post->ID, '_freelancer_assigned' , true );
					$employer_id = get_user_meta( $post->post_author, 'employer_id' , true );
					?>

					<div class="content-wrapper ">
					  <div class="notch"></div>
					  <div class="row">
						<div class="col-md-12 grid-margin">
						  <div class="d-flex justify-content-between flex-wrap">
							<div class="d-flex align-items-end flex-wrap">
							  <div class="mr-md-3 mr-xl-5">
								<h2><?php echo esc_html__('Project Details','khebrat_theme'); ?></h2>
								<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
									<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'khebrat_theme' ); ?>&nbsp;</p>
									<?php echo exertio_dashboard_extention_return(); ?>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					  <?php
					?>
					  <div class="row">
						<div class="col-md-12 grid-margin stretch-card">
						  <div class="card mb-4">
							<div class="card-body">
							  <div class="pro-section project-details">
								<div class="pro-box">
								  <div class="pro-coulmn pro-title">
									<h4 class="pro-name"> <a href="<?php  echo esc_url(get_permalink()); ?>"><?php echo	esc_html($post->post_title); ?></a> </h4>
									<span class="pro-meta-box"> <span class="pro-meta"> <i class="far fa-clock"></i>
									<?php 
										$posted_date = get_the_date(get_option( 'date_format' ), $post->ID );
										echo esc_html($posted_date); 
									?>
									</span> <span class="pro-meta">
									<?php
										$level = get_term( get_post_meta($post->ID, '_project_level', true));
										if(!empty($level) && ! is_wp_error($level))
										{
											?>
											<i class="fas fa-layer-group"></i> <?php echo esc_html($level->name); ?>
											<?php
										}
										?>
										</span> </span> </div>
								  <div class="pro-coulmn">
									<?php 
											$category = get_term( get_post_meta($post->ID, '_project_category', true));
											if(!empty($category) && ! is_wp_error($category))
											{
												echo esc_html($category->name);
											}
										 ?>
								  </div>
								  <div class="pro-coulmn">
									<?php 
										$type =get_post_meta($post->ID, '_project_type', true);
										if($type == 'fixed' || $type == 1)
										{
											echo esc_html(fl_price_separator(get_post_meta($post->ID, '_project_cost', true))).'/'.esc_html__( 'Fixed ', 'khebrat_theme' );
										}
										else if($type == 'hourly' || $type == 2)
										{
											echo esc_html(fl_price_separator(get_post_meta($post->ID, '_project_cost', true))).' / '.esc_html__( 'Hourly ', 'khebrat_theme' );
											echo '<small class="estimated-hours">'.esc_html__( 'Estimated Hours ', 'khebrat_theme' ).get_post_meta($post->ID, '_estimated_hours', true).'</small>';
										}
									 ?>
								  </div>
									<div class="pro-coulmn completed-status blue-color emp-media">
										<span>
											<a href="<?php echo get_the_permalink($employer_id) ?>"> <?php echo get_profile_img($employer_id, "employer"); ?></a>
										</span>
										<div>
											<span class="">
												 <a href="<?php echo get_the_permalink($employer_id) ?>"><?php echo exertio_get_username('employer',$employer_id, 'badge', 'right' ); ?></a>
											</span>
											<small>
												<?php  echo esc_html__( 'Assigned on: ', 'khebrat_theme' ).date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( $employer_id, '_project_assigned_date' , true ) ) ); ?>
											</small>
										</div>
									</div>
								</div>
							  </div>
							<div class="fr-project-bidding proposals-dashboard selcted">
								<?php
									$stored_milestone_data = get_post_meta($project_id,'_project_milestone_data', true);
									if(!empty($stored_milestone_data))
									{
										?>
										<div class="fr-project-box">
										  <h3><?php echo esc_html__( 'Milestones', 'khebrat_theme' ); ?></h3>
										</div>
										<div class="milestone-section">
											<?php
											foreach($stored_milestone_data as $stored_milestone_data_array => $val)
											{
												$status = $status_msg = '';
												if($val['milestone_status'] == 'pending')
												{
													$status = 'yellow';
													$status_msg = __( 'Pending', 'khebrat_theme' );
													$paid_btn = '<div class="milestone-col-mini-box">
															<p>'.esc_html__( 'Pending', 'khebrat_theme' ).'</p>
															</div>';
												} 
												else if($val['milestone_status'] == 'paid')
												{
													$status = 'green';
													$status_msg = __( 'Paid', 'khebrat_theme' );
													$paid_btn = '<div class="milestone-col-mini-box">
															<p>'.esc_html__( 'Paid date', 'khebrat_theme' ).'</p>
															<div class="milestone-title">'.esc_html(date_i18n( get_option( 'date_format' ), strtotime( $val['milestone_paid_date'] ) )).'</div>
														</div>';

												}
											?>
											<div class="milestone-box">
												<div class="milstone-box-header">
													<div class="milestone-box-column">
														<span class="status-color <?php echo esc_attr($status); ?> protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($status_msg); ?>"></span>
														<div class="milestone-col-mini-box">
															<p> <?php echo esc_html($val['milestone_title']); ?> </p>
															<div class="milestone-title"> <?php  echo date_i18n( get_option( 'date_format' ), strtotime( $val['milestone_created_date'] ) ); ?></div>
														</div>
													</div>
													<div class="milestone-box-column">
														<div class="milestone-col-mini-box">
															<p class="primary"> <?php echo esc_html(fl_price_separator($val['total_project_amount'])); ?></p>
															<div class="milestone-title"> <?php echo esc_html__( 'Total Amount', 'khebrat_theme' ); ?></div>
														</div>
													</div>
													<div class="milestone-box-column">
														<div class="milestone-col-mini-box">
															<p><?php echo esc_html(fl_price_separator($val['current_milestone_amount'])); ?></p>
															<div class="milestone-title"> <?php echo esc_html__( 'In Escrew', 'khebrat_theme' ); ?></div>
														</div>
													</div>
													<div class="milestone-box-column">
														<div class="milestone-col-mini-box">
															<p><?php echo esc_html(fl_price_separator($val['milestone_amount_paid'])); ?></p>
															<div class="milestone-title"> <?php echo esc_html__( 'Amount Paid', 'khebrat_theme' ); ?></div>
														</div>
													</div>
													<div class="milestone-box-column">
														<div class="milestone-col-mini-box">
															<p> <?php echo esc_html(fl_price_separator($val['milestone_remaining_amount'])); ?></p>
															<div class="milestone-title"> <?php echo esc_html__( 'Remaining Payment', 'khebrat_theme' ); ?></div>
														</div>

													</div>
													<div class="milestone-box-column">
														<?php echo wp_return_echo($paid_btn); ?>
														<span class="milstone-errow show-milestone-detail" data-ml-id="<?php echo esc_attr($val['milestone_id']); ?>"><i class="fas fa-chevron-right"></i></span>
													</div>
												</div>
												<?php
												if($val['milestone_desc'] != '')
												{
													?>
													<div class="milestone-box-footer mlhide-<?php echo esc_attr($val['milestone_id']); ?>">
														<div class="milestone-desc">
															<p><?php echo esc_html($val['milestone_desc']); ?></p>
														</div>
													</div>
													<?php
												}
												?>
											</div>
											<?php
											}
											?>
										</div>
										<?php
									}
									?>
							</div>
							  <!--PROJECT HISTORY-->
							  <div class="project-history">
									<h3><?php echo esc_html__( 'Project History', 'khebrat_theme' ); ?></h3>
									<div class="history-body">
										<div class="history-chat-body">
											<?php
											$messages = get_history_msg($project_id);
											if($messages)
											{
												foreach($messages as $message)
												{
													$pro_img_id = get_post_meta( $message->msg_author, '_profile_pic_attachment_id', true );
													$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );

													$chat_right ='';
													if($msg_author != $message->msg_author)
													{
														$chat_right = 'success';
													}
													else
													{
														$chat_right = 'chant-single-right';
													}
													?>
													<div class="chat-single-box">
														<div class="chat-single <?php echo esc_html($chat_right); ?>">
															<div class="history-user">
																<?php
																	if($msg_author != $message->msg_author)
																	{
																	?>
																		<span> <?php echo get_profile_img($message->msg_author, "employer"); ?> </span>
																		<a href="#" class="history-username"><?php echo exertio_get_username('employer',$message->msg_author, 'badge', 'right' ); ?></a>
																		<span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
																	 <?php
																	}
																	else
																	{
																	?>
																		<span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
																		<a href="#" class="history-username"><?php echo exertio_get_username('freelancer',$msg_author, 'badge', 'right'); ?></a>
																		<span> <?php echo get_profile_img($msg_author, "freelancer"); ?> </span>

																	 <?php
																	}
																	?>

															</div>
															<p class="history-text">
																<?php echo esc_html(wp_strip_all_tags($message->message)); ?>
															</p>
															<?php
															if($message->attachment_ids >0)
															{
																?>
																<!--<a class="history_attch_dwld btn btn-black" href="javascript:void(0)" id="download-files" > Download</a>-->
																<div class="history_attch_dwld btn-loading" id="download-files" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
																	<i class="fas fa-arrow-down"></i>
																	<?php echo esc_html__( 'Attachments', 'khebrat_theme' ); ?>
																	<div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
																</div>
																<?php
															 }
															 ?>
														</div>
													</div>
													<?php	
												}
											}
											else
											{
												?>
												<p class="text-center"><?php echo esc_html__( 'No history found', 'khebrat_theme' ); ?></p>
												<?php	
											}
											?>
										</div>
									</div>
							  </div>
							  <div class="history-msg-form">
								<h3><?php echo esc_html__( 'Send Message', 'khebrat_theme' ); ?></h3>
								<div class="history-text">
									<form id="send_himstory_msg">
										<div class="form-row">
											<div class="form-group col-md-12">
												<textarea name="history_msg_text" id="" class="form-control fl-textarea" required data-smk-msg="<?php echo esc_attr__('Please provide message to send','khebrat_theme'); ?>"></textarea>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												<div class="upload-btn-wrapper">
													<button class="btn btn-theme-secondary mt-2 mt-xl-0" type="button"><?php echo esc_html__('Select Attachments','khebrat_theme'); ?></button>
													<input type="file" id="gen_attachment_uploader" multiple name="project_attachments[]" accept = "image/pdf/doc/docx/ppt/pptx*" data-post-id="<?php echo esc_attr($project_id) ?>" title=" <?php echo esc_html__('No file selected','khebrat_theme'); ?>"/>
													<input type="hidden" name="attachment_ids" value="" id="history_attachments_ids">
												</div>
											</div>
										</div>
										<div class="form-row" >
												 <div class="form-group col-md-12 attachment-box"> 
												</div>
											</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												<button type="button" class="btn btn-theme float-right btn-loading" id="history_msg_btn" data-post-id="<?php echo esc_attr($project_id) ?>" data-fl-id="<?php echo esc_attr($employer_id) ?>" data-msg-author="<?php echo esc_attr($msg_author) ?>">
													<?php echo esc_html__('Send Message','khebrat_theme'); ?>
													<div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
												</button>
											</div>
										</div>
									</form>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					<?php
				}
				else
				{
					get_template_part( 'template-parts/dashboard/layouts/dashboard');
				}
			}
			else
			{
				get_template_part( 'template-parts/dashboard/layouts/dashboard');
			}
		}
		else
		{
			get_template_part( 'template-parts/dashboard/layouts/dashboard');
		}
	}
	else
	{
		echo exertio_redirect(home_url('/'));
	?>
<?php
	}
	?>
