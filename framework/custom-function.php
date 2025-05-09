<?php


// إنشاء الميتا بوكس عند استخدام قالب legal-services-form.php
add_action('add_meta_boxes', 'custom_service_meta_box');
function custom_service_meta_box()
{
    global $post;

    $template_file = get_post_meta($post->ID, '_wp_page_template', true);
    if ($template_file === 'legal-services-form.php') {
        add_meta_box(
            'service_details_box',
            'تفاصيل الخدمة',
            'render_service_fields',
            'page',
            'normal',
            'high'
        );
    }
}

// عرض الحقول داخل الميتا بوكس
function render_service_fields($post)
{
    $details = get_post_meta($post->ID, '_service_details', true);
    $price = get_post_meta($post->ID, '_service_price', true);
?>
    <div class="form-group">
        <label for="service_details"><strong>تفاصيل الخدمة:</strong></label>
        <textarea name="service_details" id="service_details" class="widefat" rows="5"><?php echo esc_textarea($details); ?></textarea>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <label for="service_price"><strong>سعر الخدمة (ر.س):</strong></label>
        <input type="number" name="service_price" id="service_price" class="widefat" value="<?php echo esc_attr($price); ?>" step="0.01" />
    </div>
    <?php
}

function khebrat_time_since($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $post_date = get_the_date('U', $post_id);
    $current_time = current_time('timestamp');

    if (!$post_date) {
        return '';
    }

    return 'منذ ' . human_time_diff($post_date, $current_time);
}


function khebrat_price_icon($post_id, $meta_key)
{
    $price = get_post_meta($post_id, $meta_key, true);

    if ($price !== '') {
        echo esc_html($price) . ' <i class="icon-saudi_riyal"></i>';
    } else {
        echo '<span class="text-muted">لا يوجد سعر</span>';
    }
}


// حفظ البيانات عند تحديث الصفحة
add_action('save_post', 'save_service_fields');
function save_service_fields($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['service_details'])) {
        update_post_meta($post_id, '_service_details', sanitize_textarea_field($_POST['service_details']));
    }

    if (isset($_POST['service_price'])) {
        update_post_meta($post_id, '_service_price', floatval($_POST['service_price']));
    }
}


function service_offer_status($post_id)
{
    $status = get_post_meta($post_id, '_service_offer_status', true);

    $statuses = [
        'accepted' => [
            'class' => 'success',
            'icon'  => 'bi-check-circle',
            'text'  => 'تم القبول '
        ],
        'rejected' => [
            'class' => 'danger',
            'icon'  => 'bi-x-circle',
            'text'  => 'تم الرفض '
        ],
        'pending' => [
            'class' => 'secondary',
            'icon'  => 'bi-hourglass-split',
            'text'  => 'قيد المراجعة '
        ]
    ];

    // إذا لم تكن القيمة محددة، نعتبرها pending
    $data = $statuses[$status] ?? $statuses['pending'];

    return sprintf(
        '<span class="badge bg-%s px-4 py-2"><i class="bi %s me-1"></i>%s</span>',
        esc_attr($data['class']),
        esc_attr($data['icon']),
        esc_html($data['text'])
    );
}



function get_field_meta($post_id, $fieldName, $message = '')
{
    $post_meta = get_post_meta($post_id, $fieldName, true);

    if ($post_meta) {
        return $post_meta;
    } else {
        return $message;
    }
}


function get_front_dashbord()
{
    global $khebrat_theme_options;
    return get_the_permalink($khebrat_theme_options['user_dashboard_page']);
}


add_action('wp_ajax_upload_pdf_to_media', 'upload_pdf_to_media_callback');
add_action('wp_ajax_nopriv_upload_pdf_to_media', 'upload_pdf_to_media_callback');

