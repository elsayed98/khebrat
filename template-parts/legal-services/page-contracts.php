<?php
//صفحة - العقود والاتفاقيات


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
            <h3 class="text-center mb-4"><?php echo get_the_title($khebrat_theme_options['page_contracts']); ?></h3>


            <form id="legal_services_form">
                <!-- الصفحة 1: اختيار التصنيف الأب -->
                <div class="step active">
                    <p class="mb-4 ">1/7</p>
                    <?php
                    $requested_service = get_post_meta($lsid, '_requested_service', true);
                    ?>

                    <div class="mb-4">
                        <p class="fw-bold">ماهي الخدمة المطلوبة؟</p>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 <?php if ($requested_service == 'draft') echo 'active'; ?>">
                            <input type="radio" name="requested_service" class="d-none" value="draft" <?php if ($requested_service == 'draft') echo 'checked'; ?>>
                            <div>صياغة العقود والاتفاقيات</div>
                        </label>

                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center <?php if ($requested_service == 'review') echo 'active'; ?>">
                            <input type="radio" name="requested_service" class="d-none" value="review" <?php if ($requested_service == 'review') echo 'checked'; ?>>
                            <div>مراجعة العقود والاتفاقيات</div>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>

                </div>

                <!-- الصفحة 2: اختيار التصنيف الفرعي -->
                <div class="step">
                    <p class="mb-4">2/7</p>
                    <h5 class="text-center"></h5>

                    <?php
                    $contract_type = get_post_meta($lsid, '_contract_type', true);
                    ?>

                    <div class="mb-4">
                        <p class="fw-bold">نوع العقد</p>

                        <?php
                        $contract_options = [
                            'بيع',
                            'إيجار',
                            'مقايضة',
                            'هبة',
                            'وديعة',
                            'استثمار',
                            'مقاولة',
                            'عمل',
                            'تقديم خدمات',
                            'اتفاقية عدم إفصاح',
                            'مذكرة تفاهم',
                            'شراكات',
                            'امتياز تجاري',
                            'تصنيع وتوريد وتوزيع',
                            'نقل وتخزين',
                            'أخرى'
                        ];

                        foreach ($contract_options as $option) {
                            $value = $option; // القيمة التي ستُحفظ
                            $active_class = ($contract_type === $value) ? 'active' : '';
                            $checked_attr = ($contract_type === $value) ? 'checked' : '';
                            echo '
                              <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 ' . $active_class . '">
                                <input type="radio" name="contract_type" class="d-none" value="' . esc_attr($value) . '" ' . $checked_attr . '>
                                <div>' . esc_html($option) . '</div>
                              </label>
                            ';
                        }
                        ?>
                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>

                </div>

                <!-- الصفحة 3:  -->
                <div class="step">
                    <p class="mb-4">3/7</p>
                    <h5 class="text-center"></h5>



                    <?php
                    $required_language = get_post_meta($lsid, '_required_language', true);
                    ?>

                    <div class="mb-4">
                        <h4 class="fw-bold">اللغة المطلوبة</h4>

                        <?php
                        $language_options = [
                            'عربي' => 'عربي',
                            'انجليزي' => 'انجليزي',
                            'عربي و انجليزي' => 'عربي و انجليزي'
                        ];

                        foreach ($language_options as $value => $label) {
                            $active_class = ($required_language === $value) ? 'active' : '';
                            $checked_attr = ($required_language === $value) ? 'checked' : '';
                            echo '
                                      <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 ' . $active_class . '">
                                        <input type="radio" name="required_language" class="d-none" value="' . esc_attr($value) . '" ' . $checked_attr . '>
                                        <div>' . esc_html($label) . '</div>
                                      </label>
                                    ';
                        }
                        ?>
                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>



                <!-- الصفحة 1:  -->
                <div class="step">
                    <p class="mb-4">4/7</p>
                    <h5 class="text-center"></h5>

                    <div class="mb-4">

                        <?php
                        $party_count = get_post_meta($lsid, '_party_count', true);
                        $party_1_role = get_post_meta($lsid, '_party_1_role', true);
                        $party_2_role = get_post_meta($lsid, '_party_2_role', true);
                        $party_3_role = get_post_meta($lsid, '_party_3_role', true);
                        $party_4_role = get_post_meta($lsid, '_party_4_role', true);
                        ?>

                        <p class="fw-bold">عدد الأطراف</p>

                        <!-- خيار 2 أطراف -->
                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 <?= ($party_count == 2 ? 'active' : '') ?>">
                            <input type="radio" name="party_count" id="party2" class="d-none" value="2" <?= ($party_count == 2 ? 'checked' : '') ?>>
                            <div>2</div>
                        </label>

                        <!-- خيار 3 أطراف -->
                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 <?= ($party_count == 3 ? 'active' : '') ?>">
                            <input type="radio" name="party_count" id="party3" class="d-none" value="3" <?= ($party_count == 3 ? 'checked' : '') ?>>
                            <div>3</div>
                        </label>

                        <!-- خيار 4 أطراف -->
                        <label class="btn btn-outline-secondary w-100 p-3 d-flex align-items-center mb-2 <?= ($party_count == 4 ? 'active' : '') ?>">
                            <input type="radio" name="party_count" id="party4" class="d-none" value="4" <?= ($party_count == 4 ? 'checked' : '') ?>>
                            <div>4</div>
                        </label>

                        <div id="count-alert" class="alert alert-danger mt-3" style="display: none;">
                            الرجاء اختيار عدد الأطراف للمتابعة.
                        </div>

                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>



                <!-- الصفحة 2:  -->
                <div class="step">
                    <p class="mb-4">5/7</p>
                    <h5 class="text-center"></h5>

                    <div class="mb-4">
                        <!-- الطرف الأول -->
                        <div class="mb-4" id="party_1_wrapper">
                            <p class="fw-bold">صفة الطرف الأول</p>
                            <?php $roles = ['فرد', 'منشأة', 'جهة حكومية']; ?>
                            <?php foreach ($roles as $role): ?>
                                <label class="btn btn-outline-secondary w-100 p-3 mb-2 <?= ($party_1_role == $role ? 'active' : '') ?>">
                                    <input type="radio" name="party_1_role" class="d-none" value="<?= $role ?>" <?= ($party_1_role == $role ? 'checked' : '') ?>>
                                    <div><?= $role ?></div>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- الطرف الثاني -->
                        <div class="mb-4" id="party_2_wrapper">
                            <p class="fw-bold">صفة الطرف الثاني</p>
                            <?php foreach ($roles as $role): ?>
                                <label class="btn btn-outline-secondary w-100 p-3 mb-2 <?= ($party_2_role == $role ? 'active' : '') ?>">
                                    <input type="radio" name="party_2_role" class="d-none" value="<?= $role ?>" <?= ($party_2_role == $role ? 'checked' : '') ?>>
                                    <div><?= $role ?></div>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- الطرف الثالث -->
                        <div class="mb-4 party-wrapper" id="party_3_wrapper">
                            <p class="fw-bold">صفة الطرف الثالث</p>
                            <?php foreach ($roles as $role): ?>
                                <label class="btn btn-outline-secondary w-100 p-3 mb-2 <?= ($party_3_role == $role ? 'active' : '') ?>">
                                    <input type="radio" name="party_3_role" class="d-none" value="<?= $role ?>" <?= ($party_3_role == $role ? 'checked' : '') ?>>
                                    <div><?= $role ?></div>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- الطرف الرابع -->
                        <div class="mb-4 party-wrapper" id="party_4_wrapper">
                            <p class="fw-bold">صفة الطرف الرابع</p>
                            <?php foreach ($roles as $role): ?>
                                <label class="btn btn-outline-secondary w-100 p-3 mb-2 <?= ($party_4_role == $role ? 'active' : '') ?>">
                                    <input type="radio" name="party_4_role" class="d-none" value="<?= $role ?>" <?= ($party_4_role == $role ? 'checked' : '') ?>>
                                    <div><?= $role ?></div>
                                </label>
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const steps = document.querySelectorAll(".step");
                        const nextBtns = document.querySelectorAll(".nextBtn");
                        const prevBtns = document.querySelectorAll(".prevBtn");
                        let currentStep = 0;

                        function showStep(index) {
                            steps.forEach((step, i) => {
                                step.style.display = (i === index) ? "block" : "none";
                            });

                            // ✅ إذا كانت الخطوة الحالية تحتوي على أطراف
                            const partySection = steps[index].querySelector('#party_1_wrapper');
                            if (partySection) {
                                const selected = document.querySelector('input[name="party_count"]:checked');
                                if (!selected) {
                                    document.getElementById("count-alert").style.display = "block";
                                    currentStep = 0;
                                    showStep(currentStep);
                                    return;
                                }
                                document.getElementById("count-alert").style.display = "none";

                                const count = parseInt(selected.value);
                                for (let i = 1; i <= 4; i++) {
                                    const el = document.getElementById(`party_${i}_wrapper`);
                                    if (el) {
                                        el.style.display = (i <= count) ? 'block' : 'none';
                                    }
                                }
                            }
                        }

                        nextBtns.forEach((btn) => {
                            btn.addEventListener("click", () => {
                                if (currentStep < steps.length - 1) {
                                    currentStep++;
                                    showStep(currentStep);
                                }
                            });
                        });

                        prevBtns.forEach((btn) => {
                            btn.addEventListener("click", () => {
                                if (currentStep > 0) {
                                    currentStep--;
                                    showStep(currentStep);
                                }
                            });
                        });

                        // بدء النموذج
                        showStep(currentStep);
                    });
                </script>




                <!-- الصفحة 6:  -->
                <div class="step">
                    <p class="mb-4">6/7</p>
                    <h5 class="text-center"></h5>

                    <div class="form-group">
                        <label for="requestTitle">عنوان الطلب</label>
                        <input type="text" class="form-control" id="requestTitle" name="request_title" value="<?php echo get_post_meta($lsid, '_request_title', true); ?>" placeholder="يرجى كتابة عنوان الطلب بشكل واضح ومختصر" required></input>

                    </div>

                    <div class="form-group">
                        <label for="caseSubject">موضوع الخدمة</label>
                        <textarea class="form-control" id="caseSubject" name="case_subject" rows="3" placeholder="يرجى كتابة تفاصيل الموضوع بشكل واضح ومختصر" required><?= esc_textarea(get_post_meta($lsid, '_case_subject', true)); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                        <button type="button" class="btn btn-primary nextBtn">التالي</button>
                    </div>
                </div>

                <div class="step">
                    <p class="mb-4">7/7</p>
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
                        <input type="hidden" name="service_type" value="<?php echo $khebrat_theme_options['page_contracts']; ?>" />

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

        showStep(currentStep);
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



<script>
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