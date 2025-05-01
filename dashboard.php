<?php

/*
Template Name: dashboard
*/
// استدعاء ملفات CSS الأساسية عبر wp_head()

if (!in_array('khebrat-framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    wp_redirect(home_url());
    exit;
}

if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

// عرض الهيدر
get_template_part('template-parts/html', 'header');

// بيانات المستخدم
$current_user_id = get_current_user_id();
$active_profile = get_user_meta($current_user_id, '_active_profile', true);

?>

<!-- **************** MAIN CONTENT START **************** -->
<main>

    <?php if ($active_profile == 4) : ?>

        <!-- ======================= Menu lawyer START -->
        <section class="pt-4">
            <div class="container">
                <?php get_template_part('template-parts/dashboard/sidebar', '4'); ?>
            </div>
        </section>
        <!-- ======================= Menu lawyer END -->

        <?php get_template_part('template-parts/dashboard/redirection'); ?>

    <?php else : ?>

        <!-- ======================= Content START -->
        <section class="pt-3">
            <div class="container">
                <div class="row">

                    <?php
                    // تحميل السايدبار حسب نوع البروفايل
                    switch ($active_profile) {
                        case 1:
                            get_template_part('template-parts/dashboard/sidebar');
                            break;
                        case 2:
                            get_template_part('template-parts/dashboard/sidebar', '2');
                            break;
                        case 3:
                            get_template_part('template-parts/dashboard/sidebar', '3');
                            break;
                    }
                    ?>

                    <!-- Main content START -->
                    <div class="col-lg-8 col-xl-9">
                        <!-- Offcanvas menu button -->
                        <div class="d-grid mb-0 d-lg-none w-100">
                            <button class="btn btn-primary mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                                <i class="fas fa-sliders-h"></i>
                            </button>
                        </div>

                        <?php get_template_part('template-parts/dashboard/redirection'); ?>
                    </div>
                    <!-- Main content END -->

                </div>
            </div>
        </section>
        <!-- ======================= Content END -->

    <?php endif; ?>

</main>
<!-- **************** MAIN CONTENT END **************** -->

<?php
get_footer();
?>