function upload_pdf_to_media_callback()
{
    // تحميل الملف إلى مكتبة الوسائط باستخدام media_handle_upload
    if (!function_exists('media_handle_upload')) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
    }

    if (!isset($_FILES['file'])) {
        wp_send_json_error(['message' => 'لم يتم إرسال الملف']);
    }

    $file_id = media_handle_upload('file', 0); // 0 = غير مرتبط بمنشور حالياً

    if (is_wp_error($file_id)) {
        wp_send_json_error(['message' => $file_id->get_error_message()]);
    }

    $file_url = wp_get_attachment_url($file_id);

    wp_send_json_success([
        'attachment_id' => $file_id,
        'url' => $file_url
    ]);
}



function khebrat_display_service_attachments($post_id = null)
{

    $pro_img_id = get_post_meta($post_id, '_project_attachment_ids', true);

    if (!empty($pro_img_id)) :
    ?>
        <div class="fr-project-attachments mb-5">
            <h5 class="mt-4"><?php echo esc_html__('Attachments', 'khebrat_theme'); ?></h5>
            <div class="row g-3">
                <?php
                if (fl_framework_get_options('show_project_attachment_public') == 0 && !is_user_logged_in()) :
                    global $khebrat_theme_options;
                    echo '<div class="col-12"><p><a href="' . esc_url(get_the_permalink($khebrat_theme_options['login_page']) . '?redirect=' . $post_id) . '" class="btn btn-primary">' . esc_html__('Login', 'khebrat_theme') . '</a> ' . esc_html__('to view attachments', 'khebrat_theme') . '</p></div>';
                else :
                    $attachment_arr = explode(',', $pro_img_id);
                    foreach ($attachment_arr as $value) :
                        $full_link = wp_get_attachment_url($value);
                        $file_path = get_attached_file($value);
                        $ext = wp_check_filetype($full_link);
                        $is_image = wp_attachment_is_image($value);

                        // اختيار الأيقونة حسب نوع الملف
                        if ($is_image) {
                            $icon = '<i class="bi bi-card-image fs-3"></i>';
                        } else {
                            $icon = '<i class="bi bi-file-earmark-text fs-3"></i>';
                        }
                ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center border rounded p-3 shadow-sm bg-white">
                                <div class="me-3 text-primary">
                                    <?php echo $icon; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" title="<?php echo esc_attr(get_the_title($value)) . '.' . $ext['ext']; ?>">
                                        <?php echo wp_trim_words(get_the_title($value), 7, '...') . '.' . esc_html($ext['ext']); ?>
                                    </h6>
                                    <small class="text-muted"><?php echo esc_html__('File size:', 'khebrat_theme') . ' ' . size_format(filesize($file_path)); ?></small>
                                </div>
                                <div class="ms-3">
                                    <a href="<?php echo esc_url($full_link); ?>" download class="btn btn-primary btn-round mb-0">
                                        <i class="bi bi-cloud-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    <?php
    endif;
}


function khebrat_display_offer_modal($lsid)
{
    ob_start();
    ?>
    <div class="modal fade" id="offer" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="offerModalLabel">عرض الملف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="offer_form">
                        <!-- حقل معرف المنشور -->
                        <input type="hidden" name="service_id" value="<?php echo esc_attr($lsid); ?>">

                        <!-- مدة التنفيذ وقيمة العرض بجانب بعض -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="service_execution_time" class="form-label">مدة التنفيذ (بالأيام)</label>
                                <input type="number" class="form-control" id="service_execution_time" name="service_execution_time" required placeholder="أدخل مدة التنفيذ">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service_offer_price" class="form-label">قيمة العرض (ر.س)</label>
                                <input type="number" class="form-control" id="service_offer_price" name="service_offer_price" required placeholder="أدخل قيمة العرض">
                            </div>
                        </div>

                        <!-- تفاصيل العرض -->
                        <div class="mb-3">
                            <label for="offer_details" class="form-label">تفاصيل العرض</label>
                            <textarea class="form-control" id="offer_details" name="offer_details" rows="4" required placeholder="أدخل تفاصيل العرض"></textarea>
                        </div>

                        <!-- زر الإرسال -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-primary w-100" id="create_offer_btn">إرسال العرض</button>
                            <input type="hidden" id="create_offer_nonce" value="<?php echo wp_create_nonce('fl_create_offer_secure'); ?>" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}


