<?php

// تحميل ملفات CSS والخطوط
function enqueue_theme_styles()
{
    // Google Fonts

    // Plugins CSS
    wp_enqueue_style('font-awesome', TEMPLATE_THEME_DIR . '/assets/vendor/font-awesome/css/all.min.css', array(), '6.0.0'); 
    wp_enqueue_style('bootstrap-icons', TEMPLATE_THEME_DIR . '/assets/vendor/bootstrap-icons/bootstrap-icons.css', array(), '1.0.0'); 
    wp_enqueue_style('tiny-slider', TEMPLATE_THEME_DIR . '/assets/vendor/tiny-slider/tiny-slider.css', array(), '1.0.0'); 
    wp_enqueue_style('glightbox', TEMPLATE_THEME_DIR . '/assets/vendor/glightbox/css/glightbox.css', array(), '1.0.0'); 
    wp_enqueue_style('flatpickr', TEMPLATE_THEME_DIR . '/assets/vendor/flatpickr/css/flatpickr.min.css', array(), '1.0.0'); 
    wp_enqueue_style('dropzone', TEMPLATE_THEME_DIR . '/assets/vendor/dropzone/css/dropzone.css', array(), '1.0.0'); 
    wp_enqueue_style('choices', TEMPLATE_THEME_DIR . '/assets/vendor/choices/css/choices.min.css', array(), '1.0.0'); 
    wp_enqueue_style('aos', TEMPLATE_THEME_DIR . '/assets/vendor/aos/aos.css', array(), '1.0.0'); 
    wp_enqueue_style('fontello', TEMPLATE_THEME_DIR . '/css/fontello.css', array(), '1.0.0'); 
    wp_enqueue_style('overlay-scrollbar', TEMPLATE_THEME_DIR . '/assets/vendor/overlay-scrollbar/css/overlayscrollbars.min.css', array(), '1.0.0'); 
    wp_enqueue_style('apexcharts', TEMPLATE_THEME_DIR . '/assets/vendor/apexcharts/css/apexcharts.css', array(), '1.0.0'); 
    wp_enqueue_style('bs-stepper', TEMPLATE_THEME_DIR . '/assets/vendor/stepper/css/bs-stepper.min.css', array(), '1.0.0'); 

    // Theme CSS
    wp_enqueue_style('theme-style', TEMPLATE_THEME_DIR . '/assets/css/style-rtl.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles', 999);



function enqueue_theme_scripts()
{
    // ملفات JavaScript الخاصة بالمكتبات
    wp_enqueue_script('bootstrap-js', TEMPLATE_THEME_DIR . '/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.0', true);
    wp_enqueue_script('tiny-slider-js', TEMPLATE_THEME_DIR . '/assets/vendor/tiny-slider/tiny-slider-rtl.js', true);
    wp_enqueue_script('glightbox-js', TEMPLATE_THEME_DIR . '/assets/vendor/glightbox/js/glightbox.js', array(), '3.0.0', true);
    wp_enqueue_script('flatpickr-js', TEMPLATE_THEME_DIR . '/assets/vendor/flatpickr/js/flatpickr.min.js', array(), '4.6.9', true);
    wp_enqueue_script('flatpickr-ar-js', TEMPLATE_THEME_DIR . '/assets/vendor/flatpickr/js/flatpickr.ar.js', array(), '4.6.9', true);
    wp_enqueue_script('dropzone-js', TEMPLATE_THEME_DIR . '/assets/vendor/dropzone/js/dropzone.js', array(), '4.6.9', true);
    wp_enqueue_script('choices-js', TEMPLATE_THEME_DIR . '/assets/vendor/choices/js/choices.min.js', array(), '10.0.0', true);
    wp_enqueue_script('aos-js', TEMPLATE_THEME_DIR . '/assets/vendor/aos/aos.js', true);
    wp_enqueue_script('overlay-scrollbar-js', TEMPLATE_THEME_DIR . '/assets/vendor/overlay-scrollbar/js/overlayscrollbars.min.js', true);
    wp_enqueue_script('apexcharts-js', TEMPLATE_THEME_DIR . '/assets/vendor/apexcharts/js/apexcharts.min.js', true);
    wp_enqueue_script('bs-stepper-js', TEMPLATE_THEME_DIR . '/assets/vendor/stepper/js/bs-stepper.min.js', true);

    

    // ملف JavaScript الخاص بالقالب
    wp_enqueue_script('theme-functions', TEMPLATE_THEME_DIR . '/assets/js/functions.js', array(), '1.0.0', true);
    wp_enqueue_script('custom-functions', TEMPLATE_THEME_DIR . '/assets/js/custom-functions.js', array(), '1.0.0', true);
    
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts',);



function enqueue_toastr_assets()
{

    // toastr JavaScript
    wp_enqueue_script('toastr', TEMPLATE_THEME_DIR . '/assets/toastr/toastr.min.js', ['jquery'], null, true);

    // toastr CSS
    wp_enqueue_style('toastr', TEMPLATE_THEME_DIR . '/assets/toastr/toastr.min.css', [], null);
}
add_action('wp_enqueue_scripts', 'enqueue_toastr_assets', 9999);



function admin_enqueue_theme_scripts()
{
    wp_enqueue_style('flatpickr', TEMPLATE_THEME_DIR . '/assets/vendor/flatpickr/css/flatpickr.min.css', array(), '1.0.0'); // استبدل بالنسخة الصحيحة

    wp_enqueue_script('flatpickr-js', TEMPLATE_THEME_DIR . '/assets/vendor/flatpickr/js/flatpickr.min.js', array(), '4.6.9', true);
    wp_enqueue_script('flatpickr-ar-js', TEMPLATE_THEME_DIR . '/assets/vendor/flatpickr/js/flatpickr.ar.js', array(), '4.6.9', true);

    wp_enqueue_script('theme-functions', TEMPLATE_THEME_DIR . '/assets/js/functions.js', array(), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'admin_enqueue_theme_scripts');
