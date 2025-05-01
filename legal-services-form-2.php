<?php

/*
Template Name: legal services form
*/
// استدعاء ملفات CSS الأساسية عبر wp_head()




global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$customer_id = get_user_meta( $current_user_id, 'customer_id' , true );
if(isset($_GET['lsid']) == '' )
{
	$is_service_paid = fl_framework_get_options('is_services_paid');
	if(isset($is_service_paid) && $is_service_paid == 1)
	{
		$simple_services = get_post_meta($customer_id, '_simple_services', true);
		$freelancer_package_expiry_date = get_post_meta($customer_id, '_freelancer_package_expiry_date', true);
		$today_date = date("d-m-Y");

		if($simple_services < 1 && $simple_services != -1 || strtotime($freelancer_package_expiry_date) < strtotime($today_date))
		{
			echo exertio_redirect(get_the_permalink(fl_framework_get_options('freelancer_package_page')));
		}
	}
}



$cust_id = get_user_meta( $current_user_id, 'customer_id' , true );
$selected_custom_data = $fetch_custom_data = '';
$custom_field_dispaly = 'style=display:none;';
$is_update = '';
	if(isset($_GET['lsid']))
	{
		$lsid = $_GET['lsid'];
		$is_update = $lsid;
		
	}
	else
	{
		$lsid = get_user_meta( $current_user_id, '_processing_legal_services_id' , true );
		if(isset($lsid) && $lsid =='')
		{
			$my_post = array(
				'post_title' => '',
				'post_status' => 'pending',
				'post_author' => $current_user_id,
				'post_type' => 'legal_services'
			);
			$lsid = wp_insert_post($my_post);
			update_user_meta( $current_user_id, '_processing_legal_services_id', $lsid );
				
		}
	}