function render_service_categories_display($post_id)
{
    $parent_id = get_post_meta($post_id, '_parent_service_category', true);
    $child_ids = get_post_meta($post_id, '_child_service_category_ids', true);
    $taxonomy = 'legal_category';

    if ($parent_id || (!empty($child_ids) && is_array($child_ids))) {
        echo '<div class="border rounded p-2 mt-2">';
        echo '<h6 class="mb-2 text-dark">التخصص 🧷</h6>';

        // التصنيف الأب بشكل مميز
        if ($parent_id) {
            $parent_term = get_term($parent_id, $taxonomy);
            if (!is_wp_error($parent_term)) {
                echo '<div class="mb-2">';
                echo '<span class="badge bg-primary fs-6 p-2 px-3">' . esc_html($parent_term->name) . '</span>';
                echo '</div>';
            }
        }

        // التصنيفات الأبناء على شكل Tags
        if (!empty($child_ids) && is_array($child_ids)) {
            $child_terms = get_terms([
                'taxonomy' => $taxonomy,
                'include' => $child_ids,
                'hide_empty' => false,
            ]);

            if (!is_wp_error($child_terms)) {
                echo '<div class="d-flex flex-wrap gap-2">';
                foreach ($child_terms as $term) {
                    echo '<span class="badge rounded-pill p-2 bg-info border">' . esc_html($term->name) . '</span>';
                }
                echo '</div>';
            }
        }

        echo '</div>';
    }
}



function has_user_offered_service($user_id, $service_id)
{
    if (!$user_id || !$service_id) {
        return false;
    }

    $offered_services = get_user_meta($user_id, '_offered_services', true);

    return (is_array($offered_services) && in_array($service_id, $offered_services));
}



add_action('wp_ajax_offer_services', 'fl_offer_services');
if (!function_exists('fl_offer_services')) {
    function fl_offer_services()
    {
        check_ajax_referer('fl_create_offer_secure', 'security');

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'يجب تسجيل الدخول']);
        }

        $current_user_id = get_current_user_id();
        $params = [];
        parse_str($_POST['offer_data'], $params);

        $service_id = intval($params['service_id']);
        $execution_time = sanitize_text_field($params['service_execution_time']);
        $offer_price = sanitize_text_field($params['service_offer_price']);
        $offer_details = wp_kses_post($params['offer_details']);
        $service_author = get_post_field('post_author', $service_id); // صاحب الخدمة الأصلية

        // إنشاء منشور جديد
        $new_post = array(
            'post_title'    => 'عرض بقيمة ' . $offer_price . ' ر.س', // يمكنك تغيير العنوان حسب رغبتك
            'post_content'  => $offer_details,
            'post_status'   => 'publish',
            'post_author'   => $current_user_id,
            'post_type'     => 'service_offers',
            'post_parent'   => $service_id,
        );

        $post_id = wp_insert_post($new_post);

        if (is_wp_error($post_id)) {
            wp_send_json_error(['message' => 'حدث خطأ أثناء إنشاء العرض']);
        }


        // حفظ الحقول الإضافية
        update_post_meta($post_id, '_service_offer_price', $offer_price);
        update_post_meta($post_id, '_service_execution_time', $execution_time);
        update_post_meta($post_id, '_service_offer_status', 'pending');

        do_action('khebrat_notification_filter', array(
            'post_id' => $service_id,
            'n_type' => 'send_offer',
            'sender_id' => $current_user_id,
            'receiver_id' => $service_author,
            'sender_type' => 'lawyer'

        ));

        // حفظ معرف الخدمة في user_meta
        $offered_services[] = $service_id;
        update_user_meta($current_user_id, '_offered_services', $offered_services);

        wp_send_json_success(['message' => 'تم إرسال العرض بنجاح']);
        wp_die();
    }
}



