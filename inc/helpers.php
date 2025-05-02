<?php 


function hatem_debug($array) {
  ?>
  <style>
    .preClass{
      background-color:#f7f7f7;
      font-size:18px;
      line-height:1.2;
      min-height:30vh;
      padding:20px;
      direction:ltr;
      border-radius:8px;
      color:black !important;
      
    }
  </style>
  <?Php
  echo '<pre class="preClass">';
    if(!empty($array) && is_array($array)){
      print_r($array);
    }else{
      echo "<span>-- $array</span>";
    }
  echo '</pre>';
  exit;
}


function Hatem_get_post_withFilds() {
  global $wpdb;

    $result = [];

    // Get ALL registered post types (public + private + custom)
    $post_types = get_post_types([], 'names');

    foreach ($post_types as $post_type) {
        // Initialize with empty array, even if there's no meta yet
        $result[$post_type] = [
            'meta_fields' => []
        ];

        // Pull distinct meta_keys for posts of this type (if any exist)
        $meta_keys = $wpdb->get_col($wpdb->prepare("
            SELECT DISTINCT pm.meta_key
            FROM {$wpdb->postmeta} pm
            INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE p.post_type = %s
              AND pm.meta_key != ''
            ", $post_type)
        );

        $result[$post_type]['meta_fields'] = $meta_keys;
    }

    return $result;
}