<?php
global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$pid = get_user_meta($current_user_id, 'lawyer_id', true);
$post  =  get_post($pid);

$user_info = get_userdata($current_user_id);
$user_name = $user_info->display_name;

$pro_img_id = get_post_meta($pid, '_profile_pic_attachment_id', true);
$pro_img = wp_get_attachment_image_src($pro_img_id, 'thumbnail');



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


    <!-- ======================= Content START -->
    <section class="pt-0">
        <div class="container vstack gap-4">


            <!-- Personal info START -->
            <div class="card border">
                <!-- Card header -->
                <div class="card-header border-bottom">
                    <h4 class="card-header-title"><?php echo esc_html__('Profile details', 'khebrat_theme'); ?></h4>
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
            <!-- Personal info END -->

            <!-- Update email START -->
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
            <!-- Update email END -->

            <!-- Update Password START -->
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
            <!-- Update Password END -->
        </div>

        <script>
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
        </script>
        </div>
    </section>


    <!-- =======================
Content END -->



    <!-- =======================
Content START -->
    <section class="pt-0">
        <div class="container vstack gap-4">
            <!-- Title START -->
            <div class="row">
                <div class="col-12">
                    <h1 class="fs-4 mb-0"><i class="bi bi-gear fa-fw me-1"></i>Settings</h1>
                </div>
            </div>
            <!-- Title END -->

            <!-- Tabs START -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light pb-0 px-2 px-lg-0 rounded-top">
                        <ul class="nav nav-tabs nav-bottom-line nav-responsive border-0 nav-justified" role="tablist">
                            <li class="nav-item"> <a class="nav-link mb-0 active" data-bs-toggle="tab" href="#tab-1"><i class="fas fa-cog fa-fw me-2"></i>Edit Profile</a> </li>
                            <li class="nav-item"> <a class="nav-link mb-0" data-bs-toggle="tab" href="#tab-2"><i class="fas fa-bell fa-fw me-2"></i>Notification Settings</a> </li>
                            <li class="nav-item"> <a class="nav-link mb-0" data-bs-toggle="tab" href="#tab-3"><i class="fas fa-user-circle fa-fw me-2"></i>Account Settings</a> </li>
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
                        <div class="tab-pane show active" id="tab-1">
                            <div class="row g-4">
                                <!-- Edit profile START -->
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header border-bottom">
                                            <h5 class="card-header-title">Edit Profile</h5>
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
                                        <div class="card-header border-bottom">
                                            <h5 class="card-header-title">Update Password</h5>
                                            <p class="mb-0 small">Your current email address is <span class="text-primary">example@gmail.com</span></p>
                                        </div>
                                        <!-- Card body START -->
                                        <form class="card-body">
                                            <!-- Current password -->
                                            <div class="mb-3">
                                                <label class="form-label">Current password</label>
                                                <input class="form-control" type="password" placeholder="Enter current password">
                                            </div>
                                            <!-- New password -->
                                            <div class="mb-3">
                                                <label class="form-label"> Enter new password</label>
                                                <div class="input-group">
                                                    <input class="form-control fakepassword" type="password" id="psw-input" placeholder="Enter new password">
                                                    <span class="input-group-text p-0 bg-transparent">
                                                        <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Confirm -->
                                            <div>
                                                <label class="form-label">Confirm new password</label>
                                                <input class="form-control" type="password" placeholder="Confirm new password">
                                            </div>

                                            <div class="text-end mt-3">
                                                <a href="#" class="btn btn-primary mb-0">Change Password</a>
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
                        <div class="tab-pane" id="tab-2">
                            <div class="card border mb-4">
                                <!-- Card header -->
                                <div class="card-header bg-transparent border-bottom">
                                    <h5 class="card-header-title">Notification Settings</h5>
                                    <p class="mb-0">Figure what you want to be notified about, and unsubscribe from what you don't.</p>
                                </div>

                                <!-- Form START -->
                                <form class="card-body">
                                    <!-- Radio -->
                                    <div class="mb-4">
                                        <label class="form-label">Newsletter *</label>
                                        <div class="d-flex gap-4 flex-wrap">
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDaily" checked="">
                                                <label class="form-check-label" for="flexRadioDaily">
                                                    Daily
                                                </label>
                                            </div>
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Twice a week
                                                </label>
                                            </div>
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                    Weekly
                                                </label>
                                            </div>
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4">
                                                <label class="form-check-label" for="flexRadioDefault4">
                                                    Never
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Switch -->
                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                        <label class="form-check-label ps-0 pe-4" for="checkPrivacy1">Notify me via email when logging in</label>
                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy1" checked="">
                                    </div>

                                    <!-- Switch -->
                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                        <label class="form-check-label ps-0 pe-4" for="checkPrivacy2">I would like to receive booking assist reminders</label>
                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy2" checked="">
                                    </div>

                                    <!-- Switch -->
                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                        <label class="form-check-label ps-0 pe-4" for="checkPrivacy3">I would like to receive emails about Booking promotions</label>
                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy3" checked="">
                                    </div>

                                    <!-- Switch -->
                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                        <label class="form-check-label ps-0 pe-4" for="checkPrivacy7">I would like to know about information and offers related to my upcoming trip</label>
                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy7" checked="">
                                    </div>

                                    <!-- Switch -->
                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                        <label class="form-check-label ps-0 pe-4" for="checkPrivacy4">Show your profile publicly</label>
                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy4">
                                    </div>

                                    <!-- Switch -->
                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                        <label class="form-check-label ps-0 pe-4" for="checkPrivacy6">Send SMS confirmation for all online payments</label>
                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy6">
                                    </div>

                                    <!-- Switch -->
                                    <div class="form-check form-switch form-check-md d-flex justify-content-between mb-4">
                                        <label class="form-check-label ps-0 pe-4" for="checkPrivacy5">Check which device(s) access your account</label>
                                        <input class="form-check-input flex-shrink-0" type="checkbox" id="checkPrivacy5" checked="">
                                    </div>

                                    <!-- Button -->
                                    <div class="d-sm-flex justify-content-end">
                                        <button type="button" class="btn btn-sm btn-primary me-2 mb-0">Save changes</button>
                                        <a href="#" class="btn btn-sm btn-outline-secondary mb-0">Cancel</a>
                                    </div>
                                </form>
                                <!-- Form END -->
                            </div>
                        </div>
                        <!-- Tab content 2 END -->

                        <!-- Tab content 3 START -->
                        <div class="tab-pane" id="tab-3">
                            <div class="row g-4">
                                <!-- Security settings START -->
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header border-bottom">
                                            <h5 class="card-header-title">Security settings</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Two step -->
                                            <form class="mb-3">
                                                <h6>Two-factor authentication</h6>
                                                <label class="form-label">Add a phone number to set up two-factor authentication</label>
                                                <input type="text" class="form-control mb-2" placeholder="Enter your mobile number">
                                                <button class="btn btn-sm btn-primary mb-0">Send Code</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Security settings END -->

                                <!-- Linked account START -->
                                <div class="col-lg-6">
                                    <div class="card border rounded-3">
                                        <!-- Card header -->
                                        <div class="card-header border-bottom">
                                            <h5 class="card-header-title">Linked account</h5>
                                        </div>
                                        <!-- Card body START -->
                                        <div class="card-body pb-0">
                                            <!-- Google -->
                                            <div class="position-relative mb-4 d-sm-flex bg-success bg-opacity-10 border border-success p-3 rounded">
                                                <!-- Title and content -->
                                                <h2 class="fs-1 mb-0 me-3"><i class="fab fa-google text-google-icon"></i></h2>
                                                <div>
                                                    <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle lh-1 h-20px">
                                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                    </div>
                                                    <h6 class="mb-1">Google</h6>
                                                    <p class="mb-1 small">You are successfully connected to your Google account</p>
                                                    <!-- Button -->
                                                    <button type="button" class="btn btn-sm btn-danger mb-0">Invoke</button>
                                                    <a href="#" class="btn btn-sm btn-link text-body mb-0">Learn more</a>
                                                </div>
                                            </div>

                                            <!-- Linkedin -->
                                            <div class="mb-4 d-sm-flex border p-3 rounded">
                                                <!-- Title and content -->
                                                <h2 class="fs-1 mb-0 me-3"><i class="fab fa-linkedin-in text-linkedin"></i></h2>
                                                <div>
                                                    <h6 class="mb-1">Linkedin</h6>
                                                    <p class="mb-1 small">Connect with Linkedin account for a personalized experience</p>
                                                    <!-- Button -->
                                                    <button type="button" class="btn btn-sm btn-primary mb-0">Connect Linkedin</button>
                                                    <a href="#" class="btn btn-sm btn-link text-body mb-0">Learn more</a>
                                                </div>
                                            </div>

                                            <!-- Facebook -->
                                            <div class="mb-4 d-sm-flex border p-3 rounded">
                                                <!-- Title and content -->
                                                <h2 class="fs-1 mb-0 me-3"><i class="fab fa-facebook text-facebook"></i></h2>
                                                <div>
                                                    <h6 class="mb-1">Facebook</h6>
                                                    <p class="mb-1 small">Connect with Facebook account for a personalized experience</p>
                                                    <!-- Button -->
                                                    <button type="button" class="btn btn-sm btn-primary mb-0">Connect Facebook</button>
                                                    <a href="#" class="btn btn-sm btn-link text-body mb-0">Learn more</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card body END -->
                                    </div>
                                </div>
                                <!-- Linked account END -->

                                <!-- Social account END -->
                                <div class="col-lg-6">
                                    <div class="card border rounded-3">
                                        <!-- Card header -->
                                        <div class="card-header border-bottom">
                                            <h5 class="card-header-title">Social media profile</h5>
                                        </div>
                                        <!-- Card body START -->
                                        <div class="card-body">
                                            <!-- Facebook username -->
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fab fa-facebook text-facebook me-2"></i>Enter facebook username</label>
                                                <input class="form-control" type="text" value="loristev" placeholder="Enter username">
                                            </div>

                                            <!-- Twitter username -->
                                            <div class="mb-3">
                                                <label class="form-label"><i class="bi bi-twitter text-twitter me-2"></i>Enter twitter username</label>
                                                <input class="form-control" type="text" value="loristev" placeholder="Enter username">
                                            </div>

                                            <!-- Instagram username -->
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fab fa-instagram text-instagram-gradient me-2"></i>Enter instagram username</label>
                                                <input class="form-control" type="text" value="loristev" placeholder="Enter username">
                                            </div>

                                            <!-- Youtube -->
                                            <div class="mb-3">
                                                <label class="form-label"><i class="fab fa-youtube text-youtube me-2"></i>Add your youtube profile URL</label>
                                                <input class="form-control" type="text" value="https://www.youtube.com/in/Booking-05620abc" placeholder="Enter username">
                                            </div>

                                            <!-- Button -->
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="button" class="btn btn-primary mb-0">Save change</button>
                                            </div>
                                        </div>
                                        <!-- Card body END -->
                                    </div>
                                </div>
                                <!-- Social account END -->

                                <!-- Active logs START -->
                                <div class="col-12">
                                    <div class="card border">

                                        <!-- Card header -->
                                        <div class="card-header border-bottom">
                                            <h5 class="card-header-title">Active Logs</h5>
                                        </div>

                                        <!-- Card body START -->
                                        <div class="card-body">
                                            <!-- Table START -->
                                            <div class="table-responsive border-0">
                                                <table class="table align-middle p-4 mb-0 table-hover">

                                                    <!-- Table head -->
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col" class="border-0 rounded-start">Browser</th>
                                                            <th scope="col" class="border-0">IP</th>
                                                            <th scope="col" class="border-0">Time</th>
                                                            <th scope="col" class="border-0 rounded-end">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <!-- Table body START -->
                                                    <tbody>
                                                        <!-- Table row -->
                                                        <tr>
                                                            <td> Chrome On Window </td>
                                                            <td> 173.238.198.108 </td>
                                                            <td> 12 Nov 2021 </td>
                                                            <td> <button class="btn btn-sm btn-danger-soft me-1 mb-1 mb-md-0">Sign out</button> </td>
                                                        </tr>

                                                        <!-- Table row -->
                                                        <tr>
                                                            <td> Mozilla On Window </td>
                                                            <td> 107.222.146.90 </td>
                                                            <td> 08 Nov 2021 </td>
                                                            <td> <button class="btn btn-sm btn-danger-soft me-1 mb-1 mb-md-0">Sign out</button> </td>
                                                        </tr>

                                                        <!-- Table row -->
                                                        <tr>
                                                            <td> Chrome On iMac </td>
                                                            <td> 231.213.125.55 </td>
                                                            <td> 06 Nov 2021 </td>
                                                            <td> <button class="btn btn-sm btn-danger-soft me-1 mb-1 mb-md-0">Sign out</button> </td>
                                                        </tr>

                                                        <!-- Table row -->
                                                        <tr>
                                                            <td>Mozilla On Window </td>
                                                            <td> 37.242.105.138 </td>
                                                            <td> 02 Nov 2021 </td>
                                                            <td> <button class="btn btn-sm btn-danger-soft me-1 mb-1 mb-md-0">Sign out</button> </td>
                                                        </tr>
                                                    </tbody>
                                                    <!-- Table body END -->
                                                </table>
                                            </div>
                                            <!-- Table END -->

                                            <!-- Active session -->
                                            <form class="mt-4">
                                                <h6 class="mb-0">Active sessions</h6>
                                                <p class="mb-2">Selecting "Sign out" will sign you out from all devices except this one. This can take up to 10 minutes.</p>
                                                <button class="btn btn-sm btn-danger mb-0">Sign Out of all devices</button>
                                            </form>
                                        </div>
                                        <!-- Card body END -->
                                    </div>
                                </div>
                                <!-- Active logs END -->
                            </div>
                        </div>
                        <!-- Tab content 3 END -->
                    </div>
                </div>
            </div>
            <!-- Tabs Content END -->
        </div>
    </section>
    <!-- =======================
Content END -->



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
    </script>

<?php
}
?>