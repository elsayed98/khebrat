<?php
/* Template Name: Login-old */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Exertio
 */
?>
<?php get_header(); ?>
<?php
if (!is_user_logged_in()) {
    global $khebrat_theme_options;
    $only_url = $khebrat_theme_options['login_bg_image']['url'];
?>
<main>
    <section class="vh-xxl-100" style="background: url('<?php echo esc_url($only_url); ?>') no-repeat center center/cover;">
        <div class="h-100 d-flex px-0 px-sm-4">
            <div class="row justify-content-center align-items-center m-auto">
                <div class="col-12">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0">
                            <!-- Image Section -->
                            <div class="col-lg-6 d-flex align-items-center order-2 order-lg-1">
                                <div class="p-3 p-lg-5">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/element/signin.svg" alt="Login Illustration">
                                </div>
                                <div class="vr opacity-1 d-none d-lg-block"></div>
                            </div>
                            
                            <!-- Login Form Section -->
                            <div class="col-lg-6 order-1">
                                <div class="p-4 p-sm-7">
                                    <!-- Logo -->
                                    <?php if (isset($khebrat_theme_options['login_logo_show']) && $khebrat_theme_options['login_logo_show'] == 1) { ?>
                                        <a href="<?php echo get_home_url(); ?>">
                                            <img class="h-50px mb-4" src="<?php echo esc_url($khebrat_theme_options['dasboard_logo']['url']); ?>" alt="Logo">
                                        </a>
                                    <?php } ?>
                                    
                                    <!-- Title -->
                                    <h1 class="mb-2 h3"> <?php echo esc_html($khebrat_theme_options['login_heading_text']); ?></h1>
                                    <p class="mb-0"> <?php echo esc_html($khebrat_theme_options['login_textarea']); ?></p>
                                    
                                    <!-- Form -->
                                    <form id="signin-form" class="mt-4 text-start">
                                        <div class="mb-3">
                                            <label class="form-label"> <?php echo esc_html__('Email Address', 'khebrat_theme'); ?> </label>
                                            <input type="text" name="fl_email" class="form-control" required>
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <label class="form-label"> <?php echo esc_html__('Password', 'khebrat_theme'); ?> </label>
                                            <input class="form-control" type="password" name="fl_password" id="password-field" required>
                                            <span class="position-absolute top-50 end-0 translate-middle-y p-0 mt-3">
                                                <i class="fa fa-fw fa-eye field-icon toggle-password"></i>
                                            </span>
                                        </div>
                                        
                                        <!-- Remember me -->
                                        <div class="mb-3 d-sm-flex justify-content-between">
                                            <div>
                                                <input type="checkbox" name="is_remember" class="form-check-input">
                                                <label class="form-check-label"> <?php echo esc_html__('Keep me logged in', 'khebrat_theme'); ?> </label>
                                            </div>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#forget_pwd"> <?php echo esc_html__('Forgot Password?', 'khebrat_theme'); ?> </a>
                                        </div>
                                        
                                        <!-- Login Button -->
                                        <div>
                                            <button type="button" class="btn btn-primary w-100" id="signin-btn"> <?php echo esc_html__('Sign in', 'khebrat_theme'); ?> </button>
                                        </div>
                                        
                                        <!-- Social Login -->
                                        <?php if (class_exists('mo_openid_login_wid')) { ?>
                                            <div class="position-relative my-4">
                                                <hr>
                                                <p class="small bg-mode position-absolute top-50 start-50 translate-middle px-2"> <?php echo esc_html__('Or sign in with', 'khebrat_theme'); ?> </p>
                                            </div>
                                            <div class="vstack gap-3">
                                                <?php echo do_shortcode('[miniorange_social_login]'); ?>
                                            </div>
                                        <?php } ?>
                                    </form>
                                    
                                    <!-- Register Link -->
                                    <div class="text-center mt-3">
                                        <p> <?php echo esc_html__('Don\'t have an account?', 'khebrat_theme'); ?>
                                            <span>
                                                <a href="<?php echo get_the_permalink($khebrat_theme_options['register_page']); ?>"> <?php echo esc_html__('Register here', 'khebrat_theme'); ?> </a>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
} else {
    echo exertio_redirect(get_the_permalink($khebrat_theme_options['user_dashboard_page']));
}
?>
<?php get_footer(); ?>