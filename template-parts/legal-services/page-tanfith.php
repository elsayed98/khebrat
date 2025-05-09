<?php
//صفحة - طلبات التنفيذ




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


?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body content-wrapper">
            <h3 class="text-center mb-4"><?php echo get_the_title($khebrat_theme_options['page_tanfith']); ?></h3>


            <form id="legal_services_form">


                <!-- الصفحة 1:  -->
                <div class="step">
                    <p class="mb-4">1/5</p>
                    <h5 class="text-center"></h5>

                    <div class="row">
                        <!-- حقول المدعي -->
                        <div class="form-group">
                            <label for="plaintiffRole">صفتك كمدعي:</label>
                            <input type="hidden" name="case_role_type" value="مدعى عليه" />
                            <select class="form-control" name="defendant_identity_type">
                                <option value="فرد">فرد</option>
                                <option value="منشأة">منشأة</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="defendantRoleAsPlaintiff">صفة المدعي عليه :</label>
                            <select class="form-control" name="plaintiff_identity_type_by_defendant">
                                <option value="فرد">فرد</option>
                                <option value="منشأة">منشأة</option>
                                <option value="جهة حكومية">جهة حكومية</option>
                            </select>
                        </div>


                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>
                <!-- الصفحة 2:  -->
                <div class="step">
                    <p class="mb-4">2/5</p>
                    <h5 class="text-center"></h5>
                    <?php
                    $execution_type = get_post_meta($lsid, '_execution_type', true);
                    ?>

                    <div class="mb-4">
                        <p class="fw-bold">نوع السند التنفيذي</p>

                        <!-- تنفيذ مالي -->
                        <label class="btn btn-outline-secondary w-100 p-3 mb-2 text-start <?php if ($execution_type == 'financial') echo 'active'; ?>">
                            <input type="radio" name="execution_type" class="d-none" value="financial" <?php if ($execution_type == 'financial') echo 'checked'; ?>>
                            <div>
                                <strong class="d-block">تنفيذ مالي</strong>
                                <small class="text-muted">ما كان محل الحكم والتنفيذ فيه مبلغ مالي موثق بسند تنفيذي يُعتد به</small>
                            </div>
                        </label>

                        <!-- تنفيذ أحوال شخصية -->
                        <label class="btn btn-outline-secondary w-100 p-3 mb-2 text-start <?php if ($execution_type == 'personal_status') echo 'active'; ?>">
                            <input type="radio" name="execution_type" class="d-none" value="personal_status" <?php if ($execution_type == 'personal_status') echo 'checked'; ?>>
                            <div>
                                <strong class="d-block">تنفيذ احوال شخصية</strong>
                                <small class="text-muted">ما كان محل الحكم والتنفيذ فيه نفقة أو عوض أو سكن أو حضانة أو زيارة ونحوها مما كان أثراً لعقد النكاح</small>
                            </div>
                        </label>

                        <!-- تنفيذ مباشر -->
                        <label class="btn btn-outline-secondary w-100 p-3 text-start <?php if ($execution_type == 'direct') echo 'active'; ?>">
                            <input type="radio" name="execution_type" class="d-none" value="direct" <?php if ($execution_type == 'direct') echo 'checked'; ?>>
                            <div>
                                <strong class="d-block">تنفيذ مباشر</strong>
                                <small class="text-muted">ما كان محل الحكم والتنفيذ فيه فعلاً أو امتناعاً عن فعل لا يمكن أن يحل محله التنفيذ على المال مثلًا إخلاء العقار</small>
                            </div>
                        </label>
                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>

                </div>

                <!-- الصفحة 3:  -->
                <div class="step">
                    <p class="mb-4">3/5</p>
                    <h5 class="text-center"></h5>

                    <div class="form-group">
                        <label for="requestTitle">عنوان الطلب</label>
                        <input type="text" class="form-control" id="requestTitle" name="request_title" value="<?php echo get_post_meta($lsid, '_request_title', true); ?>" placeholder="يرجى كتابة عنوان الطلب بشكل واضح ومختصر" required></input>

                    </div>

                    <div class="form-group">
                        <label for="caseSubject"><?php echo esc_html__('موضوع السند التفيذي', 'khebrat_theme'); ?></label>
                        <textarea class="form-control" id="caseSubject" name="case_subject" rows="3" placeholder="يرجى كتابة تفاصيل الموضوع بشكل واضح ومختصر" required><?= esc_textarea(get_post_meta($lsid, '_case_subject', true)); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>


                <!-- الصفحة 4:  -->
                <div class="step">
                    <p class="mb-4">4/5</p>
                    <h5 class="text-center"></h5>

                    <?php
                    $submitted_to_enforcement_court = get_post_meta($lsid, '_submitted_to_enforcement_court', true);
                    $decision_34_issued = get_post_meta($lsid, '_decision_34_issued', true);
                    $decision_46_issued = get_post_meta($lsid, '_decision_46_issued', true);
                    ?>

                    <!-- الحقل الأول -->
                    <div class="mb-4">
                        <p class="fw-bold">هل تم تقديم الطلب لمحكمة التنفيذ؟</p>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 <?php if ($submitted_to_enforcement_court == 'yes') echo 'active'; ?>">
                            <input type="radio" name="submitted_to_enforcement_court" id="submitted_yes" class="d-none" value="yes" <?php if ($submitted_to_enforcement_court == 'yes') echo 'checked'; ?>>
                            <div>نعم</div>
                        </label>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center <?php if ($submitted_to_enforcement_court == 'no') echo 'active'; ?>">
                            <input type="radio" name="submitted_to_enforcement_court" id="submitted_no" class="d-none" value="no" <?php if ($submitted_to_enforcement_court == 'no') echo 'checked'; ?>>
                            <div>لا</div>
                        </label>
                    </div>

                    <!-- الحقل الثاني (قرار 34) -->
                    <div class="mb-4" id="decision34_wrapper" style="display: <?php echo ($submitted_to_enforcement_court == 'yes') ? 'block' : 'none'; ?>;">
                        <p class="fw-bold">هل صدر قرار ٣٤ على المنفذ ضده؟</p>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 <?php if ($decision_34_issued == 'yes') echo 'active'; ?>">
                            <input type="radio" name="decision_34_issued" id="decision34_yes" class="d-none" value="yes" <?php if ($decision_34_issued == 'yes') echo 'checked'; ?>>
                            <div>نعم</div>
                        </label>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center <?php if ($decision_34_issued == 'no') echo 'active'; ?>">
                            <input type="radio" name="decision_34_issued" id="decision34_no" class="d-none" value="no" <?php if ($decision_34_issued == 'no') echo 'checked'; ?>>
                            <div>لا</div>
                        </label>
                    </div>

                    <!-- الحقل الثالث (قرار 46) -->
                    <div class="mb-4" id="decision46_wrapper" style="display: <?php echo ($decision_34_issued == 'yes') ? 'block' : 'none'; ?>;">
                        <p class="fw-bold">هل صدر قرار ٤٦ على المنفذ ضده؟</p>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 <?php if ($decision_46_issued == 'yes') echo 'active'; ?>">
                            <input type="radio" name="decision_46_issued" class="d-none" value="yes" <?php if ($decision_46_issued == 'yes') echo 'checked'; ?>>
                            <div>نعم</div>
                        </label>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center <?php if ($decision_46_issued == 'no') echo 'active'; ?>">
                            <input type="radio" name="decision_46_issued" class="d-none" value="no" <?php if ($decision_46_issued == 'no') echo 'checked'; ?>>
                            <div>لا</div>
                        </label>
                    </div>




                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>

                <div class="step">
                    <p class="mb-4">5/5</p>
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
                        <input type="hidden" name="service_type" value="<?php echo $khebrat_theme_options['page_tanfith']; ?>" />

                        <input type="hidden" id="create_legal_services_nonce" value="<?php echo wp_create_nonce('fl_create_legal_services_secure'); ?>" />


                    </div>
                </div>


            </form>
        </div>
    </div>
