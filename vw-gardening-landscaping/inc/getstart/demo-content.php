<div class="theme-offer">
	<?php 
        // Check if the demo import has been completed
        $vw_gardening_landscaping_demo_import_completed = get_option('vw_gardening_landscaping_demo_import_completed', false);

        // If the demo import is completed, display the "View Site" button
        if ($vw_gardening_landscaping_demo_import_completed) {
        echo '<p class="notice-text">' . esc_html__('Your demo import has been completed successfully.', 'vw-gardening-landscaping') . '</p>';
        echo '<span><a href="' . esc_url(home_url()) . '" class="button button-primary site-btn" target="_blank">' . esc_html__('View Site', 'vw-gardening-landscaping') . '</a></span>';
        }

		//POST and update the customizer and other related data
        if (isset($_POST['submit'])) {
            // Check if ibtana visual editor is installed and activated
            if (!is_plugin_active('ibtana-visual-editor/plugin.php')) {
              // Install the plugin if it doesn't exist
              $vw_gardening_landscaping_plugin_slug = 'ibtana-visual-editor';
              $vw_gardening_landscaping_plugin_file = 'ibtana-visual-editor/plugin.php';

              // Check if plugin is installed
              $vw_gardening_landscaping_installed_plugins = get_plugins();
              if (!isset($vw_gardening_landscaping_installed_plugins[$vw_gardening_landscaping_plugin_file])) {
                  include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
                  include_once(ABSPATH . 'wp-admin/includes/file.php');
                  include_once(ABSPATH . 'wp-admin/includes/misc.php');
                  include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

                  // Install the plugin
                  $vw_gardening_landscaping_upgrader = new Plugin_Upgrader();
                  $vw_gardening_landscaping_upgrader->install('https://downloads.wordpress.org/plugin/ibtana-visual-editor.latest-stable.zip');
              }
              // Activate the plugin
              activate_plugin($vw_gardening_landscaping_plugin_file);
            }

            // ------- Create Nav Menu --------
            $vw_gardening_landscaping_menuname = 'Main Menus';
            $vw_gardening_landscaping_bpmenulocation = 'primary';
            $vw_gardening_landscaping_menu_exists = wp_get_nav_menu_object($vw_gardening_landscaping_menuname);

            if (!$vw_gardening_landscaping_menu_exists) {
                $vw_gardening_landscaping_menu_id = wp_create_nav_menu($vw_gardening_landscaping_menuname);

                // Create Home Page
                $vw_gardening_landscaping_home_title = 'Home';
                $vw_gardening_landscaping_home = array(
                    'post_type' => 'page',
                    'post_title' => $vw_gardening_landscaping_home_title,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'home'
                );
                $vw_gardening_landscaping_home_id = wp_insert_post($vw_gardening_landscaping_home);
                // Assign Home Page Template
                add_post_meta($vw_gardening_landscaping_home_id, '_wp_page_template', 'page-template/custom-home-page.php');
                // Update options to set Home Page as the front page
                update_option('page_on_front', $vw_gardening_landscaping_home_id);
                update_option('show_on_front', 'page');
                // Add Home Page to Menu
                wp_update_nav_menu_item($vw_gardening_landscaping_menu_id, 0, array(
                    'menu-item-title' => __('Home', 'vw-gardening-landscaping'),
                    'menu-item-classes' => 'home',
                    'menu-item-url' => home_url('/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_gardening_landscaping_home_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Create Pages Page with Dummy Content
                $vw_gardening_landscaping_pages_title = 'Pages';
                $vw_gardening_landscaping_pages_content = '
                <p>Explore all the pages we have on our website. Find information about our services, company, and more.</p>

                 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                  All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
                $vw_gardening_landscaping_pages = array(
                    'post_type' => 'page',
                    'post_title' => $vw_gardening_landscaping_pages_title,
                    'post_content' => $vw_gardening_landscaping_pages_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'pages'
                );
                $vw_gardening_landscaping_pages_id = wp_insert_post($vw_gardening_landscaping_pages);
                // Add Pages Page to Menu
                wp_update_nav_menu_item($vw_gardening_landscaping_menu_id, 0, array(
                    'menu-item-title' => __('Pages', 'vw-gardening-landscaping'),
                    'menu-item-classes' => 'pages',
                    'menu-item-url' => home_url('/pages/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_gardening_landscaping_pages_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Create About Us Page with Dummy Content
                $vw_gardening_landscaping_about_title = 'About Us';
                $vw_gardening_landscaping_about_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

                         Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
                $vw_gardening_landscaping_about = array(
                    'post_type' => 'page',
                    'post_title' => $vw_gardening_landscaping_about_title,
                    'post_content' => $vw_gardening_landscaping_about_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'about-us'
                );
                $vw_gardening_landscaping_about_id = wp_insert_post($vw_gardening_landscaping_about);
                // Add About Us Page to Menu
                wp_update_nav_menu_item($vw_gardening_landscaping_menu_id, 0, array(
                    'menu-item-title' => __('About Us', 'vw-gardening-landscaping'),
                    'menu-item-classes' => 'about-us',
                    'menu-item-url' => home_url('/about-us/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_gardening_landscaping_about_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Set the menu location if it's not already set
                if (!has_nav_menu($vw_gardening_landscaping_bpmenulocation)) {
                    $locations = get_theme_mod('nav_menu_locations'); // Use 'nav_menu_locations' to get locations array
                    if (empty($locations)) {
                        $locations = array();
                    }
                    $locations[$vw_gardening_landscaping_bpmenulocation] = $vw_gardening_landscaping_menu_id;
                    set_theme_mod('nav_menu_locations', $locations);
                }
                
        }

         
            // Set the demo import completion flag
    		update_option('vw_gardening_landscaping_demo_import_completed', true);
    		// Display success message and "View Site" button
    		echo '<p class="notice-text">' . esc_html__('Your demo import has been completed successfully.', 'vw-gardening-landscaping') . '</p>';
    		echo '<span><a href="' . esc_url(home_url()) . '" class="button button-primary site-btn" target="_blank">' . esc_html__('View Site', 'vw-gardening-landscaping') . '</a></span>';
            //end 


            // Top Bar //
            set_theme_mod( 'vw_gardening_landscaping_phone_icon', 'fas fa-phone' );  
            set_theme_mod( 'vw_gardening_landscaping_phone_number', '+00 987 654 1230' );  
            set_theme_mod( 'vw_gardening_landscaping_email_icon', 'fas fa-envelope-open' );  
            set_theme_mod( 'vw_gardening_landscaping_email_address', 'example@gmail.com' );
            set_theme_mod( 'vw_gardening_landscaping_top_btn_text', 'GET A QUOTE' );  
            set_theme_mod( 'vw_gardening_landscaping_top_btn_url', '#' );


            // slider section start //     
            set_theme_mod( 'vw_gardening_landscaping_slider_button_text', 'Read More' );  
            set_theme_mod( 'vw_gardening_landscaping_top_button_url', '#' );

            for($vw_gardening_landscaping_i=1;$vw_gardening_landscaping_i<=3;$vw_gardening_landscaping_i++){
               $vw_gardening_landscaping_slider_title = 'Lorem ipsum dolor sit amet, consectetur adipiscing';
               $vw_gardening_landscaping_slider_content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry';
                  // Create post object
               $my_post = array(
               'post_title'    => wp_strip_all_tags( $vw_gardening_landscaping_slider_title ),
               'post_content'  => $vw_gardening_landscaping_slider_content,
               'post_status'   => 'publish',
               'post_type'     => 'page',
               );

               // Insert the post into the database
               $vw_gardening_landscaping_post_id = wp_insert_post( $my_post );

               if ($vw_gardening_landscaping_post_id) {
                 // Set the theme mod for the slider page
                 set_theme_mod('vw_gardening_landscaping_slider_page' . $vw_gardening_landscaping_i, $vw_gardening_landscaping_post_id);

                  $vw_gardening_landscaping_image_url = get_template_directory_uri().'/assets/images/slider'.$vw_gardening_landscaping_i.'.png';

                $vw_gardening_landscaping_image_id = media_sideload_image($vw_gardening_landscaping_image_url, $vw_gardening_landscaping_post_id, null, 'id');

                    if (!is_wp_error($vw_gardening_landscaping_image_id)) {
                        // Set the downloaded image as the post's featured image
                        set_post_thumbnail($vw_gardening_landscaping_post_id, $vw_gardening_landscaping_image_id);
                    }
                }
            }    
            

            // Service Section //
            set_theme_mod( 'vw_gardening_landscaping_section_text', 'Our Gardening' );
            set_theme_mod( 'vw_gardening_landscaping_section_title', 'OUR EXPERTISE' );
            set_theme_mod( 'vw_gardening_landscaping_expertise_button_text', 'Read More' );
            set_theme_mod('vw_gardening_landscaping_our_expertise', 'category1');

            // Define post category names and post titles
            $vw_gardening_landscaping_category_names = array('category1', 'category2');
            $vw_gardening_landscaping_title_array = array(
                array("Our Expertise Title 1", "Our Expertise Title 2", "Our Expertise Title 3"),
                array("Our Expertise Title 1", "Our Expertise Title 2", "Our Expertise Title 3")
            );

            foreach ($vw_gardening_landscaping_category_names as $vw_gardening_landscaping_index => $vw_gardening_landscaping_category_name) {
                // Create or retrieve the post category term ID
                $vw_gardening_landscaping_term = term_exists($vw_gardening_landscaping_category_name, 'category');
                if ($vw_gardening_landscaping_term === 0 || $vw_gardening_landscaping_term === null) {
                    // If the term does not exist, create it
                    $vw_gardening_landscaping_term = wp_insert_term($vw_gardening_landscaping_category_name, 'category');
                }
                if (is_wp_error($vw_gardening_landscaping_term)) {
                    error_log('Error creating category: ' . $vw_gardening_landscaping_term->get_error_message());
                    continue; // Skip to the next iteration if category creation fails
                }

                for ($vw_gardening_landscaping_i = 0; $vw_gardening_landscaping_i < 3; $vw_gardening_landscaping_i++) {
                    // Create post content
                    $vw_gardening_landscaping_title = $vw_gardening_landscaping_title_array[$vw_gardening_landscaping_index][$vw_gardening_landscaping_i];
                    $vw_gardening_landscaping_content = 'Lorem Ipsum is simply dummy text of the printing and typesetting';

                    // Create post post object
                    $vw_gardening_landscaping_my_post = array(
                        'post_title'    => wp_strip_all_tags($vw_gardening_landscaping_title),
                        'post_content'  => $vw_gardening_landscaping_content,
                        'post_status'   => 'publish',
                        'post_type'     => 'post', // Post type set to 'post'
                    );

                    // Insert the post into the database
                    $vw_gardening_landscaping_post_id = wp_insert_post($vw_gardening_landscaping_my_post);

                    if (is_wp_error($vw_gardening_landscaping_post_id)) {
                        error_log('Error creating post: ' . $vw_gardening_landscaping_post_id->get_error_message());
                        continue; // Skip to the next post if creation fails
                    }

                    // Assign the category to the post
                    wp_set_post_categories($vw_gardening_landscaping_post_id, array((int)$vw_gardening_landscaping_term['term_id']));

                    // Handle the featured image using media_sideload_image
                    $vw_gardening_landscaping_image_url = get_template_directory_uri() . '/assets/images/expertise' . ($vw_gardening_landscaping_i + 1) . '.png';
                    $vw_gardening_landscaping_image_id = media_sideload_image($vw_gardening_landscaping_image_url, $vw_gardening_landscaping_post_id, null, 'id');

                    if (is_wp_error($vw_gardening_landscaping_image_id)) {
                        error_log('Error downloading image: ' . $vw_gardening_landscaping_image_id->get_error_message());
                        continue; // Skip to the next post if image download fails
                    }
                    // Assign featured image to post
                    set_post_thumbnail($vw_gardening_landscaping_post_id, $vw_gardening_landscaping_image_id);
                }
            }   


            //Copyright Text
            set_theme_mod( 'vw_gardening_landscaping_footer_text', 'By VWThemes' );  
     
        }
    ?>


    <p><?php esc_html_e('Please back up your website if it’s already live with data. This importer will overwrite your existing settings with the new customizer values for VW Gardening Landscaping', 'vw-gardening-landscaping'); ?></p>
    <form action="<?php echo esc_url(home_url()); ?>/wp-admin/themes.php?page=vw_gardening_landscaping_guide" method="POST" onsubmit="return validate(this);">
        <?php if (!get_option('vw_gardening_landscaping_demo_import_completed')) : ?>
            <input class="run-import" type="submit" name="submit" value="<?php esc_attr_e('Run Importer', 'vw-gardening-landscaping'); ?>" class="button button-primary button-large">
        <?php endif; ?>
        <div id="spinner" style="display:none;">         
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/spinner.png" alt="" />
        </div>
    </form>
    <script type="text/javascript">
        function validate(form) {
            if (confirm("Do you really want to import the theme demo content?")) {
                // Show the spinner
                document.getElementById('spinner').style.display = 'block';
                // Allow the form to be submitted
                return true;
            } 
            else {
                return false;
            }
        }
    </script>
</div>

