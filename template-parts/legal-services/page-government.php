<?php
//صفحة - مراجعة الجهات والدوائر الحكومية



global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$customer_id = get_user_meta($current_user_id, 'customer_id', true);
if (isset($_GET['lsid']) == '') {
    $is_service_paid = fl_framework_get_options('is_services_paid');
    if (isset($is_service_paid) && $is_service_paid == 1) {
        $simple_services = get_post_meta($customer_id, '_simple_services', true);
        $freelancer_package_expiry_date = get_post_meta($customer_id, '_freelancer_package_expiry_date', true);
        $today_date = date("d-m-Y");

        if ($simple_services < 1 && $simple_services != -1 || strtotime($freelancer_package_expiry_date) < strtotime($today_date)) {
            echo exertio_redirect(get_the_permalink(fl_framework_get_options('freelancer_package_page')));
        }
    }
}



$cust_id = get_user_meta($current_user_id, 'customer_id', true);


// التحقق إذا كان هناك lsid في الرابط
if (isset($_GET['lsid'])) {
    $lsid = intval($_GET['lsid']);
} else {
    // لا يوجد lsid في الرابط، محاولة البحث عن منشور pending
    $args = array(
        'post_type'      => 'legal_services',
        'post_status'    => 'pending',
        'author'         => $current_user_id,
        'posts_per_page' => 1,
        'orderby'        => 'ID',
        'order'          => 'DESC',
    );

    $pending_posts = get_posts($args);

    if (!empty($pending_posts)) {
        // يوجد منشور pending
        $lsid = $pending_posts[0]->ID;
    } else {
        // لا يوجد منشور pending → إنشاء جديد
        $my_post = array(
            'post_title'  => '',
            'post_status' => 'pending',
            'post_author' => $current_user_id,
            'post_type'   => 'legal_services'
        );
        $lsid = wp_insert_post($my_post);
    }
}

// محاولة جلب المنشور
$post = get_post($lsid);

// تأكيد أن المنشور موجود
if (empty($post)) {
    $my_post = array(
        'post_title'  => '',
        'post_status' => 'pending',
        'post_author' => $current_user_id,
        'post_type'   => 'legal_services'
    );
    $lsid = wp_insert_post($my_post);
    $post = get_post($lsid);
}



$parent_terms = get_terms([
    'taxonomy'   => 'legal_category',
    'hide_empty' => false,
    'parent'     => 0
]);

$children_by_parent = [];
foreach ($parent_terms as $parent) {
    $children = get_terms([
        'taxonomy'   => 'legal_category',
        'hide_empty' => false,
        'parent'     => $parent->term_id
    ]);
    $children_by_parent[$parent->term_id] = $children;
}

$session_location1 = get_post_meta($lsid, '_session_location_1', true);
$session_location2 = get_post_meta($lsid, '_session_location_2', true);
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
$saved_child_term = $session_location2;
$saved_parent_term = '';
if ($saved_child_term) {
    $child_term = get_term($saved_child_term);
    $saved_parent_term = $child_term ? $child_term->parent : '';
}


