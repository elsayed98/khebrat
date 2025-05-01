<?php global $khebrat_theme_options;
$current_user_id = get_current_user_id();
$limit = get_option( 'posts_per_page' );;
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

$notification = exertio_view_all_notifications($start_from, $limit);

	?>
	<div class="content-wrapper">
		<div class="notch"></div>
		  <div class="row">
			<div class="col-md-7 grid-margin">
			  <div class="d-flex justify-content-between flex-wrap">
				<div class="d-flex align-items-end flex-wrap">
				  <div class="mr-md-3 mr-xl-5">
					<h2><?php echo esc_html__('Notifications','khebrat_theme'); ?></h2>
					<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
						<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'khebrat_theme' ); ?>&nbsp;</p>
						<?php echo exertio_dashboard_extention_return(); ?>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			<div class="col-md-5 grid-margin"> 
                <?php  if(!empty($notification)){  ?>

                <button class="btn btn-theme"  id="clear_notification"> <?php  echo esc_html__('Clear Notifications'); ?> 
            </button>

        <?php } ?>
		</div>

		  </div>
		  <div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 grid-margin stretch-card">
				<div class="card mb-4">
					<div class="card-body">
					  <div class="pro-section">
						<div class="pro-box heading-row">
						  <div class="pro-coulmn pro-title"> </div>
						  <div class="pro-coulmn"><?php echo esc_html__( 'Time', 'khebrat_theme' ) ?> </div>
						</div>
							<?php
							$notification = exertio_view_all_notifications($start_from, $limit);
							if(!empty($notification))
							{
								echo $notification;
							}
							else
							{
								?>
								<div class="nothing-found">
								  <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo esc_attr__( 'Nothing found icon', 'khebrat_theme' ) ?> ">
									<h3><?php echo esc_html__( 'No new Notifications', 'khebrat_theme' ) ?></h3>
								</div>
								<?php
							}
							echo notification_pagination($pageno, $limit);
							?>
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
	echo exertio_redirect(home_url('/'));
}
?>