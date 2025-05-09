<?php
function khebrat_store_notifications_callback( $arg_array = array() ) {
	global $khebrat_theme_options;
	if(isset($khebrat_theme_options['exertio_notifications']) && $khebrat_theme_options['exertio_notifications'] == true)
	{
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		$current_time = current_time('mysql');
		$data = array(
				'timestamp' => $current_time,
				'updated_on' => $current_time,
				'post_id' => $arg_array['post_id'],
				'n_type' => $arg_array['n_type'],
				'sender_id' => $arg_array['sender_id'],
				'receiver_id' => $arg_array['receiver_id'],
				'sender_type' => $arg_array['sender_type'],
				'status' => 1,
				);
		$wpdb->insert($table,$data);
	}
}
add_action( 'khebrat_notification_filter', 'khebrat_store_notifications_callback', 10 );




if (! function_exists('khebrat_get_notifications')) {
    function khebrat_get_notifications($uid)
    {
        global $wpdb;
        $table = EXERTIO_NOTIFICATIONS_TBL;
        global $khebrat_theme_options;
        $dashboard_page = get_the_permalink($khebrat_theme_options['user_dashboard_page']);

        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
            $query = "SELECT * FROM " . $table . " WHERE `receiver_id` = '" . esc_sql($uid) . "' ORDER BY `timestamp` DESC LIMIT 10";
            $result = $wpdb->get_results($query);
            if ($result) {
                $result_html = '<ul class="list-group list-group-flush list-unstyled p-2 list-notifications-ls">';
                foreach ($result as $results) {
                    $status_class = ($results->status == 1) ? 'notif-unread' : '';
                    $n_sender_name = '';

                    if ($results->sender_type == 'customer') {
                        $customer_id = get_user_meta($results->sender_id, 'customer_id', true);
                        $n_sender_name = exertio_get_username('customer', $customer_id);
                    } elseif ($results->sender_type == 'lawyer') {
                        $lawyer_id = get_user_meta($results->sender_id, 'lawyer_id', true);
                        $n_sender_name = exertio_get_username('lawyer', $lawyer_id);
                    }

                    $redirect_url = '';
                    $title = '';
                    $message = '';

                    if ($results->n_type == 'proposal') {
                        $redirect_url = $dashboard_page . '?ext=project-propsals&project-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' أرسل عرضًا على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'send_offer') {
                        $redirect_url = $dashboard_page . '?ext=service-offers&sfid=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' أرسل عرضًا على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

                    elseif ($results->n_type == 'start_consul') {
                        $redirect_url = $dashboard_page . '?ext=consultations-detail&cid=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' تم بدا الاستشارة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'completed_consul') {
                        $redirect_url = $dashboard_page . '?ext=consultations-detail&cid=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' تم انهاء الاستشارة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'completed_service') {
                        $redirect_url = $dashboard_page . '?ext=service-detail&lsid=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' تم تعليم الطلب كمكتمل ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

					elseif ($results->n_type == 'accept_offer') {
						$redirect_url = $dashboard_page . '?ext=services';
                        //$redirect_url = $dashboard_page . '?ext=service-offers&sfid=' . $results->post_id;
                        $title = $n_sender_name. '  قبل عرضك  ';
                        $message = __(' تم قبول عرضًك على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

					elseif ($results->n_type == 'project_expired') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت مدته.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'project_featured_expired') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت من القائمة المميزة.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'project_assigned') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = __('مبروك! حصلت على مشروع جديد ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_completed') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = __('تم إكمال مشروعك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_rating') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('التقييمات', 'khebrat_theme');
                        $message = __('حصلت على تقييم جديد على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_canceled') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = __('تم إلغاء مشروعك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_msg') {
                        $redirect_url = $dashboard_page . '?ext=ongoing-project-detail&project-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' أرسل رسالة على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_dispute' || $results->n_type == 'service_dispute') {
                        $redirect_url = $dashboard_page . '?ext=dispute-detail&dispute-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' قام بفتح نزاع ضد المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'dispute_msg') {
                        $redirect_url = $dashboard_page . '?ext=dispute-detail&dispute-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' أرسل رسالة في النزاع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

                    elseif ($results->n_type == 'service_purchased') {
                        $redirect_url = $dashboard_page . '?ext=ongoing-services';
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = __('لديك طلب جديد على الخدمة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'product_purchased') {
                        $redirect_url = $dashboard_page . '?ext=all-orders';
                        $title = __('المتجر', 'khebrat_theme');
                        $message = __('طلب جديد على منتجك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'service_completed') {
                        $redirect_url = $dashboard_page . '?ext=completed-services';
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' أكمل الطلب لخدمة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'service_canceled') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' ألغى طلبًا على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'payout_processed') {
                        $redirect_url = $dashboard_page . '?ext=payouts';
                        $title = __('المدفوعات', 'khebrat_theme');
                        $price = fl_price_separator(get_post_meta($results->post_id, '_payout_amount', true));
                        $message = __('تمت معالجة دفعتك ', 'khebrat_theme') . $price;
                    }
                    elseif ($results->n_type == 'identity_verified') {
                        $redirect_url = 'javascript:void(0)';
                        $title = __('التحقق', 'khebrat_theme');
                        $message = __('حصلت على شارة التحقق في ملفك الشخصي', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'service_expired') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت مدتها.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'service_featured_expired') {
                        $redirect_url = 'javascript:void(0)';
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت من القائمة المميزة.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'service_msg') {
                        $table2 = EXERTIO_PURCHASED_SERVICES_TBL;
                        $query = "SELECT `service_id` FROM " . $table2 . " WHERE `id` = '" . esc_sql($results->post_id) . "' AND `status` ='ongoing'";
                        $id_resuld = $wpdb->get_results($query, ARRAY_A);

                        $service = get_post($results->post_id);
                        if (get_post_type($results->post_id) == 'custom_orders') {
                            $remove_words = array(' – ', 'طلب', 'جديد');
                            $redirect_url = $dashboard_page . '?ext=order-detail&order_id=' . $results->post_id;
                            $servise_title = isset($results->post_id) ? str_replace($remove_words, ' ', get_the_title($results->post_id)) : "";
                        } else {
                            $redirect_url = $dashboard_page . '?ext=ongoing-service-detail&sid=' . $results->post_id;
                            $servise_title = isset($id_resuld[0]['service_id']) ? get_the_title(($id_resuld[0]['service_id'])) : "";
                        }

                        $title = $n_sender_name;
                        $message = __(' أرسل رسالة على ', 'khebrat_theme') . '<span>' . $servise_title . '</span>';
                    }
                    elseif ($results->n_type == 'dispute_action') {
                        $redirect_url = $dashboard_page . '?ext=dispute-detail&dispute-id=' . $results->post_id;
                        $title = __('النزاعات', 'khebrat_theme');
                        $message = __('تم حل النزاع على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                   

                    elseif ($results->n_type == 'offer_received') {
                        $redirect_url = $dashboard_page . '?ext=project-offers';
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تلقيت عرضًا جديدًا على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'offer_accepted') {
                        $redirect_url = $dashboard_page . '?ext=accepted-offers';
                        $title = __('العروض', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' قبل عرضك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'offer_rejected') {
                        $redirect_url = $dashboard_page . '?ext=accepted-offers';
                        $title = __('العروض', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' رفض عرضك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'received_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' أرسل لك دعوة للمشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'reject_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' رفض دعوتك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'accept_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' قبل دعوتك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'cancel_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' ألغى الدعوة على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

                    elseif ($results->n_type == 'new_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' أرسل لك دعوة للمشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'new_inquiry') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الاستفسارات', 'khebrat_theme');
                        $message = __('تم إنشاء استفسار جديد على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'inquiry_updated') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الاستفسارات', 'khebrat_theme');
                        $message = __('تم الرد على استفسارك حول ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'new_offers') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تم إرسال عرض جديد على فرصتك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'offer_approved') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تمت ترسية عرضك في الفرصة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    elseif ($results->n_type == 'offer_rejected_sl') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تم رفض عرضك في الفرصة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    elseif ($results->n_type == 'message_sender' || $results->n_type == 'message_recipient') {
                        $redirect_url = '/dashboard/?ext=message';
                        $title = __('الرسائل', 'khebrat_theme');
                        $message = __('لديك رسالة جديدة حول ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'new_company_quote') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض الموحدة', 'khebrat_theme');
                        $message = __('تم إرسال عرض جديد على الفرصة الموحدة للشركات ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    elseif ($results->n_type == 'new_association_reply') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('طلبات الجمعيات', 'khebrat_theme');
                        $message = __('تم إرسال طلب جمعية جديد على الفرصة الموحدة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    
                    
                    $result_html .= '<li>';
                    $result_html .= '<a href="' . esc_url($redirect_url) . '" class="list-group-item list-group-item-action rounded  ' . esc_attr($status_class) . ' border-0 mb-1 p-3">';
                    $result_html .= '<h6 class="mb-2">' . $title . '</h6>';
                    $result_html .= '<p class="mb-0 small">' . $message . '</p>';
                    $result_html .= '<span>' . time_ago_function($results->timestamp) . '</span>';
                    $result_html .= '</a>';
                    $result_html .= '</li>';
                }
                $result_html .= '</ul>';
                return $result_html;
            } else {
                return '<p class="no-notification">' . __('لا توجد إشعارات جديدة', 'khebrat_theme') . '</p>';
            }
        }
    }
}



add_action('wp_ajax_exertio_notification_ajax', 'exertio_notification_ajax');
if ( ! function_exists( 'exertio_notification_ajax' ) )
{ 
	function exertio_notification_ajax($only_count = '')
	{
		$uid = get_current_user_id();
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$count = 0;
			$query = "SELECT `id` FROM ".$table." WHERE `receiver_id` = '" . $uid . "' AND `status` ='1' ORDER BY  `timestamp` DESC";
			$result = $wpdb->get_results($query);
			if($result)
			{
				$count = count($result);
			}
		}
		if($only_count == 'count')
		{
			return $count;
		}
		else
		{
			$list = exertio_get_notifications($uid);

			$return = array('count'=>$count, 'n_list'=> $list);
			wp_send_json_success($return);
		}
		
	}
}

add_action('wp_ajax_exertio_read_notifications', 'exertio_read_notifications');
if ( ! function_exists( 'exertio_read_notifications' ) )
{ 
	function exertio_read_notifications($only_count = '')
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$uid = get_current_user_id();
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$current_time = current_time('mysql');
			$data = array(
						'updated_on' =>$current_time,
						'status' => 0,
						);
			$where = array(
						'receiver_id' => $uid,
						);

			$update_id = $wpdb->update( $table, $data, $where );
			if ( is_wp_error( $update_id ) )
			{
				$return = array('message' => esc_html__( 'Notification read issue', 'khebrat_theme' ));
				wp_send_json_error($return);
			}
			else
			{
				$return = array('message' => esc_html__( 'Notifications marked as read', 'khebrat_theme' ));
				wp_send_json_success($return);
			}
		}
	}
}






if ( ! function_exists( 'exertio_view_all_notifications' ) )
{ 
	function exertio_view_all_notifications($start_from = 0, $limit = 10)
	{
		$uid = get_current_user_id();
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$count = 0;
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $uid . "' ORDER BY  `timestamp` DESC LIMIT ".$start_from.",".$limit."";
			$result = $wpdb->get_results($query);
			if($result)
			{
				$count = count($result);
				//$result_html = '<ul class="notifications">';
				$result_html ='';
				
				foreach($result as $results)
				{
					$status_class = '';
					if($results->sender_type == 'employer')
					{
						$employer_id = get_user_meta( $results->sender_id, 'employer_id' , true );
						$n_sender_name = exertio_get_username('employer', $employer_id);
					}
					else if($results->sender_type == 'freelancer')
					{
						$freelancer_id = get_user_meta( $results->sender_id, 'freelancer_id' , true );
						$n_sender_name = exertio_get_username('freelancer', $freelancer_id);
					}
					if($results->status == 1)
					{
						$status_class = 'active';
					}
					
					$n_type = $results->n_type;
					//$result_html .= '<li>';
					$result_html .= '<div class="pro-box notification_page '.esc_attr($status_class).'">';
					if($n_type == 'proposal')
					{

						  $redirect_url  = $dashboard_page.'?ext=project-propsals&project-id='.$results->post_id;
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.esc_url($redirect_url).'" class=""> <span>'.$n_sender_name.'</span> '.__( ' sent a proposal on your job ', 'khebrat_theme' ).'<span> '.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired.', 'khebrat_theme' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_featured_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired from featured list.', 'khebrat_theme' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_assigned')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class="">'.__( 'Congratulations! you got a new project ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_completed')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class="">'.__( 'Your project ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span> '.__( ' has been completed', 'khebrat_theme' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_rating')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class="">'.__( 'Your got a new rating on ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_canceled')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class="">'.__( 'Your project ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span> '.__( ' has been canceled', 'khebrat_theme' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_msg')
					{
						$redirect_url  = $dashboard_page.'?ext=ongoing-project-detail&project-id='.$results->post_id;
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.esc_url($redirect_url ).'" class=""><span>'.$n_sender_name.'</span>'.__( ' sent a message on ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_dispute')
					{
						 $redirect_url  = $dashboard_page.'?ext=dispute-detail&dispute-id='.$results->post_id;

						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.esc_url( $redirect_url ).'" class=""><span>'.$n_sender_name.'</span>'.__( ' created a dispute against the job ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'dispute_msg')
					{

						$redirect_url  = $dashboard_page.'?ext=dispute-detail&dispute-id='.$results->post_id;

						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.esc_url($redirect_url).'" class=""><span>'.$n_sender_name.'</span>'.__( ' sent a message on a dispute ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_purchased')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class=""><span></span>'.__( 'You got a new order on ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_completed')
					{
						$redirect_url  = $dashboard_page.'?ext=completed-services';
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.esc_url($redirect_url).'" class=""><span>'.$n_sender_name.'</span>'.__( ' marked order completed for ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_canceled')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class=""><span>'.$n_sender_name.'</span>'.__( ' canceled an order on ', 'khebrat_theme' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'payout_processed')
					{

						  $redirect_url  = $dashboard_page.'?ext=payouts';
						$price = fl_price_separator(get_post_meta($results->post_id,'_payout_amount',true));
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.$redirect_url.'" class=""><span></span>'.__( ' Your payout ', 'khebrat_theme' ).$price.'<span></span>'.__( ' has been processed. ', 'khebrat_theme' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'identity_verified')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span></span>'.__( ' You got a verified badge on your profile', 'khebrat_theme' ).'<span></span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.get_the_permalink($results->post_id).'" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired.', 'khebrat_theme' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_featured_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired from featured list.', 'khebrat_theme' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_msg')
					{
						$table2 = EXERTIO_PURCHASED_SERVICES_TBL;
						$query = "SELECT `service_id` FROM ".$table2." WHERE `id` = '" .$results->post_id. "' AND `status` ='ongoing'";
						$id_resuld = $wpdb->get_results($query, ARRAY_A );

						  $servise_title  =  isset($id_resuld[0]['service_id']) ?  get_the_title(($id_resuld[0]['service_id']))   : "";   

						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span>'.$n_sender_name.'</span>'.__( ' sent a message on ', 'khebrat_theme' ).'<span>'.$servise_title.'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'dispute_action')
					{
						$redirect_url  = $dashboard_page.'?ext=dispute-detail&dispute-id='.$results->post_id;
						$result_html .= '<div class="pro-coulmn pro-title"><a href="'.esc_url($redirect_url).'" class="">'.__( 'Your dispute ', 'khebrat_theme' ).' <span>'.get_the_title($results->post_id).'</span> '.__( ' has been resolved.', 'khebrat_theme' ).'</div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></a></div>';
					}
					
					//$result_html .= '</li>';
					$result_html .= '</div>';
				}
				
				return $result_html;
			}
		}

	}
}


if ( ! function_exists( 'notification_pagination' ) )
{
    function notification_pagination( $paged = '', $max_posts = '5')
    {
		$uid = get_current_user_id();
        if(isset($paged))
		{
            $pageno = $paged;
        } 
		else 
		{
            $pageno = 1;
        }
        $no_of_records_per_page = $max_posts;
        $offset = ($pageno-1) * $no_of_records_per_page;
		
		global $wpdb;

		$table =  EXERTIO_NOTIFICATIONS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $uid . "' ORDER BY  `timestamp` DESC ";
			$result = $wpdb->get_results($query);
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=notifications&pageno=1'> ".__( 'First', 'khebrat_theme' )."</a></li>";
		}
		for ($i=1; $i<=$total_pages; $i++)
		{
			if($total_pages> 1)
			{
				if($i==$pageno)
				{  
					$pagLink .= "<li class='active'><a href='javascript:void(0)'>".$i."</a></li>"; 
				}
				else if($i > $pageno+2 || $i < $pageno-2)
				{
					$pagLink .= "";
				}
				else
				{
					$pagLink .= "<li><a href='?ext=notifications&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?ext=notifications&pageno=".$total_pages."'> ".__( 'Last', 'khebrat_theme' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;
    }
}











if (! function_exists('exertio_get_notifications_ls')) {
    function exertio_get_notifications_ls($uid)
    {
        global $wpdb;
        $table = EXERTIO_NOTIFICATIONS_TBL;
        global $khebrat_theme_options;
        $dashboard_page = get_the_permalink($khebrat_theme_options['user_dashboard_page']);

        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
            $query = "SELECT * FROM " . $table . " WHERE `receiver_id` = '" . esc_sql($uid) . "' ORDER BY `timestamp` DESC LIMIT 10";
            $result = $wpdb->get_results($query);
            if ($result) {
                $result_html = '<ul class="list-group list-group-flush list-unstyled p-2 list-notifications-ls">';
                foreach ($result as $results) {
                    $status_class = ($results->status == 1) ? 'notif-unread' : '';
                    $n_sender_name = '';

                    if ($results->sender_type == 'employer') {
                        $employer_id = get_user_meta($results->sender_id, 'employer_id', true);
                        $n_sender_name = exertio_get_username('employer', $employer_id);
                    } elseif ($results->sender_type == 'freelancer') {
                        $freelancer_id = get_user_meta($results->sender_id, 'freelancer_id', true);
                        $n_sender_name = exertio_get_username('freelancer', $freelancer_id);
                    }

                    $redirect_url = '';
                    $title = '';
                    $message = '';

                    if ($results->n_type == 'proposal') {
                        $redirect_url = $dashboard_page . '?ext=project-propsals&project-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' أرسل عرضًا على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_expired') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت مدته.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'project_featured_expired') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت من القائمة المميزة.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'project_assigned') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = __('مبروك! حصلت على مشروع جديد ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_completed') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = __('تم إكمال مشروعك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_rating') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('التقييمات', 'khebrat_theme');
                        $message = __('حصلت على تقييم جديد على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_canceled') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('المشاريع', 'khebrat_theme');
                        $message = __('تم إلغاء مشروعك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_msg') {
                        $redirect_url = $dashboard_page . '?ext=ongoing-project-detail&project-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' أرسل رسالة على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'project_dispute' || $results->n_type == 'service_dispute') {
                        $redirect_url = $dashboard_page . '?ext=dispute-detail&dispute-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' قام بفتح نزاع ضد المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'dispute_msg') {
                        $redirect_url = $dashboard_page . '?ext=dispute-detail&dispute-id=' . $results->post_id;
                        $title = $n_sender_name;
                        $message = __(' أرسل رسالة في النزاع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

                    elseif ($results->n_type == 'service_purchased') {
                        $redirect_url = $dashboard_page . '?ext=ongoing-services';
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = __('لديك طلب جديد على الخدمة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'product_purchased') {
                        $redirect_url = $dashboard_page . '?ext=all-orders';
                        $title = __('المتجر', 'khebrat_theme');
                        $message = __('طلب جديد على منتجك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'service_completed') {
                        $redirect_url = $dashboard_page . '?ext=completed-services';
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' أكمل الطلب لخدمة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'service_canceled') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' ألغى طلبًا على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'payout_processed') {
                        $redirect_url = $dashboard_page . '?ext=payouts';
                        $title = __('المدفوعات', 'khebrat_theme');
                        $price = fl_price_separator(get_post_meta($results->post_id, '_payout_amount', true));
                        $message = __('تمت معالجة دفعتك ', 'khebrat_theme') . $price;
                    }
                    elseif ($results->n_type == 'identity_verified') {
                        $redirect_url = 'javascript:void(0)';
                        $title = __('التحقق', 'khebrat_theme');
                        $message = __('حصلت على شارة التحقق في ملفك الشخصي', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'service_expired') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت مدتها.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'service_featured_expired') {
                        $redirect_url = 'javascript:void(0)';
                        $title = __('الخدمات', 'khebrat_theme');
                        $message = '<span>' . get_the_title($results->post_id) . '</span> ' . __(' انتهت من القائمة المميزة.', 'khebrat_theme');
                    }
                    elseif ($results->n_type == 'service_msg') {
                        $table2 = EXERTIO_PURCHASED_SERVICES_TBL;
                        $query = "SELECT `service_id` FROM " . $table2 . " WHERE `id` = '" . esc_sql($results->post_id) . "' AND `status` ='ongoing'";
                        $id_resuld = $wpdb->get_results($query, ARRAY_A);

                        $service = get_post($results->post_id);
                        if (get_post_type($results->post_id) == 'custom_orders') {
                            $remove_words = array(' – ', 'طلب', 'جديد');
                            $redirect_url = $dashboard_page . '?ext=order-detail&order_id=' . $results->post_id;
                            $servise_title = isset($results->post_id) ? str_replace($remove_words, ' ', get_the_title($results->post_id)) : "";
                        } else {
                            $redirect_url = $dashboard_page . '?ext=ongoing-service-detail&sid=' . $results->post_id;
                            $servise_title = isset($id_resuld[0]['service_id']) ? get_the_title(($id_resuld[0]['service_id'])) : "";
                        }

                        $title = $n_sender_name;
                        $message = __(' أرسل رسالة على ', 'khebrat_theme') . '<span>' . $servise_title . '</span>';
                    }
                    elseif ($results->n_type == 'dispute_action') {
                        $redirect_url = $dashboard_page . '?ext=dispute-detail&dispute-id=' . $results->post_id;
                        $title = __('النزاعات', 'khebrat_theme');
                        $message = __('تم حل النزاع على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'zoom_meeting') {
                        $redirect_url = 'javascript:void(0)';
                        $title = __('الاجتماعات', 'khebrat_theme');
                        $message = __('لديك اجتماع Zoom بخصوص ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

                    elseif ($results->n_type == 'offer_received') {
                        $redirect_url = $dashboard_page . '?ext=project-offers';
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تلقيت عرضًا جديدًا على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'offer_accepted') {
                        $redirect_url = $dashboard_page . '?ext=accepted-offers';
                        $title = __('العروض', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' قبل عرضك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'offer_rejected') {
                        $redirect_url = $dashboard_page . '?ext=accepted-offers';
                        $title = __('العروض', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' رفض عرضك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'received_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' أرسل لك دعوة للمشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'reject_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' رفض دعوتك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'accept_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' قبل دعوتك على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'cancel_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' ألغى الدعوة على المشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }

                    elseif ($results->n_type == 'new_invitation') {
                        $redirect_url = $dashboard_page . '?ext=invitations';
                        $title = __('الدعوات', 'khebrat_theme');
                        $message = '<span>' . $n_sender_name . '</span> ' . __(' أرسل لك دعوة للمشروع ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'new_inquiry') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الاستفسارات', 'khebrat_theme');
                        $message = __('تم إنشاء استفسار جديد على ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'inquiry_updated') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('الاستفسارات', 'khebrat_theme');
                        $message = __('تم الرد على استفسارك حول ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'new_offers') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تم إرسال عرض جديد على فرصتك ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'offer_approved') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تمت ترسية عرضك في الفرصة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    elseif ($results->n_type == 'offer_rejected_sl') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض', 'khebrat_theme');
                        $message = __('تم رفض عرضك في الفرصة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    elseif ($results->n_type == 'message_sender' || $results->n_type == 'message_recipient') {
                        $redirect_url = '/dashboard/?ext=message';
                        $title = __('الرسائل', 'khebrat_theme');
                        $message = __('لديك رسالة جديدة حول ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span>';
                    }
                    elseif ($results->n_type == 'new_company_quote') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('العروض الموحدة', 'khebrat_theme');
                        $message = __('تم إرسال عرض جديد على الفرصة الموحدة للشركات ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    elseif ($results->n_type == 'new_association_reply') {
                        $redirect_url = get_the_permalink($results->post_id);
                        $title = __('طلبات الجمعيات', 'khebrat_theme');
                        $message = __('تم إرسال طلب جمعية جديد على الفرصة الموحدة ', 'khebrat_theme') . '<span>' . get_the_title($results->post_id) . '</span> (' . $results->post_id . ')';
                    }
                    
                    
                    $result_html .= '<li>';
                    $result_html .= '<a href="' . esc_url($redirect_url) . '" class="list-group-item list-group-item-action rounded  ' . esc_attr($status_class) . ' border-0 mb-1 p-3">';
                    $result_html .= '<h6 class="mb-2">' . $title . '</h6>';
                    $result_html .= '<p class="mb-0 small">' . $message . '</p>';
                    $result_html .= '<span>' . time_ago_function($results->timestamp) . '</span>';
                    $result_html .= '</a>';
                    $result_html .= '</li>';
                }
                $result_html .= '</ul>';
                return $result_html;
            } else {
                return '<p class="no-notification">' . __('لا توجد إشعارات جديدة', 'khebrat_theme') . '</p>';
            }
        }
    }
}
