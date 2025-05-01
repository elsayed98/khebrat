<?php
/* Template Name: Register lawyer */

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

				<form id="lawyer-signup-form">
					<input type="text" name="fl_username" placeholder="اسم المستخدم" required>
					<input type="email" name="fl_email" placeholder="البريد الإلكتروني" required>
					<input type="password" name="fl_password" placeholder="كلمة المرور" required>
					<input type="text" name="lawyer_full_name" placeholder="الاسم الكامل" required>

					<!-- حقول الملف الشخصي الخاص بالمحامي -->
					<input type="date" name="lawyer_birthdate" placeholder="تاريخ الميلاد" required>
					<input type="text" name="lawyer_specialization" placeholder="التخصص" required>
					<input type="text" name="lawyer_phone" placeholder="رقم الجوال" required>

					<input type="hidden" id="lawyer_register_nonce" value="<?php echo wp_create_nonce('lawyer_register_secure'); ?>">

					<button type="button" id="lawyer-signup-btn">
						<span class="bubbles"></span>
						تسجيل
					</button>
				</form>

			</div>
		</div>
	</section>




<?php
} else {
	echo exertio_redirect(get_the_permalink($khebrat_theme_options['user_dashboard_page']));
}
?>
<?php get_footer(); ?>