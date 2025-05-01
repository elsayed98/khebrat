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
    
    <div class="vstack gap-4">
        <!-- Verified message -->
        <div class="bg-light rounded p-3">
            <!-- Progress bar -->
            <div class="overflow-hidden">
                <h6>Complete Your Profile</h6>
                <div class="progress progress-sm bg-success bg-opacity-10">
                    <div class="progress-bar bg-success aos" role="progressbar"
                        data-aos="slide-right" data-aos-delay="200" data-aos-duration="1000"
                        data-aos-easing="ease-in-out" style="width: 85%" aria-valuenow="85"
                        aria-valuemin="0" aria-valuemax="100">
                        <span class="progress-percent-simple h6 fw-light ms-auto">85%</span>
                    </div>
                </div>
                <p class="mb-0">Get the best out of booking by adding the remaining details!</p>
            </div>
            <!-- Content -->
            <div class="bg-body rounded p-3 mt-3">
                <ul class="list-inline hstack flex-wrap gap-2 justify-content-between mb-0">
                    <li class="list-inline-item h6 fw-normal mb-0"><a href="#"><i class="bi bi-check-circle-fill text-success me-2"></i>Verified Email</a></li>
                    <li class="list-inline-item h6 fw-normal mb-0"><a href="#"><i class="bi bi-check-circle-fill text-success me-2"></i>Verified Mobile Number</a></li>
                    <li class="list-inline-item h6 fw-normal mb-0"><a href="#" class="text-primary"><i class="bi bi-plus-circle-fill me-2"></i>Complete Basic Info</a></li>
                </ul>
            </div>
        </div>

        <!-- Personal info START -->
        <div class="card border">
            <!-- Card header -->
            <div class="card-header border-bottom">
                <h4 class="card-header-title"><?php echo esc_html__('Profile details', 'khebrat_theme'); ?></h4>
            </div>

            <!-- Card body START -->
            <div class="card-body content-wrapper ">
                <!-- Form START -->
                <form id="customer_form" class="row g-3">
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
                        <input type="text" class="form-control" name="customer_full_name" value="<?php echo esc_html(get_post_meta($pid, '_customer_full_name', true)); ?>" placeholder="ادخل الاسم بالكامل" required data-smk-msg="<?php echo esc_attr__('الرجاء ادخال الاسم بالكامل', 'khebrat_theme'); ?>">
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label"><?php echo esc_html__('Email address', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                        <input type="email" class="form-control" value="<?php echo esc_html($user_info->user_email); ?>" disabled placeholder="Enter your email id">
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-6">
                        <label class="form-label"><?php echo esc_html__('رقم الجوال', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="tel" name="customer_contact_number" class="form-control" value="<?php echo esc_attr(get_post_meta($pid, '_customer_contact_number', true)); ?>" pattern="\d{9}" placeholder="5xxxxxxxx">
                            <span class="input-group-text">
                                <img src="https://flagcdn.com/w40/sa.png" alt="SA" width="20" class="me-1"> +966
                            </span>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <label class="form-label"><?php echo esc_html__('نوع الحساب', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                        <?php
                        $customer_attribute = get_post_meta($pid, '_customer_attribute', true)
                        ?>
                        <select name="customer_attribute" class="form-select" required data-smk-msg="<?php echo esc_attr__('Please select customer_attribute', 'khebrat_theme'); ?>">
                            <option value="single" <?php if ($customer_attribute  == "single") {
                                                        echo "selected=selected";
                                                    } ?>><?php echo __("فرد", 'khebrat_theme'); ?> </option>
                            <option value="company" <?php if ($customer_attribute  == "company") {
                                                        echo "selected=selected";
                                                    } ?>><?php echo __("شركة", 'khebrat_theme'); ?> </option>
                        </select>
                    </div>

                    <div id="company-fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label"><?php echo esc_html__('اسم الشركة', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" value="<?php echo esc_attr(get_post_meta($pid, '_company_name', true)); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?php echo esc_html__('السجل الضريبي', 'khebrat_theme'); ?><span class="text-danger">*</span></label>
                                <input type="text" name="company_tax" class="form-control" value="<?php echo esc_attr(get_post_meta($pid, '_company_tax', true)); ?>">
                            </div>
                        </div>
                    </div>
                    <script>

                    </script>


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
                        <button type="button" class="btn btn-primary btn-loading" id="customer_profile_btn" data-post-id="<?php echo esc_attr($pid) ?>">
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
            const select = document.querySelector('select[name="customer_attribute"]');
            const companyFields = document.getElementById('company-fields');

            function toggleCompanyFields() {
                if (select.value === 'company') { // 2 = شركة
                    companyFields.style.display = 'block';
                } else {
                    companyFields.style.display = 'none';
                }
            }

            // Initial state
            toggleCompanyFields();

            // On change
            select.addEventListener('change', toggleCompanyFields);
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
    </script>

<?php
}
?>