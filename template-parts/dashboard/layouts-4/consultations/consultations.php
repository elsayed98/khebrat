<?php

$current_user_id = get_current_user_id();

$lawyer_id = get_user_meta($current_user_id, 'lawyer_id', true);

$args = array(
    'post_type'      => 'legal_consultation',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'   => '_lawyer_id', // عدّل هذا المفتاح ليتطابق مع اسم مفتاح الميتا الموجود في post
            'value' => $lawyer_id,
        ),
    ),
);

$user_posts = new WP_Query($args);
?>


<section class="pt-0">
    <div class="container vstack gap-4">
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
                        <div id="consultations-list" data-page="2">
                            <?php echo query_post(['paged' => 1]); ?>
                        </div>
                        <button id="load-more" class="d-none" data-page="1"></button>
                    </div>
                    <!-- Card body END -->

                </div>
            </div>
        </div>
        <!-- Listing table END -->

    </div>
</section>

<script>
   jQuery(document).ready(function($) {
	let isLoading = false;
	let hasMore = true;

	function loadConsultations(page = 1) {
		if (isLoading || !hasMore) return;
		isLoading = true;

		let container = '#consultations-list';
		let lastElement = null;
		if (page > 1) {
			lastElement = $(container + ' .card').last();
		}

		$.ajax({
			url: localize_vars_frontend.freelanceAjaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'load_legal_consultations',
				page: page
			},
			beforeSend: function() {
				if (page == 1) {
					$(container).html(`
						<div class="text-center my-5">
							<div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
								<span class="visually-hidden">جارٍ التحميل...</span>
							</div>
							<p class="mt-2 text-muted">جارٍ تحميل الاستشارات...</p>
						</div>
					`);
				} else {
					$(container).append(`
						<div class="text-center my-4" id="scroll-loader">
							<div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
								<span class="visually-hidden">جارٍ التحميل...</span>
							</div>
							<p class="mt-2 text-muted">جارٍ تحميل المزيد...</p>
						</div>
					`);
				}
			},
			success: function(response) {
				if (page == 1) {
					$(container).html(response.html);
				} else {
					$('#scroll-loader').remove();
					$(container).append(response.html);

					if (lastElement && lastElement.length) {
						$('html, body').scrollTop(lastElement.offset().top);
					}
				}

				// تحديث رقم الصفحة في الزر المخفي
				$('#load-more').data('page', page + 1);
				hasMore = response.has_more;
				isLoading = false;

				if (!hasMore && page > 1) {
					$(container).append('<p class="text-center text-muted">تم الوصول إلى نهاية القائمة</p>');
				}
			}
		});
	}

	// التمرير التلقائي
	$(window).scroll(function() {
		if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
			let page = $('#load-more').data('page') || 2;
			loadConsultations(page);
		}
	});

	// أول تحميل
	loadConsultations(1);
});

</script>