<?php global $khebrat_theme_options;
$current_user_id = get_current_user_id();

if (!isset($_GET['offer_id']) || !is_numeric($_GET['offer_id'])) {
    get_template_part('template-parts/dashboard/layouts-3/services/services');
    exit;
}

$offer_id   = intval($_GET['offer_id']);
$offer_post = get_post($offer_id);
$status     = get_post_meta($offer_id, '_service_offer_status', true);

$offer_author_id = $offer_post->post_author;
$lawyer_id = get_user_meta($offer_author_id, 'lawyer_id', true);
$lawyer_name = exertio_get_username('lawyer', $lawyer_id);

$service_id = wp_get_post_parent_id($offer_id);

$parent_author_id = get_post_field('post_author', $service_id);

$child_offers = get_posts([
    'post_type'   => 'service_offers',         // ← نوع المنشور: غيّره حسب اسم post type الفعلي للعروض
    'post_parent' => $service_id,      // ← ID منشور الخدمة (الأب)
    'post_status' => 'publish',       // ← فقط المنشورات المنشورة
    'post__not_in'   => [$offer_id],
    'numberposts' => -1               // ← جلب جميع العروض دون حد أقصى
]);



$service_type_id = get_post_meta($service_id, '_service_type', true);
$service_type       = get_the_title($service_type_id);
$specialization = get_post_meta($service_id, '_specialization', true); // التخصص
// التحقق من وجود المنشور

if (!$offer_post) {
    get_template_part('template-parts/dashboard/layouts-3/services/services');
    exit;
}

// التحقق من نوع المنشور (عدّله حسب نوع العرض لديك)
if ($offer_post->post_type !== 'service_offers') {
    get_template_part('template-parts/dashboard/layouts-3/services/services');
    exit;
}

// التحقق إذا كان العرض منشور ابن

if (!$service_id) {
    get_template_part('template-parts/dashboard/layouts-3/services/services');
    exit;
}

// جلب مؤلف العرض ومؤلف الخدمة الأصلية
if ($parent_author_id != $current_user_id) {
    get_template_part('template-parts/dashboard/layouts-3/services/services');
    exit;
}
/*
if ($offer_author_id != $current_user_id) {
    get_template_part('template-parts/dashboard/layouts-3/services/services');
    exit;
}
*/


/*
echo '<div class="alert alert-success">';
echo '✅ معرف العرض: ' . esc_html($offer_id) . '<br>';
echo '👤 مؤلف العرض: ' . esc_html($offer_author_id) . '<br>';
echo '📄 معرف الخدمة الأصلية: ' . esc_html($service_id) . '<br>';
echo '👤 مؤلف الخدمة الأصلية: ' . esc_html($parent_author_id);
echo '</div>';

foreach ($child_offers as $offer) {
    echo '<h4>' . esc_html(get_the_title($offer)) . '</h4>';
    echo '<h4>' . esc_html(get_post_meta($offer->ID, '_service_offer_status', true)) . '</h4>';
    echo '<p>' . esc_html(wp_trim_words($offer->post_content, 20)) . '</p>';
    echo '<hr>';
}
*/
?>

<div class="vstack gap-4">
    <!-- Review START -->
    <div class="row">
        <div class="col-12">
            <div class="card border rounded-3">
                <!-- Card header START -->
                <div class="card-header border-bottom">
                    <div class="row g-4 align-items-center">
                        <!-- Cotent -->
                        <div class="col-md-6 order-md-2">
                            <!-- Title -->
                            <h5><?php echo esc_html__(' الخدمة : ', 'khebrat_theme'); ?><?php echo esc_html(get_the_title($service_id)); ?></h5>

                            <!-- تفاصيل -->
                            <ul class="list-group list-group-borderless mb-0">
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
                <!-- Card header END -->

                <!-- Card body START -->
                <div class="card-body">
                    <div class="bg-light rounded p-3">
                        <!-- Review item START -->
                        <div class="d-sm-flex justify-content-between">
                            <!-- Avatar image -->
                            <div class="d-sm-flex align-items-center mb-3">
                                <?php echo get_profile_img($lawyer_id, "lawyer", "avatar avatar-md rounded-circle float-start me-3"); ?>
                                <!-- Title -->
                                <div>
                                    <h6 class="m-0"><?php echo esc_html($lawyer_name); ?></h6>
                                    <span class="me-3 small"><?php echo khebrat_time_since($offer_id); ?></span>
                                </div>
                            </div>

                        </div>

                        <div>
                            <!-- مدة التنفيذ -->
                            <div class="alert alert-info d-flex justify-content-between align-items-center mb-2">
                                <span class="h6 fw-normal mb-0"><i class="bi bi-clock fa-fw me-2"></i><?php echo esc_html__('مدة التنفيذ : ', 'khebrat_theme'); ?></span>
                                <span><?php echo get_post_meta($offer_id, '_service_execution_time', true); ?> ايام </span>
                            </div>

                            <!-- قيمة العرض -->
                            <div class="alert alert-info d-flex justify-content-between align-items-center">
                                <span class="h6 fw-normal mb-0"><i class="bi bi-cash-coin fa-fw me-2"></i><?php echo esc_html__('قيمة العرض : ', 'khebrat_theme'); ?></span>
                                <span><?php khebrat_price_icon($offer_id, '_service_offer_price'); ?></span>
                            </div>
                        </div>

                        <!-- Content -->
                        <h6 class="fw-normal"><?php echo esc_html__('تفاصيل العرض : ', 'khebrat_theme'); ?></h6>
                        <?php echo apply_filters('the_content', $offer_post->post_content); ?>

                        <div class="status-output mb-2" id="offer-status-<?php echo $offer_id; ?>">
                            <?php if ($status == 'accepted'): ?>
                                <div class="alert alert-success">تم قبول هذا العرض</div>
                            <?php elseif ($status == 'rejected'): ?>
                                <div class="alert alert-danger">تم رفض هذا العرض</div>
                            <?php endif; ?>
                        </div>

                        <?php if ($status == 'pending'): ?>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-success me-md-2 btn-offer-action"
                                    data-id="<?php echo $offer_id; ?>"
                                    data-action="accept"><?php echo esc_html__('قبول العرض', 'khebrat_theme'); ?></button>
                                <button class="btn btn-danger-soft btn-offer-action"
                                    data-id="<?php echo $offer_id; ?>"
                                    data-action="reject"><?php echo esc_html__('رفض العرض', 'khebrat_theme'); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
                <!-- Card body END -->


            </div>
        </div>
    </div>
    <!-- Review END -->
</div>