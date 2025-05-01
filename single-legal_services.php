<?php

if (in_array('khebrat-framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    get_template_part('header');
    global $khebrat_theme_options;

    $lsid = get_the_ID();
    
    $service_type_id = get_post_meta($lsid, '_service_type', true);

    if ($service_type_id == $khebrat_theme_options['page_case_study']) {
        get_template_part('components/legal-services/page-case-study');
    } elseif ($service_type_id == $khebrat_theme_options['page_litigation']) {
        get_template_part('components/legal-services/page-litigation');
    } elseif ($service_type_id == $khebrat_theme_options['page_sessions']) {
        get_template_part('components/legal-services/page-sessions');
    } elseif ($service_type_id == $khebrat_theme_options['page_legal_writing']) {
        get_template_part('components/legal-services/page-legal-writing');
    } elseif ($service_type_id == $khebrat_theme_options['page_tanfith']) {
        get_template_part('components/legal-services/page-tanfith');
    } elseif ($service_type_id == $khebrat_theme_options['page_contracts']) {
        get_template_part('components/legal-services/page-contracts');
    } elseif ($service_type_id == $khebrat_theme_options['page_trademark']) {
        get_template_part('components/legal-services/page-trademark');
    } elseif ($service_type_id == $khebrat_theme_options['page_government']) {
        get_template_part('components/legal-services/page-government');
    } elseif ($service_type_id == $khebrat_theme_options['page_other_services']) {
        get_template_part('components/legal-services/page-other-services');
    } elseif ($service_type_id == $khebrat_theme_options['form_legal_consultation']) {
        get_template_part('legal-consultation-form');
    } else {
        echo '<p>لم يتم العثور على المحتوى المناسب لهذه الصفحة.</p>';
    }


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