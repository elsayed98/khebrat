<?php
global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$pid = get_user_meta($current_user_id, 'lawyer_id', true);
$post  =  get_post($pid);

$user_info = get_userdata($current_user_id);
$user_name = $user_info->display_name;

$pro_img_id = get_post_meta($pid, '_profile_pic_attachment_id', true);
$pro_img = wp_get_attachment_image_src($pro_img_id, 'thumbnail');

$pdf_id =  get_post_meta($pid, '_license_attached_pdf', true); // استبدل هذا برقم معرف الملف
$pdf_url = wp_get_attachment_url($pdf_id);


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

// استرجاع التصنيف الابن المحفوظ وتحديد التصنيف الأب
$saved_child_term = get_post_meta($pid, '_lawyer_location', true);
$saved_parent_term = '';
if ($saved_child_term) {
    $child_term = get_term($saved_child_term);
    $saved_parent_term = $child_term ? $child_term->parent : '';
}


if ($current_user_id == '') {
    echo exertio_redirect(home_url('/'));
    exit;
} else {
?>


    <!-- =======================
Content START -->
    <section class="pt-0">
        <div class="container vstack gap-4">
            <!-- Title START -->
            <div class="row">
                <div class="col-12">
                    <h1 class="fs-4 mb-0"><i class="bi bi-gear fa-fw me-1"></i><?php echo esc_html__('Settings', 'khebrat_theme'); ?></h1>
                </div>
            </div>
            <!-- Title END -->

            <!-- Tabs START -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light pb-0 px-2 px-lg-0 rounded-top">
                        <ul class="nav nav-tabs nav-bottom-line nav-responsive border-0 nav-justified" role="tablist">
                            <li class="nav-item"> <a class="nav-link mb-0 active" data-bs-toggle="tab" href="#personal-info"><i class="fas fa-cog fa-fw me-2"></i><?php echo esc_html__('تعديل الملف الشخصي', 'khebrat_theme'); ?></a> </li>
                            <li class="nav-item"> <a class="nav-link mb-0" data-bs-toggle="tab" href="#lawyer-info"><i class="fas fa-user-circle fa-fw me-2"></i><?php echo esc_html__('تعديل بيانات المحامي', 'khebrat_theme'); ?></a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Tabs END -->

            <!-- Tabs Content START -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="tab-content">
                        <!-- Tab content 1 START -->
                        <div class="tab-pane show active" id="personal-info">
                            <div class="row g-4">
                                <!-- Edit profile START -->
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header border-bottom">
                                            <h5 class="card-header-title"><?php echo esc_html__('تعديل الملف الشخصي', 'khebrat_theme'); ?></h5>
                                        </div>
                                        <!-- Card body START -->
                                        <div class="card-body content-wrapper ">
                                            <!-- Form START -->
                                            <form id="lawyer_form" class="row g-3">
                                                <!-- Profile photo -->
                                                <div class="col-12">
                                                    <label class="form-label"><?php echo esc_html__('الصورة الشخصية', 'khebrat_theme'); ?><span
                                                            class="text-danger">*</span></label>
                                                    <div class="d-flex align-items-center">
                                                        <label class="position-relative me-4" for="uploadfile-1"
                                                            title="Replace this pic">
                                                            <!-- Avatar place holder -->

                                                            <?php
                                                            if (!empty($pro_img_id)) {
                                                            ?>
                                                                <span class="avatar avatar-xl avatar-profile">
                                                                    <img src="<?php echo esc_url($pro_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="avatar-img rounded-circle border border-white border-3 shadow">

                                                                    <i class="mdi mdi-close" id="delete_image" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta="_profile_pic_attachment_id" data-attachment-id="<?php echo esc_attr($pro_img_id) ?>"></i>
                                                                </span>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span class="avatar avatar-xl">
                                                                    <img class="avatar-img rounded-circle border border-white border-3 shadow" src="<?php echo esc_url($khebrat_theme_options['employer_df_img']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>">
                                                                </span>

                                                            <?php
                                                            }
                                                            ?>
                                                        </label>
                                                        <!-- Upload button -->
                                                        <div class="upload-btn-wrapper">
                                                            <button class="btn btn-primary-soft mb-0"><?php echo esc_html__('Upload New Picture', 'khebrat_theme'); ?></button>
                                                            <input type="file" id="emp_profile_pic" name="emp_profile_pic" accept="image/*" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta="_profile_pic_attachment_id" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Name -->
                                                <div class="form-group col-md-12">
                                                    <label class="form-label"><?php echo esc_html__('الأسم بالكامل', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="lawyer_full_name" value="<?php echo esc_html(get_post_meta($pid, '_lawyer_full_name', true)); ?>" placeholder="ادخل الاسم بالكامل" required data-smk-msg="<?php echo esc_attr__('الرجاء ادخال الاسم بالكامل', 'khebrat_theme'); ?>">
                                                </div>

                                                <!-- Email -->
                                                <div class="col-md-6">
                                                    <label class="form-label"><?php echo esc_html__('Email address', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" value="<?php echo esc_html($user_info->user_email); ?>" disabled placeholder="Enter your email id">
                                                </div>

                                                <!-- Mobile -->
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><?php echo esc_html__('رقم الجوال', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="tel" name="lawyer_contact_number" id="lawyer_contact_number" class="form-control" value="<?php echo esc_attr(get_post_meta($pid, '_lawyer_contact_number', true)); ?>" required placeholder="5xxxxxxxx" data-smk-msg="يرجى إدخال رقم جوال مكون من 9 أرقام" maxlength="9" pattern="\d{9}">
                                                        <span class="input-group-text">
                                                            <img src="https://flagcdn.com/w40/sa.png" alt="SA" width="20" class="me-1"> +966
                                                        </span>
                                                    </div>
                                                </div>






                                                <div class="col-md-12">
                                                    <label class="form-label"><?php echo esc_html__('نوع الرخصة', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                                    <?php
                                                    $license_type = get_post_meta($pid, '_license_type', true)
                                                    ?>
                                                    <select name="license_type" class="form-select" required data-smk-msg="<?php echo esc_attr__('Please select license_type', 'khebrat_theme'); ?>">
                                                        <option value="محامي مرخص" <?php if ($license_type  == "محامي مرخص") {
                                                                                        echo "selected=selected";
                                                                                    } ?>><?php echo __("محامي مرخص", 'khebrat_theme'); ?> </option>
                                                    </select>
                                                </div>



                                                <!-- Date of birth -->
                                                <div class="col-md-6">
                                                    <label class="form-label"><?php echo esc_html__('تاريخ الميلاد', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control flatpickr" name="date_birth_id" value="<?php echo esc_attr(get_post_meta($pid, '_lawyer_date_birth', true)); ?>" placeholder="Enter date of birth" data-date-format="d M Y">
                                                </div>

                                                <!-- Gender -->
                                                <div class="col-md-6">
                                                    <?php
                                                    $gender = get_post_meta($pid, '_lawyer_gender', true); // أو استخدم get_user_meta() إذا كان للحسابات
                                                    ?>
                                                    <label class="form-label"><?php echo esc_html__('تحديد الجنس', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                                    <div class="d-flex gap-4">
                                                        <div class="form-check radio-bg-light">
                                                            <input class="form-check-input" type="radio" name="lawyer_gender" id="gender_male" value="0" <?php checked($gender, '0'); ?>>
                                                            <label class="form-check-label" for="gender_male"><?php echo esc_html__('ذكر', 'khebrat_theme'); ?></label>
                                                        </div>
                                                        <div class="form-check radio-bg-light">
                                                            <input class="form-check-input" type="radio" name="lawyer_gender" id="gender_female" value="1" <?php checked($gender, '1'); ?>>
                                                            <label class="form-check-label" for="gender_female"><?php echo esc_html__('أنثى', 'khebrat_theme'); ?></label>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <label for="parent-select">المنطقة</label>
                                                    <select class="form-select" name="locations_parent_term" id="parent-select">
                                                        <option value="">-- اختر المنطقة --</option>
                                                        <?php foreach ($parent_terms as $parent): ?>
                                                            <option value="<?php echo esc_attr($parent->term_id); ?>" <?php selected($parent->term_id, $saved_parent_term); ?>>
                                                                <?php echo esc_html($parent->name); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="child-select">المدينة</label>
                                                    <select name="locations_child_term" id="child-select" class="form-select" <?php echo empty($saved_parent_term) ? 'disabled' : ''; ?>>
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

                                                <!-- Button -->
                                                <div class="col-12 text-end">
                                                    <button type="button" class="btn btn-primary btn-loading" id="lawyer_profile_btn" data-post-id="<?php echo esc_attr($pid) ?>">
                                                        <?php echo esc_html__('Save Profile', 'khebrat_theme'); ?>
                                                        <input type="hidden" id="save_pro_nonce" value="<?php echo wp_create_nonce('fl_save_pro_secure'); ?>" />
                                                        <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                                    </button>
                                                </div>
                                            </form>
                                            <!-- Form END -->
                                        </div>
                                        <!-- Card body END -->
                                    </div>
                                </div>
                                <!-- Edit profile END -->

                                <!-- Update Email START -->
                                <div class="col-md-6">
                                    <div class="card border">
                                        <!-- Card header -->
                                        <div class="card-header border-bottom">
                                            <h4 class="card-header-title"><?php echo esc_html__('تحديث البريد الالكتروني ', 'khebrat_theme'); ?></h4>
                                            <p class="mb-0"><?php echo esc_html__('Your current email address is ', 'khebrat_theme'); ?><span class="text-primary"><?php echo esc_html($user_info->user_email); ?></span></p>
                                        </div>

                                        <!-- Card body START -->
                                        <div class="card-body">
                                            <form>
                                                <!-- Email -->
                                                <label class="form-label"><?php echo esc_html__('Enter your new email id', 'khebrat_theme'); ?><span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" placeholder="Enter your email id">

                                                <div class="text-end mt-3">
                                                    <a href="#" class="btn btn-primary mb-0">Save Email</a>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Card body END -->
                                    </div>
                                </div>
                                <!-- Update Email END -->

                                <!-- Update Password START -->
                                <div class="col-md-6">
                                    <div class="card border">
                                        <!-- Card header -->
                                        <div class="card-header border-bottom">
                                            <h4 class="card-header-title"><?php echo esc_html__('Change Password', 'khebrat_theme'); ?></h4>
                                            <p class="mb-0"><?php echo esc_html__('Your current email address is ', 'khebrat_theme'); ?><span class="text-primary"><?php echo esc_html($user_info->user_email); ?></span></p>
                                        </div>

                                        <!-- Card body START -->
                                        <form id="change_pass_form" class="card-body">
                                            <!-- Current password -->
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo esc_html__('Old Password', 'khebrat_theme'); ?></label>
                                                <input class="form-control" type="password" name="old_password" placeholder="<?php echo esc_html__('Old Password', 'khebrat_theme'); ?>" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('Please provide current password', 'khebrat_theme'); ?>">
                                            </div>
                                            <!-- New password -->
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo esc_html__('New Password', 'khebrat_theme'); ?></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="new_password" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('Enter new password. Minimum 6 characters', 'khebrat_theme'); ?>">

                                                    <span class="input-group-text p-0 bg-transparent">
                                                        <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Confirm -->
                                            <div class="mb-3">
                                                <label class="form-label"><?php echo esc_html__('Confirm Password', 'khebrat_theme'); ?></label>
                                                <input type="password" class="form-control" name="confirm_password" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('confirm password required', 'khebrat_theme'); ?>">
                                            </div>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary" id="change_password_btn" data-post-id="<?php echo esc_attr($pid) ?>">
                                                    <?php echo esc_html__('Change Password', 'khebrat_theme'); ?>
                                                </button>
                                                <input type="hidden" id="change_psw_nonce" value="<?php echo wp_create_nonce('fl_change_psw_secure'); ?>" />

                                            </div>
                                        </form>
                                        <!-- Card body END -->
                                    </div>
                                </div>
                                <!-- Update Password END -->
                            </div>
                        </div>
                        <!-- Tab content 1 END -->

                        <!-- Tab content 2 START -->
                        <div class="tab-pane" id="lawyer-info">

                            <div class="card bg-transparent border mb-4">
                                <!-- Card header START -->
                                <div class="card-header bg-transparent border-bottom">
                                    <!-- Title -->
                                    <h4 class="card-title mb-0"><?php echo esc_html__('بيانات الرخصة الحالية', 'khebrat_theme'); ?></h4>
                                </div>
                                <!-- Card header END -->

                                <!-- Card body START -->
                                <div class="card-body">

                                    <div class="row g-4 mb-3">
                                        <!-- Item -->
                                        <div class="col-md-4">
                                            <div class="bg-light py-3 px-4 rounded-3">
                                                <h6 class="fw-light small mb-1"><?php echo esc_html__('تاريخ البداية', 'khebrat_theme'); ?></h6>
                                                <h6 class="mb-0"><?php echo esc_attr(get_post_meta($pid, '_license_start_date', true)); ?></h6>
                                            </div>
                                        </div>

                                        <!-- Item -->
                                        <div class="col-md-4">
                                            <div class="bg-light py-3 px-4 rounded-3">
                                                <h6 class="fw-light small mb-1"><?php echo esc_html__('تاريخ الانتهاء', 'khebrat_theme'); ?></h6>
                                                <h6 class="mb-0"><?php echo esc_attr(get_post_meta($pid, '_license_end_date', true)); ?></h6>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="bg-light py-3 px-4 rounded-3">
                                                <h6 class="fw-light small mb-1"><?php echo esc_html__('رقم الرخصة', 'khebrat_theme'); ?></h6>
                                                <h6 class="mb-0"><?php echo esc_attr(get_post_meta($pid, '_license_number', true)); ?></h6>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Button -->
                                    <div class="d-grid gap-2">

                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal"><?php echo esc_attr__('عرض الملف الرخصة', 'khebrat_theme'); ?></button>
                                    </div>
                                </div>
                                <!-- Card body END -->
                            </div>

                            <div class="card border mb-4">
                                <!-- Card header -->
                                <div class="card-header bg-transparent border-bottom">
                                    <h5 class="card-header-title"><?php echo esc_html__('تعديل بيانات المحامي', 'khebrat_theme'); ?></h5>
                                </div>



                                <!-- Form START -->
                                <form id="lawyer_info_form" class="card-body">

                                    <?php
                                    $uploaded_file_id = get_post_meta($pid, '_license_attached_pdf', true); // أو حسب الحقل الخاص بك
                                    $uploaded_file_url = !empty($uploaded_file_id) ? wp_get_attachment_url($uploaded_file_id) : '';
                                    ?>

                                    <div class="form-group mb-3">
                                        <label class="upload-box">
                                            <div class="upload-icon"><i class="bi bi-upload display-3"></i></div>
                                            <p id="license_name_file">
                                                <?php if (!empty($uploaded_file_url)) :
                                                    $uploaded_file_name = basename($uploaded_file_url); // استخراج اسم الملف من الرابط
                                                ?>
                                                    <a type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#pdfModal"><?php echo esc_html($uploaded_file_name); ?></a>

                                                <?php endif; ?>
                                            </p>
                                            <div class="upload-text">
                                                <?php echo !empty($uploaded_file_url) ? 'تغيير الرخصة' : 'قم بإدراج الملفات هنا'; ?>

                                            </div>
                                            <input type="file" id="license_file" accept="application/pdf">
                                        </label>

                                        <input type="hidden" id="uploaded_license_file" name="uploaded_license_file" value="<?php echo esc_attr($uploaded_file_id); ?>" required data-smk-msg="يرجى إدراج ملف الرخصة">
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label class="form-label"><?php echo esc_html__('نوع الرخصة', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                        <?php
                                        $license_type = get_post_meta($pid, '_license_type', true)
                                        ?>
                                        <select name="license_type" class="form-select" required data-smk-msg="<?php echo esc_attr__('Please select license_type', 'khebrat_theme'); ?>">
                                            <option value="محامي مرخص" <?php if ($license_type  == "محامي مرخص") {
                                                                            echo "selected=selected";
                                                                        } ?>><?php echo __("محامي مرخص", 'khebrat_theme'); ?> </option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">تاريخ البداية *</label>
                                        <input type="text" class="form-control flatpickr" name="license_start_date" value="<?php echo esc_attr(get_post_meta($pid, '_license_start_date', true)); ?>" required data-smk-msg="يرجى تحديد تاريخ البداية" placeholder="تحديد تاريخ البداية" data-date-format="d m Y">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">تاريخ الانتهاء *</label>
                                        <input type="text" class="form-control flatpickr" name="license_end_date" value="<?php echo esc_attr(get_post_meta($pid, '_license_end_date', true)); ?>" required data-smk-msg="يرجى تحديد تاريخ الانتهاء" placeholder="تحديد تاريخ الانتهاء" data-date-format="d m Y">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">رقم الرخصة *</label>
                                        <input type="text" class="form-control" name="license_number" value="<?php echo esc_attr(get_post_meta($pid, '_license_number', true)); ?>" required data-smk-msg="يرجى إدخال رقم الرخصة">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">سعر الاستشارة *</label>
                                        <input type="text" class="form-control" name="consultation_price" value="<?php echo esc_attr(get_post_meta($pid, '_consultation_price', true)); ?>" required data-smk-msg="يرجى إدخال رقم الرخصة">
                                    </div>




                                    <!-- Recent Search START -->
                                    <div class="row g-2 mt-6">
                                        <!-- Title -->
                                        <div class="col-lg-2">
                                            <h4 class="mb-0"><?php echo esc_html__('التخصصات', 'khebrat_theme'); ?></h4>
                                        </div>
                                        <?php

                                        $legal_taxonomies = get_terms(array(
                                            'taxonomy' => 'legal_category',
                                            'hide_empty' => false,
                                            'parent' => 0,
                                        ));

                                        // التصنيفات المرتبطة بالمنشور
                                        $saved_legal_terms = wp_get_post_terms($pid, 'legal_category', array('fields' => 'ids'));
                                        ?>
                                        <div class="col-lg-10">
                                            <div class="hstack flex-wrap gap-3" id="selectedItems">
                                                <?php
                                                if (!empty($saved_legal_terms)) :
                                                    foreach ($saved_legal_terms as $term_id) :
                                                        $term = get_term($term_id, 'legal_category');
                                                        if (!is_wp_error($term)) :
                                                ?>
                                                            <div class="alert bg-light fade show small px-3 py-1 mb-0 d-flex align-items-center" role="alert" data-term-id="<?php echo esc_attr($term->term_id); ?>">
                                                                <span class="me-1"><?php echo esc_html($term->name); ?></span>
                                                                <input type="hidden" name="selected_legal_categories[]" value="<?php echo esc_attr($term->term_id); ?>" required data-smk-msg="يرجى اختيار اختصاص واحد علي الاقل">
                                                                <button type="button" class="btn-close small p-2" aria-label="Close"></button>
                                                            </div>
                                                <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                        </div>




                                        <div class="form-row">
                                            <div class="form-group col-md-12">

                                                <!-- القائمة المنسدلة -->
                                                <select id="dropdown" class="form-select">
                                                    <option value="">-- اختر تخصص --</option>
                                                    <?php if (!empty($legal_taxonomies) && !is_wp_error($legal_taxonomies)) : ?>
                                                        <?php foreach ($legal_taxonomies as $term) : ?>
                                                            <?php
                                                            // لا تعرض التخصصات المختارة بالفعل
                                                            if (!in_array($term->term_id, $saved_legal_terms)) :
                                                            ?>
                                                                <option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>

                                                <!-- التخصصات المختارة تظهر هنا -->

                                                <input type="hidden" id="validation_selected_legal_categories" required data-smk-msg="يرجى اختيار اختصاص واحد على الأقل">

                                            </div>
                                        </div>



                                    </div>
                                    <!-- Recent Search END -->




                                    <div class="d-sm-flex justify-content-end">
                                        <button type="button" class="btn btn-primary me-2 mb-0  btn-loading" id="lawyer_info_btn" data-post-id="<?php echo esc_attr($pid) ?>">
                                            <?php echo esc_attr__('تحديث بيانات المحامي', 'khebrat_theme'); ?>
                                            <input type="hidden" id="save_info_nonce" value="<?php echo wp_create_nonce('fl_save_info_secure'); ?>" />
                                            <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                        </button>
                                    </div>
                                </form>
                                <!-- Form END -->
                            </div>
                        </div>
                        <!-- Tab content 2 END -->


                    </div>
                </div>
            </div>
            <!-- Tabs Content END -->
        </div>
    </section>
    <!-- =======================
Content END -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">عرض الملف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewer" src="" width="100%" height="600px" style="border: none;"></iframe>
                    
                </div>
            </div>
        </div>
    </div>



    <!-- جافاسكربت -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hash = window.location.hash;

            if (hash) {
                const tabTriggerEl = document.querySelector(`a[href="${hash}"]`);
                if (tabTriggerEl) {
                    const tab = new bootstrap.Tab(tabTriggerEl);
                    tab.show();
                }
            }

            // عند النقر على أي تبويب، نغيّر الهاش في الرابط
            const tabLinks = document.querySelectorAll('a[data-bs-toggle="tab"]');
            tabLinks.forEach((tabLink) => {
                tabLink.addEventListener("shown.bs.tab", function(e) {
                    const hash = e.target.getAttribute("href");
                    history.replaceState(null, null, hash);
                });
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

        document.addEventListener("DOMContentLoaded", function() {
            var pdfUrl = "<?php echo esc_url($pdf_url); ?>";
            var iframe = document.getElementById('pdfViewer');
            var modal = document.getElementById('pdfModal');

            modal.addEventListener('show.bs.modal', function() {
                iframe.src = pdfUrl;
            });

            modal.addEventListener('hidden.bs.modal', function() {
                iframe.src = ''; 
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('dropdown');
            const selectedItemsDiv = document.getElementById('selectedItems');
            const validationInput = document.getElementById('validation_selected_legal_categories');
            const noSelectionMessage = document.getElementById('noSelectionMessage');
            const form = dropdown.closest('form'); // الوصول للفورم

            function checkIfNoSelections() {
                if (selectedItemsDiv.querySelectorAll('input[type="hidden"]').length === 0) {
                    validationInput.value = ''; // لا يوجد تخصص ➔ فارغ (smkValidate يمنع الإرسال)
                } else {
                    validationInput.value = '1'; // تم اختيار تخصص ➔ قيمة موجودة
                }
            }

            dropdown.addEventListener('change', function() {
                const selectedOption = dropdown.options[dropdown.selectedIndex];
                const value = selectedOption.value;
                const label = selectedOption.text;

                if (value) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert bg-light fade show small px-3 py-1 mb-0 d-flex align-items-center';
                    alertDiv.setAttribute('role', 'alert');
                    alertDiv.setAttribute('data-term-id', value);
                    alertDiv.innerHTML = `
                <span class="me-1">${label}</span>
                <input type="hidden" name="selected_legal_categories[]" value="${value}">
                <button type="button" class="btn-close small p-2" aria-label="Close"></button>
            `;

                    selectedItemsDiv.appendChild(alertDiv);

                    selectedOption.remove();
                    dropdown.selectedIndex = 0;

                    // زر الإغلاق لإرجاع التخصص
                    alertDiv.querySelector('.btn-close').addEventListener('click', function() {
                        const termId = alertDiv.getAttribute('data-term-id');
                        const newOption = document.createElement('option');
                        newOption.value = termId;
                        newOption.text = label;
                        dropdown.appendChild(newOption);

                        alertDiv.remove();
                        checkIfNoSelections(); // تحديث التحقق بعد الحذف
                    });

                    checkIfNoSelections(); // تحديث التحقق بعد الإضافة
                }
            });

            // عند تحميل الصفحة: ربط أزرار الحذف للتخصصات الموجودة
            selectedItemsDiv.querySelectorAll('.btn-close').forEach(function(button) {
                button.addEventListener('click', function() {
                    const alertDiv = button.parentElement;
                    const termId = alertDiv.getAttribute('data-term-id');
                    const label = alertDiv.querySelector('span').textContent.trim();

                    const newOption = document.createElement('option');
                    newOption.value = termId;
                    newOption.text = label;
                    dropdown.appendChild(newOption);

                    alertDiv.remove();
                    checkIfNoSelections(); // تحديث التحقق بعد الحذف
                });
            });

            // ربط التحقق قبل إرسال النموذج
            form.addEventListener('submit', function(e) {
                checkIfNoSelections(); // تأكد قبل الإرسال
            });

            // عند تحميل الصفحة تحديث حالة التحقق
            checkIfNoSelections();
        });
    </script>



<?php
}
?>