<?php global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$con_id = $_GET['cid'];




if (is_user_logged_in()) {
    $lawyer_id = get_user_meta($current_user_id, 'customer_id', true);
    $customer_id = get_user_meta($current_user_id, 'customer_id', true);



    if (isset($_GET['cid']) && !empty($_GET['cid'])) {
        $cust_id = get_post_field('post_author', $con_id);
        $customer_id_msg = get_user_meta($cust_id, 'customer_id', true);;

        $lawyer_id_msg = get_post_meta($con_id, '_lawyer_id', true);


        if ($customer_id_msg == $customer_id) {
?>
            <div class="content-wrapper p-0">
                <div class="notch"></div>

                <div class="card shadow mb-2">
                    <!-- Card header -->
                    <div class="card-header border-bottom p-4">
                        <h1 class="mb-0 fs-3"><?php echo esc_html__('تفاصيل الاستشارة', 'khebrat_theme'); ?></h1>
                    </div>

                    <!-- Card body START -->
                    <div class="card-body p-4">
                        <div class="row g-md-4">

                            <!-- Card and address detail -->
                            <div class="col-md-10">
                                <!-- Title -->
                                <h5 class="card-title mb-2"><?php echo get_the_title($con_id); ?></h5>
                                <ul class="nav nav-divider h6 fw-normal mb-2">
                                    <?php
                                    $terms = wp_get_object_terms($con_id, 'legal_category');

                                    if (!empty($terms) && !is_wp_error($terms)) {
                                        foreach ($terms as $term) {
                                            echo '<li class="nav-item">' . esc_html($term->name) . '</li>';
                                        }
                                    } else {
                                        echo '<li class="nav-item">لا يوجد تصنيف</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <div class="badge bg-info bg-opacity-10 text-info"><?php echo get_post_meta($con_id, '_legal_consultation_status', true); ?></div>
                            </div>



                        </div>

                        <!-- Title -->
                        <h6 class="mb-0 mt-3">Passenger Detail</h6>

                    </div>
                    <!-- Card body END -->
                </div>

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
                                                $messages = get_service_msg($con_id);
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
                                                                    <div class="bg-primary text-dark p-2 rounded-3">
                                                                        <small class="text-light d-block">
                                                                            <a href="<?php echo get_the_permalink($message->msg_sender_id); ?>" class="history-username"></a>
                                                                            22<?php echo exertio_get_username('customer', $message->msg_sender_id, 'badge', 'left'); ?>
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
                                                                    <div class="bg-light text-white p-2 rounded-3">
                                                                        <small class="text-light d-block"><?php echo exertio_get_username('customer', $message->msg_sender_id, 'badge', 'right'); ?></small>
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
                                                                    <?php echo get_profile_img($message->msg_sender_id, 'customer', 'avatar-img rounded-circle'); ?>
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
                                                        <button type="button" class="btn btn-sm btn-primary ms-2 px-4 mb-0 flex-shrink-0" id="service_history_msg_btn" data-post-id="<?php echo esc_attr($con_id) ?>" data-sender-id="<?php echo esc_attr($customer_id_msg) ?>" data-receiver-id="<?php echo esc_attr($lawyer_id_msg) ?>"><i class="fas fa-paper-plane fs-5"></i></button>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                    </div>

                                <?php  }  ?>


                            </div>
                        </div>
                    </div>
                </div>
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