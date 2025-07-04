<?php
global $khebrat_theme_options;
$current_user_id = get_current_user_id();

$pid = get_user_meta($current_user_id, 'lawyer_id', true);
$post  =  get_post($pid);

$user_info = get_userdata($current_user_id);
$user_name = $user_info->display_name;

$pro_img_id = get_post_meta($pid, '_profile_pic_attachment_id', true);
$pro_img = wp_get_attachment_image_src($pro_img_id, 'thumbnail');



?>


<!-- =======================
Content START -->
<section class="pt-0">
	<div class="container vstack gap-4">
		<!-- Title START -->
		<div class="row">
			<div class="col-12">
				<h1 class="fs-4 mb-0"><i class="bi bi-house-door fa-fw me-1"></i>Dashboard</h1>
			</div>
		</div>
		<!-- Title END -->

		<!-- Counter START -->
		<div class="row g-4">
			<!-- Counter item -->
			<div class="col-sm-6 col-xl-3">
				<div class="card card-body border">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-xl bg-success rounded-3 text-white">
							<i class="bi bi-journals"></i>
						</div>
						<!-- Content -->
						<div class="ms-3">
							<h4>56</h4>
							<span>Total Listings</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Counter item -->
			<div class="col-sm-6 col-xl-3">
				<div class="card card-body border">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-xl bg-info rounded-3 text-white">
							<i class="bi bi-graph-up-arrow"></i>
						</div>
						<!-- Content -->
						<div class="ms-3">
							<h4>$2,55,365</h4>
							<span>Earning</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Counter item -->
			<div class="col-sm-6 col-xl-3">
				<div class="card card-body border">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-xl bg-warning rounded-3 text-white">
							<i class="bi bi-bar-chart-line-fill"></i>
						</div>
						<!-- Content -->
						<div class="ms-3">
							<h4>15K</h4>
							<span>Visitors</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Counter item -->
			<div class="col-sm-6 col-xl-3">
				<div class="card card-body border">
					<div class="d-flex align-items-center">
						<!-- Icon -->
						<div class="icon-xl bg-primary rounded-3 text-white">
							<i class="bi bi-star"></i>
						</div>
						<!-- Content -->
						<div class="ms-3">
							<h4>12K</h4>
							<span>Total Reviews</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Counter END -->

		<!-- Graph START -->
		<div class="row g-4">
			<!-- Booking Chart START -->
			<div class="col-lg-7 col-xl-8">
				<!-- Chart START -->
				<div class="card border h-100">
					<!-- Card header -->
					<div class="card-header border-bottom">
						<h5 class="card-header-title">Booking stats</h5>
					</div>
					<!-- Card body -->
					<div class="card-body">
						<!-- Apex chart -->
						<div id="apexChartTrafficStats" class="mt-2"></div>
					</div>
				</div>
				<!-- Chart END -->
			</div>
			<!-- Booking Chart END -->

			<!-- Booking graph START -->
			<div class="col-lg-4">
				<div class="card border h-100">

					<!-- Card header -->
					<div class="card-header border-bottom d-flex justify-content-between align-items-center">
						<h5 class="card-header-title">Booking Traffic</h5>
						<a href="#" class="btn btn-link p-0 mb-0">View all</a>
					</div>

					<!-- Card body START -->
					<div class="card-body p-3">
						<!-- Chart -->
						<div class="col-sm-6 mx-auto">
							<div class="d-flex justify-content-center" id="ChartTrafficViews"></div>
						</div>

						<!-- Content -->
						<ul class="list-group list-group-borderless align-items-center mt-3">
							<li class="list-group-item"><i class="text-primary fas fa-circle me-2"></i>Organic
							</li>
							<li class="list-group-item"><i class="text-success fas fa-circle me-2"></i>Google
							</li>
							<li class="list-group-item"><i class="text-warning fas fa-circle me-2"></i>Social
								media</li>
							<li class="list-group-item"><i class="text-danger fas fa-circle me-2"></i>Referral
								program</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- Booking graph END -->
		</div>
		<!-- Graph END -->

		<!-- Booking table START -->
		<div class="row">
			<div class="col-12">
				<div class="card border rounded-3">
					<!-- Card header START -->
					<div class="card-header border-bottom">
						<div class="d-sm-flex justify-content-between align-items-center">
							<h5 class="mb-2 mb-sm-0">Upcoming Bookings</h5>
							<a href="#" class="btn btn-sm btn-primary mb-0">View All</a>
						</div>
					</div>
					<!-- Card header END -->

					<!-- Card body START -->
					<div class="card-body">
						<!-- Search and select START -->
						<div class="row g-3 align-items-center justify-content-between mb-3">
							<!-- Search -->
							<div class="col-md-8">
								<form class="rounded position-relative">
									<input class="form-control pe-5" type="search" placeholder="Search"
										aria-label="Search">
									<button
										class="btn border-0 px-3 py-0 position-absolute top-50 end-0 translate-middle-y"
										type="submit"><i class="fas fa-search fs-6"></i></button>
								</form>
							</div>

							<!-- Select option -->
							<div class="col-md-3">
								<!-- Short by filter -->
								<form>
									<select class="form-select js-choice" aria-label=".form-select-sm">
										<option value="">Sort by</option>
										<option>Free</option>
										<option>Newest</option>
										<option>Oldest</option>
									</select>
								</form>
							</div>
						</div>
						<!-- Search and select END -->

						<!-- Hotel room list START -->
						<div class="table-responsive border-0">
							<table class="table align-middle p-4 mb-0 table-hover table-shrink">
								<!-- Table head -->
								<thead class="table-light">
									<tr>
										<th scope="col" class="border-0 rounded-start">#</th>
										<th scope="col" class="border-0">Name</th>
										<th scope="col" class="border-0">Type</th>
										<th scope="col" class="border-0">Date</th>
										<th scope="col" class="border-0">status</th>
										<th scope="col" class="border-0">Payment</th>
										<th scope="col" class="border-0 rounded-end">Action</th>
									</tr>
								</thead>

								<!-- Table body START -->
								<tbody class="border-top-0">
									<!-- Table item -->
									<tr>
										<td>
											<h6 class="mb-0">01</h6>
										</td>
										<td>
											<h6 class="mb-0"><a href="#">Deluxe Pool View</a></h6>
										</td>
										<td> With Breakfast </td>
										<td> Nov 22 - 25 </td>
										<td>
											<div class="badge text-bg-success">Booked</div>
										</td>
										<td>
											<div class="badge bg-success bg-opacity-10 text-success">Full
												payment</div>
										</td>
										<td> <a href="#" class="btn btn-sm btn-light mb-0">View</a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td>
											<h6 class="mb-0">02</h6>
										</td>
										<td>
											<h6 class="mb-0"><a href="#">Deluxe Pool View with Breakfast</a>
											</h6>
										</td>
										<td> Free Cancellation | Breakfast only </td>
										<td> Nov 24 - 28 </td>
										<td>
											<div class="badge text-bg-success">Booked</div>
										</td>
										<td>
											<div class="badge bg-orange bg-opacity-10 text-orange">On Property
											</div>
										</td>
										<td> <a href="#" class="btn btn-sm btn-light mb-0">View</a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td>
											<h6 class="mb-0">03</h6>
										</td>
										<td>
											<h6 class="mb-0"><a href="#">Luxury Room with Balcony</a></h6>
										</td>
										<td> Free Cancellation | Breakfast + Lunch/Dinner </td>
										<td> Nov 24 - 28 </td>
										<td>
											<div class="badge text-bg-info">Reserved</div>
										</td>
										<td>
											<div class="badge bg-info bg-opacity-10 text-info">Half Payment
											</div>
										</td>
										<td> <a href="#" class="btn btn-sm btn-light mb-0">View</a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td>
											<h6 class="mb-0">04</h6>
										</td>
										<td>
											<h6 class="mb-0"><a href="#">Deluxe Room Twin Bed With Balcony</a>
											</h6>
										</td>
										<td> Free Cancellation </td>
										<td> Nov 28 - 30 </td>
										<td>
											<div class="badge text-bg-success">Booked</div>
										</td>
										<td>
											<div class="badge bg-success bg-opacity-10 text-success">Full
												Payment</div>
										</td>
										<td> <a href="#" class="btn btn-sm btn-light mb-0">View</a> </td>
									</tr>

									<!-- Table item -->
									<tr>
										<td>
											<h6 class="mb-0">05</h6>
										</td>
										<td>
											<h6 class="mb-0"><a href="#">Room With Free Cancellation | Breakfast
													+ Lunch</a></h6>
										</td>
										<td> Free Cancellation </td>
										<td> Nov 28 - 30 </td>
										<td>
											<div class="badge text-bg-info">Reserved</div>
										</td>
										<td>
											<div class="badge bg-success bg-opacity-10 text-success">Full
												Payment</div>
										</td>
										<td> <a href="#" class="btn btn-sm btn-light mb-0">View</a> </td>
									</tr>
								</tbody>
								<!-- Table body END -->
							</table>
						</div>
						<!-- Hotel room list END -->
					</div>
					<!-- Card body END -->

					<!-- Card footer START -->
					<div class="card-footer pt-0">
						<!-- Pagination and content -->
						<div class="d-sm-flex justify-content-sm-between align-items-sm-center">
							<!-- Content -->
							<p class="mb-sm-0 text-center text-sm-start">Showing 1 to 8 of 20 entries</p>
							<!-- Pagination -->
							<nav class="mb-sm-0 d-flex justify-content-center" aria-label="navigation">
								<ul class="pagination pagination-sm pagination-primary-soft mb-0">
									<li class="page-item disabled">
										<a class="page-link" href="#" tabindex="-1">Prev</a>
									</li>
									<li class="page-item"><a class="page-link" href="#">1</a></li>
									<li class="page-item active"><a class="page-link" href="#">2</a></li>
									<li class="page-item disabled"><a class="page-link" href="#">..</a></li>
									<li class="page-item"><a class="page-link" href="#">15</a></li>
									<li class="page-item">
										<a class="page-link" href="#">Next</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<!-- Card footer END -->
				</div>
			</div>
		</div>
		<!-- Booking table END -->
	</div>
</section>
<!-- =======================
Content END -->