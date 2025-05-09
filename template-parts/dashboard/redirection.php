<?php
$uid = get_current_user_id();
/*global $khebrat_theme_options;
$uid = get_current_user_id();
$employer_id = get_user_meta( $uid, 'employer_id' , true );

$freelancer_id = get_user_meta( $uid, 'freelancer_id' , true );
if($employer_id == "" || $freelancer_id =="")
{
	$user_info = get_userdata($uid);
	$user_name = $user_info->display_name;
	$my_post = array(
		'post_title' => $user_name,
		'post_status' => 'publish',
		'post_author' => $uid,
		'post_type' => 'employer'
	);
	
	$company_id = wp_insert_post($my_post);
	update_user_meta( $uid, 'employer_id', $company_id );
	
	$my_post_2 = array(
		'post_title' => $user_name,
		'post_status' => 'publish',
		'post_author' => $uid,
		'post_type' => 'freelancer'
	);
	$freelancer_id = wp_insert_post($my_post_2);
	update_user_meta( $uid, 'freelancer_id', $freelancer_id );
}*/ 
/*REDIRECTION URLS*/
$active_profile = get_user_meta($uid,'_active_profile', true);
if(isset($active_profile)  && $active_profile == 1)
{
	if(isset($_GET['ext']) && $_GET['ext'] !="")
	{
		$page_type  = $_GET['ext'];
		if($page_type == "edit-profile")
		{
			get_template_part('template-parts/dashboard/layouts/profile/edit-profile');
		}
		else if($page_type == "dashboard")
		{
			get_template_part('template-parts/dashboard/layouts/dashboard');
		}

		else if($page_type == "inbox")
		{
			get_template_part( 'template-parts/dashboard/chat' );
		}
		else if($page_type == "create-project")
		{
			get_template_part('template-parts/dashboard/layouts/project/create-project');
		}
		else if($page_type == "pending-projects")
		{
			get_template_part('template-parts/dashboard/layouts/project/pending-projects');
		}
		else if($page_type == "projects")
		{
			get_template_part('template-parts/dashboard/layouts/project/all-project');
		}
		else if($page_type == "canceled-projects")
		{
			get_template_part('template-parts/dashboard/layouts/project/canceled-projects');
		}
		else if($page_type == "project-propsals")
		{
			get_template_part('template-parts/dashboard/layouts/project/proposals');
		}
		else if($page_type == "ongoing-project")
		{
			get_template_part('template-parts/dashboard/layouts/project/ongoing-project');
		}
		else if($page_type == "expired-project")
		{
			get_template_part('template-parts/dashboard/layouts/project/expired-project');
		}
		else if($page_type == "ongoing-project-proposals")
		{
			get_template_part('template-parts/dashboard/layouts/project/ongoing-project-proposals');
		}
		else if($page_type == "ongoing-project-detail")
		{
			get_template_part('template-parts/dashboard/layouts/project/ongoing-project-detail');
		}
		else if($page_type == "completed-projects")
		{
			get_template_part('template-parts/dashboard/layouts/project/completed-projects');
		}
		else if($page_type == "saved-services")
		{
			get_template_part('template-parts/dashboard/layouts/services/saved-services');
		}
		else if($page_type == "completed-project-detail")
		{
			get_template_part('template-parts/dashboard/layouts/project/completed-project-detail');
		}
		else if($page_type == "ongoing-services")
		{
			get_template_part('template-parts/dashboard/layouts/services/ongoing-services');
		}
		else if($page_type == "ongoing-service-detail")
		{
			get_template_part('template-parts/dashboard/layouts/services/ongoing-service-detail');
		}
		else if($page_type == "completed-services")
		{
			get_template_part('template-parts/dashboard/layouts/services/completed-services');
		}
		else if($page_type == "completed-service-detail")
		{
			get_template_part('template-parts/dashboard/layouts/services/completed-service-detail');
		}
		else if($page_type == "canceled-services")
		{
			get_template_part('template-parts/dashboard/layouts/services/canceled-services');
		}
		else if($page_type == "canceled-service-detail")
		{
			get_template_part('template-parts/dashboard/layouts/services/canceled-service-detail');
		}
		else if($page_type == "invoices")
		{
			get_template_part('template-parts/dashboard/invoices/invoices');
		}
		else if($page_type == "invoice-detail")
		{
			get_template_part('template-parts/dashboard/invoices/invoice-detail');
		}
		else if($page_type == "followed-freelancers")
		{
			get_template_part('template-parts/dashboard/layouts/profile/followed-freelancer');
		}
		else if($page_type == "project-offers")
		{
			get_template_part('template-parts/dashboard/layouts/offers/project-offers');
		}
		else if($page_type == "accepted-offers")
		{
			get_template_part('template-parts/dashboard/layouts/offers/accepted-offers');
		}
		else if($page_type == "rejected-offers")
		{
			get_template_part('template-parts/dashboard/layouts/offers/rejected-offers');
		}
		else if($page_type == "cancelled-offers")
		{
			get_template_part('template-parts/dashboard/layouts/offers/cancelled-offers');
		}
		else if($page_type == "disputes")
		{
			get_template_part('template-parts/dashboard/disputes/create-disputes');
		}
		else if($page_type == "dispute-detail")
		{
			get_template_part('template-parts/dashboard/disputes/dispute-detail');
		}
		else if($page_type == "identity-verification")
		{
			get_template_part('template-parts/dashboard/verification/identity-verification');
		}
		else if($page_type == "notifications")
		{
			get_template_part('template-parts/dashboard/notifications');
		}
		else if($page_type == "statements")
		{
			get_template_part('template-parts/dashboard/statements');
		}
		else if($page_type == "meetings-settings")
		{
			get_template_part('template-parts/dashboard/layouts/meetings/meetings-settings');
		}
		else if($page_type == "all-meetings")
		{
			get_template_part('template-parts/dashboard/layouts/meetings/all-meetings');
		}
		else if($page_type == "invitations")
		{
			get_template_part('template-parts/dashboard/layouts/invitations/invitations');
		}
		else
		{
			get_template_part( 'template-parts/dashboard/layouts/dashboard');
		}

		

	}
	else 
	{
		get_template_part( 'template-parts/dashboard/layouts/dashboard');	
	}
}
else if(isset($active_profile)  && $active_profile == 2)
{
	if(isset($_GET['ext']) && $_GET['ext'] !="")
	{
		$page_type  = $_GET['ext'];
		if($page_type == "dashboard")
		{
			get_template_part('template-parts/dashboard/layouts-2/dashboard');
		}
		else if($page_type == "inbox")
		{
			get_template_part( 'template-parts/dashboard/chat' );
		}
		else if($page_type == "edit-profile")
		{
			get_template_part('template-parts/dashboard/layouts-2/profile/edit-profile');
		}
		else if($page_type == "create-addon")
		{
			get_template_part('template-parts/dashboard/layouts-2/addons/create-addons');
		}
		else if($page_type == "addons")
		{
			get_template_part('template-parts/dashboard/layouts-2/addons/all-addons');
		}
		else if($page_type == "pending-addons")
		{
			get_template_part('template-parts/dashboard/layouts-2/addons/pending-addons');
		}
		else if($page_type == "add-services")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/add-services');
		}
		else if($page_type == "all-services")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/all-services');
		}

		else if($page_type == "ongoing-services")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/ongoing-services');
		}
		else if($page_type == "ongoing-service-detail")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/ongoing-service-detail');
		}
		else if($page_type == "pending-services")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/pending-services');
		}
		else if($page_type == "completed-services")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/completed-services');
		}
		else if($page_type == "completed-service-detail")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/completed-service-detail');
		}
		else if($page_type == "canceled-services")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/canceled-services');
		}
		else if($page_type == "canceled-service-detail")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/canceled-service-detail');
		}

       else if($page_type == "in_active-services")
		{
			get_template_part('template-parts/dashboard/layouts-2/services/in-active-services');
		}
		else if($page_type == "ongoing-project")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/ongoing-project');
		}
		else if($page_type == "ongoing-project-detail")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/ongoing-project-detail');
		}

        else if($page_type == "invitations")
		{
			get_template_part('template-parts/dashboard/layouts-2/invitations/invitations');
		}

		else if($page_type == "alert-project")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/alert-project');
		}
		else if($page_type == "completed-projects")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/completed-projects');
		}
		else if($page_type == "completed-project-detail")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/completed-project-detail');
		}
		else if($page_type == "canceled-projects")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/canceled-projects');
		}
		else if($page_type == "saved-projects")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/saved-projects');
		}
		else if($page_type == "followed-employers")
		{
			get_template_part('template-parts/dashboard/layouts-2/profile/followed-employers');
		}
		else if($page_type == "invoices")
		{
			get_template_part('template-parts/dashboard/invoices/invoices');
		}
		else if($page_type == "invoice-detail")
		{
			get_template_part('template-parts/dashboard/invoices/invoice-detail');
		}
		else if($page_type == "disputes")
		{
			get_template_part('template-parts/dashboard/disputes/create-disputes');
		}
		else if($page_type == "dispute-detail")
		{
			get_template_part('template-parts/dashboard/disputes/dispute-detail');
		}
		else if($page_type == "payouts")
		{
			get_template_part('template-parts/dashboard/payouts/payout-page');
		}
		else if($page_type == "settings")
		{
			get_template_part('template-parts/dashboard/layouts-2/settings/freelancer-settings');
		}
		else if($page_type == "identity-verification")
		{
			get_template_part('template-parts/dashboard/verification/identity-verification');
		}
		else if($page_type == "my-proposals")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/my-proposals');
		}
		else if($page_type == "project-offers")
		{
			get_template_part('template-parts/dashboard/layouts-2/offers/project-offers');
		}
		else if($page_type == "accepted-offers")
		{
			get_template_part('template-parts/dashboard/layouts-2/offers/accepted-offers');
		}
		else if($page_type == "rejected-offers")
		{
			get_template_part('template-parts/dashboard/layouts-2/offers/rejected-offers');
		}
		else if($page_type == "cancelled-offers")
		{
			get_template_part('template-parts/dashboard/layouts-2/offers/cancelled-offers');
		}
		else if($page_type == "my-ratings")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/my-ratings');
		}
		else if($page_type == "my-ratings-project")
		{
			get_template_part('template-parts/dashboard/layouts-2/project/my-ratings-project');
		}
		else if($page_type == "notifications")
		{
			get_template_part('template-parts/dashboard/notifications');
		}
		else if($page_type == "statements")
		{
			get_template_part('template-parts/dashboard/statements');
		}
		else if($page_type == "all-meetings")
		{
			get_template_part('template-parts/dashboard/layouts-2/meetings/all-meetings');
		}
		else
		{
			get_template_part( 'template-parts/dashboard/layouts-2/dashboard');	
		}
	}
	else 
	{
		get_template_part( 'template-parts/dashboard/layouts-2/dashboard');	
	}
}
else if(isset($active_profile)  && $active_profile == 3)
{
	if(isset($_GET['ext']) && $_GET['ext'] !="")
	{
		$page_type  = $_GET['ext'];
		if($page_type == "dashboard")
		{
			get_template_part('template-parts/dashboard/layouts-3/dashboard');
		}
		
		else if($page_type == "profile")
		{
			get_template_part('template-parts/dashboard/layouts-3/profile/profile');
		}
		else if($page_type == "services")
		{
			get_template_part('template-parts/dashboard/layouts-3/services/services');
		}
		else if($page_type == "service-offers")
		{
			get_template_part('template-parts/dashboard/layouts-3/services/service-offers');
		}
		else if($page_type == "offer-detail")
		{
			get_template_part('template-parts/dashboard/layouts-3/services/offer-detail');
		}
		else if($page_type == "service-detail")
		{
			get_template_part('template-parts/dashboard/layouts-3/services/service-detail');
		}
		else if($page_type == "consultations")
		{
			get_template_part('template-parts/dashboard/layouts-3/consultations/consultations');
		}
		else if($page_type == "consultations-detail")
		{
			get_template_part('template-parts/dashboard/layouts-3/consultations/consultations-detail');
		}
		
		else if($page_type == "sessions")
		{
			get_template_part('template-parts/dashboard/layouts-3/sessions/sessions');
		}
		
		else
		{
			get_template_part( 'template-parts/dashboard/layouts-3/dashboard');	
		}
	}
	else 
	{
		get_template_part( 'template-parts/dashboard/layouts-3/dashboard');	
	}
}
else if(isset($active_profile)  && $active_profile == 4)
{
	if(isset($_GET['ext']) && $_GET['ext'] !="")
	{
		$page_type  = $_GET['ext'];
		if($page_type == "dashboard")
		{
			get_template_part('template-parts/dashboard/layouts-4/dashboard');
		}
		
		else if($page_type == "profile")
		{
			get_template_part('template-parts/dashboard/layouts-4/profile/profile');
		}
		else if($page_type == "settings")
		{
			get_template_part('template-parts/dashboard/layouts-4/profile/settings');
		}
		else if($page_type == "services")
		{
			get_template_part('template-parts/dashboard/layouts-4/services/services');
		}
		else if($page_type == "service-detail")
		{
			get_template_part('template-parts/dashboard/layouts-4/services/service-detail');
		}
		else if($page_type == "consultations")
		{
			get_template_part('template-parts/dashboard/layouts-4/consultations/consultations');
		}
		else if($page_type == "consultations-detail")
		{
			get_template_part('template-parts/dashboard/layouts-4/consultations/consultations-detail');
		}
		
		else if($page_type == "sessions")
		{
			get_template_part('template-parts/dashboard/layouts-4/sessions/sessions');
		}
		
		else
		{
			get_template_part( 'template-parts/dashboard/layouts-4/dashboard');	
		}
	}
	else 
	{
		get_template_part( 'template-parts/dashboard/layouts-4/dashboard');	
	}
}


?>
