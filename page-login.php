<?php
/* Template Name: Login */

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
      <div class="container h-100 d-flex px-0 px-sm-4">
        <div class="row justify-content-center align-items-center m-auto w-100">
          <!-- Login Form Section -->
          <div class="col-lg-6">
            <div class="p-4 p-sm-5 bg-mode rounded-3 shadow">
              <!-- Logo -->
              <?php if (isset($khebrat_theme_options['login_logo_show']) && $khebrat_theme_options['login_logo_show'] == 1) { ?>
                <div class="text-center mb-4">
                  <img src="<?php echo esc_url($khebrat_theme_options['dasboard_logo']['url']); ?>" alt="Logo" class="img-fluid" style="max-height: 80px;">
                </div>
              <?php } ?>

              <!-- Title -->
              <div class="text-center mb-4">
                <h1 class="mb-2 h3"> <?php echo esc_html($khebrat_theme_options['login_heading_text']); ?></h1>
                <p class="mb-0"> <?php echo esc_html($khebrat_theme_options['login_textarea']); ?></p>
              </div>
              <!-- Form -->
              <form id="signin-form" class="mt-4 text-start">
                <div class="mb-3">
                  <label class="form-label"> <?php echo esc_html__('Email Address', 'khebrat_theme'); ?> </label>
                  <input type="text" name="fl_email" class="form-control" required>
                </div>
                <div class="mb-3 position-relative">
                  <label class="form-label"> <?php echo esc_html__('Password', 'khebrat_theme'); ?> </label>
                  <input class="form-control" type="password" name="fl_password" id="password-field" required>
                  <span class="position-absolute top-50 end-0 translate-middle-y p-2 mt-3">
                  <span data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
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
          <!-- Right column: Slider -->
          <div class="col-lg-6 d-none d-lg-block">
            <div class="h-100 d-flex align-items-center justify-content-center bg-light p-4">
              <div class="owl-carousel owl-theme w-100">
                <?php if (!empty($khebrat_theme_options['register_slides'])) :
                  foreach ($khebrat_theme_options['register_slides'] as $slide) : ?>
                    <div class="text-center">
                      <img src="<?php echo esc_url($slide['thumb']); ?>" class="img-fluid mb-3" alt="">
                      <h4><?php echo esc_html($slide['title']); ?></h4>
                      <p><?php echo esc_html($slide['description']); ?></p>
                    </div>
                <?php endforeach;
                endif; ?>
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