<?php global $khebrat_theme_options;
$current_user_id = get_current_user_id();
if (get_query_var('paged')) {
  $paged = get_query_var('paged');
} else if (get_query_var('page')) {

  $paged = get_query_var('page');
} else {
  $paged = 1;
}

if (is_user_logged_in()) {

  $the_query = new WP_Query(
    array(
      'author__in' => array($current_user_id),
      'post_type' => 'projects',
      'meta_query' => array(),
      'paged' => $paged,
      'post_status'     => 'canceled'
    )
  );

  $total_count = $the_query->found_posts;
?>
  <div class="content-wrapper">
    <div class="notch"></div>
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex align-items-end flex-wrap">
            <div class="mr-md-3 mr-xl-5">
              <h2><?php echo esc_html__('Canceled Projects', 'khebrat_theme') . esc_html(' (' . $total_count . ')'); ?></h2>
              <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
                <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'khebrat_theme'); ?>&nbsp;</p>
                <?php echo exertio_dashboard_extention_return(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card mb-4">
          <div class="card-body">
            <div class="pro-section">
              <div class="pro-box heading-row">
                <div class="pro-coulmn pro-title">
                </div>
                <div class="pro-coulmn"><?php echo esc_html__('Category', 'khebrat_theme') ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__('Type/Cost', 'khebrat_theme') ?> </div>
                <!--<div class="pro-coulmn"><?php echo esc_html__('Proposals', 'khebrat_theme') ?> </div>-->
              </div>
              <?php
              if ($the_query->have_posts()) {
                while ($the_query->have_posts()) {
                  $the_query->the_post();
                  $pid = get_the_ID();
                  $posted_date = get_the_date(get_option('date_format'), $pid);
              ?>
                  <div class="pro-box">
                    <div class="pro-coulmn pro-title">
                      <h4 class="pro-name">
                        <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo  esc_html(get_the_title()); ?></a>
                      </h4>
                      <span class="pro-meta-box">
                        <span class="pro-meta">
                          <i class="far fa-clock"></i> <?php echo  esc_html($posted_date); ?>
                        </span>
                        <span class="pro-meta">
                          <?php
                          $level = get_term(get_post_meta($pid, '_project_level', true));
                          if (!empty($level) && ! is_wp_error($level)) {
                          ?>
                            <i class="fas fa-layer-group"></i> <?php echo esc_html($level->name); ?>
                          <?php
                          }
                          ?>
                        </span>
                      </span>
                    </div>
                    <div class="pro-coulmn">
                      <?php
                      $category = get_term(get_post_meta($pid, '_project_category', true));
                      if (!empty($category) && ! is_wp_error($category)) {
                        echo esc_html($category->name);
                      }
                      ?>
                    </div>
                    <div class="pro-coulmn">
                      <?php
                      $type = get_post_meta($pid, '_project_type', true);
                      if ($type == 'fixed' || $type == 1) {
                        echo esc_html(fl_price_separator(get_post_meta($pid, '_project_cost', true))) . '/' . esc_html__('Fixed ', 'khebrat_theme');
                      } else if ($type == 'hourly' || $type == 2) {
                        echo esc_html(fl_price_separator(get_post_meta($pid, '_project_cost', true))) . ' ' . esc_html__('Hourly ', 'khebrat_theme');
                        echo '<small class="estimated-hours">' . esc_html__('Estimated Hours ', 'khebrat_theme') . get_post_meta($pid, '_estimated_hours', true) . '</small>';
                      }
                      ?>
                    </div>
                  </div>
                <?php
                }
                fl_pagination($the_query);
                wp_reset_postdata();
              } else {
                ?>
                <div class="nothing-found">
                  <h3><?php echo esc_html__('Sorry!!! No Record Found', 'khebrat_theme') ?></h3>
                  <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo esc_attr__('Nothing found icon', 'khebrat_theme') ?> ">
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
} else {
  echo exertio_redirect(home_url('/'));
}
?>