<?php
global $khebrat_theme_options;

$current_user_id = get_current_user_id();
$pid = get_user_meta($current_user_id, 'lawyer_id', true);
$user_info = get_userdata($current_user_id);
global $khebrat_theme_options;

$page_name = '';
if (isset($_GET['ext']) && $_GET['ext'] != "") {
	$page_name = $_GET['ext'];
}
$alt_id = '';

?>
<div class="card rounded-3 border p-3 pb-2">
	<!-- Avatar and info START -->
	<div class="d-sm-flex align-items-center">

		<?php
		$pro_img_id = get_post_meta($pid, '_profile_pic_attachment_id', true);
		$pro_img = wp_get_attachment_image_src($pro_img_id, 'thumbnail');
		if (!empty($pro_img_id)) {
		?>
			<div class="avatar avatar-xl mb-2 mb-sm-0 avatar-profile">
				<img src="<?php echo esc_url($pro_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="avatar-img rounded-circle">
			</div>
		<?php
		} else {
		?>
			<div class="avatar avatar-xl mb-2 mb-sm-0">
				<img class="avatar-img rounded-circle" src="<?php echo esc_url($khebrat_theme_options['employer_df_img']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>">
			</div>

		<?php
		}
		?>
		<h4 class="mb-2 mb-sm-0 ms-sm-3"><span class="fw-light">Hi</span> <?php echo exertio_get_username('lawyer', $pid, 'badge', 'right'); ?></h4>
		<a href="add-listing.html" class="btn btn-sm btn-primary-soft mb-0 ms-auto flex-shrink-0"><i
				class="bi bi-plus-lg fa-fw me-2"></i>Add New Listing</a>
	</div>
	<!-- Avatar and info START -->

	<!-- Responsive navbar toggler -->
	<button class="btn btn-primary w-100 d-block d-xl-none mt-2" type="button"
		data-bs-toggle="offcanvas" data-bs-target="#dashboardMenu" aria-controls="dashboardMenu">
		<i class="bi bi-list"></i> Dashboard Menu
	</button>

	<!-- Nav links START -->
	<div class="offcanvas-xl offcanvas-end mt-xl-3" tabindex="-1" id="dashboardMenu">
		<div class="offcanvas-header border-bottom p-3">
			<h5 class="offcanvas-title">Menu</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"
				data-bs-target="#dashboardMenu" aria-label="Close"></button>
		</div>
		<!-- Offcanvas body -->
		<div class="offcanvas-body p-3 p-xl-0">
			<!-- Nav item -->
			<div class="navbar navbar-expand-xl">
				<ul class="navbar-nav navbar-offcanvas-menu">


					<li class="nav-item">
						<a class="nav-link <?php if ($page_name == '') {
												echo 'active';
											} ?>" href="<?php echo esc_url(get_the_permalink()); ?>"><i class="bi bi-house-door fa-fw me-1"></i><?php echo esc_html__('لوحة التحكم', 'khebrat_theme'); ?> </a>
					</li>


					<li class="nav-item">
						<a class="nav-link <?php if ($page_name == 'services') { echo 'active'; } ?>" href="<?php echo esc_url(get_the_permalink()); ?>?ext=services"><i class="bi bi-person-gear fa-fw me-2"></i><?php echo esc_html__('الخدمات', 'khebrat_theme'); ?></a>
					</li>

					<li class="nav-item"> <a class="nav-link" href="agent-bookings.html"><i
								class="bi bi-bookmark-heart fa-fw me-1"></i>الاستشارات</a> </li>
					<li class="nav-item"> <a class="nav-link" href="agent-bookings.html"><i
								class="bi bi-bookmark-heart fa-fw me-1"></i>الجلسات</a> </li>

					<li class="nav-item"> <a class="nav-link" href="agent-activities.html"><i
								class="bi bi-bell fa-fw me-1"></i>Activities</a> </li>

					<li class="nav-item"> <a class="nav-link" href="agent-earnings.html"><i
								class="bi bi-graph-up-arrow fa-fw me-1"></i>Earnings</a> </li>

					<li class="nav-item"> <a class="nav-link" href="agent-reviews.html"><i
								class="bi bi-star fa-fw me-1"></i>Reviews</a></li>


					<li class="nav-item">
						<a class="nav-link <?php if ($page_name == 'settings') {
												echo 'active';
											} ?> " href="<?php echo esc_url(get_the_permalink()); ?>?ext=settings"><i class="bi bi-gear fa-fw me-1"></i><?php echo esc_html__('اعدادات ', 'khebrat_theme'); ?> </a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdoanMenu"
							data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="bi bi-list-ul fa-fw me-1"></i>Dropdown
						</a>
						<ul class="dropdown-menu" aria-labelledby="dropdoanMenu">
							<!-- Dropdown menu -->
							<li> <a class="dropdown-item" href="#">Item 1</a></li>
							<li> <a class="dropdown-item" href="#">Item 2</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- Nav links END -->
</div>