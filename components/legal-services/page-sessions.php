<?php
//صفحة - حضور الجلسات 

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
$has_previous_sessions = get_post_meta($lsid, '_has_previous_sessions', true);
$previous_sessions_count = get_post_meta($lsid, '_previous_sessions_count', true);



$is_remote_session = get_post_meta($lsid, '_is_remote_session', true);
$remote_label = ($is_remote_session === 'yes') ? 'نعم' : 'لا';

$session_date = get_post_meta($lsid, '_session_date', true);
$session_time = get_post_meta($lsid, '_session_time', true);
$session_location1 = get_post_meta($lsid, '_session_location_1', true);
$session_location2 = get_post_meta($lsid, '_session_location_2', true);
$formatted_date = $session_date ? date_i18n('j F Y', strtotime($session_date)) : 'غير محدد';

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
                                            <small><?php echo esc_html__('تم عقد جلسات على نفس القضية من قبل : ', 'khebrat_theme'); ?></small>
                                            <span
                                                class="h6 mb-0 fw-normal ms-1"><?php echo ($has_previous_sessions == 'yes') ? 'نعم' : 'لا'; ?></span>
                                        </div>
                                        <?php if ($has_previous_sessions == 'yes'): ?>
                                            <div class="col-md-12 mt-2">
                                                <small><?php echo esc_html__('عدد الجلسات : ', 'khebrat_theme'); ?></small>
                                                <span
                                                    class="h6 mb-0 fw-normal ms-1"><?php echo $previous_sessions_count; ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                               

                                <div class="card border rounded-3 mb-2">
                                    <div class="card-body p-3">
                                        <h5 class="card-title mb-3"><i class="bi bi-calendar-check me-2"></i>معلومات الجلسة</h5>

                                        <ul class="list-group list-group-flush">
                                            <!-- الحضور عن بعد -->
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span><i class="bi bi-laptop me-2"></i>هل الحضور عن بعد؟</span>
                                                <span class="fw-bold">
                                                    <?php echo ($is_remote_session === 'yes') ? 'نعم' : 'لا'; ?>
                                                </span>
                                            </li>

                                            <!-- التاريخ -->
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span><i class="bi bi-calendar-event me-2"></i>تاريخ الجلسة</span>
                                                <span class="fw-bold"><?php echo esc_html($formatted_date); ?></span>
                                            </li>

                                            <!-- الوقت -->
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span><i class="bi bi-clock me-2"></i>وقت الجلسة</span>
                                                <span class="fw-bold"><?php echo esc_html($session_time ?: 'غير محدد'); ?></span>
                                            </li>

                                            <!-- المكان فقط إذا كانت الجلسة حضورية -->
                                            <?php if ($is_remote_session === 'no' && $session_location2) :
                                                $child_term = get_term($session_location2, 'customer-locations');
                                                if (!is_wp_error($child_term) && $child_term) {
                                                    $child_name = $child_term->name;
                                                    $parent_name = '';
                                                    if ($child_term->parent) {
                                                        $parent_term = get_term($child_term->parent, 'customer-locations');
                                                        if (!is_wp_error($parent_term) && $parent_term) {
                                                            $parent_name = $parent_term->name;
                                                        }
                                                    }
                                            ?>
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <span><i class="bi bi-geo-alt-fill me-2"></i>مكان الجلسة</span>
                                                        <span class="fw-bold"><?php echo ($parent_name ? esc_html($parent_name) . ' - ' : '') . esc_html($child_name); ?></span>
                                                    </li>
                                            <?php }
                                            endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
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

                                <div class="col-md-6">
                                    <ul class="list-group list-group-borderless">

                                        <li class="list-group-item"></span></li>
                                        <li class="list-group-item"></span></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Title -->


                            <div class="row">
                                <!-- List -->
                                <div class="col-sm-12">
                                <div class="mb-2">
                                        <small><?php echo esc_html__('موضوع الطلب : ', 'khebrat_theme'); ?></small>
                                        <p class="h6 fw-light mb-md-0"><?php echo get_field_meta($lsid, '_request_title', 'لا يوجد') ?></p>
                                    </div>
                                    <div class="mb-2">
                                        <small><?php echo esc_html__('موضوع القضية : ', 'khebrat_theme'); ?></small>
                                        <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_case_subject', 'لا يوجد')); ?></div>
                                    </div>
                                    <div class="mb-2">
                                        <small><?php echo esc_html__('المطلوب من المحامي عمله في هذه الجلسة : ', 'khebrat_theme'); ?></small>
                                        <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_case_questions', 'لا يوجد')); ?></div>
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