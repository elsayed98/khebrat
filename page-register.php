<?php
/* Template Name: Register */

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
	$img_id = '';
	$only_url = $khebrat_theme_options['register_bg_image']['url'];
	$bg_img = "style=\"background: url('$only_url'); background-repeat: no-repeat; background-position: center center; background-size: cover;\"";

?>
	<section class="vh-xxl-100">
		<div class="container h-100 d-flex px-0 px-sm-4">
			<div class="row justify-content-center align-items-center m-auto w-100">
				<div class="col-lg-6">
					<div class="p-4 p-sm-5 bg-mode rounded-3 shadow">

						<?php if (fl_framework_get_options('fl_allow_user_email_verification') == false) : ?>
							<div class="alert alert-danger fr_resend_email">
								<p>
									<?php echo esc_html__('A verification link has been sent to your email.', 'khebrat_theme'); ?>
									<button class="btn btn-link p-0 fr_send_email"><?php echo esc_html__('Resend Email', 'khebrat_theme'); ?></button>
								</p>
							</div>
						<?php endif; ?>

						<?php if (!empty($khebrat_theme_options['dasboard_logo']['url'])) : ?>
							<div class="text-center mb-4">
								<img src="<?php echo esc_url($khebrat_theme_options['dasboard_logo']['url']); ?>" alt="Logo" class="img-fluid" style="max-height: 80px;">
							</div>
						<?php endif; ?>

						<div class="text-center mb-4">
							<h2><?php echo esc_html($khebrat_theme_options['register_heading_text']); ?></h2>
							<p class="text-muted"><?php echo esc_html($khebrat_theme_options['register_textarea']); ?></p>
						</div>

						<form id="signup-form">
							
							<div class="mb-3">
								<input type="text" name="fl_full_name" class="form-control" placeholder="<?php esc_attr_e('Display name', 'khebrat_theme'); ?>" required>
							</div>
							<div class="mb-3">
								<input type="text" name="fl_username" class="form-control" placeholder="<?php esc_attr_e('Username', 'khebrat_theme'); ?>" required>
							</div>
							<div class="mb-3">
								<input type="email" name="fl_email" class="form-control" placeholder="<?php esc_attr_e('Email address', 'khebrat_theme'); ?>" required>
							</div>
							<div class="mb-3 position-relative">
								<input type="password" name="fl_password" id="password-field" class="form-control" placeholder="<?php esc_attr_e('Password', 'khebrat_theme'); ?>" required>
								<span data-toggle="#password-field" class="fa fa-eye field-icon toggle-password position-absolute top-50 end-0 translate-middle-y me-3"></span>
							</div>

							<?php
							if (!empty($khebrat_theme_options['google_recaptcha_key']) && $khebrat_theme_options['signin_form_recaptcha_switch']) :
							?>
								<div class="mb-3">
									<div class="g-recaptcha" data-sitekey="<?php echo esc_attr($khebrat_theme_options['google_recaptcha_key']); ?>"></div>
								</div>
							<?php endif; ?>

							<div class="mb-3 form-check">
								<input type="checkbox" class="form-check-input" required name="term_condition">
								<label class="form-check-label">
									<?php echo esc_html__('I agree to the', 'khebrat_theme'); ?>
									<a href="<?php echo esc_url(get_permalink($khebrat_theme_options['terms_condition_page'])); ?>"><?php echo esc_html__('Terms and Conditions', 'khebrat_theme'); ?></a>
								</label>
							</div>

							<input type="hidden" id="register_nonce" value="<?php echo wp_create_nonce('fl_register_secure'); ?>" />
							<input type="hidden" name="fl_user_id" id="fl_user_id" value="">

							<div class="d-grid mb-3">
								<button type="button" class="btn btn-primary" id="signup-btn" data-redirect-id="<?php echo esc_attr($redirect_page ?? ''); ?>">
									<?php echo esc_html__('Create Account', 'khebrat_theme'); ?>
								</button>
							</div>

							<?php if (class_exists('mo_openid_login_wid')) : ?>
								<div class="text-center my-3">
									<p><?php echo esc_html__('OR', 'khebrat_theme'); ?></p>
									<?php echo do_shortcode('[miniorange_social_login]'); ?>
								</div>
							<?php endif; ?>
						</form>

						<div class="text-center">
							<p><?php echo esc_html__('Already have an account?', 'khebrat_theme'); ?>
								<a href="<?php echo esc_url(get_permalink($khebrat_theme_options['login_page'])); ?>">
									<?php echo esc_html__('Login here', 'khebrat_theme'); ?>
								</a>
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




<?php
} else {
	echo exertio_redirect(get_the_permalink($khebrat_theme_options['user_dashboard_page']));
}
?>
<?php get_footer(); ?>