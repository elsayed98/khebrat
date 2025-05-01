<?php

/*
*/
// استدعاء ملفات CSS الأساسية عبر wp_head()


if (in_array('khebrat-framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    if (is_user_logged_in()) {
        get_template_part('template-parts/html', 'header');
?>


        <style>
            .hidden {
                display: none;
            }

            .step {
                display: none;
            }

            .step.active {
                display: block;
            }
        </style>
        </head>

        <div class="container mt-5">
            <div class="card shadow">
                <div class="card-body">

                    <h3 class="text-center mb-4">دراسة قضاية</h3>
                    <form id="multiStepForm">
                        <!-- الصفحة 1 -->
                        <div class="step active">
                            <p class="mb-4">1/5</p>
                            <h5>اختر التخصص </h5>
                            <?php
                            $terms = get_terms([
                                'taxonomy'   => 'legal_category',
                                'hide_empty' => false,
                                'parent'     => 0
                            ]);

                            if (!empty($terms) && !is_wp_error($terms)) :
                            ?>
                                <div class="container">
                                    <h4 class="mb-3">اختر التخصص</h4>
                                    <div class="row">
                                        <?php foreach ($terms as $term) : ?>
                                            <div class="col-md-6 mb-3">
                                                <label class="btn btn-outline-primary w-100 d-flex align-items-center p-3 category-radio">
                                                    <input type="radio" name="category_id" value="<?php echo esc_attr($term->term_id); ?>" class="category-input d-none">
                                                    <div>
                                                        <h6 class="mb-1"><?php echo esc_html($term->name); ?></h6>
                                                        <p class="small text-muted mb-0"><?php echo esc_html($term->description); ?></p>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        let categoryInputs = document.querySelectorAll(".category-input");

                                        categoryInputs.forEach(input => {
                                            input.addEventListener("change", function() {
                                                let selectedCategory = this.value;

                                                // الحصول على الرابط الحالي بدون المعاملات (Query String)
                                                let currentURL = window.location.origin + window.location.pathname;

                                                // إنشاء الرابط الجديد مع category_id
                                                let nextPage = currentURL + "?category_id=" + selectedCategory;

                                                // تحديث الرابط في المتصفح
                                                window.location.href = nextPage;
                                            });
                                        });
                                    });
                                </script>


                            <?php endif; ?>




                            <style>
                                .category-radio {
                                    cursor: pointer;
                                    transition: all 0.3s ease;
                                }

                                .category-radio:hover {
                                    background-color: #e9ecef;
                                }

                                .category-radio input:checked+div h6 {
                                    color: #0d6efd;
                                    /* لون Bootstrap الأساسي */
                                }

                                .category-radio input:checked+div p {
                                    font-weight: bold;
                                }
                            </style>

                        </div>

                        <!-- الصفحة 2 -->
                        <div class="step">
                            <h5>معلومات الاتصال</h5>
                            <div class="mb-3">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">العنوان</label>
                                <input type="text" class="form-control" id="address" required>
                            </div>

                            <!-- التصنيفات الفرعية ستظهر هنا -->
                            <?php
                            $selected_category = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

                            if ($selected_category) {
                                $subcategories = get_terms([
                                    'taxonomy'   => 'legal_category',
                                    'hide_empty' => false,
                                    'parent'     => $selected_category
                                ]);
                            }
                            ?>

                            <div class="container">
                                <h4 class="mb-3">اختر التخصص الفرعي</h4>
                                <form method="POST" action="process_form.php">
                                    <div class="row">
                                        <?php if (!empty($subcategories) && !is_wp_error($subcategories)) : ?>
                                            <?php foreach ($subcategories as $sub) : ?>
                                                <div class="col-md-6 mb-3">
                                                    <label class="btn btn-outline-secondary w-100 p-3">
                                                        <input type="checkbox" name="subcategories[]" value="<?php echo esc_attr($sub->term_id); ?>" class="form-check-input me-2">
                                                        <?php echo esc_html($sub->name); ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p class="text-muted">لا توجد تصنيفات فرعية متاحة.</p>
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">إرسال</button>
                                </form>
                            </div>


                            <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                            <button type="button" class="btn btn-primary nextBtn">التالي</button>
                        </div>

                        <!-- الصفحة 3 -->
                        <div class="step">
                            <h5>تفاصيل الحساب</h5>
                            <div class="mb-3">
                                <label class="form-label">اسم المستخدم</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                            <button type="button" class="btn btn-primary nextBtn">التالي</button>
                        </div>


                         <!-- الصفحة 4 -->
                         <div class="step">
                            <h5>تفاصيل الحساب</h5>
                            <div class="mb-3">
                                <label class="form-label">اسم المستخدم</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                            <button type="button" class="btn btn-primary nextBtn">التالي</button>
                        </div>

                         <!-- الصفحة 5 -->
                         <div class="step">
                            <h5>تفاصيل الحساب</h5>
                            <div class="mb-3">
                                <label class="form-label">اسم المستخدم</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="button" class="btn btn-secondary prevBtn">السابق</button>
                            <button type="submit" class="btn btn-success">إرسال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



<?php
    } else {
        wp_redirect(home_url());
    }
} else {
    wp_redirect(home_url());
}

get_footer();

?>