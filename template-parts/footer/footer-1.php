<?php
$footer_logo = fl_framework_get_options('exertio_footer_logo');
if(isset($footer_logo) && $footer_logo != '')
{
	$footer_logo_url = $footer_logo['url'];
}
else
{
	$footer_logo_url = get_template_directory_uri().'/images/logo-dashboard.svg';
}
$none = '';
if(fl_framework_get_options('project_sidebar_layout') == '2' && is_page_template( 'page-project-search.php' ) ){
    $none = 'none';
}
$img_id ='';
$actionbBar = fl_framework_get_options('action_bar');
if(isset($actionbBar) && $actionbBar == 1)
{
	$action_btn = fl_framework_get_options('action_btn_text');
	if(isset($action_btn) && $action_btn == '')
	{
		$action_cols = 'col-xl-12 col-lg-12';	
	}
	else
	{
		$action_cols = 'col-xl-8 col-lg-8';
	}
	if(!is_page_template( 'page-register.php' ) && !is_page_template( 'page-login.php' ))
	{
	?>
		<section class="fr-bg-style2 <?php echo esc_attr($none);?>">
		  <div class="container">
			<div class="row">
			  <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
				<div class="fr-bg-style">
				  <div class="row">
					<div class="<?php echo esc_attr($action_cols); ?>">
					  <div class="fr-gt-content">
						<h3><?php echo esc_html(fl_framework_get_options('action_heading_text')); ?></h3>
						<p><?php echo esc_html(fl_framework_get_options('action_content')); ?></p>
					  </div>
					</div>
					<?php
					if($action_btn != '')
					{
					?>
					<div class="col-xl-4 col-lg-4 align-self-center">
					  <div class="fr-gt-btn"> <a href="<?php echo get_the_permalink(fl_framework_get_options('action_btn_link')); ?>" class="btn btn-theme"><?php echo esc_html(fl_framework_get_options('action_btn_text')); ?></a> </div>
					</div>
					<?php
					}
					?>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</section>
	<?php
	}
}
?>


<footer class="bg-dark py-7">
	<div class="container">
		<div class="row mx-auto">
			<div class="col-md-10 col-xl-6 mx-auto text-center">
				<!-- Logo -->
				<img class="mx-auto h-60px" src="<?php echo esc_url($footer_logo_url); ?>" alt="logo">
				<p class="mt-3 text-white"><?php echo esc_html(fl_framework_get_options('website_footer_content')); ?></p>
				<!-- Links -->
				<?php if(fl_framework_get_options('footer_custom_link')==1)
              	{?>
              	    <h3 class="fr-style-8"><?php echo esc_html(fl_framework_get_options('footer_custom_link_heading')); ?></h3>
              	    <?php
              	    exertio_main_menu( 'footer_menu' );
              	}
			  	?>
				<!-- Social media button -->
				<ul class="list-inline mt-3 mb-0">
				<?php 
				if(fl_framework_get_options('footer_facebook_link') != ''){?><li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-facebook" href="<?php echo esc_url(fl_framework_get_options('footer_facebook_link')); ?>"><i class="fab fa-fw fa-facebook-f"></i></i></a> </li><?php } 
				if(fl_framework_get_options('footer_twitter_link') != ''){?><li class="list-inline-item"> <a  class="btn btn-white btn-sm shadow px-2 text-twitter" href="<?php echo esc_url(fl_framework_get_options('footer_twitter_link')); ?>"><i class="fab fa-fw fa-twitter"></i></a> </li><?php } 
				if(fl_framework_get_options('footer_linkedin_link') != ''){?><li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-linkedin" href="<?php echo esc_url(fl_framework_get_options('footer_linkedin_link')); ?>"><i class="fab fa-fw fa-linkedin-in"></i></a> </li><?php }
				if(fl_framework_get_options('footer_instagram_link') != ''){?><li class="list-inline-item"> <a class="btn btn-white btn-sm shadow px-2 text-instagram" href="<?php echo esc_url(fl_framework_get_options('footer_instagram_link')); ?>"><i class="fab fa-fw fa-instagram"></i></a> </li><?php }
				?>				
				</ul>
				<!-- copyright text -->
				<div class="text-body-secondary text-primary-hover mt-3">
				<?php echo fl_framework_get_options('footer_copyright_text'); ?>
				</div>
			</div>
		</div>

	</div>
</footer>