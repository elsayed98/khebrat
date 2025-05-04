<?php
//صفحة - الترافع والتوكيل

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
$is_financial_case   = get_post_meta($lsid, '_is_financial_case', true);
$total_claim_value   = get_post_meta($lsid, '_total_claim_value', true);
$claims_description  = get_post_meta($lsid, '_claims_description', true);
$lawyer_mandate_stage = get_post_meta($lsid, '_lawyer_mandate_stage', true);
$stage_labels = [
    'initial' => 'صدور الحكم الابتدائي فقط.',
    'until_final' => 'صدور الحكم الابتدائي والاعتراض إن لزم الأمر حتى يصبح الحكم قطعي.',
    'until_enforced' => 'صدور الحكم الابتدائي والاعتراض إن لزم الأمر حتى يصبح الحكم قطعي وتنفيذ الحكم.'
];

$stage_icons = [
    'initial' => 'gavel',
    'until_final' => 'file-earmark-text',
    'until_enforced' => 'check2-square'
];

$icon = $stage_icons[$lawyer_mandate_stage];
$label = $stage_labels[$lawyer_mandate_stage];


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
                                            <small><?php echo esc_html__('التخصص : ', 'khebrat_theme'); ?></small>
                                            <?php
                                            $terms = wp_get_object_terms($lsid, 'legal_category');
                                            if (!empty($terms) && !is_wp_error($terms)) {
                                                $term_names = wp_list_pluck($terms, 'name');
                                                echo '<span class="h6 mb-0 fw-normal ms-1">' . implode('، ', $term_names) . '</span>';
                                            } else {
                                                echo '<span class="h6 mb-0 fw-normal ms-1">' . esc_html('غير محدد') . '</span>';
                                            }
                                            ?>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <small><?php echo esc_html__('القضية تخص مطالبات مالية نقدية او عينية او تعويضات : ', 'khebrat_theme'); ?></small>
                                            <span
                                                class="h6 mb-0 fw-normal ms-1"><?php echo ($is_financial_case == 'yes') ? 'نعم' : 'لا'; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php if ($lawyer_mandate_stage) : ?>
                                        <div class="card border-start border-1 border-primary shadow-sm mb-2">
                                            <div class="card-body">
                                                <h6 class="card-title mb-1">
                                                    <i class="bi bi-<?php echo esc_attr($icon); ?> me-2 text-primary"></i><?php echo esc_html__('توكيل محامي للترافع حتى : ', 'khebrat_theme'); ?>
                                                </h6>
                                                <p class="card-text mb-0"><?php echo esc_html($label); ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
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
                                </div>
                            </div>
                            <!-- Title -->
                            <div class="row">
                                <!-- List -->
                                <div class="col-sm-12">
                                    <div class="mb-2">
                                        <small><?php echo esc_html__('موضوع الطلب', 'khebrat_theme'); ?></small>
                                        <p class="h6 fw-light mb-md-0"><?php echo get_field_meta($lsid, '_request_title', 'لا يوجد') ?></p>
                                    </div>

                                    <div class="mb-2">
                                        <small><?php echo esc_html__('موضوع القضية', 'khebrat_theme'); ?></small>
                                        <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_case_subject', 'لا يوجد')); ?></div>
                                    </div>
                                    <div class="mb-2">
                                        <small><?php echo esc_html__('الأشياء التي تبحث عنها إجابات لها من خلال هذه الدراسة : ', 'khebrat_theme'); ?></small>
                                        <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_case_questions', 'لا يوجد')); ?></div>
                                    </div>

                                    <?php if ($is_financial_case === 'yes') : ?>
                                        <div class="card border-0 shadow-sm mt-4">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>تفاصيل المطالبات المالية</h5>
                                                <span class="badge bg-light text-dark">معلومات هامة</span>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div><i class="bi bi-currency-dollar me-2 text-success"></i><strong>إجمالي المطالبات</strong></div>
                                                        <span class="fw-bold text-success"><?php echo number_format($total_claim_value); ?> ريال</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div><i class="bi bi-card-text me-2 text-info"></i><strong>وصف المطالبات</strong></div>
                                                        <p class="mb-0 mt-2"><?php echo nl2br(esc_html($claims_description)); ?></p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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