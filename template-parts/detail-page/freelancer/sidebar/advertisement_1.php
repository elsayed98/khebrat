<?php
global $khebrat_theme_options;
if(isset($khebrat_theme_options['detail_page_sidebar_ad_1']) && $khebrat_theme_options['detail_page_sidebar_ad_1'] != '')
{
	?>
    <div class="fr-product-progress sidebar-box">
      <?php echo wp_return_echo($khebrat_theme_options['detail_page_sidebar_ad_1']); ?>
    </div>
	<?php
}
?>
