<?php
$items_per_page = get_option( 'posts_per_page' );
$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;
global $khebrat_theme_options;
global $wpdb;
			$table = EXERTIO_PROJECT_OFFER_TBL;
			//if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
			//{
$current_user_id = get_current_user_id();
$freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );

$query = "SELECT * FROM ".$table." WHERE `author_id` = " . $current_user_id ."&& `offer_Status` = 2 "; 
$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
$total = $wpdb->get_var( $total_query );

$results = $wpdb->get_results( $query.' ORDER BY `timestamp` DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

$pagination = paginate_links( array(
                        'base' => add_query_arg( 'cpage', '%#%' ),
                        'format' => '',
                        'prev_text' => __('&laquo;'),
                        'next_text' => __('&raquo;'),
                        'total' => ceil($total / $items_per_page),
                        'current' => $page,
						'type' => 'array',
                    ));

if ( is_user_logged_in() ) {
  ?>
<div class="content-wrapper">
  <div class="notch"></div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="mr-md-3 mr-xl-5">
            <h2><?php echo esc_html__('Accepted Offers','khebrat_theme'); ?></h2>
            <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
              <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'khebrat_theme' ); ?>&nbsp;</p>
              <?php echo exertio_dashboard_extention_return(); ?> </div>
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
              <div class="pro-coulmn pro-title"> </div>
              <div class="pro-coulmn"><?php echo esc_html__( 'Cost / Delivery', 'khebrat_theme' ) ?> </div>
               <div class="pro-coulmn"><?php echo esc_html__( 'Freelancer', 'khebrat_theme' ) ?> </div>
               <div class="pro-coulmn"><?php echo esc_html__( 'Status', 'khebrat_theme' ) ?> </div>
            
            </div>
            <?php
            if ( !empty($results) )
			{
              foreach($results as $result)
			  {
                $pid = $result->project_id;
                $posted_date = date_i18n( get_option( 'date_format' ), strtotime( $result->timestamp ) );
                ?>
				<div class="pro-box">
				  <div class="pro-coulmn pro-title">
					<h4 class="pro-name">
						<a href="<?php  echo esc_url(get_permalink($pid)); ?>"><?php echo esc_html(get_the_title($pid)); ?></a>
							<span class="bidding-badges">
							<?php if($result->is_top == 1){ ?>
							<i class="fas fa-medal protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'Sticky Proposal', 'khebrat_theme' ); ?>"></i>
							<?php } ?>
							<?php if(isset($result->is_featured) && $result->is_featured == 1){ ?>
							<i class="far fa-star protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'Featured Proposal', 'khebrat_theme' ); ?>"></i>
							<?php } ?>
							<?php if($result->is_sealed == 1){ ?>
							<i class="fas fa-lock protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'Sealed Proposal', 'khebrat_theme' ); ?>"></i>
							<?php } ?>
							</span>
					</h4>
					<span class="pro-meta-box">
						<span class="pro-meta"> <i class="far fa-calendar-alt"></i> <?php echo	esc_html($posted_date); ?> </span>
						<span class="pro-meta"> <i class="far fa-calendar-alt"></i> <a href="javascript:void(0)" class="cover-letter" data-prpl-id ='<?php echo esc_html($result->id); ?>'> <?php echo esc_html__( 'Cover Letter', 'khebrat_theme' ); ?> </a></span>
					</span>
					<div class="show-cover-letter showhide_<?php echo esc_html($result->id); ?>">
						<h5><?php echo esc_html__( 'Cover Letter', 'khebrat_theme' ); ?></h5>
					  <p><?php echo esc_html($result->cover_letter); ?></p>
					</div>
				</div>

				  <div class="pro-coulmn">
					  <?php 
							$type = get_post_meta($pid, '_project_type', true);
							if($type == 'fixed' || $type == 1)
							{
								echo esc_html(fl_price_separator( $result->proposed_cost )).'/'.esc_html__( 'Fixed ', 'khebrat_theme' );
								echo '<small class="estimated-hours">'.esc_html__( 'Days to Complete ', 'khebrat_theme' ).$result->day_to_complete.'</small>';
							}
							else if($type == 'hourly' || $type == 2)
							{
								echo esc_html(fl_price_separator($result->proposed_cost )).' '.esc_html__( 'Hourly ', 'khebrat_theme' );
								echo '<small class="estimated-hours">'.esc_html__( 'Estimated Hours ', 'khebrat_theme' ).$result->allowed_hours.'</small>';
							}
						 ?>
				  </div>
          <div class="pro-coulmn offer-freelancer">   
                    <a href="<?php  echo esc_url(get_permalink($result->freelancer_id)); ?>">
                              <div class="h-style2"> <?php echo exertio_get_username('freelancer', $result->freelancer_id, 'badge', 'right'); ?></div>
                              </a>
           </div>

				  <div class="pro-coulmn">
				  	<?php
                        if($result->offer_Status == "1") {
                           $offer_Status   =   esc_html__('Pending','khebrat_theme');
                        }
                         else if($result->offer_Status == "2"){
                         $offer_Status   =   esc_html__('Accepted','khebrat_theme');
                         }

                         else if($result->offer_Status == "3"){
                         	$offer_Status   =   esc_html__('Rejected','khebrat_theme');
                         }
                         else if($result->offer_Status == "4"){
                         	$offer_Status   =   esc_html__('Cancelled by you','khebrat_theme');
                         }
				  	 ?>
                     <p> <?php echo esc_html($offer_Status); ?></p>
				</div>

				
				</div>
            <?php
            }
				if ( ! empty( $pagination ) )
				{
					?>
			  <div class="fl-navigation">
				<ul class="pagination">
					<?php foreach ( $pagination as $key => $page_link ) : ?>
						<li class="<?php if ( strpos( $page_link, 'current' ) !== false ) { echo ' active'; } ?>"><?php echo wp_return_echo($page_link); ?></li>
					<?php endforeach ?>
				</ul>
			</div>
			<?php 
			}
            //wp_reset_postdata();
            }
            else {
              ?>
            <div class="nothing-found">
              <h3><?php echo esc_html__( 'Sorry!!! No Record Found', 'khebrat_theme' ) ?></h3>
              <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo esc_attr__( 'Nothing found icon', 'khebrat_theme' ) ?> "> </div>
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
} else {
  echo exertio_redirect( home_url( '/' ) );
  ?>
<?php
}
?>
