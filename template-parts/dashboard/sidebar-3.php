<?php
global $khebrat_theme_options;

$current_user_id = get_current_user_id();
$pid = get_user_meta( $current_user_id, 'customer_id' , true );
$user_info = get_userdata($current_user_id);
global $khebrat_theme_options;

$page_name ='';
if(isset($_GET['ext']) && $_GET['ext'] !="")
{ 
	$page_name = $_GET['ext'];	
}
$alt_id ='';

?>
<!-- Sidebar START -->
<div class="col-lg-4 col-xl-3">
	<!-- Responsive offcanvas body START -->
	<div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasSidebar">
		<!-- Offcanvas header -->
		<div class="offcanvas-header justify-content-end pb-2">
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"
				data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
		</div>

		<!-- Offcanvas body -->
		<div class="offcanvas-body p-3 p-lg-0">
			<div class="card bg-light w-100">

				<!-- Edit profile button -->
				<div class="position-absolute top-0 end-0 p-3">
					<a href="#" class="text-primary-hover" data-bs-toggle="tooltip"
						data-bs-title="Edit profile">
						<i class="bi bi-pencil-square"></i>
					</a>
				</div>

				<!-- Card body START -->
				<div class="card-body p-3">
					<!-- Avatar and content -->
					<div class="text-center mb-3">
						<!-- Avatar -->
						<?php
						$pro_img_id = get_post_meta( $pid, '_profile_pic_attachment_id', true );
						$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );
						if (!empty($pro_img_id)) { 
						?>
							<div class="avatar avatar-xl mb-2 avatar-profile">
								<img src="<?php echo esc_url($pro_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="avatar-img rounded-circle border border-2 border-white">
							</div>
						<?php
						} else {
						?>
							<div class="avatar avatar-xl mb-2">
								<img class="avatar-img rounded-circle border border-2 border-white" src="<?php echo esc_url($khebrat_theme_options['employer_df_img']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>">
							</div>

						<?php
						}
						?>
						<h6 class="mb-0"><?php echo exertio_get_username('customer', $pid, 'badge', 'right'); ?></h6>
						<a href="#" class="text-reset text-primary-hover small"><?php echo esc_html($user_info->user_email); ?></a>
						<hr>
					</div>

					<!-- Sidebar menu item START -->
					<ul class="nav nav-pills-primary-soft flex-column">
						<li class="nav-item">
							<a class="nav-link <?php if($page_name == 'dashboard') { echo 'active';} ?>" href="<?php echo esc_url(get_the_permalink());?>"><i class="bi bi-house fa-fw me-2"></i><?php echo esc_html__( 'لوحة التحكم', 'khebrat_theme' ); ?> </a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($page_name == 'profile') { echo 'active';} ?> " href="<?php echo esc_url(get_the_permalink());?>?ext=profile"><i class="bi bi-person fa-fw me-2"></i><?php echo esc_html__( 'تفاصيل الحساب', 'khebrat_theme' ); ?> </a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($page_name == 'services') { echo 'active';} ?>" href="<?php echo esc_url(get_the_permalink());?>?ext=services"><i class="bi bi-person-gear fa-fw me-2"></i><?php echo esc_html__( 'خدماتي', 'khebrat_theme' ); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($page_name == 'consultations') { echo 'active';} ?>" href="<?php echo esc_url(get_the_permalink());?>?ext=consultations"><i class="bi bi-ticket-perforated fa-fw me-2"></i><?php echo esc_html__( 'استشاراتي', 'khebrat_theme' ); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($page_name == 'sessions') { echo 'active';} ?>" href="account-bookings.html"><i class="bi bi-person-video2 fa-fw me-2"></i><?php echo esc_html__( 'جلساتي', 'khebrat_theme' ); ?></a>
						</li>
						
						<li class="nav-item">
							<a class="nav-link text-danger bg-danger-soft-hover" href="<?php echo wp_logout_url(get_the_permalink(fl_framework_get_options('login_page'))); ?>"><i class="fas fa-sign-out-alt fa-fw me-2"></i><?php echo esc_html__( 'تسجيل خروج', 'khebrat_theme' ); ?></a>
						</li>
					</ul>
					<!-- Sidebar menu item END -->
				</div>
				<!-- Card body END -->
			</div>
		</div>
	</div>
	<!-- Responsive offcanvas body END -->
</div>
<!-- Sidebar END -->