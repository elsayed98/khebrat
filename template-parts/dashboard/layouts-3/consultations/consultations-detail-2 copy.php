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
            <div class="content-wrapper">
                <div class="notch"></div>
                
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card services ongoing-services-details">
                        <div class="card mb-4">
                            <div class="card-body">

                                <?php
                                if (fl_framework_get_options('turn_services_messaging') == true) {
                                ?>
                                    <!--PROJECT HISTORY-->
                                    <div class="project-history">
                                        <div class="history-body">
                                            <div class="history-chat-body">
                                                <?php
                                                $messages = get_service_msg($con_id);
                                                if ($messages) {
                                                    foreach ($messages as $message) {
                                                        $msg_author = get_user_meta($current_user_id, 'customer_id', true);

                                                        if ($msg_author == $message->msg_sender_id) {
                                                ?>
                                                            <div class="chat-single-box">
                                                                <div class="chat-single chant-single-right">
                                                                    <div class="history-user">
                                                                        <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                                        <a href="<?php echo get_the_permalink($message->msg_sender_id); ?>" class="history-username">22<?php echo exertio_get_username('customer', $message->msg_sender_id, 'badge', 'left'); ?></a>
                                                                        <span><?php echo get_profile_img($message->msg_sender_id, "customer"); ?></span>
                                                                    </div>
                                                                    <p class="history-text">
                                                                        <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                                    </p>
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
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="chat-single-box">
                                                                <div class="chat-single success">
                                                                    <div class="history-user">
                                                                        <span>
                                                                            <?php echo get_profile_img($message->msg_sender_id, "customer"); ?>
                                                                        </span>
                                                                        <a href="<?php echo get_the_permalink($message->msg_sender_id); ?>" class="history-username"><?php echo exertio_get_username('customer', $message->msg_sender_id, 'badge', 'right'); ?></a>
                                                                        <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                                    </div>
                                                                    <p class="history-text">
                                                                        <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                                    </p>
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

                                    <div class="container my-5">
  <div class="border rounded p-3">
    
    <!-- رسالة مرسلة -->
    <div class="d-flex align-items-start mb-3">
      <img src="https://randomuser.me/api/portraits/women/45.jpg" class="rounded-circle me-2" width="40" height="40" alt="Receiver">
      <div>
        <div class="bg-primary text-dark p-2 rounded-3">
          <small class="text-light d-block">From: Receiver</small>
          Hello, can you update the website colors to pink and purple?
        </div>
        <small class="text-muted">08:45 PM</small>
      </div>
    </div>

    
     <!-- رسالة مستلمة -->
    <div class="d-flex align-items-start justify-content-end mb-3">
      <div class="text-end">
        <div class="bg-light text-white p-2 rounded-3">
          <small class="text-light d-block">From: You</small>
          Sure! I'll change the color theme as you requested. 😄
        </div>
        <small class="text-muted">08:46 PM</small>
      </div>
      <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle ms-2" width="40" height="40" alt="Sender">
    </div>

    
  </div>

  <!-- مدخل الكتابة -->
  <form class="mt-3 d-flex">
    <input type="text" class="form-control me-2" placeholder="Type your message...">
    <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
        <path d="M15.854.146a.5.5 0 0 0-.623-.062l-15 9a.5.5 0 0 0 .057.884l5.678 2.102 2.1 5.678a.5.5 0 0 0 .884.057l9-15a.5.5 0 0 0-.062-.623zM6.832 10.884 2.123 9.134 13.5 2.5 6.832 10.884zm1.167 1.681 1.666 4.5-4.5-1.666 2.834-2.834z"/>
      </svg>
    </button>
  </form>
</div>

                                    <div class="history-msg-form">
                                        <h3><?php echo esc_html__('Send Message', 'khebrat_theme'); ?></h3>
                                        <div class="history-text">
                                            <form id="send_service_msg">
                                                
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <div class="upload-btn-wrapper">
                                                            <button class="btn btn-theme-secondary mt-2 mt-xl-0" type="button"><?php echo esc_html__('Select Attachments', 'khebrat_theme'); ?></button>
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
                                                        <button type="button" class="btn btn-sm btn-primary ms-2 px-4 mb-0 flex-shrink-0" id="service_history_msg_btn" data-post-id="<?php echo esc_attr($con_id) ?>" data-sender-id="<?php echo esc_attr($customer_id_msg) ?>" data-receiver-id="<?php echo esc_attr($buyer_id_msg) ?>"><i class="fas fa-paper-plane fs-5"></i></button>
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