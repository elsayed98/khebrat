<?php
if(in_array( 'khebrat-framework/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  get_template_part( 'header' );
  global $khebrat_theme_options;
  global $post;
  $sid = get_the_ID();
  $post_author = $post->post_author;
  $fid = get_user_meta( $post_author, 'freelancer_id', true );
$alt_id = '';
  ?>
<section class="fr-service-bar">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-xl-12">
        <div class="fr-service-container">
          <ul>
            <li class="links"> <a href="#description" class="scroll"><?php echo esc_html__('Description','khebrat_theme'); ?></a> </li>
            <li class="links"> <a href="#seller" class="scroll"><?php echo esc_html__('Seller Detail','khebrat_theme'); ?></a> </li>
            <li class="links"> <a href="#reviews" class="scroll"><?php echo esc_html__('Reviews','khebrat_theme'); ?></a> </li>
            <li class="links"> <a href="#faqs" class="scroll"><?php echo esc_html__('FAQ,s','khebrat_theme'); ?></a> </li>
            <li class="links"> <a href="#related" class="scroll"><?php echo esc_html__('Related Services','khebrat_theme'); ?></a> </li>
            <li class="links">
              <div class="fr-m-products-2">
                <ul>
                  <li>
                    <?php
                    $saved_service = get_user_meta( get_current_user_id(), '_service_fav_id_' . $sid, true );
                    $active_saved = '';
                    $icon_saved = '<i class="far fa-heart"></i>';
                    if ( isset( $saved_service ) && $saved_service != '' ) {
                      $active_saved = 'active';
                      $icon_saved = '<i class="fas fa-heart"></i>';
                    }
                    ?>
                    <a href="javascript:void(0);" class="fr-m-assets save_service <?php echo esc_html($active_saved); ?>" data-post-id="<?php echo esc_attr($sid); ?>"><?php echo wp_return_echo($icon_saved);?></a> </li>
                  <li> <a href="javascript:void(0);" class="fr-m-assets" data-bs-toggle="modal" data-bs-target="#report-modal"><i class="fas fa-exclamation-triangle"></i></a> </li>
                  <?php
                  if ( $khebrat_theme_options[ 'service_social_share' ] ) {
                    ?>
                  <li class="social-share">
                    <div id="wrapper">
                      <input type="checkbox" class="checkbox" id="share" />
                      <label for="share" class="label fl-export"><i class="fas fa-share-alt"></i><span><?php echo esc_html__('Share','khebrat_theme'); ?></span></label>
                      <div class="social">
                        <ul>
                          <li class="fl-facebook"><a href="https://www.facebook.com/sharer.php?u=<?php  echo esc_url(get_permalink()); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                          <li class="fl-linkedin"><a href="https://www.linkedin.com/shareArticle?url=<?php  echo esc_url(get_permalink()); ?>&title=<?php echo get_permalink(); ?>"  target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                          <li class="fl-pinterest"><a href="https://pinterest.com/pin/create/button/?url=<?php  echo esc_url(get_permalink()); ?>&description=<?php echo urlencode(get_the_title()); ?>&media=&description="  target="_blank"><i class="fab fa-pinterest"></i></a></li>
                          <li class="fl-twitter"><a href="https://twitter.com/share?url=<?php  echo esc_url(get_permalink()); ?>&text=<?php echo urlencode (get_the_title()); ?>"  target="_blank"><i class="fab fa-twitter"></i></a></li>
                          <li class="fl-instagram"><a  class="instagram-share-button" href="https://www.instagram.com/?url=<?php  echo esc_url(get_permalink()); ?>2F&t="  target="_blank"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                      </div>
                    </div>
                  </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$padding_call_to_action = '';
if ( isset($khebrat_theme_options[ 'action_bar' ]) && $khebrat_theme_options[ 'action_bar' ] == 1 ) {
  $padding_call_to_action = 'padding-top-bottom-2';
}
?>
<section class="fr-services2-details bg-gray-color <?php echo esc_attr($padding_call_to_action); ?>">
  <div class="container">
    <div class="row">
      <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
        <?php
        if ( get_post_status( $sid ) == 'pending' ) {
          ?>
        <div class="alert alert-warning fade show" role="alert">
          <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
          <div class="alert-text"><?php echo esc_html__('Pending for admin Approval.','khebrat_theme'); ?></div>
          <div class="alert-close">
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"> <span aria-hidden="true"><i class="fas fa-times"></i></i></span> </button>
          </div>
        </div>
        <?php
        }
        ?>
        <div class="fr-m-contents">
          <div class="fr-m-main-title">
            <?php
            $featured_badge = '';
            $featured_service = get_post_meta( $sid, '_service_is_featured', true );
            if ( isset( $featured_service ) && $featured_service == 1 ) {
              ?>
            <span><?php echo esc_html__( 'Featured', 'khebrat_theme' ); ?></span>
            <?php
            }
            ?>
            <p>
              <?php
              echo get_term_names( 'service-categories', '_service_category', $sid, 'reverse', ',' );
              ?>
            </p>
            <h1><?php echo get_the_title(); ?></h1>
          </div>
          <div class="fr-m-products">
            <ul>
              <li>
                <p><i class="fa fa-star"></i><?php echo get_service_rating($sid); ?></p>
              </li>
              <li>
                <p><?php echo exertio_queued_services($sid); ?></p>
              </li>
            <?php if(intval(get_post_meta($sid, 'exertio_service_total_views', true) !="")) {?>
                <li><p><i class="far fa-eye"></i>
                    <?php
                    echo wp_sprintf(esc_html__('%s Views', 'khebrat_theme'), number_format(get_post_meta($sid, 'exertio_service_total_views', true)));
                    ?>
                    </p>
                </li>
            <?php } ?>
            </ul>
          </div>
        </div>
        <div class="extra-features">
          <ul>
				<?php
				if(fl_framework_get_options('services_delivery_time') == 3)
				{

				}
				else
				{
				?>
            <li> <img src="<?php echo get_template_directory_uri()?>/images/icons/delivery-truck.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>"> <span> <small> <?php echo esc_html__('Delivery Time','khebrat_theme'); ?></small>
              <?php
              $delivery_time = get_term( get_post_meta( $sid, '_delivery_time', true ) );
              if ( !empty( $delivery_time ) && !is_wp_error( $delivery_time ) ) {
                echo esc_html($delivery_time->name);
              }
              ?>
              </span> </li>
			  <?php
				}
			if(fl_framework_get_options('services_response_time') == 3)
			{

			}
			else
			{
			?>
            <li> <img src="<?php echo get_template_directory_uri()?>/images/icons/fast-time.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>"> <span> <small> <?php echo esc_html__('Response Time','khebrat_theme'); ?></small>
              <?php
              $response_time = get_term( get_post_meta( $sid, '_response_time', true ) );
              if ( !empty( $response_time ) && !is_wp_error( $response_time ) ) {
                echo esc_html($response_time->name);
              }
              ?>
              </span> </li>
			  <?php
			}
				if(fl_framework_get_options('services_english_level') == 3)
				{

				}
				else
				{
				?>
            <li> <img src="<?php echo get_template_directory_uri()?>/images/icons/global.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>"> <span> <small> <?php echo esc_html__('English Level','khebrat_theme'); ?></small>
              <?php
              $service_eng_level = get_term( get_post_meta( $sid, '_service_eng_level', true ) );
              if ( !empty( $service_eng_level ) && !is_wp_error( $service_eng_level ) ) {
                echo esc_html($service_eng_level->name);
              }
              ?>
              </span> </li>
				<?php
				}
				?>
          </ul>
        </div>
        <?php

        $ser_attactment_show = get_post_meta( $sid, '_service_attachment_show', true );
         $service_youtube_urls = get_post_meta( $sid, '_service_youtube_urls', true );
        if ( (isset( $ser_attactment_show ) && $ser_attactment_show == 'yes' ) || $service_youtube_urls != "" ) {
          $services_img_id = get_post_meta( $sid, '_service_attachment_ids', true );

          if ( (isset( $services_img_id ) && $services_img_id != '') || $service_youtube_urls != "" ) {
            ?>
        <div class="slider-box">
          <div class="flexslider fr-slick image-popup1">
            <ul class="slides">
              <?php
              $atatchment_arr = explode( ',', $services_img_id );
              foreach ( $atatchment_arr as $value ) {
                $full_link = wp_get_attachment_url( $value );
				$img_atts = wp_get_attachment_image_src($value, 'service_detail_img');
				if(isset($img_atts) && $img_atts != '')
				{
                ?>
              <li> <a data-fancybox="services" href="<?php echo esc_url($full_link); ?>"><img src="<?php echo esc_url($img_atts['0']); ?>" class="img-fluid" alt="<?php esc_attr(get_post_meta($value, '_wp_attachment_image_alt', TRUE)); ?>" /></a> </li>
              <?php
				}
              }
              if ( $khebrat_theme_options[ 'service-youtube-links' ] ) {
                $service_youtube_urls = get_post_meta( $sid, '_service_youtube_urls', true );
                if ( isset( $service_youtube_urls ) && $service_youtube_urls != '' ) {
                  $urls = json_decode( $service_youtube_urls );
                  foreach ( $urls as $url ) {
                    preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', esc_url( $url ), $match );
                    if ( isset( $match[ 1 ] ) && $match[ 1 ] != "" ) {
                      $video_id = $match[ 1 ];

                      echo '<li class="video-link"><iframe src="https://www.youtube.com/embed/' . esc_attr( $video_id ) . '"  allow="picture-in-picture" allowfullscreen></iframe></li>';
                    }
                  }
                }
              }
              ?>
            </ul>
          </div>
          <div class="flexslider carousel fr-slick-thumb">
            <ul class="slides">
              <?php
              $atatchment_arr = explode( ',', $services_img_id );
              foreach ( $atatchment_arr as $value )
			  {
				$full_link = wp_get_attachment_image_src( $value, 'thumbnail' );
				if(isset($full_link) && $full_link != '')
				{
					?>
					<li> <img src="<?php echo esc_url($full_link[0]); ?>" alt="<?php esc_attr(get_post_meta($value, '_wp_attachment_image_alt', TRUE)); ?>" /> </li>
					<?php
				}
              }
              if ( $khebrat_theme_options[ 'service-youtube-links' ] ) {
                $service_youtube_urls = get_post_meta( $sid, '_service_youtube_urls', true );
                if ( isset( $service_youtube_urls ) && $service_youtube_urls != '' ) {
                  $urls = json_decode( $service_youtube_urls );
                  foreach ( $urls as $url ) {
                    preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', esc_url( $url ), $match );
                    if ( isset( $match[ 1 ] ) && $match[ 1 ] != "" ) {
                      $video_id = $match[ 1 ];
                      //$iframe = 'iframe';
                      echo '<li><img src="' . get_template_directory_uri() . '/images/youtube.png" alt="'.esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)).'" /></li>';
                    }
                  }
                }
              }
              ?>
            </ul>
          </div>
        </div>
        <?php
        }
        }
        ?>
        <?php
        if ( $khebrat_theme_options[ 'service_ad_1' ] ) {
          ?>
        <div class="fl-advert-box">
          <?php
          echo wp_return_echo( $khebrat_theme_options[ 'service_ad_1' ] );
          ?>
        </div>
        <?php
        }
		if(class_exists('ACF'))
		{
			get_template_part( 'template-parts/detail-page/custom-field', '');	
		}
        $profile_clickable = $profile_name_clickable = $profile_clickable_close = '';
        $none = 'none';
        if (fl_framework_get_options("fl_allow_profile_clickable") == 1) {
            $profile_clickable .= '<a href="'.esc_url(get_permalink($fid)).'">';
            $profile_clickable_close = '</a>';
            $profile_name_clickable .= '<a href="'.esc_url(get_permalink($fid)).'">';
            $none = '';
        }
        ?>
		
        <div class="main-box-services" id="description">
          <div class="fr-product-des-box heading-contents vector-bg">
            <h3><?php echo esc_html__('Description ','khebrat_theme'); ?></h3>
            <?php echo wp_kses($post->post_content, exertio_allowed_html_tags()); ?> </div>
        </div>
        <div class="fr-seller-servives-2" id="seller">
          <div class="fr-seller-servives">
            <div class="heading-contents">
              <h3><?php echo esc_html__('About The Seller','khebrat_theme'); ?></h3>
            </div>
            <div class="fr-seller-servives-meta"> <?php  echo $profile_clickable; ?>
              <div class="fr-seller-profile"> <?php echo get_profile_img($fid, 'freelancer'); ?> </div>
              <?php echo $profile_clickable_close;?>
              <div class="fr-seller-details"> <?php  echo $profile_clickable; ?><span><?php echo exertio_get_username('freelancer', $fid, 'badge', 'left'); ?></span><?php echo $profile_clickable_close;?>
                <h3><?php echo esc_html(get_post_meta( $fid, '_freelancer_tagline' , true )); ?></h3>
                <div class="fr-seller-rating">
                  <?php
                  echo get_freelancer_rating( $fid, 'stars', 'service' );
                  ?>
                </div>
              </div>
              <div class="fr-seller-view <?php echo $none; ?>"> <a href="<?php  echo esc_url(get_permalink($fid)); ?>" class="btn btn-theme"><?php echo esc_html__('View Profile','khebrat_theme'); ?></a> </div>
            </div>
          </div>
          <div class="fr-seller-contents">
            <ul>
              <li>
                <p><?php echo esc_html__('Location:','khebrat_theme'); ?></p>
                <span>
                <?php
                echo get_term_names( 'freelancer-locations', '_freelancer_location', $fid, '', ',' );
                ?>
                </span> </li>
              <li>
                <p><?php echo esc_html__('Member since:','khebrat_theme'); ?></p>
                <span><?php echo date_i18n( get_option( 'date_format' ), strtotime( get_the_time('Y-m-d', $fid) ) ); ?></span> </li>
            </ul>
          </div>
        </div>
        <?php
        if ( $khebrat_theme_options[ 'service-faqs' ] ) {
          $service_faqs = '';
			$faqs = array();
          $service_faqs = get_post_meta( $sid, '_service_faqs', true );
          if ( !empty( $service_faqs ) ) {
            $faqs = json_decode( stripslashes($service_faqs ));
            ?>
        <div class="fr-frquntly-qa" id="faqs">
          <?php
          if ( $khebrat_theme_options[ 'sevices_faqs_title' ] ) {
            ?>
          <div class="heading-contents">
            <h3><?php echo esc_html($khebrat_theme_options['sevices_faqs_title']); ?></h3>
          </div>
			<?php
            }
			?>
          <div class="all-accordion">
            <?php
			  if ( !empty( $faqs ) )
			  {
				$i = 0;
				foreach ( $faqs as $faq )
				{
					$accordian_id = 'id="collapse-'.esc_attr($i).'"';
					?>
					<div class="accordion" id="accordionid-<?php echo esc_attr($i); ?>">
					<div class="card">
					<div class="card-header" id="headingFaq-<?php echo esc_attr($i); ?>">
					  <h4 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr($i); ?>" aria-expanded="true">
						<?php echo esc_html($faq->faq_title); ?>
						<span><i class="fa fa-angle-down" aria-hidden="true"></i></span> </button>
					  </h4>
					</div>
					<div <?php echo wp_return_echo($accordian_id); ?> class="collapse" aria-labelledby="headingFaq-<?php echo esc_attr($i); ?>" data-bs-parent="#accordionid-<?php echo esc_attr($i); ?>">
					  <div class="card-body"><?php echo esc_html($faq->faq_answer); ?></div>
					</div>
					</div>
					</div>
					<?php
					$i++;
				}
			  }
            ?>
          </div>
        </div>
        <?php
        }
        }
        ?>
        <?php
        if ( $khebrat_theme_options[ 'service_review' ] ) {
          $reviews = get_service_rating_detail( $sid );
          if ( $reviews != '' ) {
            ?>
        <div class="main-box" id="reviews">
          <div class="fr-recent-review-box">
            <div class="fr-recent-container">
              <?php
              if ( $khebrat_theme_options[ 'sevices_review_title' ] ) {
                ?>
              <div class="heading-contents">
                <h3><?php echo esc_html($khebrat_theme_options['sevices_review_title']); ?></h3>
              </div>
              <?php
              }
              foreach ( $reviews as $review ) {
                ?>
              <div class="show-reviews">
                <div class="fr-recent-content">
                  <div class="reviews-header">
                    <div class="fr-recent-review-profile"> <a href="<?php  echo esc_url(get_permalink($review->giver_id)); ?>"><?php echo get_profile_img($review->giver_id, "employer"); ?></a> </div>
                    <div class="fr-recent-location-details"> <a href="<?php  echo esc_url(get_permalink($review->giver_id)); ?>">
                      <h4><?php echo esc_html(get_post_meta( $review->giver_id, '_employer_dispaly_name' , true )); ?></h4>
                      </a>
                      <ul>
                        <li> <i class="fa fa-clock-o"></i><span><?php echo time_ago_function($review->timestamp); ?></span> </li>
                      </ul>
                    </div>
                    <div class="fr-recent-rating">
                      <p><?php echo esc_html(number_format($review->star_avg,1)); ?></p>
                      <span class="xm">out of 5</span> </div>
                  </div>
                  <p class="feedback"><?php echo esc_html($review->feedback); ?></p>
                  <div class="individual-stars">
                    <div class="individual-star-boxs">
                      <label> <?php echo esc_html($khebrat_theme_options['service_first_title']); ?></label>
                      <span>
                      <?php
                      $total_stars_1 = $review->star_1;
                      for ( $i = 0; $i < 5; $i++ ) {
                        if ( $i < $total_stars_1 ) {
                          ?>
                      <i class="fa fa-star colored"></i>
                      <?php
                      } else {
                        ?>
                      <i class="fa fa-star"></i>
                      <?php
                      }
                      }
                      ?>
                      </span> </div>
                    <div class="individual-star-boxs">
                      <label> <?php echo esc_html($khebrat_theme_options['service_second_title']); ?></label>
                      <span>
                      <?php
                      $total_stars_2 = $review->star_2;
                      for ( $i = 0; $i < 5; $i++ ) {
                        if ( $i < $total_stars_2 ) {
                          ?>
                      <i class="fa fa-star colored"></i>
                      <?php
                      } else {
                        ?>
                      <i class="fa fa-star"></i>
                      <?php
                      }
                      }
                      ?>
                      </span> </div>
                    <div class="individual-star-boxs">
                      <label> <?php echo esc_html($khebrat_theme_options['service_third_title']); ?></label>
                      <span>
                      <?php
                      $total_stars_3 = $review->star_3;
                      for ( $i = 0; $i < 5; $i++ ) {
                        if ( $i < $total_stars_3 ) {
                          ?>
                      <i class="fa fa-star colored"></i>
                      <?php
                      } else {
                        ?>
                      <i class="fa fa-star"></i>
                      <?php
                      }
                      }
                      ?>
                      </span> </div>
                  </div>
                </div>
              </div>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
        <?php
        }
        }
        if ( $khebrat_theme_options[ 'service_ad_2' ] ) {
          ?>
        <div class="fl-advert-box bottom">
          <?php
          echo wp_return_echo( $khebrat_theme_options[ 'service_ad_2' ] );
          ?>
        </div>
        <?php
        }
        ?>
      </div>
      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
        <div class="service-sidebar position-sticky">
			<?php
			if( fl_framework_get_options('whizzchat_service_detail_option') == true)
			{
				if(in_array('whizz-chat/whizz-chat.php', apply_filters('active_plugins', get_option('active_plugins'))))
				{
					$classes = '';
					if(is_user_logged_in())
					{
						$classes = 'class="chat_toggler" data-user_id="'.esc_attr($post_author).'" data-page_id="'.esc_attr($sid).'"';
					}
					else
					{
						$classes = 'class="not_loggedin_chat_toggler"';
					}
				?>
					<div class="whizzchat-button">
						<a href="javascript:void(0)" <?php echo wp_return_echo($classes); ?>>
							<span>
								<img src="<?php echo get_template_directory_uri()?>/images/chat-color-icon.svg" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
								<?php echo esc_html__('Chat with Seller','khebrat_theme'); ?>
							</span>
							<i class="fas fa-angle-right"></i>
						</a>
						</div>
				<?php
				}
			}



if( fl_framework_get_options('enable_sb_chat_on_service_detail') == true)
      {
          
          if(class_exists('SB_Chat')){
          $classes = 'btn btn-theme'; 
           $button_text  =  __('Chat with Seller' , 'khebrat_theme');
            echo '<div class="whizzchat-button">';
            echo do_shortcode('[sb_chat_shortcode_popup class="'.$classes.'" post_id="'.$sid.'" button_title = "'.$button_text.'" post_author_id="'.$post_author.'" ]') ;
            echo '</div>';
        }
      }


			?>
			<?php
			if ( isset($khebrat_theme_options[ 'sidebar_service_ad_1' ]) && $khebrat_theme_options[ 'sidebar_service_ad_1' ] != '' )
			{
				?>
				<div class="fl-advert-box">
				<?php
				echo wp_return_echo( $khebrat_theme_options[ 'sidebar_service_ad_1' ] );
				?>
				</div>
				<?php
			}
			?>
			<div class="project-price service">
				<div class="card-body">
				  <div class="row">
					<div class="col"> <span class="price-label"><?php echo esc_html__('Starting From','khebrat_theme'); ?></span>
					  <div class="price" data-service-price="<?php echo esc_attr(get_post_meta($sid, '_service_price', true)); ?>"><?php echo fl_price_separator(get_post_meta($sid, '_service_price', true), 'html'); ?></div>
					</div>
					<div class="feature"> <i class="far fa-money-bill-alt"></i> </div>
				  </div>
				</div>
			</div>
			<?php
			$admin_commission = 0;
			if ( isset($khebrat_theme_options[ 'service_charges_employer' ]) && $khebrat_theme_options[ 'service_charges_employer' ] > 0 )
			{
				$service_price = get_post_meta($sid, '_service_price', true);
				//$khebrat_theme_options[ 'service_charges_employer' ];
				if(isset($service_price) && $service_price != '')
				{
					$admin_commission_percent = fl_framework_get_options('service_charges_employer');
					$decimal_amount = $admin_commission_percent/100;
					$admin_commission = $decimal_amount*$service_price;
					//$freelancer_earning = $service_price - $admin_commission;
					//echo $admin_commission;
				}
				?>
				<div class="services-charges">
					<span><?php echo esc_html__('Service charges','khebrat_theme'); ?></span>
					<span> <?php echo esc_html(fl_price_separator($admin_commission)); ?></span>
				</div>
				<?php
			}
			?>
			
			<div class="fr-services2-box">
				<form id="purchased_addon_form">
				  <?php
				  $addon_saved_ids = json_decode( get_post_meta( $sid, '_services_addon', true ) );
				  if ( isset( $addon_saved_ids ) && $addon_saved_ids != "" )
				  {
					?>
					  <div class="fr-services2-h-style">
						<h3> <?php echo esc_html__('Addons Services','khebrat_theme'); ?></h3>
					  </div>
					  <?php
					  $args = array(
						'post__in' => $addon_saved_ids,
						'post_type' => 'addons',
						'meta_query' => array(
						  array(
							'key' => '_addon_status',
							'value' => 'active',
							'compare' => '=',
						  ),
						),
						'post_status' => 'publish'
					  );

					  $addons = get_posts( $args );
					  foreach ( $addons as $addon )
					  {
						$addon_id = $addon->ID;
						?>
						  <div class="fr-services-products">
							<div class="fr-services2-sm">
							  <div class="pretty p-default">
								<input type="checkbox" name="services_addon[]" value="<?php echo esc_attr( $addon_id ) ?>" class="fl_addon_checkbox" id="addon_checkbox_<?php echo esc_attr($addon_id); ?>" data-addon-price="<?php echo esc_attr( get_post_meta( $addon_id, '_addon_price', true ) ) ?>" data-service-id="<?php echo esc_attr($sid); ?>">
								<div class="state p-warning">
								  <label> </label>
								</div>
							  </div>
							</div>
							<div class="fr-services2-sm-1">
							  <div class="fr-services-list"> <?php echo esc_html(get_the_title($addon_id)); ?></div>
							  <span class="addon_price_<?php echo esc_attr($addon_id); ?>"> <?php echo fl_price_separator(get_post_meta( $addon_id, '_addon_price', true ),'html'); ?></span>
							  <p><?php echo ($addon->post_content); ?></p>
							</div>
							  </div>
						  <?php
					  }
					  if ( isset( $khebrat_theme_options[ 'below_addon_desc' ] ) )
					  {
						?>
						  <div class="fr-services-content-data"><?php echo esc_html($khebrat_theme_options['below_addon_desc']); ?></div>
						  <?php
					  }
				  }
					$final_service_price = 0;
					$service_price = get_post_meta($sid, '_service_price', true);
					if(isset($service_price) && $service_price != '')
					{
						$final_service_price = $service_price + $admin_commission; 
				  ?>


                        <?php if (fl_framework_get_options('exertio_service_deposit') != '' && fl_framework_get_options('exertio_service_deposit') == 1 )
                        {
                        ?>
                            <button class="btn btn-theme buy_service" type="button" id="buy_service_woo" data-sid="<?php echo esc_attr($sid) ?>" > <?php echo esc_html__('Purchase Now','khebrat_theme'); ?><small> (<span><?php echo fl_price_separator($final_service_price, 'html'); ?></span>)</small></button>
                            <?php
                        }
                        if (fl_framework_get_options('exertio_wallet_system') != '' && fl_framework_get_options('exertio_wallet_system') == 0 && fl_framework_get_options('exertio_service_deposit') == 0) {?>
                            <button class="btn btn-theme" type="button" id="buy_service" data-sid="<?php echo esc_attr($sid) ?>" > <?php echo esc_html__('Purchase Now','khebrat_theme'); ?><small> (<span><?php echo fl_price_separator($final_service_price, 'html'); ?></span>)</small></button>
                        <?php }
					}
                    ?>
				</form>
			  </div>
			<?php
			if ( isset($khebrat_theme_options[ 'sidebar_service_ad_2' ]) && $khebrat_theme_options[ 'sidebar_service_ad_2' ] != ''  )
			{
				?>
				<div class="fl-advert-box">
				<?php
				echo wp_return_echo( $khebrat_theme_options[ 'sidebar_service_ad_2' ] );
				?>
				</div>
				<?php
			}
			?>
			<p class="ref-id">
				<?php 
					$service_ref_id = get_post_meta($sid, '_service_ref_id', true);
					if(isset($service_ref_id) && $service_ref_id != '')
					{
						$service_ref_id = $service_ref_id;
					}
					else
					{
						$service_ref_id = $sid;
					}
					echo esc_html__('Ref #: ','khebrat_theme').$service_ref_id; 
				?>
			</p>
        </div>
	</div>
      <?php get_template_part( 'template-parts/detail-page/services/related-services', '' ); ?>
    </div>
  </div>
</section>
<?php
} else {
  wp_redirect( home_url() );
}
if(isset($khebrat_theme_options['footer_type'])) { $footer_type  = $khebrat_theme_options['footer_type']; } else { $footer_type  = 0; }
if($footer_type  ==  1) {
    if($footer_type  ==  1 && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins'))))
    {
        elementor_theme_do_location('footer');
        get_footer();
    }else{
        get_footer();
    }
}else {
    get_template_part('footer');
}
?>