add_action('wp_ajax_handle_offer_action', 'handle_offer_action_callback');
function handle_offer_action_callback()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'يجب تسجيل الدخول.']);
    }
    $current_user_id = get_current_user_id();

    $offer_id = intval($_POST['offer_id']);
    $action_type = sanitize_text_field($_POST['action_type']);

    if (!$offer_id || !in_array($action_type, ['accept', 'reject'])) {
        wp_send_json_error(['message' => 'بيانات غير صحيحة.']);
    }
    $offer_author =  get_post_field('post_author', $offer_id);

    $offer = get_post($offer_id);
    if (!$offer || $offer->post_type !== 'service_offers') {
        wp_send_json_error(['message' => 'العرض غير موجود.']);
    }


    $new_status = ($action_type == 'accept') ? 'accepted' : 'rejected';
    update_post_meta($offer_id, '_service_offer_status', $new_status);


    if ($action_type === 'accept') {
        $parent_id = wp_get_post_parent_id($offer_id);
        do_action('khebrat_notification_filter', array(
            'post_id' => $parent_id,
            'n_type' => 'accept_offer',
            'sender_id' => $current_user_id,
            'receiver_id' => $offer_author,
            'sender_type' => 'customer'

        ));

        update_post_meta($parent_id, '_accepted_offer', $offer_id);
        update_post_meta($parent_id, '_legal_services_status', 'progress');

        if ($parent_id) {
            $other_offers = get_posts([
                'post_type'      => 'service_offers',
                'post_parent'    => $parent_id,
                'post_status'    => 'publish',
                'numberposts'    => -1,
                'post__not_in'   => [$offer_id],
            ]);

            foreach ($other_offers as $other_offer) {
                update_post_meta($other_offer->ID, '_service_offer_status', 'rejected');
            }
        }
    }

    $message = ($action_type === 'accept') ? 'تم قبول العرض، .' : 'تم رفض العرض بنجاح.';
    wp_send_json_success(['message' => $message]);
}


/*
add_action('wp_ajax_change_legal_consultation_status', 'change_legal_consultation_status_callback');
function change_legal_consultation_status_callback()
{
    $post_id = intval($_POST['post_id']);
    $new_status = sanitize_text_field($_POST['new_status']);
    $current_user_id = get_current_user_id();

    $user_lawyer_id = get_user_meta($current_user_id, 'lawyer_id', true);

    $author_id = get_post_field('post_author', $post_id);

    $lawyer_id = get_post_meta($post_id, '_lawyer_id', true);
   
    // شرط حالة بدء الاستشارة (processing)
    if ($new_status === 'processing') {
       
        if ($lawyer_id != $user_lawyer_id) {
            wp_send_json_error(['message' => 'ليس لديك صلاحية لبدء هذه الاستشارة']);
        }
        do_action('khebrat_notification_filter', array(
            'post_id' => $post_id,
            'n_type' => 'start_consul',
            'sender_id' => $current_user_id,
            'receiver_id' => $author_id,
            'sender_type' => 'lawyer'
        ));
    }

    if (get_post_type($post_id) == 'legal_consultation') {

        $author_lawyer_id = get_post_field('post_author', $lawyer_id);
         // شرط حالة إنهاء الاستشارة (completed)
        if ($new_status === 'completed') {
            if ($current_user_id != $author_id) {
                wp_send_json_error(['message' => 'فقط صاحب الطلب يمكنه إنهاء الاستشارة']);
            }
            do_action('khebrat_notification_filter', array(
                'post_id' => $post_id,
                'n_type' => 'completed_consul',
                'sender_id' => $current_user_id,
                'receiver_id' => $author_lawyer_id,
                'sender_type' => 'customer'
            ));
        }

        update_post_meta($post_id, '_legal_consultation_status', $new_status);
        $status_messages = [
            'processing' => 'تم بدء الاستشارة',
            'completed'  => 'تم إنهاء الاستشارة'
        ];

    } elseif (get_post_type($post_id) == 'legal_services') {
        $offer_id = get_post_meta($post_id, '_accepted_offer', true);
        $author_offer_id = get_post_field('post_author', $offer_id);

        // شرط حالة إنهاء الخدمة (completed)
        if ($new_status === 'completed') {
            if ($current_user_id != $author_id) {
                wp_send_json_error(['message' => 'فقط صاحب الطلب يمكنه إنهاء الاستشارة']);
            }
            do_action('khebrat_notification_filter', array(
                'post_id' => $post_id,
                'n_type' => 'completed_service',
                'sender_id' => $current_user_id,
                'receiver_id' => $author_offer_id,
                'sender_type' => 'customer'
            ));
        }
        update_post_meta($post_id, '_legal_services_status', $new_status);
        $status_messages = [
            'processing' => 'تم بدء الطلب',
            'completed'  => 'تم اكتمال الطلب '
        ];
    }



    wp_send_json_success([
        'message' => $status_messages[$new_status] ?? 'تم التحديث'
    ]);
}
*/

