<?php // Register post  type and taxonomy
add_action('init', 'sl_post_customer', 0);

function sl_post_customer()
{
    $args = array(
        'public' => true,
        'labels' => array(
            'name' => __('customer', 'khebrat_framework'),
            'singular_name' => __('customer', 'khebrat_framework'),
            'menu_name' => __('customer', 'khebrat_framework'),
            'name_admin_bar' => __('customer', 'khebrat_framework'),
            'add_new' => __('Add New customer', 'khebrat_framework'),
            'add_new_item' => __('Add New customer', 'khebrat_framework'),
            'new_item' => __('New customer', 'khebrat_framework'),
            'edit_item' => __('Edit customer', 'khebrat_framework'),
            'view_item' => __('View customer', 'khebrat_framework'),
            'all_items' => __('All customers', 'khebrat_framework'),
            'search_items' => __('Search customer', 'khebrat_framework'),
            'not_found' => __('No customer Found.', 'khebrat_framework'),
        ),
        'delete_with_user' => true,
        'supports' => array('title', 'editor'),
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        //'menu_icon'           => FL_PLUGIN_URL . '/images/customer.png',
        
        'rewrite' => array('with_front' => false, 'slug' => 'customer'),
        'capabilities' => array(
            'create_posts' => 'do_not_allow',
        ),
        'map_meta_cap' => true,
        
    );
    register_post_type('customer', $args);
    /*
 * ADMIN COLUMN - HEADERS
 */
    add_filter('manage_edit-customer_columns', 'customer_columns_id');
    add_action('manage_customer_posts_custom_column', 'customer_custom_columns', 5, 2);


    function customer_columns_id($defaults)
    {
        unset($defaults['date']);

        $defaults['display_name'] =  __('Display Name', 'khebrat_framework');
        $defaults['wallet_amount'] =  __('Wallet', 'khebrat_framework');
        return $defaults;
    }
    function customer_custom_columns($column_name, $id)
    {
        if ($column_name === 'display_name') {
            $author_id = get_post_field('post_author', $id);
            $user_info = get_userdata($author_id);
            if (isset($user_info->display_name)) {
                $display_name = $user_info->display_name;
            }
            echo $display_name;
        }
        if ($column_name === 'wallet_amount') {
            $author_id = get_post_field('post_author', $id);
            $wallet_amount = get_user_meta($author_id, '_fl_wallet_amount', true);
            echo $wallet_amount;
        }
    }

    // Add the custom columns to the customer post type:
    add_filter('manage_customer_posts_columns', 'set_custom_edit_customer_columns');
    function set_custom_edit_customer_columns($columns)
    {
        unset($columns['date']);
        $columns['user'] = __('Author', 'khebrat_framework');

        return $columns;
    }

    // Add the data to the custom columns for the customer post type:
    add_action('manage_customer_posts_custom_column', 'custom_customer_column', 10, 2);
    function custom_customer_column($column, $post_id)
    {
        $author_id = get_post_field('post_author', $post_id);
        $author_name = '<a href="' . get_edit_user_link($author_id) . '">' . get_the_author_meta('nickname', $author_id) . ' </a>';
        switch ($column) {

            case 'user':

                echo $author_name;
                break;
        }
    }
    

    $locations_labels = array(
        'name'                       => __('Locations', 'taxonomy general name', 'khebrat_framework'),
        'search_items'               => __('Search Locations', 'khebrat_framework'),
        'popular_items'              => __('Popular Locations', 'khebrat_framework'),
        'all_items'                  => __('All Locations', 'khebrat_framework'),
        'edit_item'                  => __('Edit Location', 'khebrat_framework'),
        'update_item'                => __('Update Location', 'khebrat_framework'),
        'add_new_item'               => __('Add New Location', 'khebrat_framework'),
        'new_item_name'              => __('New Locations Name', 'khebrat_framework'),
        'separate_items_with_commas' => __('Separate Locations with commas', 'khebrat_framework'),
        'add_or_remove_items'        => __('Add or remove Locations', 'khebrat_framework'),
        'choose_from_most_used'      => __('Choose from the most used Locations', 'khebrat_framework'),
        'not_found'                  => __('No Location found.', 'khebrat_framework'),
        'menu_name'                  => __('Locations', 'khebrat_framework'),
    );
    register_taxonomy('customer-locations', array('customer'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'labels' => $locations_labels,
        'show_admin_column' => true,
        'query_var' => true,
        'meta_box_cb' => false,
        'rewrite' => array('slug' => 'locations'),
    ));
    

    
    



    if (!class_exists('customer_locations_Taxonomy_Images')) {
        class customer_locations_Taxonomy_Images
        {

            public function __construct()
            {
                //
            }

            /**
             * Initialize the class and start calling our hooks and filters
             */
            public function init()
            {
                // Image actions
                add_action('customer-locations_add_form_fields', array($this, 'add_category_image'), 10, 2);
                add_action('created_customer-locations', array($this, 'save_category_image'), 10, 2);
                add_action('customer-locations_edit_form_fields', array($this, 'update_category_image'), 10, 2);
                add_action('edited_customer-locations', array($this, 'updated_category_image'), 10, 2);
                add_action('admin_enqueue_scripts', array($this, 'load_media'));
                add_action('admin_footer', array($this, 'add_script'));
            }

            public function load_media()
            {
                if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'customer-locations') {
                    return;
                }
                wp_enqueue_media();
            }

            /**
             * Add a form field in the new category page
             * @since 1.0.0
             */

            public function add_category_image($taxonomy)
            { ?>
                <div class="form-field term-group">
                    <label for="locations-taxonomy-image-id"><?php __('Image', 'khebrat_framework'); ?></label>
                    <input type="hidden" id="locations-taxonomy-image-id" name="locations-taxonomy-image-id" class="custom_media_url" value="">
                    <div id="locations-image-wrapper"></div>
                    <p>
                        <input type="button" class="button button-secondary locations_tax_media_button" id="locations_tax_media_button" name="locations_tax_media_button" value="<?php echo __('Add Image', 'khebrat_framework'); ?>" />
                        <input type="button" class="button button-secondary locations_tax_media_remove" id="locations_tax_media_remove" name="locations_tax_media_remove" value="<?php echo __('Remove Image', 'khebrat_framework'); ?>" />
                    </p>
                </div>
            <?php }

            /**
             * Save the form field
             * @since 1.0.0
             */
            public function save_category_image($term_id, $tt_id)
            {
                if (isset($_POST['locations-taxonomy-image-id']) && '' !== $_POST['locations-taxonomy-image-id']) {
                    add_term_meta($term_id, 'locations-taxonomy-image-id', absint($_POST['locations-taxonomy-image-id']), true);
                }
            }

            /**
             * Edit the form field
             * @since 1.0.0
             */
            public function update_category_image($term, $taxonomy)
            { ?>
                <tr class="form-field term-group-wrap">
                    <th scope="row">
                        <label for="locations-taxonomy-image-id"><?php echo __('Image', 'khebrat_framework'); ?></label>
                    </th>
                    <td>
                        <?php $image_id = get_term_meta($term->term_id, 'locations-taxonomy-image-id', true); ?>
                        <input type="hidden" id="locations-taxonomy-image-id" name="locations-taxonomy-image-id" value="<?php echo esc_attr($image_id); ?>">
                        <div id="locations-image-wrapper">
                            <?php if ($image_id) { ?>
                                <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                            <?php } ?>
                        </div>
                        <p>
                            <input type="button" class="button button-secondary locations_tax_media_button" id="locations_tax_media_button" name="locations_tax_media_button" value="<?php echo __('Add Image', 'khebrat_framework'); ?>" />
                            <input type="button" class="button button-secondary locations_tax_media_remove" id="locations_tax_media_remove" name="locations_tax_media_remove" value="<?php echo __('Remove Image', 'khebrat_framework'); ?>" />
                        </p>
                    </td>
                </tr>
            <?php }

            /**
             * Update the form field value
             * @since 1.0.0
             */
            public function updated_category_image($term_id, $tt_id)
            {
                if (isset($_POST['locations-taxonomy-image-id']) && '' !== $_POST['locations-taxonomy-image-id']) {
                    update_term_meta($term_id, 'locations-taxonomy-image-id', absint($_POST['locations-taxonomy-image-id']));
                } else {
                    update_term_meta($term_id, 'locations-taxonomy-image-id', '');
                }
            }

            /**
             * Enqueue styles and scripts
             * @since 1.0.0
             */
            public function add_script()
            {
                if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'customer-locations') {
                    return;
                } ?>
                <script>
                    jQuery(document).ready(function($) {
                        _wpMediaViewsL10n.insertIntoPost = '<?php echo __('Insert', 'khebrat_framework'); ?>';

                        function ct_media_upload(button_class) {
                            var _custom_media = true,
                                _orig_send_attachment = wp.media.editor.send.attachment;
                            $('body').on('click', button_class, function(e) {
                                var button_id = '#' + $(this).attr('id');
                                var send_attachment_bkp = wp.media.editor.send.attachment;
                                var button = $(button_id);
                                _custom_media = true;
                                wp.media.editor.send.attachment = function(props, attachment) {
                                    if (_custom_media) {
                                        $('#locations-taxonomy-image-id').val(attachment.id);
                                        $('#locations-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                                        $('#locations-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
                                    } else {
                                        return _orig_send_attachment.apply(button_id, [props, attachment]);
                                    }
                                }
                                wp.media.editor.open(button);
                                return false;
                            });
                        }
                        ct_media_upload('.locations_tax_media_button.button');
                        $('body').on('click', '.locations_tax_media_remove', function() {
                            $('#locations-taxonomy-image-id').val('');
                            $('#locations-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                        });

                        $(document).ajaxComplete(function(event, xhr, settings) {
                            var queryStringArr = settings.data.split('&');
                            if ($.inArray('action=add-tag', queryStringArr) !== -1) {
                                var xml = xhr.responseXML;
                                $response = $(xml).find('term_id').text();
                                if ($response != "") {
                                    // Clear the thumb image
                                    $('#locations-image-wrapper').html('');
                                }
                            }
                        });
                    });
                </script>
        <?php }
        }
        $customer_locations_Taxonomy_Images = new customer_locations_Taxonomy_Images();
        $customer_locations_Taxonomy_Images->init();
    }


    add_action('load-post.php', 'customer_boxes_setup');
    add_action('load-post-new.php', 'customer_boxes_setup');


    function customer_boxes_setup()
    {

        /* Add meta boxes on the 'add_meta_boxes' hook. */
        add_action('add_meta_boxes', 'customer_meta_boxes');

        /* Save post meta on the 'save_post' hook. */
        add_action('save_post', 'customer_save_post_class_meta', 10, 2);
    }

    //add_action( 'admin_enqueue_scripts', 'attachment_wp_admin_enqueue' );
    /* Create one or more meta boxes to be displayed on the post editor screen. */
    function customer_meta_boxes()
    {

        add_meta_box(
            'customer-post-class',      // Unique ID
            esc_html__('Add customer Detail', 'khebrat_framework'),    // Title
            'customer_meta_box',   // Callback function
            'customer',
            'normal',         // Context
            'default'         // Priority
        );
    }

    function customer_meta_box($post)
    { ?>

        <?php wp_nonce_field(basename(__FILE__), 'customer_post_class_nonce');

        //print_r($post);
        $post_id =  $post->ID;

        $custom_field_dispaly = 'style=display:none;';
        if (class_exists('ACF')) {
            $selected_custom_data = exertio_customer_fields_by_listing_id($post_id);
            if (!empty($selected_custom_data) && is_array($selected_custom_data)) {
                $custom_field_dispaly = '';
                if (!empty($selected_custom_data)) {
                    $custom_field_dispaly = '';
                }
                //$custom_field_dispaly = '';
                $fetch_custom_data = $selected_custom_data;
            }
        }
        ?>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Gender", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $customer_gender = '';
                $customer_gender = get_post_meta($post_id, '_customer_gender', true);
                ?>
                <select name="customer_gender">
                    <option value="0" <?php if ($customer_gender == '0') {
                                            echo "selected='selected'";
                                        } ?>><?php echo __("Male", 'khebrat_framework'); ?> </option>
                    <option value="1" <?php if ($customer_gender == '1') {
                                            echo "selected='selected'";
                                        } ?>><?php echo __("Female", 'khebrat_framework'); ?> </option>
                    <option value="2" <?php if ($customer_gender  == "2") {
                                            echo "selected=selected";
                                        } ?>><?php echo __("Other", 'exertio_theme'); ?> </option>
                </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Tagline", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $customer_tagline = '';
                $customer_tagline = get_post_meta($post_id, '_customer_tagline', true);
                ?>
                <input type="text" name="customer_tagline" value="<?php echo $customer_tagline; ?>" placeholder="<?php echo __(" Tagline", "khebrat_framework"); ?>">
                <p><?php echo __("customer Tagline will be here", "khebrat_framework"); ?></p>
            </div>
        </div>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Display Name", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $customer_dispaly_name = '';
                $customer_dispaly_name = get_post_meta($post_id, '_customer_dispaly_name', true);
                ?>
                <input type="text" name="customer_dispaly_name" value="<?php echo $customer_dispaly_name; ?>" placeholder="<?php echo __(" Display Name", "khebrat_framework"); ?>">
                <p><?php echo __("This will be visible on website", "khebrat_framework"); ?></p>
            </div>
        </div>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("الاسم الثلاثي", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $customer_three_name = '';
                $customer_three_name = get_post_meta($post_id, '_customer_three_name', true);
                ?>
                <input type="text" name="customer_three_name" value="<?php echo $customer_three_name; ?>" placeholder="<?php echo __("الاسم الثلاثي", "khebrat_framework"); ?>">
                <p><?php echo __("This will be visible on website", "khebrat_framework"); ?></p>
            </div>
        </div>


        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Contact Number", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $customer_contact_number = '';
                $customer_contact_number = get_post_meta($post_id, '_customer_contact_number', true);
                ?>
                <input type="number" name="customer_contact_number" value="<?php echo $customer_contact_number; ?>" placeholder="<?php echo __("Phone number", "khebrat_framework"); ?>" required>
            </div>
        </div>
        
        
        
        

        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Location", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $location_taxonomies =sl_get_terms('customer-locations');
                if (!empty($location_taxonomies)) {
                    $fl_location = get_post_meta($post_id, '_customer_location', true);
                    echo '<select name="customer_location" class="form-control general_select">' . get_hierarchical_terms('customer-locations', '_customer_location', $post_id) . '</select>';
                } else {
                    echo __("No values available. Please consider adding values first", 'khebrat_framework');
                }
                ?>
            </div>
        </div>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Profile Picture", 'khebrat_framework'); ?></label></div>
            <div class="col-9">
                <div id="freelance_gall_render_html">
                    <ul class="freelance_gallery">
                        <?php
                        $profile_pic_attachment_ids = get_post_meta($post_id, '_profile_pic_customer_id', true);
                        if (isset($profile_pic_attachment_ids) && $profile_pic_attachment_ids != '') {
                            $attachment_data = wp_get_attachment_url($profile_pic_attachment_ids);
                            echo '<li id="data-' . $profile_pic_attachment_ids . '"><img src="' . $attachment_data . '" alt="' . __("attachment", 'khebrat_framework') . '"><a href="javascript:void(0);" class="remove_button"><img src="/images/error.png" ></a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <button id="single_attachment_btn" type="button" class="button button-primary button-large"> <?php echo __("Select Profile Image", 'khebrat_framework'); ?> </button>
                <input type="hidden" name="profile_attachment_ids" value="<?php echo $profile_pic_attachment_ids; ?>" id="profile_attachment_ids">
                <p><?php echo __("Select profile picture to show publicly.", 'khebrat_framework'); ?></p>

            </div>
        </div>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Banner Image", 'khebrat_framework'); ?></label></div>
            <div class="col-9">
                <div id="freelance_gall_render_html1">
                    <ul class="freelance_banner_gallery">
                        <?php
                        $banner_attachment_id = get_post_meta($post_id, '_customer_banner_id', true);
                        if (isset($banner_attachment_id) && $banner_attachment_id != '') {
                            $banner_attachment_data = wp_get_attachment_url($banner_attachment_id);
                            echo '<li id="data-' . $banner_attachment_id . '"><img src="' . $banner_attachment_data . '" alt="' . __("attachment", 'khebrat_framework') . '"><a href="javascript:void(0);" class="remove_button"><img src="/images/error.png" >	</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <button id="banner_img_btn" type="button" class="button button-primary button-large"> <?php echo __("Select Banner Image", 'khebrat_framework'); ?> </button>
                <input type="hidden" name="banner_img_id" value="<?php echo $banner_attachment_id; ?>" id="banner_img_id">
                <p><?php echo __("Select banner image to show on public profile.", 'khebrat_framework'); ?></p>

            </div>
        </div>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Address", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $company_address = '';
                $company_address = get_post_meta($post_id, '_customer_address', true);
                ?>
                <input type="text" name="customer_address" value="<?php echo $company_address; ?>" placeholder="<?php echo __("Address", "khebrat_framework"); ?>">
            </div>
        </div>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Latitude", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $company_latitude = '';
                $company_latitude = get_post_meta($post_id, '_customer_latitude', true);
                ?>
                <input type="text" name="customer_latitude" value="<?php echo $company_latitude; ?>" placeholder="<?php echo __("Provide Latitude", "khebrat_framework"); ?>">
            </div>
        </div>

        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Longitude", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $company_longitude = '';
                $company_longitude = get_post_meta($post_id, '_customer_longitude', true);
                ?>
                <input type="text" name="customer_longitude" value="<?php echo $company_longitude; ?>" placeholder="<?php echo __("Provide Longitude", "khebrat_framework"); ?>">
            </div>
        </div>

        

        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Mark customer Featured", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $customer_featured = '';
                $customer_featured = get_post_meta($post_id, '_customer_is_featured', true);
                ?>
                <select name="customer_featured">
                    <option value="0" <?php if (isset($customer_featured) && $customer_featured == 0) {
                                            echo 'selected ="selected"';
                                        } ?>> <?php echo __("Simple", 'khebrat_framework'); ?></option>
                    <option value="1" <?php if (isset($customer_featured) && $customer_featured == 1) {
                                            echo 'selected ="selected"';
                                        } ?>> <?php echo __("Featured", 'khebrat_framework'); ?></option>
                </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __("Mark customer Verified", 'khebrat_framework'); ?></label></div>
            <div class="col-3">
                <?php
                $customer_verified = '';
                $customer_verified = get_post_meta($post_id, '_is_customer_verified', true);
                ?>
                <select name="customer_verified">
                    <option value="0" <?php if (isset($customer_verified) && $customer_verified == 0) {
                                            echo 'selected ="selected"';
                                        } ?>> <?php echo __("Not verified", 'khebrat_framework'); ?></option>
                    <option value="1" <?php if (isset($customer_verified) && $customer_verified == 1) {
                                            echo 'selected ="selected"';
                                        } ?>> <?php echo __("Verified", 'khebrat_framework'); ?></option>
                </select>
            </div>
        </div>

    <?php }


    /* Save the meta box's post metadata. */
    function customer_save_post_class_meta($post_id, $post)
    {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['customer_post_class_nonce']) || !wp_verify_nonce($_POST['customer_post_class_nonce'], basename(__FILE__)))
            return $post_id;

        /* Get the post type object. */
        $post_type = get_post_type_object($post->post_type);

        /* Check if the current user has permission to edit the post. */
        if (!current_user_can($post_type->cap->edit_post, $post_id))
            return $post_id;


        if (isset($_POST['customer_gender'])) {
            update_post_meta($post_id, '_customer_gender', $_POST['customer_gender']);
        }

        if (isset($_POST['customer_tagline'])) {
            update_post_meta($post_id, '_customer_tagline', $_POST['customer_tagline']);
        }

        if (isset($_POST['customer_dispaly_name'])) {
            update_post_meta($post_id, '_customer_dispaly_name', $_POST['customer_dispaly_name']);
        }

        if (isset($_POST['customer_three_name'])) {
            update_post_meta($post_id, '_customer_three_name', $_POST['customer_three_name']);
        }
        if (isset($_POST['customer_position'])) {
            update_post_meta($post_id, '_customer_position', $_POST['customer_position']);
        }


        if (isset($_POST['customer_contact_number'])) {
            update_post_meta($post_id, '_customer_contact_number', $_POST['customer_contact_number']);
        }
        if (isset($_POST['customer_portfolio_link'])) {
            update_post_meta($post_id, '_customer_portfolio_link', $_POST['customer_portfolio_link']);
        }

       

        if (isset($_POST['customer_location'])) {
            $customer_location_terms = array((int)$_POST['customer_location']);
            update_post_meta($post_id, '_customer_location', $_POST['customer_location']);
            wp_set_post_terms($post_id, $customer_location_terms, 'customer-locations', false);
        }

        if (isset($_POST['profile_attachment_ids'])) {
            update_post_meta($post_id, '_profile_pic_customer_id', $_POST['profile_attachment_ids']);
        }


        if (isset($_POST['banner_img_id'])) {
            update_post_meta($post_id, '_customer_banner_id', $_POST['banner_img_id']);
        }

        if (isset($_POST['customer_address'])) {
            update_post_meta($post_id, '_customer_address', $_POST['customer_address']);
        }

        if (isset($_POST['customer_latitude'])) {
            update_post_meta($post_id, '_customer_latitude', $_POST['customer_latitude']);
        }

        if (isset($_POST['customer_longitude'])) {
            update_post_meta($post_id, '_customer_longitude', $_POST['customer_longitude']);
        }

        if (isset($_POST['customer_featured'])) {
            update_post_meta($post_id, '_customer_is_featured', $_POST['customer_featured']);
        }
        if (isset($_POST['customer_verified'])) {
            update_post_meta($post_id, '_is_customer_verified', $_POST['customer_verified']);
        }
    }
}




/*SIDEBAR META BOXES*/


add_action('load-post.php', 'customer_sidebar_boxes_setup');
add_action('load-post-new.php', 'customer_sidebar_boxes_setup');


function customer_sidebar_boxes_setup()
{

    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action('add_meta_boxes', 'customer_sidebar_meta_boxes');

    /* Save post meta on the 'save_post' hook. */
    add_action('save_post', 'customer_sidebar_save_post_class_meta', 10, 2);
}

//add_action( 'admin_enqueue_scripts', 'attachment_wp_admin_enqueue' );
/* Create one or more meta boxes to be displayed on the post editor screen. */
function customer_sidebar_meta_boxes()
{

    add_meta_box(
        'customer-sidebar-post-class',      // Unique ID
        esc_html__('Package Detail', 'khebrat_framework'),    // Title
        'customer_sidebar_meta_box',   // Callback function
        'customer',
        'side',         // Context
        'default'         // Priority
    );
}

function customer_sidebar_meta_box($post)
{ ?>

    <?php wp_nonce_field(basename(__FILE__), 'customer_sidebar_post_class_nonce');

    $post_id =  $post->ID;

    ?>
    
    <?php }


/* Save the meta box's post metadata. */
function customer_sidebar_save_post_class_meta($post_id, $post)
{

    /* Verify the nonce before proceeding. */
    if (!isset($_POST['customer_sidebar_post_class_nonce']) || !wp_verify_nonce($_POST['customer_sidebar_post_class_nonce'], basename(__FILE__)))
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    
}








add_filter('post_row_actions', 'exertio_remove_row_actions_post', 10, 2);
function exertio_remove_row_actions_post($actions, $post)
{
    if ($post->post_type === 'customer' || $post->post_type === 'employer') {
        unset($actions['clone']);
        unset($actions['trash']);
    }
    return $actions;
}

add_action('admin_head', function () {
    $current_screen = get_current_screen();

    // Hides the "Move to Trash" link on the post edit page.
    if ('post' === $current_screen->base && 'customer' === $current_screen->post_type || 'post' === $current_screen->base && 'employer' === $current_screen->post_type) :
    ?>
        <style>
            #delete-action,
            #bulk-action-selector-top option[value="trash"] {
                display: none;
            }
        </style>
    <?php
    endif;
    if ('customer' === $current_screen->post_type || 'employer' === $current_screen->post_type) :
    ?>
        <style>
            .row-actions .trash,
            #bulk-action-selector-top option[value="trash"] {
                display: none;
            }
        </style>
<?php
    endif;
});
