<?php global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$service_id = $_GET['lsid'];




if (is_user_logged_in()) {
    $lawyer_id = get_user_meta($current_user_id, 'customer_id', true);
    $customer_id = get_user_meta($current_user_id, 'customer_id', true);



    if (isset($_GET['lsid']) && !empty($_GET['lsid'])) {
        $cust_id = get_post_field('post_author', $service_id);
        $customer_id_msg = get_user_meta($cust_id, 'customer_id', true);;

        $lawyer_id_msg = get_post_meta($service_id, '_lawyer_id', true);

        $service_status = get_post_meta($service_id, '_legal_services_status', true);
        switch ($service_status) {
            case 'active':
                $status_label = 'نشط';
                break;
            case 'completed':
                $status_label = 'مكتمل';
                break;
            case 'progress':
                $status_label = 'قيد التنفيذ';
                break;
            default:
                $status_label = 'غير محدد';
                break;
        }

        if ($customer_id_msg == $customer_id) {
?>
            <div class="content-wrapper p-0">
                <div class="notch"></div>

                <div class="glass-card p-5 mb-5 animate__animated animate__fadeIn">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-journal-text fs-3 text-primary"></i>
                            <h2 class="fs-3 mb-0">تفاصيل الطلب</h2>
                        </div>
                        <div>
                            <span class="badge status-badge px-4 py-2 rounded-pill">
                                <?php echo esc_html($status_label); ?>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-dark fw-bold"><?php echo get_the_title($service_id); ?></h5>
                        <div class="mt-3">
                            <?php
                            $terms = wp_get_object_terms($service_id, 'legal_category');
                            if (!empty($terms) && !is_wp_error($terms)) {
                                foreach ($terms as $term) {
                                    echo '<span class="badge bg-light text-dark border me-2 mb-2 px-3 py-2 rounded-pill shadow-sm">' . esc_html($term->name) . '</span>';
                                }
                            } else {
                                echo '<span class="text-muted">لا يوجد تصنيف</span>';
                            }
                            ?>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-muted mb-0"><i class="bi bi-person-lines-fill me-2"></i>تفاصيل المحامي</h5>
                        <?php if ($service_status == 'progress') : ?>
                            <button class="vip-btn btn-consultation-action" data-id="<?php echo esc_attr($service_id); ?>" data-status="completed" data-posttype="<?php echo get_post_type(get_the_ID()); ?>">
                                <i class="bi bi-check2-circle me-2"></i> تعليم كمكتمل 
                            </button>
                        <?php elseif ($service_status == 'active') : ?>

                            <div class="alert alert-danger" role="alert">
                               لم تيم بدا الطلب من قبل المحامي بعد !
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($service_status != 'active') : ?>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card services ongoing-services-details">
                            <div class="card mb-4 shadow">
                                <div class="card-body">

                                    <?php
                                    if (fl_framework_get_options('turn_services_messaging') == true) {
                                    ?>
                                        <!--PROJECT HISTORY-->
                                        <div class="project-history">
                                            <div class="history-body border rounded p-3">
                                                <div class="history-chat-body">
                                                    <?php
                                                    $messages = get_service_msg($service_id);
                                                    if ($messages) {
                                                        foreach ($messages as $message) {
                                                            $msg_author = get_user_meta($current_user_id, 'customer_id', true);

                                                            if ($msg_author == $message->msg_sender_id) {
                                                    ?>

                                                                <!-- رسالة مرسلة -->
                                                                <div class="d-flex align-items-start mb-3">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <?php echo get_profile_img($message->msg_sender_id, 'customer', 'avatar-img rounded-circle'); ?>
                                                                    </div>

                                                                    <div>
                                                                        <div class="bg-info text-dark p-2 rounded-3">
                                                                            <small class="text-light d-block">
                                                                                <a href="<?php echo get_the_permalink($message->msg_sender_id); ?>" class="history-username"></a>
                                                                                <?php echo exertio_get_username('customer', $message->msg_sender_id, 'badge', 'right'); ?>
                                                                            </small>
                                                                            <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                                            <?php
                                                                            if ($message->attachment_ids > 0) {
                                                                            ?>
                                                                                <div class="history_attch_dwld btn-loading" id="download-files" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
                                                                                    <i class="fas fa-arrow-down"></i>
                                                                                    <?php echo esc_html__('Attachments', 'khebrat_theme'); ?>
                                                                                    <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <small class="text-muted"><?php echo time_ago_function($message->timestamp); ?></small>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>

                                                                <!-- رسالة مستلمة -->
                                                                <div class="d-flex align-items-start justify-content-end mb-3">
                                                                    <div class="text-end">
                                                                        <div class="bg-light text-span  p-2 rounded-3">
                                                                            <small class="d-block"><?php echo exertio_get_username('lawyer', $message->msg_sender_id, 'badge', 'left'); ?></small>
                                                                            <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                                            <?php
                                                                            if ($message->attachment_ids > 0) {
                                                                            ?>
                                                                                <div class="history_attch_dwld btn-loading" id="download-files" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
                                                                                    <i class="fas fa-arrow-down"></i>
                                                                                    <?php echo esc_html__('Attachments', 'khebrat_theme'); ?>
                                                                                    <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <small class="text-muted"><?php echo time_ago_function($message->timestamp); ?></small>
                                                                    </div>
                                                                    <div class="avatar avatar-sm ms-2">
                                                                        <?php echo get_profile_img($message->msg_sender_id, 'lawyer', 'avatar-img rounded-circle'); ?>
                                                                    </div>
                                                                </div>

                                                        <?php
                                                            }
                                                        }
                                                    } else {
                                                        ?>
                                                        <p class="text-center"><?php echo esc_html__('No history found', 'khebrat_theme'); ?></p>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($service_status != 'completed') : ?>
                                        <div class="history-msg-form">
                                            <h3><?php echo esc_html__('Send Message', 'khebrat_theme'); ?></h3>
                                            <div class="history-text">
                                                <form id="send_service_msg">

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <div class="upload-btn-wrapper">
                                                                <button class="btn btn-success mt-2 mt-xl-0" type="button"><?php echo esc_html__('Select Attachments', 'khebrat_theme'); ?></button>
                                                                <input type="file" id="gen_attachment_uploader" multiple name="project_attachments[]" accept="image/pdf/doc/docx/ppt/pptx*" data-post-id="<?php echo esc_attr($get_sid) ?>" />
                                                                <input type="hidden" name="attachment_ids" value="" id="history_attachments_ids">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12 attachment-box">
                                                        </div>
                                                    </div>

                                                    <div class="collapse show" id="collapseComment">
                                                        <div class="d-flex mt-3">
                                                            <textarea class="form-control mb-0" name="history_msg_text" id="" required data-smk-msg="<?php echo esc_attr__('Please provide message to send', 'khebrat_theme'); ?>" placeholder="<?php echo esc_attr__('Type your message here.....', 'khebrat_theme'); ?>"></textarea>
                                                            <button type="button" class="btn btn-sm btn-primary ms-2 px-4 mb-0 flex-shrink-0" id="service_history_msg_btn" data-post-id="<?php echo esc_attr($service_id) ?>" data-sender-id="<?php echo esc_attr($customer_id_msg) ?>" data-receiver-id="<?php echo esc_attr($lawyer_id_msg) ?>"><i class="fas fa-paper-plane fs-5"></i></button>
                                                        </div>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    <?php  }  ?>


                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>



<?php
        } else {
            get_template_part('template-parts/dashboard/layouts-3/dashboard');
        }
    }
} else {
    echo exertio_redirect(home_url('/'));
}
?>