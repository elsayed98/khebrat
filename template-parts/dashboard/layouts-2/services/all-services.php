<?php
global $khebrat_theme_options;
$current_user_id = get_current_user_id();
if ( get_query_var( 'paged' ) ) {
  $paged = get_query_var( 'paged' );
} else if ( get_query_var( 'page' ) ) {
  /*This will occur if on front page.*/
  $paged = get_query_var( 'page' );
} else {
  $paged = 1;
}
if ( is_user_logged_in() ) {
  if ( isset( $_GET[ 'search_title' ] ) && $_GET[ 'search_title' ] != "" ) {
    $title = $_GET[ 'search_title' ];

    $query_args = array(
      's' => $title,
      'author__in' => array( $current_user_id ),
      'post_type' => 'services',
      'meta_query' => array(
        array(
          'key' => '_service_status',
          'value' => 'active',
          'compare' => '=',
        ),
      ),
      'paged' => $paged,
      'post_status' => 'publish'
    );
    $the_query = new WP_Query( $query_args );
    $total_count = $the_query->found_posts;
  } else {
    // The Query
    $the_query = new WP_Query(
      array(
        'author__in' => array( $current_user_id ),
        'post_type' => 'services',
        'meta_query' => array(
          array(
            'key' => '_service_status',
            'value' => 'active',
            'compare' => '=',
          ),
        ),
        'paged' => $paged,
        'post_status' => 'publish'
      )
    );

    $total_count = $the_query->found_posts;
  }
  ?>
<div class="content-wrapper">
  <div class="notch"></div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="mr-md-3 mr-xl-5">
            <h2><?php echo esc_html__('Active Services','khebrat_theme'); ?></h2>
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
              <div class="pro-coulmn"><?php echo esc_html__( 'Category', 'khebrat_theme' ) ?> </div>
              <div class="pro-coulmn"><?php echo esc_html__( 'Cost / Delivery', 'khebrat_theme' ) ?> </div>
              <div class="pro-coulmn"><?php echo esc_html__( 'Addons', 'khebrat_theme' ) ?> </div>
            </div>
            <?php
            if ( $the_query->have_posts() ) {
              while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $sid = get_the_ID();
                $posted_date = get_the_date( get_option( 'date_format' ), $sid );
                ?>
            <div class="pro-box">
              <div class="pro-coulmn pro-title">
                <?php
                $featured_service = get_post_meta( $sid, '_service_is_featured', true );
                if ( isset( $featured_service ) && $featured_service == 1 ) {
                  ?>
                <div class="features-star"><?php echo esc_html__( 'Featured', 'khebrat_theme' ) ?></div>
                <?php
                }
                ?>
                <h4 class="pro-name"> <a href="<?php  echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a> </h4>
                <span class="pro-meta-box"> <span class="pro-meta"> <i class="far fa-calendar-alt"></i> <?php echo date_i18n( get_option( 'date_format' ), strtotime( esc_html($posted_date) ) ); ?> </span> <span class="pro-meta">
                <?php
				  	$response_time = get_term( get_post_meta($sid, '_response_time', true));
				  	if(!empty($response_time) && ! is_wp_error($response_time))
					{
						?>
						<i class="far fa-history"></i> <?php echo esc_html($response_time->name); ?>
						<?php
					}
				  ?>
					
					</span> </span> <span class="pro-btns"> <a href="<?php echo esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page']));?>?ext=add-services&sid=<?php echo esc_html($sid); ?>" class="btn btn-inverse-primary btn-sm"> <i class="far fa-edit"></i> <?php echo esc_html__( 'Edit', 'khebrat_theme' ); ?></a> <a href="javascript:void(0)" class="btn btn-inverse-warning btn-sm cancel_service" data-pid="<?php echo esc_attr($sid); ?>" data-status="cancel"> <i class="far fa-times-circle"></i> <?php echo esc_html__( 'Deactive', 'khebrat_theme' ); ?></a> <a href="javascript:void(0)" class="btn btn-inverse-danger btn-sm cancel_service" data-pid="<?php echo esc_attr($sid); ?>" data-status="remove"> <i class="far fa-times-circle"></i> <?php echo esc_html__( 'Delete', 'khebrat_theme' ); ?></a> 

            <a href="javascript:void(0)" class="btn btn-inverse-primary btn-sm bump_up_service" data-pid="<?php echo esc_attr($sid); ?>" data-status="bump_up"> <i class="far fa-times-circle"></i> <?php echo esc_html__( 'Bump Up', 'khebrat_theme' ); ?></a> 
          </span>

         </div>
              <div class="pro-coulmn">
                <?php
                $category = get_term( get_post_meta( $sid, '_service_category', true ) );
				if(!empty($category) && ! is_wp_error($category))
				{
					echo esc_html( $category->name );
				}
                ?>
              </div>
              <div class="pro-coulmn">
                <?php
                $delivery_time = get_term( get_post_meta( $sid, '_delivery_time', true ) );
				if(!empty($delivery_time) && ! is_wp_error($delivery_time))
				{
					echo fl_price_separator( get_post_meta( $sid, '_service_price', true ) ) . '/' . $delivery_time->name;
				}
                ?>
              </div>
              <div class="pro-coulmn">
                <ul>
                  <?php
                  $slected_ids = json_decode( get_post_meta( $sid, '_services_addon', true ) );
                  if ( $slected_ids != '' ) {
                    foreach ( $slected_ids as $ids ) {
                      ?>
                  <li>
                    <?php
                    $addon = get_post( $ids );
                    echo esc_html($addon->post_title) . '</br>';
                    ?>
                  </li>
                  <?php
                  }
                  }
                  ?>
                </ul>
              </div>
            </div>
            <?php
            }

            fl_pagination( $the_query );
            wp_reset_postdata();
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
