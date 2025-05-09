<?php
//صفحة - كتابات قانونية  - لائحة نقض

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


$objection_date = get_post_meta($lsid, '_objection_date', true);
$formatted_date = $objection_date ? date_i18n('j F Y', strtotime($objection_date)) : 'غير محدد';
$objection_period_type = get_post_meta($lsid, '_objection_period_type', true);
$annulment_reasons = get_post_meta($lsid, '_annulment_reasons', true);
$reasons = [
    'sharia_violation'         => 'مخالفة أحكام الشريعة الإسلامية.',
    'invalid_court_formation'  => 'صدور الحكم من محكمة غير مشكلة تشكيلاً سليماً.',
    'non_competent_court'      => 'صدور الحكم من محكمة غير مختصة.',
    'fact_mischaracterization' => 'الخطأ في تكييف الواقعة.',
    'dont_know'                => 'لا أعلم.'
];


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
                            <h1 class="mb-0 fs-3"><?php echo $service_type . '  - لائحة نقض' ?></h1>
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
                                        <?php render_service_categories_display($lsid); ?>
                                    </div>


                                </div>


                                <div class="col-md-12">
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item"><?php echo esc_html__('مدعي أم مدعى عليه : ', 'khebrat_theme'); ?><span
                                                class="h6 fw-normal mb-0 ms-1"><?php echo $case_role ?></span></li>
                                        <?php
                                        if ($case_role == 'مدعي') {
                                            echo '<li class="list-group-item">' . esc_html__('صفة مقدم الطلب: ', 'khebrat_theme') . '<span class="h6 fw-normal mb-0 ms-1">' . get_post_meta($lsid, '_plaintiff_identity_type', true) . '</span></li>';
                                            echo '<li class="list-group-item">' . esc_html__('صفة الطرف الاخر: ', 'khebrat_theme') . '<span class="h6 fw-normal mb-0 ms-1">' . get_post_meta($lsid, '_defendant_identity_type_by_plaintiff', true) . '</span></li>';
                                        } elseif ($case_role == 'مدعى عليه') {
                                            echo '<li class="list-group-item">' . esc_html__('صفة مقدم الطلب: ', 'khebrat_theme') . '<span class="h6 fw-normal mb-0 ms-1">' . get_post_meta($lsid, '_defendant_identity_type', true) . '</span></li>';
                                            echo '<li class="list-group-item">' . esc_html__('صفة الطرف الاخر: ', 'khebrat_theme') . '<span class="h6 fw-normal mb-0 ms-1">' . get_post_meta($lsid, '_plaintiff_identity_type_by_defendant', true) . '</span></li>';
                                        }
                                        ?>
                                    </ul>

                                    <div class="card border rounded-3 mb-2">
                                        <div class="card-body p-3">
                                            <h5 class="card-title mb-3"><i class="bi bi-calendar-check me-2"></i>معلومات الجلسة</h5>
                                            <ul class="list-group list-group-flush">
                                                <!-- تاريخ بداية الاعتراض على الحكم حسب تاريخ صدور صك الحكم أو استلام الصك -->
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="bi bi-card-heading me-2"></i>تاريخ بداية الاعتراض على الحكم حسب تاريخ صدور صك الحكم أو استلام الصك</span>
                                                    <span class="fw-bold"><?php echo esc_html($formatted_date); ?></span>
                                                </li>
                                                <!-- مدة الاعتراض على الحكم حسب صك الحكم -->
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="bi bi-calendar-event me-2"></i>مدة الاعتراض على الحكم حسب صك الحكم</span>
                                                    <?php if ($objection_period_type == 'normal'): ?>
                                                        <span class="fw-bold">
                                                            فترة الاعتراض 30 يوم — حكم عادي.
                                                        </span>
                                                    <?php elseif ($objection_period_type == 'urgent'): ?>
                                                        <span class="fw-bold">
                                                            فترة الاعتراض 10 أيام — حكم مستعجل.
                                                        </span>
                                                    <?php endif; ?>
                                                </li>

                                                <!-- سبب النقض -->
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><i class="bi bi-calendar-event me-2"></i>سبب النقض</span>
                                                    <?php 
                                                    if (!empty($annulment_reasons) && isset($reasons[$annulment_reasons])) {
                                                        echo '<span class="fw-bold">' . esc_html($reasons[$annulment_reasons]) . '</span>';
                                                    }
                                                    ?>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Title -->


                            <div class="row">
                                <!-- List -->
                                <div class="col-sm-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4 text-primary"><i class="bi bi-file-earmark-text-fill me-2"></i>تفاصيل الدعوة</h5>
                                            <div class="mb-3 border-bottom pb-3">
                                                <small class="fs-6 d-block mb-1"><i class="bi bi-chat-left-text me-1"></i>عنوان الطلب</small>
                                                <p class="h6 fw-light mb-md-0"><?php echo get_field_meta($lsid, '_request_title', 'لا يوجد'); ?></p>
                                            </div>
                                            <div class="mb-3 border-bottom pb-3">
                                                <small class="fs-6 d-block mb-1"><i class="bi bi-journal-text me-1"></i>موضوع الدعوة</small>
                                                <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_case_subject', 'لا يوجد')); ?></div>
                                            </div>
                                            <div class="mb-3 border-bottom pb-3">
                                                <small class="fs-6 d-block mb-1"><i class="bi bi-journal-text me-1"></i>الجواب</small>
                                                <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_objection_reason', 'لا يوجد')); ?></div>
                                            </div>
                                            <div class="mb-3 border-bottom pb-3">
                                                <small class="fs-6 d-block mb-1"><i class="bi bi-journal-text me-1"></i>الاسانيد او الاثباتات</small>
                                                <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_legal_references', 'لا يوجد')); ?></div>
                                            </div>
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