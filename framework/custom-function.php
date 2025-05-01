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

function khebrat_time_since($post_id = null) {
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


function get_field_meta($post_id, $fieldName, $message = '')
{
    $post_meta = get_post_meta($post_id, $fieldName, true);

    if ($post_meta) {
        return $post_meta;
    } else {
        return $message;
    }
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


function has_user_offered_service($user_id, $service_id) {
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


        // إنشاء منشور جديد
        $new_post = array(
            'post_title'    => 'عرض بقيمة ' . $offer_price . ' ر.س', // يمكنك تغيير العنوان حسب رغبتك
            'post_content'  => $offer_details,
            'post_status'   => 'publish',
            'post_author'   => $current_user_id,
            'post_type'     => 'service_offers', // تأكد أن هذا post type موجود
            'post_parent'   => $service_id,
        );

        $post_id = wp_insert_post($new_post);

        if (is_wp_error($post_id)) {
            wp_send_json_error(['message' => 'حدث خطأ أثناء إنشاء العرض']);
        }


        // حفظ الحقول الإضافية
        update_post_meta($post_id, '_service_offer_price', $offer_price);
        update_post_meta($post_id, '_service_execution_time', $execution_time);
        update_post_meta($post_id, '_offer_status', 'active');
        

        // حفظ معرف الخدمة في user_meta
        $offered_services[] = $service_id;
        update_user_meta($current_user_id, '_offered_services', $offered_services);

        wp_send_json_success(['message' => 'تم إرسال العرض بنجاح']);
        wp_die();
    }
}



add_action('wp_ajax_handle_offer_action', 'handle_offer_action_callback');
function handle_offer_action_callback() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'يجب تسجيل الدخول.']);
    }

    $offer_id = intval($_POST['offer_id']);
    $action_type = sanitize_text_field($_POST['action_type']);

    if (!$offer_id || !in_array($action_type, ['accept', 'reject'])) {
        wp_send_json_error(['message' => 'بيانات غير صحيحة.']);
    }

    $offer = get_post($offer_id);
    if (!$offer || $offer->post_type !== 'service_offers') {
        wp_send_json_error(['message' => 'العرض غير موجود.']);
    }


    $new_status = ($action_type == 'accept') ? 'accepted' : 'rejected';
    update_post_meta($offer_id, '_service_offer_status', $new_status);


    if ($action_type === 'accept') {
        $parent_id = wp_get_post_parent_id($offer_id);

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