?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body content-wrapper">
            <h3 class="text-center mb-4"><?php echo get_the_title($khebrat_theme_options['page_government']); ?></h3>


            <form id="legal_services_form">
                <!-- الصفحة 1: اختيار التصنيف الأب -->
                <div class="step active">
                    <p class="mb-4 ">1/2</p>


                    <div class="form-group">
                        <label for="requestTitle">عنوان الطلب</label>
                        <input type="text" class="form-control" id="requestTitle" name="request_title" value="<?php echo get_post_meta($lsid, '_request_title', true); ?>" placeholder="يرجى كتابة عنوان الطلب بشكل واضح ومختصر" required></input>
                    </div>

                    <?php
                    $gov_name = get_post_meta($lsid, '_gov_name', true);

                    
                    $session_date      = get_post_meta($lsid, '_session_date', true);
                    $session_time      = get_post_meta($lsid, '_session_time', true);
                    $review_reason = get_post_meta($lsid, '_case_subject', true);

                    ?>


                    <!-- اسم الدائرة أو الجهة الحكومية -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم الدائرة أو الجهة الحكومية</label>
                        <input type="text" name="gov_name" class="form-control" value="<?php echo esc_attr($gov_name); ?>">
                    </div>

                    <!-- الموقع -->
                    <div class="row mb-3">
                        <label class="form-label fw-bold">الموقع</label>
                        <div class="col-md-6">
                            <label for="parent-select">المنطقة</label>
                            <select class="form-select" name="session_location_1" id="parent-select">
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
                            <select name="session_location_2" id="child-select" class="form-select" <?php echo empty($saved_parent_term) ? 'disabled' : ''; ?>>
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

                    </div>



                    <!-- سبب المراجعة والمطلوب تنفيذه -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">سبب المراجعة والمطلوب تنفيذه</label>
                        <textarea name="case_subject" rows="4" class="form-control"><?php echo esc_textarea($review_reason); ?></textarea>
                    </div>

                    <!-- موعد الجلسة -->
                    <div class="mb-3">
                        <label class="form-label fw-bold"> تاريخ وموعد الزيارة</label>
                        <input type="text" class="form-control flatpickr mb-2" name="session_date" value="<?php echo esc_attr($session_date); ?>" placeholder="Enter date of birth" data-date-format="d M Y">
                        <input type="time" name="session_time" class="form-control" value="<?php echo esc_attr($session_time); ?>">
                    </div>



                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>

                </div>



                <div class="step">
                    <p class="mb-4">2/2</p>
                    <h5 class="text-center"></h5>


                    <?php $pro_img_id = get_post_meta($lsid, '_project_attachment_ids', true); ?>
                    <div class="col-12 card-body project-attachments">
                        <div class="form-row img-wrapper" style=display:block;>
                            <div class="form-group col-md-12">
                                <div class="upload-btn-wrapper">
                                    <button class="btn btn-primary mt-2 mt-xl-0" type="button"><?php echo esc_html__('Upload Attachments', 'khebrat_theme'); ?></button>
                                    <input type="file" id="project_attachments" multiple name="project_attachments[]" accept="image/pdf/doc/docx/ppt/pptx*" data-post-id="<?php echo esc_attr($lsid) ?>" />
                                    <input type="hidden" name="attachment_ids" value="<?php echo esc_attr($pro_img_id); ?>" id="attachments_ids">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 attachment-box sortable attachment-box-services" style=display:block;>
                                <?php
                                if (isset($pro_img_id) && $pro_img_id != '') {
                                    $atatchment_arr = explode(',', $pro_img_id);
                                    foreach ($atatchment_arr as $value) {
                                        $icon = get_icon_for_attachment($value);
                                        echo wp_attachment_is_image($icon);

                                        echo '<div class="attachments ui-state-default pro-atta-' . $value . '">
														<img src="' . $icon . '" alt="' . get_post_meta($value, '_wp_attachment_image_alt', true) . '" class="img-fluid" data-img-id="' . $value . '">
														<span class="attachment-data">
															<h4>' . get_the_title($value) . '</h4>
															<p>' . esc_html__('file size', 'khebrat_theme') . ' ' . size_format(filesize(get_attached_file($value))) . '</p>
															<a href="javascript:void(0)" class="btn-pro-clsoe-icon" data-id="' . $value . '" data-pid="' . $lsid . '"> <i class="fas fa-times"></i></a>
														</span>
													</div>';
                                    }
                                }
                                ?>
                            </div>
                            <input type="hidden" class="project_attachment_ids" name="project_attachment_ids" value="<?php echo esc_attr($pro_img_id); ?>">
                            <p class="attachment_note"><?php echo esc_html__('Drag & drop to rearrange and press save button to apply. First image will be main display image.', 'khebrat_theme'); ?></p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-success" id="create_legal_services_btn" data-post-id="<?php echo esc_attr($lsid) ?>">إرسال</button>
                        <input type="hidden" name="service_type" value="<?php echo $khebrat_theme_options['page_government']; ?>" />

                        <input type="hidden" id="create_legal_services_nonce" value="<?php echo wp_create_nonce('fl_create_legal_services_secure'); ?>" />


                    </div>
                </div>


            </form>
        </div>
    </div>
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

    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.nextBtn');
        const prevButtons = document.querySelectorAll('.prevBtn');
        const parentRadios = document.querySelectorAll('input[name="locations_parent_term"]');
        const childOptions = document.getElementById('child-options');
        const childrenByParent = <?php echo json_encode($children_by_parent); ?>;

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
            });
        }

        // nextButtons.forEach(button => {
        //     button.addEventListener('click', function() {
        //         if (currentStep < steps.length - 1) {
        //             currentStep++;
        //             showStep(currentStep);
        //         }
        //     });
        // });

        // prevButtons.forEach(button => {
        //     button.addEventListener('click', function() {
        //         if (currentStep > 0) {
        //             currentStep--;
        //             showStep(currentStep);
        //         }
        //     });
        // });

        parentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const parentId = this.value;
                childOptions.innerHTML = '';

                if (parentId && childrenByParent[parentId]) {
                    childrenByParent[parentId].forEach(function(child) {
                        const div = document.createElement('div');
                        div.classList.add('col-md-4', 'mb-3');

                        const input = document.createElement('input');
                        input.classList.add('btn-check');
                        input.type = 'checkbox';
                        input.name = 'locations_child_term[]';
                        input.id = 'child-' + child.term_id;
                        input.value = child.term_id;

                        const label = document.createElement('label');
                        label.classList.add('btn', 'btn-outline-primary', 'w-100', 'p-3');
                        label.htmlFor = 'child-' + child.term_id;
                        label.textContent = child.name;

                        div.appendChild(input);
                        div.appendChild(label);
                        childOptions.appendChild(div);
                    });
                } else {
                    childOptions.innerHTML = '<p class="text-muted">يرجى اختيار التخصص أولاً</p>';
                }
            });
        });

        // showStep(currentStep);
    });
</script>

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     let steps = document.querySelectorAll(".step");
    //     let currentStep = 0;
    //     let nextBtns = document.querySelectorAll(".nextBtn");
    //     let prevBtns = document.querySelectorAll(".prevBtn");
    //     let categoryInputs = document.querySelectorAll(".category-input");
    //     let goToStep2Btn = document.getElementById("goToStep2");

    //     function showStep(stepIndex) {
    //         steps.forEach((step, index) => {
    //             step.classList.toggle("active", index === stepIndex);
    //         });
    //     }

    //     // التنقل بين الصفحات عند الضغط على زر "التالي"
    //     nextBtns.forEach(btn => {
    //         btn.addEventListener("click", function() {
    //             currentStep++;
    //             showStep(currentStep);
    //         });
    //     });

    //     // التنقل بين الصفحات عند الضغط على زر "السابق"
    //     prevBtns.forEach(btn => {
    //         btn.addEventListener("click", function() {
    //             currentStep--;
    //             showStep(currentStep);
    //         });
    //     });




    // });
</script>