<?php

if (in_array('khebrat-framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    get_template_part('header');
		$ID = get_the_ID();
		$profile_imageURL = get_template_directory_uri() . '/images/emp_default.jpg';
		$profile_pic_id 	= get_post_meta($ID, '_lawyer_banner_id', true);
		$term_output 			= "بيانات سرية";
		$PDF_ID 					= get_post_meta($ID, '_license_attached_pdf', true);
		$PDF_URL 					= wp_get_attachment_url($PDF_ID);
		if($profile_pic_id){
			$ImageURL 	= wp_get_attachment_image_url($profile_pic_id); 
			$profile_imageURL = $ImageURL;
		}
		$author_id 	= get_post_field('post_author', get_the_ID());
		$user_info = get_userdata($author_id);

		$terms = wp_get_object_terms($ID, 'customer-locations');
		if (!empty($terms) && !is_wp_error($terms)) {
				$term_output = [];
		
				foreach ($terms as $term) {
						$term_name = $term->name;
		
						if ($term->parent) {
								$parent_term = get_term($term->parent, 'customer-locations');
								if ($parent_term && !is_wp_error($parent_term)) {
										$term_name = $parent_term->name . ' - ' . $term_name;
								}
						}
		
						$term_output[] = $term_name;
				}
		

		} 


		// echo "<pre class='preClass'>";
		// 	echo $PDF_URL;
		// echo "</pre>";
    ?>
		<style>
			.preClass{
				background: #f7f7f7;
				color: black;
				padding: 20px 30px;
			}
		</style>
    <div class="row g-4 mb-5">
				<!-- Agent info START -->
				<div class="col-md-4 col-xxl-3">
					<div class="card bg-light">

						<!-- Card body -->
						<div class="card-body text-center">
							<!-- Avatar Image -->
							<div class="avatar avatar-xl flex-shrink-0 mb-3">
								<img class="avatar-img rounded-circle" src="<?php echo $profile_imageURL ?>" alt="avatar">
							</div>
							<!-- Title -->
							<h5 class="mb-2"><?php echo get_post_meta($ID, '_lawyer_full_name', true) ?></h5>

						</div>
						<!-- Card footer -->
						<div class="card-footer bg-light border-top">
							<h6 class="mb-3">Contact Details</h6>
							<!-- Email id -->
							<div class="d-flex align-items-center mb-3">
								<div class="icon-md bg-mode h6 mb-0 rounded-circle flex-shrink-0"><i class="bi bi-envelope-fill"></i></div>
								<div class="ms-2">
									<small>البريد الاكتروني</small>
									<h6 class="fw-normal small mb-0"><a href="mail:to<?php echo $user_info->user_email ?>"><?php echo $user_info->user_email ?></a></h6>
								</div>
							</div>

							<!-- Phone -->
							<div class="d-flex align-items-center mb-3">
								<div class="icon-md bg-mode h6 mb-0 rounded-circle flex-shrink-0"><i class="bi bi-telephone-fill"></i></div>
								<div class="ms-2">
									<small>الجوال</small>
									<h6 class="fw-normal small mb-0"><a href="#"><?php echo get_post_meta($ID, '_lawyer_contact_number', true) ?></a></h6>
								</div>
							</div>

							<!-- Phone -->
							<div class="d-flex align-items-center mb-3">
								<div class="icon-md bg-mode h6 mb-0 rounded-circle flex-shrink-0"><i class="bi bi-geo-alt-fill"></i></div>
								<div class="ms-2">
									<small>العنوان</small>
									<h6 class="fw-normal small mb-0"><?php echo implode('، ', $term_output) ?></h6>
								</div>
							</div>



						</div>
					</div>
				</div>
				<!-- Agent info END -->

				<div class="col-md-8 col-xxl-9">
					<!-- Personal info START -->
					<div class="card shadow">
						<!-- Card header -->
						<div class="card-header border-bottom">
							<h5 class="mb-0">البيانات المحامي</h5>
						</div>
						<!-- Card body -->
						<div class="card-body">
							<div class="row">
								<!-- Information item -->
								<div class="col-md-6">
									<ul class="list-group list-group-borderless">
										<li class="list-group-item mb-3">
											<span>الاسم بالكامل</span>
											<span class="h6 fw-normal ms-1 mb-0"><?php echo get_post_meta($ID, '_lawyer_full_name', true) ?></span>
										</li>
	

	
										<li class="list-group-item mb-3">
											<span>رقم الهاتف</span>
											<span class="h6 fw-normal ms-1 mb-0"><?php echo get_post_meta($ID, '_lawyer_contact_number', true) ?></span>
										</li>

										<li class="list-group-item mb-3">
											<span>رخصة المحاميي</span>
											<span class="h6 fw-normal ms-1 mb-0"><?php echo get_post_meta($ID, '_license_number', true) ?></span>
										</li>


									</ul>
								</div>
	
								<!-- Information item -->
								<div class="col-md-6">
									<ul class="list-group list-group-borderless">
										<li class="list-group-item mb-3">
											<span>البريد الاكتروني :</span>
											<span class="h6 fw-normal ms-1 mb-0"><?php echo $user_info->user_email ?></span>
										</li>

										<li class="list-group-item mb-3">
											<span>الجنسة:</span>
											<span class="h6 fw-normal ms-1 mb-0"><?php echo   get_post_meta($ID, '_lawyer_gender', true) ?   "ذكر" :  "انثي" ?></span>
										</li>
	
										<li class="list-group-item mb-3">
											<span>الموقع :</span>
											<span class="h6 fw-normal ms-1 mb-0"><?php echo implode('، ', $term_output) ?></span>
										</li>
	
										<li class="list-group-item mb-3">
											<span> عضو منذ :</span>
											<span class="h6 fw-normal ms-1 mb-0"><?php echo khebrat_time_since($ID) ?></span>
										</li>
									</ul>
								</div>
	
								<!-- Information item -->
								<div class="col-12">
									<ul class="list-group list-group-borderless">
										<li class="list-group-item">
											<span>وصف: </span>
											<p class="h6 fw-normal mb-0">As it so contrasted oh estimating instrument. Size-like body someone had. Are conduct viewing boy minutes warrant the expense Tolerably behavior may admit daughters offending her ask own? Praise effect wishes to change way and any wanted. Lively use looked latter regard had. Does he it part last in</p>
										</li>
									</ul>
								</div>

								<div class="col-12 mt-2 mb-2">
									<span>الملفات : </span>
									<iframe style="height:700px" height="700" src="<?php echo  $PDF_URL ?>" frameborder="0"></iframe>
								</div>
							</div>
						</div>
					</div>
					<!-- Personal info END -->
				</div>
			</div> <!-- Row END -->


    <?php

} else {
    wp_redirect(home_url());
}
if (isset($khebrat_theme_options['footer_type'])) {
    $footer_type  = $khebrat_theme_options['footer_type'];
} else {
    $footer_type  = 0;
}
if ($footer_type  ==  1) {
    if ($footer_type  ==  1 && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        elementor_theme_do_location('footer');
        get_footer();
    } else {
        get_footer();
    }
} else {
    get_template_part('footer');
}
?>