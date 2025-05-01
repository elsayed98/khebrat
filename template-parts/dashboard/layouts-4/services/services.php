<section class="pt-0">
	<div class="container vstack gap-4">
		<!-- Title START -->
		<div class="row">
			<div class="col-12">
				<h1 class="fs-4 mb-0"><i class="bi bi-journals fa-fw me-1"></i>إدارة الخدمات</h1>
			</div>
		</div>
		<!-- Title END -->

		<!-- Counter START -->

		<!-- Counter END -->

		<!-- Listing table START -->
		<div class="row">
			<div class="col-12">

				<div class="card border">
					<!-- Card header -->

					<div class="card-header border-bottom">
						<ul class="nav nav-pills nav-justified mb-3" id="serviceTabs">
							<li class="nav-item">
								<a class="nav-link mb-0 active" data-bs-toggle="tab" href="#services-list"><?php echo esc_html__('جديدة', 'khebrat_theme'); ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link mb-0 " data-bs-toggle="tab" href="#in-progress"><?php echo esc_html__('تحت التنفيذ', 'khebrat_theme'); ?></a>

							</li>
							<li class="nav-item">
								<button class="nav-link" data-status="completed">مكتملة</button>
							</li>
						</ul>
					</div>





					<!-- Card body START -->
					<div id="services-list" class="card-body vstack gap-3">
						<!-- Listing item START -->
						<div class="card border p-2">
							<div class="row g-4">

								<!-- Card body -->
								<div class="col-md-9 col-lg-12">
									<div class="card-body position-relative d-flex flex-column p-0 h-100">

										<!-- Buttons -->
										<div class="list-inline-item dropdown position-absolute top-0 end-0">
											<small><?php echo esc_html__('طلب رقم : ', 'khebrat_theme'); ?>#526452</small>

										</div>

										<!-- Title -->
										<h6 class="card-title mb-0 me-8">Pride moon Village Resort</h6>
										
										<div class="d-flex align-items-center">
											<span class="mb-0 me-1"><?php echo esc_html__('تاريخ الطلب : ', 'khebrat_theme'); ?></span>
											<span class="text-span mb-0 me-1">$day</span>
										</div>
										<div class="d-flex align-items-center">
											<span class="mb-0 me-1"><?php echo esc_html__('نوع الخدمة : ', 'khebrat_theme'); ?></span>
											<span class="text-span mb-0 me-1">$day</span>
										</div>
										<div class="d-flex align-items-center">
											<span class="mb-0 me-1"><?php echo esc_html__('التخصص : ', 'khebrat_theme'); ?></span>
											<span class="text-span mb-0 me-1">$day</span>
										</div>


										<!-- Price and Button -->
										<div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto">
											<!-- Button -->
											<div class="d-flex align-items-center">
												<h5 class="fw-bold mb-0 me-1">$1586</h5>
												<span class="mb-0 me-2">/day</span>
											</div>
											<!-- Price -->
											<div class="hstack gap-2 mt-3 mt-sm-0">
												<a href="#" class="btn btn-sm btn-success mb-0"><?php echo esc_html__('مشاهدة العروض', 'khebrat_theme'); ?></a>
												<a href="#" class="btn btn-sm btn-outline-success mb-0"><?php echo esc_html__('تفاصيل الطلب', 'khebrat_theme'); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Listing item END -->
						<p class="text-center">جارٍ التحميل...</p>

						<!-- زر تحميل المزيد -->
						<div class="text-center mt-4">
							<button id="load-more" class="btn btn-primary d-none" data-page="1">تحميل المزيد</button>
						</div>
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
		function loadServices(status, page = 1) {
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action: 'load_services',
					status: status,
					page: page,
				},
				beforeSend: function() {
					if (page == 1) {
						$('#services-list').html('<p class="text-center">جارٍ التحميل...</p>');
					}
				},
				success: function(response) {
					if (page == 1) {
						$('#services-list').html(response);
					} else {
						$('#services-list').append(response);
					}
					$('#load-more').data('page', page + 1).removeClass('d-none');
				}
			});
		}

		$('.nav-link').click(function() {
			$('.nav-link').removeClass('active');
			$(this).addClass('active');
			let status = $(this).data('status');
			loadServices(status);
		});

		$('#load-more').click(function() {
			let status = $('.nav-link.active').data('status');
			let page = $(this).data('page');
			loadServices(status, page);
		});

		// تحميل البيانات لأول تبويب عند تحميل الصفحة
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