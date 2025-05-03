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

                                    <!-- Pick up and drop address -->
                                    <div class="">
                                        <div class="col-md-12 mt-2">
                                            <small><?php echo esc_html__('الخدمة المطلوبة : ', 'khebrat_theme'); ?></small>
                                            <?php
                                            $requested_service = get_post_meta($lsid, '_requested_service', true);

                                            if ($requested_service == 'draft') {
                                                echo '<span class="h6 mb-0 fw-normal ms-1">' . esc_html__('صياغة العقود والاتفاقيات', 'khebrat_theme') . '</span>';
                                            } elseif ($requested_service == 'review') {
                                                echo '<span class="h6 mb-0 fw-normal ms-1">' . esc_html__('مراجعة العقود والاتفاقيات', 'khebrat_theme') . '</span>';
                                            } else {
                                                echo '<span class="h6 mb-0 fw-normal ms-1">' . esc_html('غير محدد') . '</span>';
                                            }
                                            ?>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <small><?php echo esc_html__('نوع العقد :', 'khebrat_theme'); ?></small>
                                            <span
                                                class="h6 mb-0 fw-normal ms-1"><?php echo get_post_meta($lsid, '_contract_type', true) ?></span>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <small><?php echo esc_html__('اللغة المطلوبة :', 'khebrat_theme'); ?></small>
                                            <span
                                                class="h6 mb-0 fw-normal ms-1"><?php echo get_post_meta($lsid, '_required_language', true) ?></span>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <small><?php echo esc_html__('عدد الأطراف:', 'khebrat_theme'); ?></small>
                                            <span
                                                class="h6 mb-0 fw-normal ms-1"><?php echo get_post_meta($lsid, '_party_count', true) ?></span>
                                        </div>
                                    </div>
                                </div>


                                <?php
                                $party_count = intval(get_post_meta($lsid, '_party_count', true));
                                $arabic_order = ['الأول', 'الثاني', 'الثالث', 'الرابع'];

                                if ($party_count > 0): ?>
                                    <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
                                        <?php for ($i = 1; $i <= $party_count; $i++):
                                            $role = get_post_meta($lsid, "_party_{$i}_role", true);
                                            if (!empty($role)): ?>
                                                <div class="col">
                                                    <div class="card shadow-sm border-0 h-100">
                                                        <div class="card-body d-flex align-items-center">
                                                            <div class="me-3">
                                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                    <i class="bi bi-person-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1">الطرف <?php echo $arabic_order[$i - 1]; ?></h6>
                                                                <p class="mb-0 text-muted"><?php echo esc_html($role); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php endif;
                                        endfor; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">لا توجد بيانات لأطراف القضية حتى الآن.</div>
                                <?php endif; ?>


                            </div>

                            <!-- Title -->


                            <div class="row">
                                <!-- List -->
                                <div class="col-sm-8">
                                    <div class="mb-2">
                                        <small><?php echo esc_html__('موضوع الطلب ', 'khebrat_theme'); ?></small>
                                        <p class="h6 fw-light mb-md-0"><?php echo get_field_meta($lsid, '_request_title', 'لا يوجد') ?></p>
                                    </div>

                                    <div class="mb-2">
                                        <small><?php echo esc_html__('موضوع الخدمة ', 'khebrat_theme'); ?></small>
                                        <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_case_subject', 'لا يوجد')); ?></div>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-sm-4 text-sm-end mt-3 mt-sm-auto">
                                    <h6 class="mb-1 fw-normal"></h6>
                                    <h2 class="mb-0 text-success"></h2>
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