add_action('wp_ajax_change_legal_consultation_status', 'change_legal_consultation_status_callback');
function change_legal_consultation_status_callback()
{
    if (empty($_POST['post_id']) || empty($_POST['new_status'])) {
        wp_send_json_error(['message' => 'بيانات غير مكتملة']);
    }

    $post_id        = intval($_POST['post_id']);
    $new_status     = sanitize_text_field($_POST['new_status']);
    $current_user   = get_current_user_id();
    $post_author_id = get_post_field('post_author', $post_id);

    // تعريف الرسائل المحتملة
    $status_messages = [
        'processing' => 'تم بدء العملية',
        'completed'  => 'تم إنهاء العملية', 
    ];

    // الاستشارة القانونية
    if (get_post_type($post_id) == 'legal_consultation') {

        $lawyer_post_id = get_post_meta($post_id, '_lawyer_id', true); // معرف منشور المحامي
        $lawyer_user_id = get_post_field('post_author', $lawyer_post_id); // مؤلف المنشور = المحامي
        $user_lawyer_id = get_user_meta($current_user, 'lawyer_id', true); // الملف المرتبط بالمستخدم

        if ($new_status == 'processing') {
            // تحقق من أن المحامي الحالي هو نفسه المعين في الاستشارة
            if ((int)$lawyer_post_id !== (int)$user_lawyer_id) {
                wp_send_json_error(['message' => 'ليس لديك صلاحية لبدء هذه الاستشارة']);
            }

            do_action('khebrat_notification_filter', [
                'post_id'     => $post_id,
                'n_type'      => 'start_consul',
                'sender_id'   => $current_user,
                'receiver_id' => $post_author_id,
                'sender_type' => 'lawyer'
            ]);

            $status_messages['processing'] = 'تم بدء الاستشارة';

        } elseif ($new_status == 'completed') {
            if ($current_user != $post_author_id) {
                wp_send_json_error(['message' => 'فقط صاحب الطلب يمكنه إنهاء الاستشارة']);
            }

            do_action('khebrat_notification_filter', [
                'post_id'     => $post_id,
                'n_type'      => 'completed_consul',
                'sender_id'   => $current_user,
                'receiver_id' => $lawyer_user_id,
                'sender_type' => 'customer'
            ]);

            $status_messages['completed'] = 'تم إنهاء الاستشارة';
        }

        update_post_meta($post_id, '_legal_consultation_status', $new_status);
    }

    // الخدمات القانونية
    elseif (get_post_type($post_id) == 'legal_services') {

        $offer_id         = get_post_meta($post_id, '_accepted_offer', true); // العرض المقبول
        $offer_author_id  = get_post_field('post_author', $offer_id); // مقدم العرض

        if ($new_status == 'completed') {
            if ($current_user != $post_author_id) {
                wp_send_json_error(['message' => 'فقط صاحب الطلب يمكنه إنهاء الخدمة']);
            }

            do_action('khebrat_notification_filter', [
                'post_id'     => $post_id,
                'n_type'      => 'completed_service',
                'sender_id'   => $current_user,
                'receiver_id' => $offer_author_id,
                'sender_type' => 'customer'
            ]);

            $status_messages['completed'] = 'تم اكتمال الطلب';
        }

        update_post_meta($post_id, '_legal_services_status', $new_status);
    }

    // الرد النهائي
    wp_send_json_success([
        'message' => $status_messages[$new_status] ?? 'تم التحديث'
    ]);
}





