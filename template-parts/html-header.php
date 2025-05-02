<?php
if (in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	global $khebrat_theme_options;
	$preloader = $khebrat_theme_options['website_preloader'];
} else {
	$preloader = '';
}


?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="loader-outer">
		<div class="loading-inner">
			<div class="loading-inner-meta">
				<div> </div>
				<div></div>
			</div>
		</div>
	</div>
	<?php
	if (isset($preloader) && $preloader == 1) {
	?>
		<div class="exertio-loader-container">
			<div class="exertio-loader">
				<span class="exertio-dot"></span>
				<div class="exertio-dots">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<?php

	if (is_page_template('page-profile.php')) {
	} else if (is_page_template('page-login.php') && $khebrat_theme_options['login_header_show'] == 0) {
	} else if (is_page_template('page-register.php') && $khebrat_theme_options['register_header_show'] == 0) {
	} else {
		/*
	if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		$header_type  = $khebrat_theme_options['header_type'];
		
		else
		{
			$header_type = (isset($_GET['header'])&& $_GET['header'] == '2')? true: false;

			if( $header_type == true)
			{
				get_template_part( 'template-parts/headers/header','2' );
			}
			else if(isset($khebrat_theme_options['header_layout']) && $khebrat_theme_options['header_layout'] == 1)
			{
				get_template_part( 'template-parts/headers/header','1' );
			}
			else if(isset($khebrat_theme_options['header_layout']) && $khebrat_theme_options['header_layout'] == 2)
			{
				get_template_part( 'template-parts/headers/header','2' );
			}
		}
	}
	else
	{
		get_template_part( 'template-parts/headers/header','1' );
	}*/

		$current_user_id = get_current_user_id();

		$emp_id = get_user_meta($current_user_id, 'employer_id', true);

		$fre_id = get_user_meta($current_user_id, 'freelancer_id', true);

		$cust_id = get_user_meta($current_user_id, 'customer_id', true);

		$law_id = get_user_meta($current_user_id, 'lawyer_id', true);
	?>

		<!-- Dark mode -->
		<script>
			const storedTheme = localStorage.getItem('theme')

			const getPreferredTheme = () => {
				if (storedTheme) {
					return storedTheme
				}
				return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
			}

			const setTheme = function(theme) {
				if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
					document.documentElement.setAttribute('data-bs-theme', 'dark')
				} else {
					document.documentElement.setAttribute('data-bs-theme', theme)
				}
			}

			setTheme(getPreferredTheme())

			window.addEventListener('DOMContentLoaded', () => {
				var el = document.querySelector('.theme-icon-active');
				if (el != 'undefined' && el != null) {
					const showActiveTheme = theme => {
						const activeThemeIcon = document.querySelector('.theme-icon-active use')
						const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
						const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

						document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
							element.classList.remove('active')
						})

						btnToActive.classList.add('active')
						activeThemeIcon.setAttribute('href', svgOfActiveBtn)
					}

					window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
						if (storedTheme !== 'light' || storedTheme !== 'dark') {
							setTheme(getPreferredTheme())
						}
					})

					showActiveTheme(getPreferredTheme())

					document.querySelectorAll('[data-bs-theme-value]')
						.forEach(toggle => {
							toggle.addEventListener('click', () => {
								const theme = toggle.getAttribute('data-bs-theme-value')
								localStorage.setItem('theme', theme)
								setTheme(theme)
								showActiveTheme(theme)
							})
						})

				}
			})
		</script>

		<!-- Header START -->
		<header class="navbar-light header-sticky">
			<!-- Logo Nav START -->
			<nav class="navbar navbar-expand-xl">
				<div class="container">
					<!-- Logo START -->
					<a class="navbar-brand" href="index-2.html">
						<?php
						if (!empty($khebrat_theme_options['frontend_logo']['url'])) {
							echo '<img class="light-mode-item navbar-brand-item" src="' . esc_url($khebrat_theme_options['frontend_logo']['url']) . '" alt="شعار الموقع">';
						}
						if (!empty($khebrat_theme_options['dark_logo']['url'])) {
							echo '<img class="dark-mode-item navbar-brand-item" src="' . esc_url($khebrat_theme_options['dark_logo']['url']) . '" alt="شعار الموقع">';
						}

						?>
					</a>
					<!-- Logo END -->

					<!-- Responsive navbar toggler -->
					<button class="navbar-toggler ms-auto mx-3 me-md-0 p-0 p-sm-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-animation">
							<span></span>
							<span></span>
							<span></span>
						</span>
					</button>

					<!-- Main navbar START -->
					<div class="navbar-collapse collapse" id="navbarCollapse">


						<?php
						wp_nav_menu(array(
							'theme_location' => 'main_theme_menu',
							'container' => false,
							'menu_class' => 'navbar-nav navbar-nav-scroll',
							'fallback_cb' => '__return_false',
							'depth' => 2,
							'walker' => new bootstrap_5_wp_nav_menu_walker()
						));
						?>
					</div>
					<!-- Main navbar END -->

					<!-- Profile and Notification START -->
					<ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">
						<?php
						if (is_user_logged_in()) { ?>
							<!-- Notification dropdown START -->
							<li class="nav-item ms-0 ms-md-3 dropdown">
								<!-- Notification button -->
								<a class="nav-link p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
									<i class="bi bi-bell fa-fw fs-5"></i>
								</a>
								<!-- Notification dote -->
								<span class="notif-badge animation-blink"></span>

								<!-- Notification dropdown menu START -->
								<div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-0 shadow-lg">
									<div class="card bg-transparent">
										<!-- Card header -->
										<div class="card-header bg-transparent d-flex justify-content-between align-items-center border-bottom">
											<h6 class="m-0">Notifications <span class="badge bg-danger bg-opacity-10 text-danger ms-2">4 new</span></h6>
											<a class="small" href="#">Clear all</a>
										</div>

										<!-- Card body START -->
										<div class="card-body p-0">
											<ul class="list-group list-group-flush list-unstyled p-2">
												<!-- Notification item -->
												<li>
													<a href="#" class="list-group-item list-group-item-action rounded notif-unread border-0 mb-1 p-3">
														<h6 class="mb-2">New! Booking flights from New York ✈️</h6>
														<p class="mb-0 small">Find the flexible ticket on flights around the world. Start searching today</p>
														<span>Wednesday</span>
													</a>
												</li>
												<!-- Notification item -->
												<li>
													<a href="#" class="list-group-item list-group-item-action rounded border-0 mb-1 p-3">
														<h6 class="mb-2">Sunshine saving are here 🌞 save 30% or more on a stay</h6>
														<span>15 Nov 2022</span>
													</a>
												</li>
											</ul>
										</div>
										<!-- Card body END -->

										<!-- Card footer -->
										<div class="card-footer bg-transparent text-center border-top">
											<a href="#" class="btn btn-sm btn-link mb-0 p-0">See all incoming activity</a>
										</div>
									</div>
								</div>
								<!-- Notification dropdown menu END -->
							</li>
							<!-- Notification dropdown END -->
							<!-- Profile dropdown START -->
							<li class="nav-item ms-3 dropdown">
								<!-- Avatar -->
								<?php
								$active_profile = get_user_meta($current_user_id, '_active_profile', true);
								$wallet_link = $wallet_text_escaped = '';
								$final_amount_html = $user_type = $user_name = $profile_image = '';
								$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
								if (isset($is_wallet_active) && $is_wallet_active == 0) {
									$amount = get_user_meta($current_user_id, '_fl_wallet_amount', true);
									if (empty($amount)) {
										$final_amout =  0;
									} else {
										$final_amout =  $amount;
									}
									$final_amount_html = ' ( ' . fl_price_separator($final_amout) . ' )';
								}
								if (isset($active_profile) &&  $active_profile == 1) {
									$active_user = 	$emp_id;
									$profile_image = get_profile_img($active_user, "employer", "avatar-img rounded-circle");

									$user_name = exertio_get_username('employer', $active_user);
									$user_type = esc_html__('Employer', 'khebrat_theme');
									$wallet_link = get_the_permalink() . '?ext=invoices';
									$wallet_text_escaped = esc_html__('View Wallet Detail', 'khebrat_theme');
								} else if (isset($active_profile) &&  $active_profile == 2) {
									$active_user = 	$fre_id;
									$profile_image = get_profile_img($active_user, "freelancer", "avatar-img rounded-circle");

									$user_name = exertio_get_username('freelancer', $active_user);
									$user_type = esc_html__('Freelancer', 'khebrat_theme');
									$wallet_link = get_the_permalink() . '?ext=payouts';
									$wallet_text_escaped = esc_html__('Withdraw Funds', 'khebrat_theme');
								} else if (isset($active_profile) &&  $active_profile == 3) {
									$active_user = 	$cust_id;
									$profile_image = get_profile_img($active_user, "customer", "avatar-img rounded-circle");

									$user_name = exertio_get_username('customer', $active_user);
									$user_type = esc_html__('Customer', 'khebrat_theme');
									$wallet_link = get_the_permalink() . '?ext=payouts';
									$wallet_text_escaped = esc_html__('Withdraw Funds', 'khebrat_theme');
								} else if (isset($active_profile) &&  $active_profile == 4) {
									$active_user = 	$law_id;
									$profile_image = get_profile_img($active_user, "lawyer", "avatar-img rounded-circle");

									$user_name = exertio_get_username('lawyer', $active_user);
									$user_type = esc_html__('lawyer', 'khebrat_theme');
									$wallet_link = get_the_permalink() . '?ext=payouts';
									$wallet_text_escaped = esc_html__('Withdraw Funds', 'khebrat_theme');
								}
								?>
								<a class="avatar avatar-xs p-0" href="javascript:void(0)" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
									<?php echo wp_return_echo($profile_image); ?>
								</a>

								<!-- Profile dropdown START -->
								<ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
									<!-- Profile info -->
									<li class="px-3 mb-3">
										<div class="d-flex align-items-center">
											<!-- Avatar -->
											<div class="avatar me-3">
												<?php echo wp_return_echo($profile_image); ?> 
											</div>

											<div>
												<h6 class="mb-0"><?php echo esc_html($user_name) . $active_profile . $active_user; ?></h6>
												<a href="<?php esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])) ?>" class="small m-0"><?php echo wp_get_current_user()->user_email ?></a>
											</div>
										</div>
									</li>

									<!-- Links -->
									<li>
										<hr class="dropdown-divider">
									</li>
									<li><a class="dropdown-item" href="<?php esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])) ?>"><i class="bi bi-house fa-fw me-2"></i>لوحة تحكم</a></li>
									<li><a class="dropdown-item" href="<?php esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])) . '?ext=services' ?>"><i class="bi bi-person-gear fa-fw me-2"></i>خدماتي</a></li>
									<li><a class="dropdown-item" href="<?php esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])) . '?ext=profile' ?>"><i class="bi bi-gear fa-fw me-2"></i>الاعدادات</a></li>
									<li><a class="dropdown-item" href="<?php esc_attr(get_permalink($khebrat_theme_options['user_dashboard_page'])) . '?ext=profile' ?>"><i class="bi bi-person-video2 fa-fw me-2"></i>جلساتي</a></li>
									<li><a class="dropdown-item bg-danger-soft-hover" href="<?php echo wp_logout_url(get_the_permalink(fl_framework_get_options('login_page'))); ?>"><i class="bi bi-power fa-fw me-2"></i>Sign Out</a></li>
									<li>
										<hr class="dropdown-divider">
									</li>

									<!-- Dark mode options START -->
									<li>
										<div class="nav-pills-primary-soft theme-icon-active d-flex justify-content-between align-items-center p-2 pb-0">
											<span>Mode:</span>
											<button type="button" class="btn btn-link nav-link text-primary-hover mb-0 p-0" data-bs-theme-value="light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Light">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun fa-fw mode-switch" viewBox="0 0 16 16">
													<path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
													<use href="#"></use>
												</svg>
											</button>
											<button type="button" class="btn btn-link nav-link text-primary-hover mb-0 p-0" data-bs-theme-value="dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dark">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars fa-fw mode-switch" viewBox="0 0 16 16">
													<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z" />
													<path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
													<use href="#"></use>
												</svg>
											</button>
											<button type="button" class="btn btn-link nav-link text-primary-hover mb-0 p-0 active" data-bs-theme-value="auto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Auto">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half fa-fw mode-switch" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
													<use href="#"></use>
												</svg>
											</button>
										</div>
									</li>
									<!-- Dark mode options END-->
								</ul>
								<!-- Profile dropdown END -->
							</li>
							<!-- Profile dropdown END -->
						<?php
						} else { ?>
							<!-- Dark mode options START -->
							<li class="nav-item dropdown me-2">
								<button class="btn btn-link text-warning p-0 mb-0" id="bd-theme" type="button"
									aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
										class="bi bi-circle-half theme-icon-active fa-fw" viewBox="0 0 16 16">
										<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
										<use href="#"></use>
									</svg>
								</button>

								<ul class="dropdown-menu min-w-auto dropdown-menu-end" aria-labelledby="bd-theme">
									<li class="mb-1">
										<button type="button" class="dropdown-item d-flex align-items-center"
											data-bs-theme-value="light">
											<svg width="16" height="16" fill="currentColor"
												class="bi bi-brightness-high-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
												<path
													d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
												<use href="#"></use>
											</svg>Light
										</button>
									</li>
									<li class="mb-1">
										<button type="button" class="dropdown-item d-flex align-items-center"
											data-bs-theme-value="dark">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
												class="bi bi-moon-stars-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
												<path
													d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
												<path
													d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
												<use href="#"></use>
											</svg>Dark
										</button>
									</li>
									<li>
										<button type="button" class="dropdown-item d-flex align-items-center active"
											data-bs-theme-value="auto">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
												class="bi bi-circle-half fa-fw mode-switch me-1" viewBox="0 0 16 16">
												<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
												<use href="#"></use>
											</svg>Auto
										</button>
									</li>
								</ul>
							</li>
							<!-- Dark mode options END -->

							<!-- Button -->
							<li class="nav-item ms-3 d-none d-sm-block">
								<a class="btn btn-sm btn-primary-soft mb-0" href="#"><i class="bi bi-lightning-charge"></i> Upgrade now</a>
							</li>

						<?php  } ?>

					</ul>
					<!-- Profile and Notification START -->

				</div>
			</nav>
			<!-- Logo Nav END -->
		</header>
		<!-- Header END -->

	<?php
	}
