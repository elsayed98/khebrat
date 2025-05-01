<?php

$current_user_id = get_current_user_id();


$args = array(
    'post_type'      => 'legal_consultation',
    'posts_per_page' => -1,
    'author'         => $current_user_id,
    'post_status'    => 'publish',
);

$user_posts = new WP_Query($args);
?>

<div class="vstack  gap-4">
    <!-- Title START -->
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="fs-4 mb-0"><i class="bi bi-journals fa-fw me-1"></i>إدارة الاستشارات</h1>
        </div>
    </div>

    <!-- Listing table START -->
    <div class="row">
        <div class="col-12">

            <div class="card border">
                <!-- Card header -->
                <div class="card-header border-bottom">
                    <h5 class="card-header-title"><?php echo esc_html__('استشاراتي', 'khebrat_theme'); ?></h5>
                </div>

                <!-- Card body START -->
                <div class="card-body vstack gap-3">
                    <?php
                    if ($user_posts->have_posts()) {
                        while ($user_posts->have_posts()) {
                            $user_posts->the_post();
                    ?>
                            <div class="card border p-2 mb-4">
                                <div class="row g-4">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card-body position-relative d-flex flex-column p-0 h-100">

                                            <!-- Buttons -->
                                            <div class="list-inline-item dropdown position-absolute top-0 end-0">

                                                <div class="badge bg-info bg-opacity-10 text-info">Half Payment</div>

                                                <a href="#" class="btn btn-sm btn-round btn-light" role="button" id="dropdownAction<?php the_ID(); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownAction<?php the_ID(); ?>">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle me-1"></i>Report</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-slash-circle me-1"></i>Disable</a></li>
                                                </ul>
                                            </div>

                                            <!-- Title -->
                                            <h5 class="card-title mb-0 me-5"><?php the_title(); ?></h5>
                                            <!-- تاريخ النشر -->
                                            <small><i class="bi bi-geo-alt me-2"></i><?php echo get_the_date(); ?></small>
                                            <?php
                                            $terms = wp_get_object_terms(get_the_ID(), 'legal_category');

                                            if (!empty($terms) && !is_wp_error($terms)) {
                                                $term_names = wp_list_pluck($terms, 'name');
                                                echo '<small>التصنيف : ' . implode('، ', $term_names) . '</small>';
                                            } else {
                                                echo '<small>لا يوجد تصنيف</small>';
                                            }
                                            ?>
                                        
                                            <!-- السعر والزرار -->
                                            <div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
                                                <div class="d-flex align-items-center">
                                                    <h5 class="fw-bold mb-0 me-1">
                                                        <?php
                                                        // مثال على حقل سعر محفوظ في الميتا
                                                        $price = get_post_meta(get_the_ID(), '_consultation_price', true);
                                                        echo $price ? '$' . esc_html($price) : '$0';
                                                        ?>
                                                    </h5>

                                                </div>

                                                <div class="hstack gap-2 mt-3 mt-sm-0">
                                                    <a href="?ext=consultations-detail&cid=<?php echo get_the_ID();?> " class="btn btn-sm btn-primary mb-0">
                                                        <i class="bi bi-pencil-square fa-fw me-1"></i>Edit
                                                    </a>
                                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary mb-0">
                                                        <?php echo esc_html__('التفاصيل', 'khebrat_theme'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<p class="alert alert-warning">لا توجد منشورات خاصة بك بعد.</p>';
                    }
                    ?>

                </div>
                <!-- Card body END -->
            </div>
        </div>
    </div>
    <!-- Listing table END -->

</div>