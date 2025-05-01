<?php

/*
Template Name: legal services form
*/
// استدعاء ملفات CSS الأساسية عبر wp_head()




global $khebrat_theme_options;
$current_user_id = get_current_user_id();




if (in_array('khebrat-framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    if (is_user_logged_in()) {
        get_template_part('template-parts/html', 'header');


        $current_id = get_the_ID();

        if ($current_id == $khebrat_theme_options['page_case_study']) { 
            get_template_part('template-parts/legal-services/page-case-study');
        } 
        elseif ($current_id == $khebrat_theme_options['page_litigation']) {
            get_template_part('template-parts/legal-services/page-litigation');
        }
        elseif ($current_id == $khebrat_theme_options['page_sessions']) {
            get_template_part('template-parts/legal-services/page-sessions');
        } 
        elseif ($current_id == $khebrat_theme_options['page_legal_writing']) {
            get_template_part('template-parts/legal-services/page-legal-writing');
        } 
        elseif ($current_id == $khebrat_theme_options['page_tanfith']) {
            get_template_part('template-parts/legal-services/page-tanfith');
        } 
        elseif ($current_id == $khebrat_theme_options['page_contracts']) {
            get_template_part('template-parts/legal-services/page-contracts');
        } 
        elseif ($current_id == $khebrat_theme_options['page_trademark']) {
            get_template_part('template-parts/legal-services/page-trademark');
        } 
        elseif ($current_id == $khebrat_theme_options['page_government']) {
            get_template_part('template-parts/legal-services/page-government');
        } 
        elseif ($current_id == $khebrat_theme_options['page_other_services']) {
            get_template_part('template-parts/legal-services/page-other-services');
        } 
        elseif ($current_id == $khebrat_theme_options['form_legal_consultation']) {
            get_template_part('legal-consultation-form');
        } 
        else {
            echo '<p>لم يتم العثور على المحتوى المناسب لهذه الصفحة.</p>';
        }
    } else {
        wp_redirect(home_url());
    }
} else {
    wp_redirect(home_url());
}

get_footer();
