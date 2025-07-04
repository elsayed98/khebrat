<?php global $khebrat_theme_options;
$current_user_id = get_current_user_id();
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} else if ( get_query_var( 'page' ) ) {
	/*This will occur if on front page.*/
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}
	if( is_user_logged_in() )
	 {
		global $wpdb;
		$uid	=	get_current_user_id();
		$rows = $wpdb->get_results( "SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$uid' AND meta_key LIKE '_service_fav_id_%'" );
		$pids	=	array(0);
		foreach( $rows as $row )
		{
			$pids[]	=	$row->meta_value;	
		}
		$args	=	array(
					'post_type' => 'services',
					'post__in' => $pids,
					'post_status' => 'publish',
					'paged' => $paged,
					'order'=> 'DESC',
					'orderby' => 'date'
				);

		// The Query
		$the_query = new WP_Query($args);
		
		$total_count = $the_query->found_posts;
		?>

<div class="content-wrapper">
  <div class="notch"></div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="mr-md-3 mr-xl-5">
            <h2><?php echo esc_html__('Saved Services','khebrat_theme').esc_html(' ('. $total_count.')');?></h2>
			<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
				<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'khebrat_theme' ); ?>&nbsp;</p>
				<?php echo exertio_dashboard_extention_return(); ?>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card services">
      <div class="card mb-4">
        <div class="card-body">
          <div class="pro-section">
              <div class="pro-box heading-row">
                <div class="pro-coulmn pro-title">
                </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'in Queue', 'khebrat_theme' ) ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Cost / Delivery', 'khebrat_theme' ) ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Action', 'khebrat_theme' ) ?> </div>
              </div>
				<?php
					if ( $the_query->have_posts() )
					{
						while ( $the_query->have_posts() ) 
						{
							$the_query->the_post();
							$sid = get_the_ID();
							$posted_date = get_the_date(get_option( 'date_format' ), $sid );
				  
							?>
							  <div class="pro-box">
								<div class="pro-coulmn pro-title">
									<h4 class="pro-name">
										<a href="<?php  echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
									</h4>
									<span class="pro-meta-box">
										<span class="pro-meta">
											<i class="far fa-calendar-alt"></i> <?php echo	esc_html($posted_date); ?>
										</span>
										<span class="pro-meta">
											<?php
												$response_time = get_term( get_post_meta($sid, '_response_time', true));
												if(!empty($response_time) && ! is_wp_error($response_time))
												{
													?>
													<i class="far fa-history"></i> <?php echo esc_html($response_time->name); ?>
													<?php
												}
												?>
										</span>
									</span>
								</div>
								<div class="pro-coulmn">
									<?php
										$category = get_term( get_post_meta($sid, '_service_category', true));
										if(!empty($category) && ! is_wp_error($category))
										{
											echo esc_html($category->name);
										}
									 ?>
								</div>
								<div class="pro-coulmn">
									<?php 
										$delivery_time = get_term( get_post_meta($sid, '_delivery_time', true));
										if(!empty($delivery_time) && ! is_wp_error($delivery_time))
										{
											echo esc_html($khebrat_theme_options['fl_currency'].' '.get_post_meta($sid, '_service_price', true).' '.$delivery_time->name);
										}
									 ?>
								</div>
								<div class="pro-coulmn"><a href="javascript:void(0)" class="btn btn-danger delete_saved_service" data-post-id="<?php echo esc_html($sid); ?>"> <?php echo esc_html__( 'Remove ', 'khebrat_theme' ); ?> </a></div>
							  </div>
						  
							<?php
						}
						
						fl_pagination($the_query);
						wp_reset_postdata();
					}
					else
					{
						?>
                        <div class="nothing-found">
                            <h3><?php echo esc_html__( 'Sorry!!! No Record Found', 'khebrat_theme' ) ?></h3>
                            <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo esc_attr__( 'Nothing found icon', 'khebrat_theme' ) ?> ">
                        </div>
                        <?php	
					}
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
	?>
<?php
	}
	?>