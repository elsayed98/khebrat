<?php
//صفحة - طلبات التنفيذ

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



$execution_type = get_post_meta($lsid, '_execution_type', true);

$styles = [
    'financial' => [
        'label' => 'تنفيذ مالي',
        'desc' => 'ما كان محل الحكم والتنفيذ فيه مبلغ مالي موثق بسند تنفيذي يُعتد به',
        'icon' => 'bi-cash-coin',
        'bg' => 'linear-gradient(135deg, #007bff, #00c6ff)',
        'icon_color' => '#007bff'
    ],
    'personal_status' => [
        'label' => 'تنفيذ أحوال شخصية',
        'desc' => 'ما كان محل الحكم والتنفيذ فيه نفقة أو عوض أو سكن أو حضانة أو زيارة ونحوها مما كان أثراً لعقد النكاح',
        'icon' => 'bi-heart-pulse',
        'bg' => 'linear-gradient(135deg, #dc3545, #ff6f91)',
        'icon_color' => '#dc3545'
    ],
    'direct' => [
        'label' => 'تنفيذ مباشر',
        'desc' => 'ما كان محل الحكم والتنفيذ فيه فعلاً أو امتناعاً عن فعل لا يمكن أن يحل محله التنفيذ على المال مثلًا إخلاء العقار',
        'icon' => 'bi-house-door-fill',
        'bg' => 'linear-gradient(135deg, #198754, #28df99)',
        'icon_color' => '#198754'
    ],
];

$info = $styles[$execution_type] ?? [
    'label' => 'غير محدد',
    'desc' => 'لم يتم تحديد نوع السند التنفيذي.',
    'icon' => 'bi-question-circle',
    'bg' => 'linear-gradient(135deg, #6c757d, #adb5bd)',
    'icon_color' => '#6c757d'
];

$submitted = get_post_meta($lsid, '_submitted_to_enforcement_court', true);
$decision34 = get_post_meta($lsid, '_decision_34_issued', true);
$decision46 = get_post_meta($lsid, '_decision_46_issued', true);



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

                                <div class="col-md-12">
                                    <style>
                                        .execution-card {
                                            background: <?php echo $info['bg']; ?>;
                                        }

                                        .execution-card .top-bar {
                                            background-color: <?php echo $info['icon_color']; ?>;
                                        }
                                    </style>

                                    <div class="execution-card mb-4">
                                        <div class="top-bar"></div>
                                        <div class="overlay-icon">
                                            <i class="bi <?php echo $info['icon']; ?>"></i>
                                        </div>
                                        <div class="card-content">
                                            <div class="execution-title"><?php echo $info['label']; ?></div>
                                            <div class="execution-desc"><?php echo $info['desc']; ?></div>
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
                                            <h5 class="card-title mb-4 text-primary"><i class="bi bi-file-earmark-text-fill me-2"></i>تفاصيل السند التنفيذي</h5>
                                            <div class="mb-3 border-bottom pb-3">
                                                <small class="text-muted d-block mb-1"><i class="bi bi-chat-left-text me-1"></i>موضوع الطلب</small>
                                                <p class="h6 fw-light mb-md-0"><?php echo get_field_meta($lsid, '_request_title', 'لا يوجد'); ?></p>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block mb-1"><i class="bi bi-journal-text me-1"></i>موضوع السند التنفيذي</small>
                                                <div class="post-desc h6 fw-light"><?php echo esc_html(get_field_meta($lsid, '_case_subject', 'لا يوجد')); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    function render_execution_card($title, $status, $icon, $gradient)
                                    {
                                        $is_yes = ($status === 'yes');
                                        $text = $is_yes ? 'نعم، تم' : 'لا، لم يتم';
                                        $icon_class = $is_yes ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
                                        $text_color = $is_yes ? 'text-white' : 'text-light';
                                        $icon_color = $is_yes ? 'text-white' : 'text-light';

                                        return '
                                        <div class="col-md-4 mb-4">
                                            <div class="card border-0 text-white h-100" style="background: ' . $gradient . '; border-radius: 1rem; overflow: hidden;">
                                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="me-3">
                                                            <i class="bi ' . $icon_class . ' fs-3 ' . $icon_color . '"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">' . $title . '</h5>
                                                            <small class="' . $text_color . '">' . $text . '</small>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <i class="bi ' . $icon . ' fs-3 opacity-25"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                    ?>

                                    <div class="row">
                                        <?php
                                        echo render_execution_card(
                                            'تقديم الطلب لمحكمة التنفيذ',
                                            $submitted,
                                            'bi-bank',
                                            'linear-gradient(135deg, #007bff, #00c6ff)'
                                        );

                                        if ($submitted === 'yes') {
                                            echo render_execution_card(
                                                'صدور قرار ٣٤ على المنفذ ضده',
                                                $decision34,
                                                'bi-card-checklist',
                                                'linear-gradient(135deg, #6610f2, #b56eff)'
                                            );
                                        }

                                        if ($submitted === 'yes' && $decision34 === 'yes') {
                                            echo render_execution_card(
                                                'صدور قرار ٤٦ على المنفذ ضده',
                                                $decision46,
                                                'bi-shield-lock-fill',
                                                'linear-gradient(135deg, #198754, #28df99)'
                                            );
                                        }
                                        ?>
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