$post	=	get_post($lsid);
if($post == '')
{
	$my_post = array(
		'post_title' => '',
		'post_status' => 'pending',
		'post_author' => $current_user_id,
		'post_type' => 'legal_services'
	);
	$lsid = wp_insert_post($my_post);
	update_user_meta( $current_user_id, '_processing_legal_services_id', $lsid );
	$post	=	get_post($lsid);
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


if (in_array('khebrat-framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    if (is_user_logged_in()) {
        get_template_part('template-parts/html', 'header');
?>


        <div class="container mt-5">
            <div class="card shadow">
                <div class="card-body content-wrapper">
                    <h3 class="text-center mb-4">دراسة قضاية</h3>

                    
                    <form id="legal_services_form">

                        <!-- الصفحة 1: اختيار التصنيف الأب -->
                        <div class="step active">
                            <p class="mb-4 ">1/5</p>
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
                            <p class="mb-4">2/5</p>
                            <h5 class="text-center">اختر التخصص الفرعي</h5>

                            <div id="child-options" class="row text-center">
                                <p class="text-muted">يرجى اختيار التخصص أولاً</p>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                                <button type="button" class="btn btn-primary nextBtn">التالي</button>
                            </div>

                        </div>

                        <!-- الصفحة 3: تفاصيل الحساب -->
                        <div class="step">
                            <p class="mb-4">3/5</p>
                            <h5 class="text-center">تفاصيل الحساب</h5>

                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <h4 class="mb-1">هل دارسة تتعلق بقضية قائمة جاليا ؟</h4>
                                    <?php  $study_related = get_post_meta($lsid, '_study_related', true) ?>
                                    <label class="btn btn-outline-primary w-100 p-3 d-flex align-items-center <?php if ($study_related  == 1) {echo 'active';} ?>">
                                        <input type="radio" name="study_related" class="d-none " value="1" <?php if ($study_related  == 1) {echo 'checked';} ?>>
                                        <div>
                                            <h6 class="mb-1">نعم </h6>
                                        </div>
                                    </label>
                                    <label class="btn btn-outline-primary w-100 p-3 d-flex align-items-center <?php if ($study_related  == 2) {echo 'active';} ?>">
                                        <input type="radio" name="study_related" class="d-none " value="2" <?php if ($study_related  == 2) {echo 'checked';} ?>>
                                        <div>
                                            <h6 class="mb-1">لا </h6>
                                        </div>
                                    </label>
                                </div>

                                <script>

                                    document.addEventListener('DOMContentLoaded', function() {
                                        const radioGroups = document.querySelectorAll('input[type="radio"][name="study_related"]');

                                        radioGroups.forEach(radio => {
                                            radio.addEventListener('change', function() {
                                                // إزالة "active" من كل العناصر
                                                radioGroups.forEach(r => {
                                                    r.closest('label').classList.remove('active');
                                                });

                                                // إضافة "active" للي تم اختياره
                                                if (this.checked) {
                                                    this.closest('label').classList.add('active');
                                                }
                                            });
                                        });
                                    });
                                </script>

                                <div class="form-group">
                                    <label for="roleSelect">هل أنت المدعي أم المدعى عليه؟</label>
                                    <?php  $case_role_type = get_post_meta($lsid, '_case_role_type', true) ?>
                                    <select class="form-control" name="case_role_type" id="roleSelect" onchange="toggleRole()">
                                        <option value="مدعي" <?php if ($case_role_type  == "مدعي") {echo "selected=selected";} ?>>مدعي</option>
                                        <option value="مدعى عليه" <?php if ($case_role_type  == "مدعى عليه") {echo "selected=selected";} ?>>مدعى عليه</option>
                                    </select>
                                </div>

                                <!-- حقول المدعي -->
                                <div class="form-group" id="plaintiffFields">
                                    <label for="plaintiffRole">صفتك كمدعي:</label>
                                    <select class="form-control" name="plaintiff_identity_type" id="plaintiffRole">
                                        <option value="فرد">فرد</option>
                                        <option value="منشأة">منشأة</option>
                                    </select>
                                </div>

                                <div class="form-group" id="plaintiffDefendantRole">
                                    <label for="defendantRoleAsPlaintiff">صفة المدعي عليه :</label>
                                    <select class="form-control" name="defendant_identity_type_by_plaintiff" id="defendantRoleAsPlaintiff">
                                        <option value="فرد">فرد</option>
                                        <option value="منشأة">منشأة</option>
                                        <option value="جهة حكومية">جهة حكومية</option>
                                    </select>
                                </div>

                                <!-- حقول المدعى عليه -->
                                <div class="form-group" id="defendantFields" style="display:none;">
                                    <label for="defendantRole">صفتك كمدعى عليه:</label>
                                    <select class="form-control" name="defendant_identity_type" id="defendantRole">
                                        <option value="فرد">فرد</option>
                                        <option value="منشأة">منشأة</option>
                                    </select>
                                </div>

                                <div class="form-group" id="defendantPlaintiffRole" style="display:none;">
                                    <label for="plaintiffRoleAsDefendant">صفة المدعي :</label>
                                    <select class="form-control" name="plaintiff_identity_type_by_defendant" id="plaintiffRoleAsDefendant">
                                        <option value="فرد">فرد</option>
                                        <option value="منشأة">منشأة</option>
                                        <option value="جهة حكومية">جهة حكومية</option>

                                    </select>
                                </div>

                                <script>
                                    function toggleRole() {
                                        var role = document.getElementById("roleSelect").value;
                                        if (role === "مدعي") {
                                            document.getElementById("plaintiffFields").style.display = "block";
                                            document.getElementById("plaintiffDefendantRole").style.display = "block";
                                            document.getElementById("defendantFields").style.display = "none";
                                            document.getElementById("defendantPlaintiffRole").style.display = "none";
                                        } else {
                                            document.getElementById("plaintiffFields").style.display = "none";
                                            document.getElementById("plaintiffDefendantRole").style.display = "none";
                                            document.getElementById("defendantFields").style.display = "block";
                                            document.getElementById("defendantPlaintiffRole").style.display = "block";
                                        }
                                    }
                                </script>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                                <button type="button" class="btn btn-primary nextBtn">التالي</button>
                            </div>
                        </div>
                        <!-- الصفحة 3: تفاصيل الحساب -->
                        <div class="step">
                            <p class="mb-4">4/5</p>
                            <h5 class="text-center">تفاصيل الحساب</h5>

                            <div class="form-group">
                                <label for="requestTitle">عنوان الطلب</label>
                                <input type="text" class="form-control" id="requestTitle" name="request_title" value="<?php echo get_post_meta($lsid, '_request_title', true); ?>" placeholder="يرجى كتابة عنوان الطلب بشكل واضح ومختصر" required></input>

                            </div>

                            <div class="form-group">
                                <label for="caseSubject">موضوع القضية</label>
                                <textarea class="form-control" id="caseSubject" name="case_subject" rows="3" placeholder="يرجى كتابة تفاصيل الموضوع بشكل واضح ومختصر" required><?= esc_textarea(get_post_meta($lsid, '_case_subject', true)); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="questions">الأشياء التي تبحث عنها إجابات لها من خلال هذه الدراسة</label>
                                <textarea class="form-control" id="questions" name="case_questions" rows="3" placeholder="يرجى كتابة تفاصيل الموضوع بشكل واضح ومختصر" required><?= esc_textarea(get_post_meta($lsid, '_case_questions', true)); ?></textarea>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                                <button type="button" class="btn btn-primary nextBtn">التالي</button>
                            </div>
                        </div>

                        <div class="step">
                            <p class="mb-4">5/5</p>
                            <h5 class="text-center">اختر التخصص الفرعي</h5>
                            

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
															<a href="javascript:void(0)" class="btn_delete_services_attachment" data-id="' . $value . '" data-pid="' . $lsid . '"> <i class="fas fa-times"></i></a>
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

                                <input type="hidden" id="create_legal_services_nonce" value="<?php echo wp_create_nonce('fl_create_legal_services_secure'); ?>"  />


                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

        

        <!-- تحسين التجاوب والجافاسكريبت -->
        <style>

        </style>

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





<?php
    } else {
        wp_redirect(home_url());
    }
} else {
    wp_redirect(home_url());
}

get_footer();

?>



