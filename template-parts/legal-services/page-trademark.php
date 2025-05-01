<?php
//صفحة - تسجيل العلامات التجارية



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
            <h3 class="text-center mb-4"><?php echo get_the_title($khebrat_theme_options['page_trademark']); ?></h3>


            <form id="legal_services_form">
                <!-- الصفحة 1: اختيار التصنيف الأب -->
                <div class="step active">
                    <p class="mb-4 ">1/3</p>

                    <?php
                    $applicant_type = get_post_meta($lsid, '_applicant_type', true);
                    $trademark_type = get_post_meta($lsid, '_trademark_type', true);
                    ?>


                    <div class="mb-4">
                        <label class="form-label fw-bold">صفة مقدم الطلب</label>
                        <div class="d-grid gap-2">
                            <label class="btn btn-outline-primary <?php echo ($applicant_type == 'فرد') ? 'active' : ''; ?>">
                                <input type="radio" name="applicant_type" value="فرد" class="d-none" <?php checked($applicant_type, 'فرد'); ?>>
                                فرد
                            </label>
                            <label class="btn btn-outline-primary <?php echo ($applicant_type == 'منشأة') ? 'active' : ''; ?>">
                                <input type="radio" name="applicant_type" value="منشأة" class="d-none" <?php checked($applicant_type, 'منشأة'); ?>>
                                منشأة
                            </label>
                        </div>
                    </div>

                    <!-- نوع العلامة التجارية -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">نوع العلامة التجارية؟</label>
                        <div class="d-grid gap-2">

                            <label class="btn btn-outline-secondary <?php echo ($trademark_type == 'علامة تجارية') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_type" value="علامة تجارية" class="d-none" <?php checked($trademark_type, 'علامة تجارية'); ?>>
                                علامة تجارية
                            </label>

                            <label class="btn btn-outline-secondary <?php echo ($trademark_type == 'علامة صوتية') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_type" value="علامة صوتية" class="d-none" <?php checked($trademark_type, 'علامة صوتية'); ?>>
                                علامة صوتية
                            </label>

                            <label class="btn btn-outline-secondary <?php echo ($trademark_type == 'علامة جماعية') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_type" value="علامة جماعية" class="d-none" <?php checked($trademark_type, 'علامة جماعية'); ?>>
                                <div><strong>علامة جماعية</strong></div>
                                <div class="small text-muted">
                                    تسجيل العلامات الجماعية التي تستخدم لتمييز بين سلع أو خدمات منشآت تعود لأعضاء ينتمون إلى كيان معين يتمتع بشخصية قانونية.
                                </div>
                            </label>

                            <label class="btn btn-outline-secondary <?php echo ($trademark_type == 'علامة الفحص أو المراقبة') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_type" value="علامة الفحص أو المراقبة" class="d-none" <?php checked($trademark_type, 'علامة الفحص أو المراقبة'); ?>>
                                <div><strong>علامة الفحص أو المراقبة</strong></div>
                                <div class="small text-muted">
                                    علامة المراقبة أو الفحص مخصصة للدلالة على إجراء المراقبة أو الفحص. يمكن للأشخاص الاعتباريين الذين يتولون مراقبة أو فحص بعض السلع أو الخدمات من حيث مصدرها أو عناصر تركيبها أو طريقة صنعها أو جودتها أو أي خصائص أخرى تسجيل العلامة.
                                </div>
                            </label>

                            <label class="btn btn-outline-secondary <?php echo ($trademark_type == 'علامة الهيئات ذات النفع العام والمؤسسات المهنية') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_type" value="علامة الهيئات ذات النفع العام والمؤسسات المهنية" class="d-none" <?php checked($trademark_type, 'علامة الهيئات ذات النفع العام والمؤسسات المهنية'); ?>>
                                <div><strong>علامة الهيئات ذات النفع العام والمؤسسات المهنية</strong></div>
                                <div class="small text-muted">
                                    هي علامة تسجيل لعلامات غير تجارية، والعلامات التي تستعملها المؤسسات المهنية لتمييز منتجاتها أو خدماتها عن منتجات وخدمات غيرها.
                                </div>
                            </label>

                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>

                </div>

                <!-- الصفحة 2: اختيار التصنيف الفرعي -->
                <div class="step">
                    <p class="mb-4">2/3</p>
                    <h5 class="text-center"></h5>

                    <div class="form-group">
                        <label for="requestTitle">عنوان الطلب</label>
                        <input type="text" class="form-control" id="requestTitle" name="request_title" value="<?php echo get_post_meta($lsid, '_request_title', true); ?>" placeholder="يرجى كتابة عنوان الطلب بشكل واضح ومختصر" required></input>

                    </div>

                    <?php
                    $trademark_language = get_post_meta($lsid, '_trademark_language', true);
                    $trademark_description = get_post_meta($lsid, '_trademark_description', true);
                    ?>

                    <!-- لغة العلامة التجارية -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">لغة العلامة التجارية</label>
                        <div class="d-grid gap-2">
                            <label class="btn btn-outline-primary <?php echo ($trademark_language == 'عربي') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_language" value="عربي" class="d-none" <?php checked($trademark_language, 'عربي'); ?>>
                                عربي
                            </label>

                            <label class="btn btn-outline-primary <?php echo ($trademark_language == 'انجليزي') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_language" value="انجليزي" class="d-none" <?php checked($trademark_language, 'انجليزي'); ?>>
                                انجليزي
                            </label>

                            <label class="btn btn-outline-primary <?php echo ($trademark_language == 'عربي و انجليزي') ? 'active' : ''; ?>">
                                <input type="radio" name="trademark_language" value="عربي و انجليزي" class="d-none" <?php checked($trademark_language, 'عربي و انجليزي'); ?>>
                                عربي و انجليزي
                            </label>
                        </div>
                    </div>

                    <!-- وصف العلامة التجارية -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">وصف العلامة التجارية</label>
                        <textarea name="trademark_description" rows="4" class="form-control"><?php echo esc_textarea($trademark_description); ?></textarea>
                    </div>



                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>

                </div>

                <div class="step">
                    <p class="mb-4">3/3</p>
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
                        <input type="hidden" name="service_type" value="<?php echo $khebrat_theme_options['page_trademark']; ?>" />

                        <input type="hidden" id="create_legal_services_nonce" value="<?php echo wp_create_nonce('fl_create_legal_services_secure'); ?>" />


                    </div>
                </div>


            </form>
        </div>
    </div>
</div>





<script>
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

        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

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

        showStep(currentStep);
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let steps = document.querySelectorAll(".step");
        let currentStep = 0;
        let nextBtns = document.querySelectorAll(".nextBtn");
        let prevBtns = document.querySelectorAll(".prevBtn");
        let categoryInputs = document.querySelectorAll(".category-input");
        let goToStep2Btn = document.getElementById("goToStep2");

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle("active", index === stepIndex);
            });
        }

        // التنقل بين الصفحات عند الضغط على زر "التالي"
        nextBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                currentStep++;
                showStep(currentStep);
            });
        });

        // التنقل بين الصفحات عند الضغط على زر "السابق"
        prevBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                currentStep--;
                showStep(currentStep);
            });
        });




    });
</script>