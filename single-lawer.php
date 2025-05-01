<?php

if (in_array('khebrat-framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    get_template_part('header');
    
    


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