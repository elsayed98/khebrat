<?php

global $khebrat_theme_options;
global $post;
$lsid = get_the_ID();
$post_author = $post->post_author;
$cust_id = get_user_meta($post_author, 'customer_id', true);
$alt_id = '';



$service_type_id    = get_post_meta($lsid, '_service_type', true);
$service_type       = get_the_title($service_type_id);
$profile_image      = get_profile_img($cust_id, "customer", "card-img");
$order_date         = get_the_date('d M Y');
$current_user_id    = get_current_user_id();

$case_role = get_post_meta($lsid, '_case_role_type', true);




?>
<!-- =======================
Main Content START -->
<section class="pt-4 pt-md-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-9 mx-auto">
                <div class="vstack gap-4">

                    <!-- Booking summary START -->
                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header border-bottom p-4">
                            <h1 class="mb-0 fs-3"><?php echo $service_type ?></h1>
                        </div>

                        <!-- Card body START -->
                        <div class="card-body p-4">
                            <div class="row g-md-4">
                                <!-- Image -->
                                <div class="col-md-3">
                                    <div class="bg-light rounded-3 px-1 py-1 mb-3 mb-md-0">
                                        <?php echo wp_return_echo($profile_image); ?>
                                    </div>
                                </div>

                                <!-- Card and address detail -->
                                <div class="col-md-9">
                                    <!-- Title -->
                                    <h5 class="card-title mb-2"><?php echo get_the_title(); ?></h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <small><?php echo esc_html__('تاريخ الطلب : ', 'khebrat_theme'); ?></small>
                                            <span class="h6 mb-0 fw-normal ms-1">
                                                <?php echo esc_html($order_date); ?>
                                            </span>
                                        </div>

                                        <div class="col-md-6 text-sm-end">
                                            <small><?php echo esc_html__('طلب رقم :', 'khebrat_theme'); ?></small>
                                            <span class="h6 mb-0 fw-normal ms-1">#
                                                <?php echo esc_html($lsid); ?>
                                            </span>
                                        </div>

                                    </div>

                                </div>

                                <!-- Title -->
                                <div class="row">
                                    <div class="card shadow-sm border-0 mb-2">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4 text-primary"><i class="bi bi-file-earmark-text-fill me-2"></i>تفاصيل الطلب </h5>
                                            <div class="mb-3 border-bottom pb-3">
                                                <small class="text-muted d-block mb-1"><i class="bi bi-chat-left-text me-1"></i>عنوان الطلب</small>
                                                <p class="h6 fw-light mb-md-0"><?php echo get_field_meta($lsid, '_request_title', 'لا يوجد'); ?></p>
                                            </div>
                                            <div class="mb-3 border-bottom pb-3">
                                                <small class="text-muted d-block mb-1"><i class="bi bi-translate me-1"></i>التفاصيل</small>
                                                <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_details', 'لا يوجد')); ?></div>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block mb-1"><i class="bi bi-journal-text me-1"></i>الخدمة المطلوب تنفيذها</small>
                                                <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_requested_service', 'لا يوجد')); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php khebrat_display_service_attachments($lsid); ?>

                                <?php
                                if ($current_user_id == $post_author) {
                                ?>
                                    <a class="btn btn-primary w-100"
                                        href="<?php echo esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])); ?>?ext=service-offers&sfid=<?php echo esc_html($lsid); ?>">
                                        <?php echo esc_html__('مشاهدة العروض', 'khebrat_theme'); ?></a>


                                    <?php
                                } else {
                                    if (has_user_offered_service($current_user_id, $lsid)) {
                                        echo '<div class="alert alert-warning">لقد قدمت عرضًا مسبقًا على هذه الخدمة.</div>';
                                    } else {
                                    ?>
                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#offer">
                                            <?php echo esc_html__('ارسال عرض', 'khebrat_theme'); ?>
                                        </button>
                                <?php
                                    }
                                }
                                ?>



                            </div>
                            <!-- Card body END -->
                        </div>
                        <!-- Booking summary END -->


                    </div>
                </div>
            </div>
        </div>
</section>
<!-- =======================
Main Content END -->
<?php echo khebrat_display_offer_modal($lsid); ?>