add_action('wp_ajax_load_services', 'load_services_callback');
add_action('wp_ajax_nopriv_load_services', 'load_services_callback');

function load_services_callback()
{
    global $khebrat_theme_options;

    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'active';
    $paged  = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type'      => 'legal_services', // عدّل حسب نوع المنشور
        'posts_per_page' => 5,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => '_legal_services_status', // ← غيّره إذا كانت الميتا لها اسم مختلف
                'value'   => $status,
                'compare' => '='
            )
        )

    );

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();


            $order_id = get_the_ID();
            $service_type_id = get_post_meta($order_id, '_service_type', true);
            $service_type = get_the_title($service_type_id);
            $specialization = get_post_meta($order_id, '_specialization', true);
            $price = get_post_meta($order_id, '_price', true);
            $services_status = get_post_meta($order_id, '_legal_services_status', true);
            $order_date = get_the_date('d M Y');
    ?>
            <div class="card border p-2 mb-3">
                <div class="row g-4">

                    <!-- Card body -->
                    <div class="col-md-9 col-lg-12">
                        <div class="card-body position-relative d-flex flex-column p-0 h-100">

                            <!-- رقم الطلب -->
                            <div class="list-inline-item dropdown position-absolute top-0 end-0">
                                <small><?php echo esc_html__('طلب رقم : ', 'khebrat_theme'); ?>#<?php echo esc_html($order_id); ?></small>
                            </div>

                            <!-- عنوان المنشور -->
                            <h6 class="card-title mb-0 me-8"><?php echo get_the_title(); ?></h6>

                            <!-- تفاصيل -->
                            <ul class="list-group list-group-borderless mb-0">
                                <li class="list-group-item"><?php echo esc_html__('تاريخ الطلب : ', 'khebrat_theme'); ?>
                                    <span class="h6 mb-0 fw-normal ms-1"><?php echo esc_html($order_date); ?></span>
                                </li>
                                <li class="list-group-item"><?php echo esc_html__('نوع الخدمة : ', 'khebrat_theme'); ?>
                                    <span class="h6 mb-0 fw-normal ms-1"><?php echo esc_html($service_type_id ? $service_type : 'غير محدد'); ?></span>
                                </li>
                                <li class="list-group-item"><?php echo esc_html__('التخصص : ', 'khebrat_theme'); ?>
                                    <?php
                                    $terms = wp_get_object_terms($order_id, 'legal_category');

                                    if (!empty($terms) && !is_wp_error($terms)) {
                                        $term_names = wp_list_pluck($terms, 'name');
                                        echo '<span class="h6 mb-0 fw-normal ms-1">' . implode('، ', $term_names) . '</span>';
                                    } else {
                                        echo '<span class="h6 mb-0 fw-normal ms-1">' . esc_html('غير محدد') . '</span>';
                                    }
                                    ?>
                                </li>
                            </ul>

                            <!-- السعر والزر -->
                            <div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                <div class="d-flex align-items-center">
                                    <h6 class=" mb-0 me-1"><?php echo esc_html__('عروض : ', 'khebrat_theme'); ?></h6>
                                </div>
                                <div class="hstack gap-2 mt-3 mt-sm-0">
                                    <?php if ($services_status == 'active'): ?>
                                        <a href="<?php echo esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])); ?>?ext=service-offers&sfid=<?php echo esc_html($order_id); ?>" class="btn btn-sm btn-success mb-0"><?php echo esc_html__('مشاهدة العروض', 'khebrat_theme'); ?></a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])); ?>?ext=service-detail&lsid=<?php echo esc_html($order_id); ?>" class="btn btn-sm btn-success mb-0"><?php echo esc_html__('دخول الخدمة', 'khebrat_theme'); ?></a>
                                    <?php endif; ?>
                                    <a href="<?php echo get_permalink(); ?>" class="btn btn-sm btn-outline-success mb-0"><?php echo esc_html__('تفاصيل الطلب', 'khebrat_theme'); ?></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    } else {
        if ($paged === 1) {
            echo '<p class="text-center text-muted">لا توجد نتائج</p>';
        }
    }
    $html = ob_get_clean();

    wp_send_json([
        'html' => $html,
        'has_more' => $query->max_num_pages > $paged,
    ]);
}