</div>



<!-- JavaScript لإظهار الحقول -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submittedYes = document.getElementById('submitted_yes');
        const submittedNo = document.getElementById('submitted_no');
        const decision34Wrapper = document.getElementById('decision34_wrapper');

        const decision34Yes = document.getElementById('decision34_yes');
        const decision34No = document.getElementById('decision34_no');
        const decision46Wrapper = document.getElementById('decision46_wrapper');

        function toggleDecisionFields() {
            if (submittedYes.checked) {
                decision34Wrapper.style.display = 'block';
            } else {
                decision34Wrapper.style.display = 'none';
                decision46Wrapper.style.display = 'none';
            }

            if (decision34Yes.checked) {
                decision46Wrapper.style.display = 'block';
            } else {
                decision46Wrapper.style.display = 'none';
            }
        }

        submittedYes.addEventListener('change', toggleDecisionFields);
        submittedNo.addEventListener('change', toggleDecisionFields);
        if (decision34Yes) decision34Yes.addEventListener('change', toggleDecisionFields);
        if (decision34No) decision34No.addEventListener('change', toggleDecisionFields);

        toggleDecisionFields(); // تنفيذ عند التحميل
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.nextBtn');
        const prevButtons = document.querySelectorAll('.prevBtn');
        const parentRadios = document.querySelectorAll('input[name="locations_parent_term"]');
        const childOptions = document.getElementById('child-options');
        const childrenByParent = <?php echo json_encode($children_by_parent); ?>;

        // function showStep(stepIndex) {
        //     steps.forEach((step, index) => {
        //         step.classList.toggle('active', index === stepIndex);
        //     });
        // }

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
    document.addEventListener('DOMContentLoaded', function() {
        // الحصول على كل أسماء مجموعات الراديو المختلفة
        const radioButtons = document.querySelectorAll('input[type="radio"]');

        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                const name = this.name;
                const group = document.querySelectorAll(`input[type="radio"][name="${name}"]`);

                // إزالة class 'active' من كل العناصر في نفس المجموعة
                group.forEach(r => {
                    if (r.closest('label')) {
                        r.closest('label').classList.remove('active');
                    }
                });

                // إضافة class 'active' للراديو المختار
                if (this.checked && this.closest('label')) {
                    this.closest('label').classList.add('active');
                }
            });
        });
    });
</script>