<?php
global $khebrat_theme_options;
if (!isset($_GET['sfid']) || !is_numeric($_GET['sfid'])) {
  echo '<div class="alert alert-danger">معرف الخدمة غير صالح.</div>';
  exit;
}

$service_id = intval($_GET['sfid']);

$service_type_id  = get_post_meta($service_id, '_service_type', true);
$service_type     = get_the_title($service_type_id);
$specialization   = get_post_meta($service_id, '_specialization', true); // التخصص
$order_date       = get_the_date('d M Y'); // تاريخ الطلب (مثل 27 Apr 2025)
$offer_statue     = get_post_meta($service_id, '_service_offer_status', true);

// hatem_debug($offer_statue);

$args = array(
  'post_type'      => 'service_offers',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'post_parent'    => $service_id,
);

$query = new WP_Query($args);

?>


<div class="vstack gap-4">


  <div class="bg-primary bg-opacity-10 rounded-3 overflow-hidden p-4">
    <div class="row g-4 align-items-center">
      <!-- Cotent -->
      <div class="col-md-6 order-md-2">
        <!-- Title -->
        <h4><i class="bi bi-journals fa-fw me-1"></i><?php echo esc_html__('عروض علي : ', 'khebrat_theme'); ?><?php echo esc_html(get_the_title($service_id)); ?></h4>
        
        <!-- تفاصيل -->
        <ul class="list-group list-group-borderless mb-0">
          <li class="list-group-item"><?php echo esc_html__('طلب رقم : ', 'khebrat_theme'); ?>
            <span class="h6 mb-0 fw-normal ms-1">#<?php echo esc_html($service_id); ?></span>
          </li>
          <li class="list-group-item"><?php echo esc_html__('تاريخ الطلب : ', 'khebrat_theme'); ?>
            <span class="h6 mb-0 fw-normal ms-1"><?php echo esc_html($order_date); ?></span>
          </li>
          <li class="list-group-item"><?php echo esc_html__('نوع الخدمة : ', 'khebrat_theme'); ?>
            <span class="h6 mb-0 fw-normal ms-1"><?php echo esc_html($service_type_id ? $service_type : 'غير محدد'); ?></span>
          </li>
          <li class="list-group-item"><?php echo esc_html__('التخصص : ', 'khebrat_theme'); ?>
            <?php
            $terms = wp_get_object_terms($service_id, 'legal_category');

            if (!empty($terms) && !is_wp_error($terms)) {
              $term_names = wp_list_pluck($terms, 'name');
              echo '<span class="h6 mb-0 fw-normal ms-1">' . implode('، ', $term_names) . '</span>';
            } else {
              echo '<span class="h6 mb-0 fw-normal ms-1">' . esc_html('غير محدد') . '</span>';
            }
            ?>
          </li>
        </ul>

      </div>
    </div>
  </div>

  <?php
  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
      $author_id      = get_post_field('post_author', get_the_ID());
      $lid            = get_user_meta($author_id, 'lawyer_id', true);
      $profile_image  = get_profile_img($lid, "lawyer", "avatar-img rounded-circle");
      $user_name      = exertio_get_username('lawyer', $lid);
      $days           = get_post_meta(get_the_ID(), '_service_execution_time', true);
      $price          = get_post_meta(get_the_ID(), '_service_offer_price', true);
      $offer_link     = get_permalink($khebrat_theme_options['user_dashboard_page']) . '/?ext=offer-detail&offer_id=' . get_the_ID(); 


  ?>
      <!-- Ticket item START -->
      <div class="card border <?php echo get_the_ID() ?>">
        <!-- Card header -->
        <div class="card-header d-sm-flex justify-content-sm-between align-items-center">
          <!-- Airline Name -->
          <div class="d-flex align-items-center mb-2 mb-sm-0">
            <div class="avatar">
              <?php echo wp_return_echo($profile_image); ?>
            </div>
            <h5 class="ms-2 mb-0"> <?php echo esc_html($user_name); ?></h5>
          </div>
          <h6 class="fw-normal mb-0"><span class="text-body"></span></h6>
        </div>

        <!-- Card body -->
        <div class="card-body p-4 pb-0  pt-0">
          <!-- Ticket item START -->
          <div class="row g-2">
            <!-- Airport detail -->
            <div class="col-sm-4 col-md-6">
              <p class="mb-0"><?php echo esc_html__('مدة التنفيذ', 'khebrat_theme'); ?></p>
              <h6>
                <?php
                if ($days == 1) {
                  echo 'يوم';
                } elseif ($days == 2) {
                  echo 'يومين';
                } elseif ($days >= 3 && $days <= 10) {
                  echo $days . ' أيام';
                } else {
                  echo $days . ' يومًا';
                }
                ?>
              </h6>
            </div>

            <!-- Airport detail -->
            <div class="col-sm-4 col-md-6">
              <p class="mb-0"><?php echo esc_html__('قيمة العرض', 'khebrat_theme'); ?></p>
              <h6><?php echo esc_html($price); ?> ر.س</h6>
            </div>
          </div>
          <!-- Ticket item END -->
        </div>

        <!-- Card footer -->
        <div class="card-footer pt-4">
          <ul class="list-inline bg-light rounded-2 d-sm-flex text-center justify-content-sm-between mb-0 px-4 py-2">
            <li class="list-inline-item"><a class="btn btn-success btn-sm" href="<?php echo $offer_link ?>"><?php echo esc_html__('تفاصيل العرض ', 'khebrat_theme'); ?></a></li>
            <li class="list-inline-item"><a class="btn btn-outline-success btn-sm" href="#"><?php echo esc_html__('قبول العرض', 'khebrat_theme'); ?></a></li>
            <li class="list-inline-item"><a class="btn btn-success btn-sm" href="<?php echo esc_attr(get_permalink($lid));?>"><?php echo esc_html__('ملف المحامي', 'khebrat_theme'); ?></a></li>
          </ul>
        </div>
      </div>
      <!-- Ticket item END -->

  <?php
    endwhile;


    wp_reset_postdata();
  else :
    echo '<div class="container mt-5"><div class="alert alert-info">لا توجد عروض حالياً لهذه الخدمة.</div></div>';
  endif;
  ?>

</div>