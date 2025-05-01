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



	$taxonomy = 'customer-locations'; // ← غيّرها حسب التصنيف الخاص بك
	$terms = get_terms([
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
	]);

	$parent_terms = [];
	$children_by_parent = [];

	foreach ($terms as $term) {
		if ($term->parent == 0) {
			$parent_terms[] = $term;
		} else {
			$children_by_parent[$term->parent][] = $term;
		}
	}
	$saved_parent_term = '';


?>
	<div class="container py-5">
		<form id="lawyer-signup-form">
			<!-- Progress steps -->
			<div class="d-flex justify-content-center mb-5">
				<div class="step-indicator text-center me-3 active" data-step="1">
					<div class="circle mb-2">1</div>
					<div>البيانات الشخصية</div>
				</div>
				<div class="step-indicator text-center me-3" data-step="2">
					<div class="circle mb-2">2</div>
					<div>المنطقة والمدينة</div>
				</div>
				<div class="step-indicator text-center" data-step="3">
					<div class="circle mb-2">3</div>
					<div>الرخصة</div>
				</div>
			</div>

			<!-- Step 1 -->
			<div class="form-step active" data-step="1">

				<div class="form-group mb-3">
					<label class="form-label">الاسم المستخدم *</label>
					<input type="text" class="form-control" name="lawyer_username" required data-smk-msg="يرجى إدخال الاسم المستخدم">
				</div>

				<div class="form-group mb-3">
					<label class="form-label">الاسم بالكامل *</label>
					<input type="text" class="form-control" name="lawyer_full_name" required data-smk-msg="يرجى إدخال الاسم بالكامل">
				</div>

				<div class="form-group mb-3">
					<label class="form-label">رقم الجوال *</label>
					<div class="input-group">

						<input type="text" class="form-control" name="lawyer_contact_number" required data-smk-msg="يرجى إدخال رقم الجوال" pattern="\d{9}" placeholder="5xxxxxxxx">
						<span class="input-group-text">
							<img src="https://flagcdn.com/w40/sa.png" alt="SA" width="20" class="me-1"> +966
						</span>
					</div>
				</div>

				<div class="form-group mb-3">
					<label class="form-label">البريد الإلكتروني *</label>
					<input type="email" class="form-control" name="lawyer_email" required data-smk-msg="يرجى إدخال بريد إلكتروني صحيح">
				</div>

				<div class="form-group mb-3">
					<label class="form-label">كلمة المرور *</label>
					<input type="password" class="form-control" name="lawyer_password" required data-smk-msg="يرجى كتابة كلمة المرور">
				</div>



				<button type="button" class="btn btn-dark w-100 next-step">التالي</button>
			</div>

			<!-- Step 2 -->
			<div class="form-step" data-step="2">


				<div class="form-group mb-3">
					<label for="parent-select">المنطقة</label>
					<select class="form-select" name="locations_parent_term" id="parent-select" required data-smk-msg="يرجى اختيار المنطقة">
						<option value="">-- اختر المنطقة --</option>
						<?php foreach ($parent_terms as $parent): ?>
							<option value="<?php echo esc_attr($parent->term_id); ?>" <?php selected($parent->term_id, $saved_parent_term); ?>>
								<?php echo esc_html($parent->name); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group mb-3">
					<label for="child-select">المدينة</label>
					<select name="locations_child_term" id="child-select" required data-smk-msg="يرجى اختيار المدينة" class="form-select" <?php echo empty($saved_parent_term) ? 'disabled' : ''; ?>>
						<option value="">-- اختر المدينة --</option>
						<?php
						if (!empty($saved_parent_term) && isset($children_by_parent[$saved_parent_term])) {
							foreach ($children_by_parent[$saved_parent_term] as $child) {
								$selected = ($child->term_id == $saved_child_term) ? 'selected="selected"' : '';
								echo '<option value="' . esc_attr($child->term_id) . '" ' . $selected . '>' . esc_html($child->name) . '</option>';
							}
						}
						?>
					</select>
				</div>

				<button type="button" class="btn btn-dark w-100 next-step">التالي</button>
			</div>

			<!-- Step 3 -->
			<div class="form-step" data-step="3">

				<div class="form-group mb-3">
					<label class="upload-box">
						<div class="upload-icon"><i class="bi bi-upload display-3"></i></div>
						<p id="license_name_file"></p>
						<div class="upload-text">قم بإدراج الملفات هنا</div>
						<input type="file" id="license_file" accept="application/pdf">
					</label>
					<input type="hidden" id="uploaded_license_file" name="uploaded_license_file" required data-smk-msg="يرجى بإدراج ملف الرخصة">
				</div>

				<div class="form-group mb-3">
					<label class="form-label">تاريخ البداية *</label>
					<input type="text" class="form-control flatpickr" name="license_start_date" required data-smk-msg="يرجى تحديد تاريخ البداية" placeholder="تحديد تاريخ البداية" data-date-format="d M Y">
				</div>

				<div class="form-group mb-3">
					<label class="form-label">تاريخ الانتهاء *</label>
					<input type="text" class="form-control flatpickr" name="license_end_date" required data-smk-msg="يرجى تحديد تاريخ الانتهاء" placeholder="تحديد تاريخ الانتهاء" data-date-format="d M Y">
				</div>

				<div class="form-group mb-3">
					<label class="form-label">نوع الرخصة *</label>
					<select class="form-control" name="license_type" required data-smk-msg="يرجى اختيار نوع الرخصة">
						<option value="محامي مرخص">محامي مرخص</option>
					</select>
				</div>

				<div class="form-group mb-3">
					<label class="form-label">رقم الرخصة *</label>
					<input type="text" class="form-control" name="license_number" required data-smk-msg="يرجى إدخال رقم الرخصة">
				</div>

				<div class="form-check mb-3">
					<input class="form-check-input" type="checkbox" id="agreeTerms" required data-smk-msg="يجب الموافقة على الشروط والأحكام">
					<label class="form-check-label" for="agreeTerms">
						أوافق على الشروط والأحكام وسياسة الخصوصية
					</label>
				</div>
				<input type="hidden" id="lawyer_register_nonce" value="<?php echo wp_create_nonce('lawyer_register_secure'); ?>">

				<button type="button" id="lawyer-signup-btn" class="btn btn-dark w-100">إرسال رمز التفعيل</button>
			</div>
		</form>
	</div>



	<script>
		jQuery(document).ready(function($) {
			$('.next-step').click(function() {
				var currentStep = $(this).closest('.form-step');

				// فحص الحقول باستخدام smkValidate
				if (!currentStep.smkValidate()) {
					return;
				}

				var currentNum = currentStep.data('step');
				var nextNum = currentNum + 1;

				$('[data-step="' + currentNum + '"]').removeClass('active');
				$('[data-step="' + nextNum + '"]').addClass('active');
			});
		});

		document.addEventListener('DOMContentLoaded', function() {
			const parentSelect = document.getElementById('parent-select');
			const childSelect = document.getElementById('child-select');

			const childrenByParent = <?php echo json_encode($children_by_parent); ?>;

			parentSelect.addEventListener('change', function() {
				const parentId = this.value;

				// حذف الخيارات القديمة
				childSelect.innerHTML = '<option value="">-- اختر المدينة --</option>';

				if (parentId && childrenByParent[parentId]) {
					childSelect.disabled = false;
					childrenByParent[parentId].forEach(function(child) {
						const option = document.createElement('option');
						option.value = child.term_id;
						option.textContent = child.name;
						childSelect.appendChild(option);
					});
				} else {
					childSelect.disabled = true;
				}
			});
		});


		/*
				document.addEventListener('DOMContentLoaded', function() {
					const input = document.getElementById('pdf_file');
					const hiddenInput = document.getElementById('uploaded_pdf_url');
					const nameFile = document.getElementById('name_file');
					const freelanceAjaxURL = document.getElementById('freelance_ajax_url')?.value || '/wp-admin/admin-ajax.php';

					input.value = '';

					input.addEventListener('change', function(e) {
						const file = e.target.files[0];

						if (!file || file.type !== 'application/pdf') {
							toastr.error('❌ الرجاء اختيار ملف PDF فقط.');
							return;
						}

						const formData = new FormData();
						formData.append('file', file);
						formData.append('action', 'upload_pdf_to_media');

						fetch(freelanceAjaxURL, {
								method: 'POST',
								body: formData
							})
							.then(response => response.json())
							.then(data => {
								console.log('📦 الرد:', data);

								if (data.success && data.data && data.data.attachment_id) {
									hiddenInput.value = data.data.attachment_id;
									nameFile.textContent = file.name;
									toastr.success('✅ تم رفع الملف بنجاح.');
								} else {
									toastr.error(data.message || '❌ فشل رفع الملف.');
								}

								input.value = '';
							})
							.catch(err => {
								console.error('❌ خطأ في الرفع:', err);
								toastr.error('⚠️ حدث خطأ أثناء رفع الملف.');
								input.value = '';
							});
					});
				});*/
	</script>



<?php
} else {
	echo exertio_redirect(get_the_permalink($khebrat_theme_options['user_dashboard_page']));
}
?>
<?php get_footer(); ?>