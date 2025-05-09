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
							<a class="nav-link mb-0 active" data-bs-toggle="tab" data-status="active" href="#services-list"><?php echo esc_html__('جديدة', 'khebrat_theme'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 " data-bs-toggle="tab" data-status="progress" href="#in-progress"><?php echo esc_html__('تحت التنفيذ', 'khebrat_theme'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link mb-0 " data-bs-toggle="tab" data-status="completed" href="#completed"><?php echo esc_html__('مكتملة', 'khebrat_theme'); ?></a>
						</li>
					</ul>
				</div>




				<div class="tab-content" id="serviceTabsContent">
					<!-- Card body START -->
					<div class="tab-pane fade show active" id="services-list">


						<div class="card-body vstack gap-3">
							<!-- Listing item START -->
							<?php
							if ($query->have_posts()) {
								while ($query->have_posts()) {
									$query->the_post();

									// متغيرات إضافية (عدل حسب حقولك المخصصة)
									$order_id = get_the_ID(); // رقم الطلب = ID المنشور
									$service_type_id = get_post_meta($order_id, '_service_type', true);
									$service_type = get_the_title($service_type_id);
									$specialization = get_post_meta($order_id, '_specialization', true); // التخصص
									$price = get_post_meta($order_id, '_price', true); // السعر
									$order_date = get_the_date('d M Y'); // تاريخ الطلب (مثل 27 Apr 2025)
							?>
									<div class="card border p-2 mb-3">
										<div class="row g-4">

											<!-- Card body -->
											<div class="col-md-9 col-lg-12">
												<div class="card-body position-relative d-flex flex-column p-0 h-100">

													<!-- رقم الطلب -->
													<div class="list-inline-item dropdown position-absolute top-0 end-0">
														<small><?php echo esc_html__('طلب رقم : ', 'khebrat_theme'); ?>#<?php echo esc_html($order_id); ?></small>
													</div>

													<!-- عنوان المنشور -->
													<h6 class="card-title mb-0 me-8"><?php echo get_the_title(); ?></h6>

													<!-- تفاصيل -->
													<ul class="list-group list-group-borderless mb-0">
														<li class="list-group-item"><?php echo esc_html__('تاريخ الطلب : ', 'khebrat_theme'); ?>
															<span class="h6 mb-0 fw-normal ms-1"><?php echo esc_html($order_date); ?></span>
														</li>
														<li class="list-group-item"><?php echo esc_html__('نوع الخدمة : ', 'khebrat_theme'); ?>
															<span class="h6 mb-0 fw-normal ms-1"><?php echo esc_html($service_type_id ? $service_type : 'غير محدد'); ?></span>
														</li>
														<li class="list-group-item"><?php echo esc_html__('التخصص : ', 'khebrat_theme'); ?>
															<?php
															$terms = wp_get_object_terms($order_id, 'legal_category');

															if (!empty($terms) && !is_wp_error($terms)) {
																$term_names = wp_list_pluck($terms, 'name');
																echo '<span class="h6 mb-0 fw-normal ms-1">' . implode('، ', $term_names) . '</span>';
															} else {
																echo '<span class="h6 mb-0 fw-normal ms-1">' . esc_html('غير محدد') . '</span>';
															}
															?>
														</li>
													</ul>

													<!-- السعر والزر -->
													<div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
														<div class="d-flex align-items-center">
															<h6 class=" mb-0 me-1"><?php echo esc_html__('عروض : ', 'khebrat_theme'); ?></h6>
														</div>
														<div class="hstack gap-2 mt-3 mt-sm-0">
															<a href="<?php echo esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])); ?>?ext=service-offers&sfid=<?php echo esc_html($order_id); ?>" class="btn btn-sm btn-success mb-0"><?php echo esc_html__('مشاهدة العروض', 'khebrat_theme'); ?></a>
															<a href="<?php echo get_permalink(); ?>" class="btn btn-sm btn-outline-success mb-0"><?php echo esc_html__('تفاصيل الطلب', 'khebrat_theme'); ?></a>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
							<?php
								}
							} else {
								echo '<div class="alert alert-warning">لا توجد منشورات لك.</div>';
							}

							wp_reset_postdata();
							?>

							<!-- Listing item END -->
							<p class="text-center">جارٍ التحميل...</p>


						</div>
					</div>
					<button id="load-more" class="d-none" data-page="1"></button>
					<!-- Card body END -->

					<div class="tab-pane fade" id="in-progress">
						<div class="card-body vstack gap-3">
							12333333

						</div>

					</div>

				</div>
			</div>


		</div>
	</div>
	<!-- Listing table END -->
</div>



<script>
	jQuery(document).ready(function($) {
		let isLoading = false;
		let hasMore = true;

		function loadServices(status, page = 1) {
			if (isLoading || !hasMore) return;
			isLoading = true;

			let lastElement = null;
			if (page > 1) {
				lastElement = $('#services-list .card').last(); // أو أي عنصر يمثل نهاية القائمة
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
						$('#services-list').html('<p class="text-center">جارٍ التحميل...</p>');
					} else {
						$('#services-list').append('<div class="text-center my-3" id="scroll-loader">جارٍ التحميل...</div>');
					}
				},
				success: function(response) {
					if (page == 1) {
						$('#services-list').html(response.html);
					} else {
						$('#scroll-loader').remove();
						$('#services-list').append(response.html);

						// بعد الإضافة: إعادة التمرير إلى العنصر الأخير قبل الإضافة
						if (lastElement && lastElement.length) {
							$('html, body').scrollTop(lastElement.offset().top);
						}
					}

					$('#load-more').data('page', page + 1);
					hasMore = response.has_more;
					isLoading = false;

					if (!hasMore && page > 1) {
						$('#services-list').append('<p class="text-center text-muted">تم الوصول إلى نهاية القائمة</p>');
					}
				}
			});
		}

		// التبديل بين التبويبات
		$('.nav-link').click(function(e) {
			e.preventDefault();
			$('.nav-link').removeClass('active');
			$(this).addClass('active');

			let status = $(this).data('status');
			$('#load-more').data('page', 1);
			hasMore = true;
			loadServices(status, 1);
		});

		// التمرير التلقائي
		$(window).scroll(function() {
			if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
				let status = $('.nav-link.active').data('status');
				let page = $('#load-more').data('page');
				loadServices(status, page);
			}
		});

		// تحميل أولي
		loadServices('new');
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