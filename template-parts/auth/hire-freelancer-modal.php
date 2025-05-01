<?php 
$pid = get_the_ID();
$freelancer_title = '';
$current_user_id = get_current_user_id();

	$freelancer_title = __('Hire Freelancer','khebrat_theme');

	global $khebrat_theme_options;
?>
<div class="modal fade forget_pwd" id="hire-freelancer-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="modal-from hire-freelancer-form" method="POST" id="hire-freelancer-form">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo esc_html($freelancer_title); ?></h5>
          <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
			<?php
			if( is_user_logged_in() )
			{
			?>
			<div class="fr-report-form">
				<div class="form-group">
					<label><?php echo esc_html__('Choose a Project','khebrat_theme'); ?></label>
					<?php
						if( is_user_logged_in() )
						{
							$the_query = new WP_Query( 
														array( 
																'author__in' => array( $current_user_id ) ,
																'post_type' =>'projects',
																'post_status'     => 'publish'	,
																'orderby' => 'date',
																'order'   => 'DESC',												
																)
															);

							$total_count = $the_query->found_posts;
							$report_category = '<select name="project-id" class="form-control general_select">';

                               $have_project  = true;

							if ( $the_query->have_posts() )
							{
								while ( $the_query->have_posts() ) 
								{
									$the_query->the_post();
									$project_id = get_the_ID();

									$report_category .= '<option value="'. esc_attr( $project_id ) .'">
											'. esc_html( get_the_title($project_id) ) .'</option>';

								}
							}
							else
							{

								 $have_project  = false; 
								$report_category .= '<option value="">'. __('No published project available','khebrat_theme').'</option>';
							}
								$report_category.='</select>';
								echo wp_return_echo($report_category);

						}
					?>
				</div>
				<div class="form-group">
					<input type="hidden" id="fl_hire_freelancer_nonce" value="<?php echo wp_create_nonce('fl_hire_freelancer__secure'); ?>"  />

                    <?php if($have_project ){  ?>
					<a href="javascript:void(0)" id="btn-hire-freelancer" class="btn btn-theme btn-loading" data-freelancer-id="<?php echo esc_attr($pid); ?>"><?php echo esc_html__("Send Invitation", 'khebrat_theme'); ?><span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span></a>
				<?php  } 
				else { 
					$dashboard_page = get_the_permalink($khebrat_theme_options['user_dashboard_page']);
                     $dashboard_page   =   $dashboard_page."?ext=create-project";
				 ?>
                    <a href="<?php echo esc_url( $dashboard_page);?>"  class="btn btn-theme btn-loading" data-freelancer-id="<?php echo esc_attr($pid); ?>"><?php echo esc_html__("Click to create Project first", 'khebrat_theme'); ?>
                    </a>

		<?php 	}
          ?>
				</div>
			</div>
        	<?php
			}
			else
			{
				?>
				<div class="form-group">
					<p><?php echo esc_html__("Please login to send invitation", 'khebrat_theme'); ?></p>
				</div>
				<?php
			}
			?>
        </div>
      </form>
    </div>
  </div>
</div>