<?php

global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$args = array(
	'post_type'      => 'legal_services', // أو استبدلها بنوع المنشور المخصص مثل 'خدمات' أو 'مشاريع'
	'posts_per_page' => 5,
	'author'         => $current_user_id,
);

$query = new WP_Query($args);

?>


<div class="vstack  gap-4">



	<!-- Title START -->
	<div class="row">
		<div class="col-12 text-center">
			<h1 class="fs-4 mb-0"><i class="bi bi-journals fa-fw me-1"></i>إدارة الخدمات</h1>
		</div>
	</div>
	<!-- Title END -->

	<!-- Listing table START -->
	<div class="row">
		<div class="col-12">

			<div class="card border">
				<!-- Card header -->

				<div class="card-header border-bottom">
					<ul class="nav nav-pills nav-justified mb-3" id="serviceTabs">
						<li class="nav-item">
							<a class="nav-link mb-0 active" data-bs-toggle="tab" data-status="active" data-target="#services-list" href="#services-list"><?php echo esc_html__('جديدة', 'khebrat_theme'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 " data-bs-toggle="tab" data-status="progress" data-target="#in-progress" href="#in-progress"><?php echo esc_html__('تحت التنفيذ', 'khebrat_theme'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 " data-bs-toggle="tab" data-status="completed" data-target="#completed" href="#completed"><?php echo esc_html__('مكتملة', 'khebrat_theme'); ?></a>
						</li>
					</ul>
				</div>

				




				<!-- تبويبات المحتوى -->
				<div class="tab-content">
					<div id="services-list" class="tab-pane fade show active card-body vstack gap-3"></div>
					<div id="in-progress" class="tab-pane fade card-body vstack gap-3"></div>
					<div id="completed" class="tab-pane fade card-body vstack gap-3"></div>
				</div>

				<!-- زر تحميل وهمي لحفظ رقم الصفحة -->
				<button id="load-more" class="d-none" data-page="1"></button>


			</div>


		</div>
	</div>
	<!-- Listing table END -->
</div>



<script>
	jQuery(document).ready(function($) {
	let isLoading = false;
	let hasMore = true;
	let currentStatus = 'active';
	let currentContainer = '#services-list';

	function loadServices(status, container, page = 1) {
		if (isLoading || !hasMore) return;
		isLoading = true;

		let lastElement = null;
		if (page > 1) {
			lastElement = $(container + ' .card').last();
		}

		$.ajax({
			url: localize_vars_frontend.freelanceAjaxurl,
			type: 'POST',
			data: {
				action: 'load_services',
				status: status,
				page: page,
			},
			beforeSend: function() {
				if (page == 1) {
					$(container).html(`
						<div class="text-center my-5">
							<div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
								<span class="visually-hidden">جارٍ التحميل...</span>
							</div>
							<p class="mt-2 text-muted">جارٍ تحميل الخدمات...</p>
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

				$('#load-more').data('page', page + 1);
				hasMore = response.has_more;
				isLoading = false;

				if (!hasMore && page > 1) {
					$(container).append('<p class="text-center text-muted">تم الوصول إلى نهاية القائمة</p>');
				}
			}
		});
	}

	// التبديل بين التبويبات
	$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
	currentStatus = $(this).data('status');
	currentContainer = $(this).data('target');

	$('#load-more').data('page', 1);
	hasMore = true;
	loadServices(currentStatus, currentContainer, 1);
	});

	// التمرير التلقائي
	$(window).scroll(function() {
		if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
			let page = $('#load-more').data('page');
			loadServices(currentStatus, currentContainer, page);
		}
	});

	// تحميل أول تبويب عند التحميل الأول
	loadServices(currentStatus, currentContainer, 1);
});








	document.addEventListener("DOMContentLoaded", function() {
		const hash = window.location.hash;

		if (hash) {
			const tabTriggerEl = document.querySelector(`a[href="${hash}"]`);
			if (tabTriggerEl) {
				const tab = new bootstrap.Tab(tabTriggerEl);
				tab.show();
			}
		}

		// عند النقر على أي تبويب، نغيّر الهاش في الرابط
		const tabLinks = document.querySelectorAll('a[data-bs-toggle="tab"]');
		tabLinks.forEach((tabLink) => {
			tabLink.addEventListener("shown.bs.tab", function(e) {
				const hash = e.target.getAttribute("href");
				history.replaceState(null, null, hash);
			});
		});
	});
	
</script>