add_action('wp_ajax_load_legal_consultations', 'load_legal_consultations_callback');
add_action('wp_ajax_nopriv_load_legal_consultations', 'load_legal_consultations_callback');

function load_legal_consultations_callback() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $html = query_post(['paged' => $paged]);

    // كشف إذا كان هناك المزيد من الصفحات
    $args = [
        'post_type'      => 'legal_consultation',
        'posts_per_page' => 5,
        'paged'          => $paged + 1,
        'post_status'    => 'publish',
    ];

    $current_user_id = get_current_user_id();
    $lawyer_id = get_user_meta($current_user_id, 'lawyer_id', true);
    if ($lawyer_id) {
        $args['meta_query'] = [[ 'key' => '_lawyer_id', 'value' => $lawyer_id ]];
    } else {
        $args['author'] = $current_user_id;
    }

    $has_more = (new WP_Query($args))->have_posts();

    wp_send_json([
        'html' => $html,
        'has_more' => $has_more
    ]);
}

function query_post($args = []) {
    $defaults = array(
        'post_type'      => 'legal_consultation',
        'posts_per_page' => -1,
        'paged'          => 1,
        'post_status'    => 'publish',
    );

    $current_user_id = get_current_user_id();
    $lawyer_id = get_user_meta($current_user_id, 'lawyer_id', true);

    if ($lawyer_id) {
        $defaults['meta_query'] = array(
            array(
                'key'   => '_lawyer_id',
                'value' => $lawyer_id,
            ),
        );
    } else {
        $defaults['author'] = $current_user_id;
    }

    $args = wp_parse_args($args, $defaults);
    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $consul_status = get_post_meta(get_the_ID(), '_legal_consultation_status', true);
            switch ($consul_status) {
                case 'active':
                    $status_label = 'نشط';
                    break;
                case 'completed':
                    $status_label = 'مكتمل';
                    break;
                case 'processing':
                    $status_label = 'قيد التنفيذ';
                    break;
                default:
                    $status_label = 'غير محدد';
                    break;
            }
            ?>
            <div class="card border p-2 mb-4">
                <div class="row g-4">
                    <div class="col-md-12 col-lg-12">
                        <div class="card-body position-relative d-flex flex-column p-0 h-100">

                            <!-- Buttons -->
                            <div class="list-inline-item dropdown position-absolute top-0 end-0">
                                <div class="badge bg-info bg-opacity-10 text-info"><?php echo $status_label; ?></div>
                            </div>

                            <!-- Title -->
                            <h5 class="card-title mb-0 me-5"><?php the_title(); ?></h5>
                            <!-- تاريخ النشر -->
                            <small><i class="bi bi-geo-alt me-2"></i><?php echo get_the_date(); ?></small>
                            <?php
                            $terms = wp_get_object_terms(get_the_ID(), 'legal_category');

                            if (!empty($terms) && !is_wp_error($terms)) {
                                $term_names = wp_list_pluck($terms, 'name');
                                echo '<small>التصنيف : ' . implode('، ', $term_names) . '</small>';
                            } else {
                                echo '<small>لا يوجد تصنيف</small>';
                            }
                            ?>

                            <!-- السعر والزرار -->
                            <div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                <div class="d-flex align-items-center">
                                    <h5 class="fw-bold mb-0 me-1">
                                        <?php khebrat_price_icon(get_the_ID(), '_consultation_price'); ?>
                                    </h5>
                                </div>

                                <div class="hstack gap-2 mt-3 mt-sm-0">
                                    <a href="?ext=consultations-detail&cid=<?php echo get_the_ID(); ?> " class="btn btn-sm btn-primary mb-0">
                                        <i class="bi bi-arrow-down-left-square fa-fw me-1"></i>دخول الاستشارة
                                    </a>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary mb-0">
                                        <?php echo esc_html__('التفاصيل', 'khebrat_theme'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        echo '<div class="alert alert-warning">لا توجد نتائج</div>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
