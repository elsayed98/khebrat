<?php
$sort = '';
if (isset($_GET['sort']) && $_GET['sort'] != "")
{
	$sort = $_GET['sort'];
}
$actionbBar = fl_framework_get_options('action_bar');
$actionbar_space = '';
if(isset($actionbBar) && $actionbBar == 1)
{
	$actionbar_space = 'actionbar_space';
}
global $khebrat_theme_options;
/* Is job alerts */
$job_alerts = ( isset($khebrat_theme_options['job_alerts_switch']) && $khebrat_theme_options['job_alerts_switch'] != "" ) ? $khebrat_theme_options['job_alerts_switch'] : false;
/* Job alert title */
$job_alerts_title = ( isset($khebrat_theme_options['job_alerts_title']) && $khebrat_theme_options['job_alerts_title'] != "" ) ? $khebrat_theme_options['job_alerts_title'] : '';
/* Job alert tagline */
$job_alerts_tagline = ( isset($khebrat_theme_options['job_alerts_tagline']) && $khebrat_theme_options['job_alerts_tagline'] != "" ) ? $khebrat_theme_options['job_alerts_tagline'] : '';
/* Job alert btn */
$job_alerts_btn = ( isset($khebrat_theme_options['job_alerts_btn']) && $khebrat_theme_options['job_alerts_btn'] != "" ) ? $khebrat_theme_options['job_alerts_btn'] : '';
?>
<section class="fr-list-side-bar section-padding bg-gray-light-color  <?php echo esc_attr($actionbar_space); ?>">
  <div class="container">
    <div class="row">
    	<?php
		if(fl_framework_get_options('project_sidebar') == 'left')
		{
			?>
			<div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 col-xl-4">
            	<div class="project-sidebar">
                	<div class="heading">
                        <h4><?php echo esc_html__('Search Filters','khebrat_theme'); ?></h4>
                        <?php
                            $project_page = '';
                            $project_page = fl_framework_get_options('project_search_page');
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($project_page)); ?>"><?php echo esc_html__('Clear Result','khebrat_theme'); ?></a>
                    </div>
                    <div class="project-widgets">
                        <form action="<?php echo get_the_permalink(fl_framework_get_options('project_search_page')); ?>">
                            <?php dynamic_sidebar( 'exertio-project-widgets' ); ?>
                            <div class="submit-btn">
                                <?php
                                    $sidebar_text = fl_framework_get_options('project_search_sidebar_text');
                                    if(isset($sidebar_text) && $sidebar_text != '')
                                    {
                                        ?> 
                                        <p><i><?php echo esc_html($sidebar_text); ?> </i></p>
                                        <?php
                                    }
                                ?>
                                <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>">
                                <button class="btn btn-theme btn-block" type="submit"> <?php echo esc_html__('Filter Result','khebrat_theme'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
			<?php
        }
        ?>
      <div class="col-xl-8 col-xs-12 col-sm-12 col-md-12 col-lg-8">
      	<div class="row">
        	<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                <div class="services-filter-2">
                	<form>
							<div class="heading-area">
								<h4><?php echo esc_html__('Found ','khebrat_theme'). $results->found_posts. esc_html__(' Results ','khebrat_theme'); ?> </h4>
							</div>
						<div class="filters">
							<select class="default-select" name="sort" id="order_by">
								<option value=""><?php echo __( 'Sort by', 'khebrat_theme' ); ?></option>
								<option value="new-old" <?php if($sort == 'new-old'){ echo "selected"; } ?>> <?php echo __( 'Date: New to old', 'khebrat_theme' ); ?></option>
								<option value="old-new" <?php if($sort == 'old-new'){ echo "selected"; } ?>> <?php echo __( 'Date: Old to new', 'khebrat_theme' ); ?></option>
							</select>
							<?php
							if(isset($_GET) && $_GET != '')
							{
								$all_filters = $_GET;
								foreach($all_filters as $key => $value)
								{
									if($key == 'sort' || $key == 'list-style')
									{

									}
									else
									{
										if(is_array($value))
										{
											foreach($value as $key2 => $value2)
											{
												echo '<input type="hidden" name="'.$key.'[]" value="'.$value2.'">';
											}
										}
										else
										{
											echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
										}
									}
								}
							}
							?>
						</div>
                    </form>
                </div>
            </div>
            <?php if ($job_alerts) { ?>
                <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                    <div class="jobs-alert-box">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <span><?php echo esc_html($job_alerts_title); ?></span>
                                <p><?php echo esc_html($job_alerts_tagline); ?></p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-theme job_alert" data-bs-toggle="modal" data-bs-target="#job-alert-subscribtion">
                                    <?php echo esc_html($job_alerts_btn); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php
            $project_ad1 = fl_framework_get_options('project_search_ad1');
			if(isset($project_ad1) && $project_ad1 != '')
			{
				?>
                <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                    <div class="adverts">
                    	<?php echo wp_return_echo($project_ad1); ?>
                    </div>
                </div>
				<?php
			}
                if ($results->have_posts())
                {
					$list_type = 'list_1';
                    $project_list_style = fl_framework_get_options('project_listing_style');
                    if(isset($project_list_style) && $project_list_style != '')
                    {
                        $list_type = $project_list_style;
                    }
                    
                    $layout_type = new exertio_get_projects();
                    while ($results->have_posts())
                    {
                        $results->the_post();
                        $project_id = get_the_ID();
                        $function = "exertio_projects_$list_type";

                        $fetch_output = $layout_type->$function($project_id);
                        echo ' '.$fetch_output;
                    }
					
					$project_ad2 = fl_framework_get_options('project_search_ad2');
					if(isset($project_ad2) && $project_ad2 != '')
					{
						?>
						<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
							<div class="adverts">
								<?php echo wp_return_echo($project_ad2); ?>
							</div>
						</div>
						<?php
					}
                    echo '<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">';
                    fl_pagination($results);
                    echo '</div>';
                    wp_reset_postdata();
                }
                else
                {
                    ?>
                    <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                        <?php echo exertio_no_result_found('white'); ?> 
                    </div>
                    <?php
                }
				
				
            ?>
        </div>
      </div>
      
      <?php
		if(fl_framework_get_options('project_sidebar') == 'right')
		{
			?>
			<div class="col-lg-4 col-xs-12 col-sm-12 col-md-4 col-xl-4">
            	<div class="project-sidebar">
                	<div class="heading">
                        <h4><?php echo esc_html__('Search Filters','khebrat_theme'); ?></h4>
                        <?php
                            $project_page = '';
                            $project_page = fl_framework_get_options('project_search_page');
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($project_page)); ?>"><?php echo esc_html__('Clear Result','khebrat_theme'); ?></a>
                    </div>
                    <div class="project-widgets">
                        <form action="">
                            <?php dynamic_sidebar( 'exertio-project-widgets' ); ?>
                            <div class="submit-btn">
                                <?php
                                    $sidebar_text = fl_framework_get_options('project_search_sidebar_text');
                                    if(isset($sidebar_text) && $sidebar_text != '')
                                    {
                                        ?> 
                                        <p><i><?php echo esc_html($sidebar_text); ?> </i></p>
                                        <?php
                                    }
                                ?>
                                <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>">
                                <button class="btn btn-theme btn-block" type="submit"> <?php echo esc_html__('Filter Result','khebrat_theme'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
			<?php
        }
        ?>
      
    </div>
  </div>
</section>