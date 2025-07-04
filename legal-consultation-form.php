<?php



//صفحة - دراسة قضية



global $khebrat_theme_options;
$current_user_id = get_current_user_id();



// التحقق إذا كان هناك lcid في الرابط
if (isset($_GET['lcid'])) {
    $lcid = intval($_GET['lcid']); 
} else {
    // لا يوجد lcid في الرابط، محاولة البحث عن منشور pending
    $args = array(
        'post_type'      => 'legal_consultation',
        'post_status'    => 'pending',
        'author'         => $current_user_id,
        'posts_per_page' => 1,
        'orderby'        => 'ID',
        'order'          => 'DESC',
    );

    $pending_posts = get_posts($args);

    if (!empty($pending_posts)) {
        // يوجد منشور pending
        $lcid = $pending_posts[0]->ID;
    } else {
        // لا يوجد منشور pending → إنشاء جديد
        $my_post = array(
            'post_title'  => '',
            'post_status' => 'pending',
            'post_author' => $current_user_id,
            'post_type'   => 'legal_consultation'
        );
        $lcid = wp_insert_post($my_post);
    }
}

// محاولة جلب المنشور
$post = get_post($lcid);

// تأكيد أن المنشور موجود
if (empty($post)) {
    $my_post = array(
        'post_title'  => '',
        'post_status' => 'pending',
        'post_author' => $current_user_id,
        'post_type'   => 'legal_consultation'
    );
    $lcid = wp_insert_post($my_post);
    $post = get_post($lcid);
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

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-body content-wrapper">
            <h3 class="text-center mb-4"><?php echo get_the_title($khebrat_theme_options['form_legal_consultation']); ?></h3>


            <form id="legal_consultation_form">
                <!-- الصفحة 1: اختيار التصنيف الأب -->
                <div class="step active">
                    <p class="mb-4 ">1/4</p>
                    <h5 class="text-center">اختر التخصص</h5>

                    <div class="row">
                        <?php foreach ($parent_terms as $parent) : ?>
                            <div class="col-md-6 col-lg-4">
                                <label class="btn btn-outline-primary w-100 p-3 d-flex align-items-center">
                                    <input type="radio" name="locations_parent_term" class="d-none nextBtn" value="<?php echo esc_attr($parent->term_id); ?>">
                                    <div>
                                        <h6 class="mb-1"><?php echo esc_html($parent->name); ?></h6>
                                        <p class="small text-muted"><?php echo esc_html($parent->description); ?></p>
                                    </div>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- الصفحة 2: اختيار التصنيف الفرعي -->
                <div class="step">
                    <p class="mb-4">2/4</p>
                    <h5 class="text-center"></h5>

                    <div id="child-options" class="row text-center">
                        <p class="text-muted">يرجى اختيار التخصص أولاً</p>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>

                </div>


                <div class="step">
                    <p class="mb-4">3/4</p>
                    <h5 class="text-center"></h5>

                    <div class="form-group">
                        <label for="requestTitle">عنوان الاستشارة</label>
                        <input type="text" class="form-control" id="requestTitle" name="request_title" value="<?php echo get_post_meta($lcid, '_request_title', true); ?>" placeholder="يرجى كتابة عنوان الطلب بشكل واضح ومختصر" required></input>

                    </div>

                    <div class="form-group">
                        <label for="caseSubject">تفاصيل الاستشارة</label>
                        <textarea class="form-control" id="caseSubject" name="case_subject" rows="3" data-smk-msg="حضور جلسات" placeholder="يرجى كتابة تفاصيل الاستشارة باختصار ووضوح والاسئلة التي ترغب بالحصول على اجاباتها من المحامي" required><?= esc_textarea(get_post_meta($lcid, '_case_subject', true)); ?></textarea>
                    </div>



                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>

                <div class="step">
                    <p class="mb-4">4/4</p>
                    <h5 class="text-center"></h5>


                    <?php $pro_img_id = get_post_meta($lcid, '_project_attachment_ids', true); ?>
                    <div class="col-12 card-body project-attachments">
                        <div class="form-row img-wrapper" style=display:block;>
                            <div class="form-group col-md-12">
                                <div class="upload-btn-wrapper">
                                    <button class="btn btn-primary mt-2 mt-xl-0" type="button"><?php echo esc_html__('Upload Attachments', 'khebrat_theme'); ?></button>
                                    <input type="file" id="project_attachments" multiple name="project_attachments[]" accept="image/pdf/doc/docx/ppt/pptx*" data-post-id="<?php echo esc_attr($lcid) ?>" />
                                    <input type="hidden" name="attachment_ids" value="<?php echo esc_attr($pro_img_id); ?>" id="attachments_ids">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 attachment-box sortable attachment-box-consultation" style=display:block;>
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
													<a href="javascript:void(0)" class="btn-pro-clsoe-icon" data-id="' . $value . '" data-pid="' . $lcid . '"> <i class="fas fa-times"></i></a>
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
                        <button type="button" class="btn btn-success" id="create_legal_consultation_btn" data-post-id="<?php echo esc_attr($lcid) ?>">إرسال</button>
                        <button class="btn btn-theme buy_service" type="button" id="buy_se rvice_woo" data-lcid="<?php echo esc_attr($lcid) ?>"> <?php echo esc_html__('Purchase Now', 'khebrat_theme'); ?></button>
                        <input type="hidden" id="create_legal_consultation_nonce" value="<?php echo wp_create_nonce('fl_create_legal_consultation_secure'); ?>" />


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