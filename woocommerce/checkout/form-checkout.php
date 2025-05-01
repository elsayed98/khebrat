<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if (! defined('ABSPATH')) {
    exit;
}
// If checkout registration is disabled and not logged in, the user cannot checkout.
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'exertio_theme')));
    return;
}

// إزالة القالب الافتراضي
remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);

// إضافة قالب مخصص
add_action('woocommerce_checkout_order_review', 'custom_checkout_order_review', 10);

function custom_checkout_order_review()
{
    // استرجاع معرف الاستشارة من الجلسة
    $consultation_id = WC()->session ? WC()->session->get('_fl_dir_payement_sid') : '';

?>
    <div id="order_review" class="woocommerce-checkout-review-order">

        <ul class="list-group list-group-borderless mb-2">
            <?php if (!empty($consultation_id)) : ?>
                <li class="list-group-item px-0 d-flex justify-content-between">
                    <span class="h6 fw-light mb-0"><?php esc_html_e('رقم الاستشارة', 'woocommerce'); ?></span>
                    <span class="h6 fw-light mb-0 fw-bold"><?php echo esc_html($consultation_id); ?></span>
                </li>
            <?php endif; ?>

            <li class="list-group-item px-0 d-flex justify-content-between">
                <span class="h6 fw-light mb-0"><?php esc_html_e('قيمة الاستشارة', 'woocommerce'); ?></span>
                <span class="h6 fw-light mb-0 fw-bold"><?php wc_cart_totals_subtotal_html(); ?></span>
            </li>
            
            <li class="list-group-item px-0 d-flex justify-content-between">
                <span class="h5 mb-0"><?php esc_html_e('المطلوب سداده', 'woocommerce'); ?></span>
                <span class="h5 mb-0"> <?php wc_cart_totals_order_total_html(); ?></span>
            </li>
        </ul>

    </div>
<?php
}


?>


<section class="pt-4 pt-md-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-9 mx-auto">
                <div class="vstack gap-4">

                    <!-- Booking summary START -->
                    <div class="card shadow">
                        <!-- Card header -->
                        <div class="card-header border-bottom p-4">
                            <h1 class="mb-0 fs-3">طلب استشارة</h1>
                        </div>
                        <?php


                        $consultation_id = WC()->session ? WC()->session->get('_fl_dir_payement_sid') : '';

                        ?>

                        
                        <!-- Card body START -->
                        <div class="card-body p-4">
                            <div class="row g-md-4">
                                <!-- Image -->
                                <div class="col-md-3">
                                    <div class="bg-light rounded-3 px-4 py-5 mb-3 mb-md-0">
                                        <img src="" alt="">
                                    </div>
                                </div>

                                <!-- Card and address detail -->
                                <div class="col-md-9">
                                    <!-- Title -->
                                    <h5 class="card-title mb-2"><?php echo get_the_title($consultation_id); ?></h5>
                                </div>

                            </div>

                            <div class="row mt-4">
                                 <!-- Price -->
                                 <div class="col-sm-5 mt-3 mt-sm-auto">
                                    <h6 class="mb-1 fw-normal">رسوم الاستشارة</h6>
                                    <h2 class="mb-0 text-success"><?php echo get_post_meta($consultation_id, '_consultation_price', true); ?></h2>
                                </div>

                                <!-- List -->
                                <div class="col-sm-7">
                                    
                                </div>

                               
                            </div>
                        </div>
                        <!-- Card body END -->
                    </div>
                    <!-- Booking summary END -->

                    <!-- Payment START -->
                    <div class="card shadow">


                        <!-- Card body -->
                        <div class="card-body text-center p-4">
                            <!-- Title -->

                            


                            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="content-area entry-left">
                                        <!-- إزالة حقول الفاتورة -->
                                        
                                            <?php do_action('woocommerce_checkout_before_customer_details'); ?>
                                            <div class="alert alert-primary" role="alert">تم التحقق من معلومات الفاتورة الخاصة بك بنجاح.</div>
                                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                                       
                                    </div>

                                    <div class="row justify-content-between text-start mb-4">
                                        <div class="blog-sidebar position-sticky">
                                            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                                            <h3 id="order_review_heading"><?php esc_html_e(' ', 'exertio_theme'); ?></h3>
                                            <?php do_action('woocommerce_checkout_before_order_review'); ?>
                                            <div id="order_review" class="woocommerce-checkout-review-order">
                                                <?php do_action('woocommerce_checkout_order_review'); ?>
                                            </div>
                                            <?php do_action('woocommerce_checkout_after_order_review'); ?>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <?php
                            do_action('woocommerce_before_checkout_form', $checkout);
                            do_action('woocommerce_after_checkout_form', $checkout);
                            ?>



                        </div>
                    </div>

                    <!-- Payment END -->
                </div>
            </div>
        </div>
    </div>
</section>