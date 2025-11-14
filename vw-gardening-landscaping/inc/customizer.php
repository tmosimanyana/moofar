<?php
/**
 * VW Gardening Landscaping Theme Customizer
 *
 * @package VW Gardening Landscaping
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vw_gardening_landscaping_custom_controls() {

    load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'vw_gardening_landscaping_custom_controls' );

function vw_gardening_landscaping_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo .site-title a',
	 	'render_callback' => 'vw_gardening_landscaping_customize_partial_blogname',
	));

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => 'p.site-description',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_blogdescription',
	));

	//Homepage Settings
	$wp_customize->add_panel( 'vw_gardening_landscaping_homepage_panel', array(
		'title' => esc_html__( 'Homepage Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_panel_id',
		'priority' => 20,
	));

	//Topbar
	$wp_customize->add_section( 'vw_gardening_landscaping_topbar', array(
    	'title'      => __( 'Topbar Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_homepage_panel',
		'priority' => 2,
	) );

	//Sticky Header
	$wp_customize->add_setting( 'vw_gardening_landscaping_sticky_header',array(
	    'default' => 0,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
  	) );
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_sticky_header',array(
	    'label' => esc_html__( 'Sticky Header','vw-gardening-landscaping' ),
	    'section' => 'vw_gardening_landscaping_topbar'
  	)));

   	// Header Background color
	$wp_customize->add_setting('vw_gardening_landscaping_header_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_header_background_color', array(
		'label'    => __('Header Background Color', 'vw-gardening-landscaping'),
		'section'  => 'header_image',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_header_img_position',array(
	  'default' => 'center top',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_header_img_position',array(
		'type' => 'select',
		'label' => __('Header Image Position','vw-gardening-landscaping'),
		'section' => 'header_image',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'vw-gardening-landscaping' ),
			'center top'   => esc_html__( 'Top', 'vw-gardening-landscaping' ),
			'right top'   => esc_html__( 'Top Right', 'vw-gardening-landscaping' ),
			'left center'   => esc_html__( 'Left', 'vw-gardening-landscaping' ),
			'center center'   => esc_html__( 'Center', 'vw-gardening-landscaping' ),
			'right center'   => esc_html__( 'Right', 'vw-gardening-landscaping' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'vw-gardening-landscaping' ),
			'center bottom'   => esc_html__( 'Bottom', 'vw-gardening-landscaping' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'vw-gardening-landscaping' ),
		),
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_topbar_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_topbar_hide_show',array(
		'label' => esc_html__( 'Show / Hide Topbar','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_topbar'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_topbar_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_topbar_padding_top_bottom',array(
		'label'	=> __('Topbar Padding Top Bottom','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_search_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_search_hide_show',array(
      'label' => esc_html__( 'Show / Hide Search','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_topbar'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_search_icon',array(
		'default'	=> 'fas fa-search',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_search_icon',array(
		'label'	=> __('Add Search Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_topbar',
		'setting'	=> 'vw_gardening_landscaping_search_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_search_close_icon',array(
		'default'	=> 'fa fa-window-close',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_search_close_icon',array(
		'label'	=> __('Add Search Close Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_topbar',
		'setting'	=> 'vw_gardening_landscaping_search_close_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('vw_gardening_landscaping_search_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_search_font_size',array(
		'label'	=> __('Search Font Size','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_search_placeholder',array(
       'default' => esc_html__('Search','vw-gardening-landscaping'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('vw_gardening_landscaping_search_placeholder',array(
       'type' => 'text',
       'label' => __('Search Placeholder Text','vw-gardening-landscaping'),
       'section' => 'vw_gardening_landscaping_topbar'
    ));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_gardening_landscaping_phone_number', array(
		'selector' => '#topbar span',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_phone_number',
	));

    $wp_customize->add_setting('vw_gardening_landscaping_phone_icon',array(
		'default'	=> 'fas fa-phone',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_phone_icon',array(
		'label'	=> __('Add Phone Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_topbar',
		'setting'	=> 'vw_gardening_landscaping_phone_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_phone_number'
	));
	$wp_customize->add_control('vw_gardening_landscaping_phone_number',array(
		'label'	=> __('Add Phone Number','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '+00 987 654 1230', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_email_icon',array(
		'default'	=> 'fas fa-envelope-open',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_email_icon',array(
		'label'	=> __('Add Email Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_topbar',
		'setting'	=> 'vw_gardening_landscaping_email_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('vw_gardening_landscaping_email_address',array(
		'label'	=> __('Add Email Address','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'example@gmail.com', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_top_btn_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_top_btn_text',array(
		'label'	=> __('Add Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'GET A QUOTE', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_top_btn_url',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('vw_gardening_landscaping_top_btn_url',array(
		'label'	=> __('Add Button URL','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'https://example.com', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_topbar',
		'type'=> 'url'
	));

	//Menus Settings
	$wp_customize->add_section( 'vw_gardening_landscaping_menu_section' , array(
    	'title' => __( 'Menus Settings', 'vw-gardening-landscaping' ),
    	'priority'	=>	3,
		'panel' => 'vw_gardening_landscaping_homepage_panel'
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_menu_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_navigation_menu_font_weight',array(
        'default' => 500,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_menu_section',
        'choices' => array(
        	'100' => __('100','vw-gardening-landscaping'),
            '200' => __('200','vw-gardening-landscaping'),
            '300' => __('300','vw-gardening-landscaping'),
            '400' => __('400','vw-gardening-landscaping'),
            '500' => __('500','vw-gardening-landscaping'),
            '600' => __('600','vw-gardening-landscaping'),
            '700' => __('700','vw-gardening-landscaping'),
            '800' => __('800','vw-gardening-landscaping'),
            '900' => __('900','vw-gardening-landscaping'),
        ),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_menus_item_style',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_menus_item_style',array(
        'type' => 'select',
        'section' => 'vw_gardening_landscaping_menu_section',
		'label' => __('Menu Item Hover Style','vw-gardening-landscaping'),
		'choices' => array(
            'None' => __('None','vw-gardening-landscaping'),
            'Zoom In' => __('Zoom In','vw-gardening-landscaping'),
        ),
	) );

	// text trasform
	$wp_customize->add_setting('vw_gardening_landscaping_menu_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_menu_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Menus Text Transform','vw-gardening-landscaping'),
		'choices' => array(
            'Uppercase' => __('Uppercase','vw-gardening-landscaping'),
            'Capitalize' => __('Capitalize','vw-gardening-landscaping'),
            'Lowercase' => __('Lowercase','vw-gardening-landscaping'),
        ),
		'section'=> 'vw_gardening_landscaping_menu_section',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_header_menus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_header_menus_color', array(
		'label'    => __('Menus Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_menu_section',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_header_menus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_header_menus_hover_color', array(
		'label'    => __('Menus Hover Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_menu_section',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_header_submenus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_header_submenus_color', array(
		'label'    => __('Sub Menus Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_menu_section',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_header_submenus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_header_submenus_hover_color', array(
		'label'    => __('Sub Menus Hover Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_menu_section',
	)));

    //Social
	$wp_customize->add_section(
		'vw_gardening_landscaping_social_links', array(
			'title'		=>	__('Social Links', 'vw-gardening-landscaping'),
			'priority'	=>	3,
			'panel'		=>	'vw_gardening_landscaping_homepage_panel'
		)
	);

	$wp_customize->add_setting('vw_gardening_landscaping_social_icons',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_social_icons',array(
		'label' =>  __('Steps to setup social icons','vw-gardening-landscaping'),
		'description' => __('<p>1. Go to Dashboard >> Appearance >> Widgets</p>
			<p>2. Add Vw Social Icon Widget in Top Bar Social Media Widget area.</p>
			<p>3. Add social icons url and save.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_social_links',
		'type'=> 'hidden'
	));
	$wp_customize->add_setting('vw_gardening_landscaping_social_icon_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_social_icon_btn',array(
		'description' => "<a target='_blank' href='". admin_url('widgets.php') ." '>Setup Social Icons</a>",
		'section'=> 'vw_gardening_landscaping_social_links',
		'type'=> 'hidden'
	));

	//Slider
	$wp_customize->add_section( 'vw_gardening_landscaping_slidersettings' , array(
    	'title'      => __( 'Slider Section', 'vw-gardening-landscaping' ),
    	'description' => __('Free theme has 3 slides options, For unlimited slides and more options </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/landscaping-wordpress-theme">GET PRO</a>','vw-gardening-landscaping'),
		'panel' => 'vw_gardening_landscaping_homepage_panel',
		'priority' => 3,
	) );

	$wp_customize->add_setting( 'vw_gardening_landscaping_slider_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_slider_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_slidersettings'
    )));

	$wp_customize->add_setting('vw_gardening_landscaping_slider_type',array(
        'default' => 'Default slider',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	) );
	$wp_customize->add_control('vw_gardening_landscaping_slider_type', array(
        'type' => 'select',
        'label' => __('Slider Type','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_slidersettings',
        'choices' => array(
            'Default slider' => __('Default slider','vw-gardening-landscaping'),
            'Advance slider' => __('Advance slider','vw-gardening-landscaping'),
        ),
	));

	$wp_customize->add_setting('vw_gardening_landscaping_advance_slider_shortcode',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_advance_slider_shortcode',array(
		'label'	=> __('Add Slider Shortcode','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_gardening_landscaping_advance_slider'
	));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_gardening_landscaping_slider_hide_show',array(
		'selector'        => '#slider .inner_carousel h1',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_slider_hide_show',
	));

	for ( $count = 1; $count <= 3; $count++ ) {
		$wp_customize->add_setting( 'vw_gardening_landscaping_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'vw_gardening_landscaping_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'vw_gardening_landscaping_slider_page' . $count, array(
			'label'    => __( 'Select Slider Page', 'vw-gardening-landscaping' ),
			'description' => __('Slider image size (1500 x 590)','vw-gardening-landscaping'),
			'section'  => 'vw_gardening_landscaping_slidersettings',
			'type'     => 'dropdown-pages',
			'active_callback' => 'vw_gardening_landscaping_default_slider'
		) );
	}

	$wp_customize->add_setting('vw_gardening_landscaping_slider_button_text',array(
		'default'=> 'Read More',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Read More', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_top_button_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('vw_gardening_landscaping_top_button_url',array(
		'label'	=> __('Add Button URL','vw-gardening-landscaping'),
		'section'	=> 'vw_gardening_landscaping_slidersettings',
		'setting'	=> 'vw_gardening_landscaping_top_button_url',
		'type'	=> 'url',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_slider_title_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_slider_title_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Title','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_slidersettings',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
    )));

	$wp_customize->add_setting( 'vw_gardening_landscaping_slider_content_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_slider_content_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Content','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_slidersettings',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
    )));

	//content layout
	$wp_customize->add_setting('vw_gardening_landscaping_slider_content_option',array(
        'default' => 'Left',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Image_Radio_Control($wp_customize, 'vw_gardening_landscaping_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    	),
		'active_callback' => 'vw_gardening_landscaping_default_slider'
    )));

    //Slider content padding
    $wp_customize->add_setting('vw_gardening_landscaping_slider_content_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_slider_content_padding_top_bottom',array(
		'label'	=> __('Slider Content Padding Top Bottom','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in %. Example:20%','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_slider_content_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_slider_content_padding_left_right',array(
		'label'	=> __('Slider Content Padding Left Right','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in %. Example:20%','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	));

    //Slider excerpt
	$wp_customize->add_setting( 'vw_gardening_landscaping_slider_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_slidersettings',
		'type'        => 'range',
		'settings'    => 'vw_gardening_landscaping_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	) );

	//Opacity
	$wp_customize->add_setting('vw_gardening_landscaping_slider_opacity_color',array(
      'default'              => 0.5,
      'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));

	$wp_customize->add_control( 'vw_gardening_landscaping_slider_opacity_color', array(
		'label' => esc_html__( 'Slider Image Opacity','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_slidersettings',
		'type'  => 'select',
		'settings' => 'vw_gardening_landscaping_slider_opacity_color',
		'choices' => array(
			'0' =>  esc_attr( __('0','vw-gardening-landscaping')),
			'0.1' =>  esc_attr( __('0.1','vw-gardening-landscaping')),
			'0.2' =>  esc_attr( __('0.2','vw-gardening-landscaping')),
			'0.3' =>  esc_attr( __('0.3','vw-gardening-landscaping')),
			'0.4' =>  esc_attr( __('0.4','vw-gardening-landscaping')),
			'0.5' =>  esc_attr( __('0.5','vw-gardening-landscaping')),
			'0.6' =>  esc_attr( __('0.6','vw-gardening-landscaping')),
			'0.7' =>  esc_attr( __('0.7','vw-gardening-landscaping')),
			'0.8' =>  esc_attr( __('0.8','vw-gardening-landscaping')),
			'0.9' =>  esc_attr( __('0.9','vw-gardening-landscaping'))
		),
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_slider_image_overlay',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_slider_image_overlay',array(
      	'label' => esc_html__( 'Show / Hide Image Overlay','vw-gardening-landscaping' ),
      	'section' => 'vw_gardening_landscaping_slidersettings',
      	'active_callback' => 'vw_gardening_landscaping_default_slider'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_slider_image_overlay_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_slider_image_overlay_color', array(
		'label'    => __('Slider Image Overlay Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_slidersettings',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	)));

	//Slider height
	$wp_customize->add_setting('vw_gardening_landscaping_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_slider_height',array(
		'label'	=> __('Slider Height','vw-gardening-landscaping'),
		'description'	=> __('Specify the slider height (px).','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_slidersettings',
		'type'=> 'text',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_slider_speed', array(
		'default'  => 4000,
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_float'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','vw-gardening-landscaping'),
		'section' => 'vw_gardening_landscaping_slidersettings',
		'type'  => 'number',
		'active_callback' => 'vw_gardening_landscaping_default_slider'
	) );

	//Our Expertise section
	$wp_customize->add_section( 'vw_gardening_landscaping_expertise_section' , array(
    	'title' => __( 'Our Expertise', 'vw-gardening-landscaping' ),
    	'description' => __('For more options of expertise section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/landscaping-wordpress-theme">GET PRO</a>','vw-gardening-landscaping'),
		'priority' => null,
		'panel' => 'vw_gardening_landscaping_homepage_panel',
		'priority' => 4,
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_gardening_landscaping_section_title', array(
		'selector' => '#serv-section h2',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_section_title',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_section_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_section_text',array(
		'label'	=> __('Add Section Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Our Gardening', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_expertise_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_section_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_section_title',array(
		'label'	=> __('Add Section Title','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'OUR EXPERTISE', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_expertise_section',
		'type'=> 'text'
	));

	$categories = get_categories();
	$cat_post = array();
	$cat_post[]= 'select';
	$i = 0;
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('vw_gardening_landscaping_our_expertise',array(
		'default'	=> 'select',
		'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices',
	));
	$wp_customize->add_control('vw_gardening_landscaping_our_expertise',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => __('Select Category to display expertise','vw-gardening-landscaping'),
		'description' => __('Image Size (533 x 333)','vw-gardening-landscaping'),
		'section' => 'vw_gardening_landscaping_expertise_section',
	));

	//Expertise excerpt
	$wp_customize->add_setting( 'vw_gardening_landscaping_expertise_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_expertise_excerpt_number', array(
		'label'       => esc_html__( 'Expertise Excerpt length','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_expertise_section',
		'type'        => 'range',
		'settings'    => 'vw_gardening_landscaping_expertise_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_expertise_button_text',array(
		'default'=> 'Read More',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_expertise_button_text',array(
		'label'	=> __('Add Expertise Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Read More', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_expertise_section',
		'type'=> 'text'
	));

	//About Us Section
	$wp_customize->add_section('vw_gardening_landscaping_about', array(
		'title'       => __('About Us Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_about_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_about_text',array(
		'description' => __('<p>1. More options for about us section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for about us section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_about',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_about_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_about_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_about',
		'type'=> 'hidden'
	));

	//Our Services Section
	$wp_customize->add_section('vw_gardening_landscaping_services', array(
		'title'       => __('Our Services Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_services_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_services_text',array(
		'description' => __('<p>1. More options for Our Services section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Our Services section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_services',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_services_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_services_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_services',
		'type'=> 'hidden'
	));

	//Working Progress Section
	$wp_customize->add_section('vw_gardening_landscaping_working_progress', array(
		'title'       => __('Working Progress Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_working_progress_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_working_progress_text',array(
		'description' => __('<p>1. More options for Working Progress section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Working Progress section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_working_progress',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_working_progress_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_working_progress_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_working_progress',
		'type'=> 'hidden'
	));

	//Our Project Section
	$wp_customize->add_section('vw_gardening_landscaping_project', array(
		'title'       => __('Our Project Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_project_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_project_text',array(
		'description' => __('<p>1. More options for Our Project section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Our Project section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_project',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_project_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_project_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_project',
		'type'=> 'hidden'
	));

	//Pricing Plans Section
	$wp_customize->add_section('vw_gardening_landscaping_pricing_plans', array(
		'title'       => __('Pricing Plans Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_pricing_plans_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_pricing_plans_text',array(
		'description' => __('<p>1. More options for Pricing Plans section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Pricing Plans section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_pricing_plans',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_pricing_plans_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_pricing_plans_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_pricing_plans',
		'type'=> 'hidden'
	));

	//Products Records Section
	$wp_customize->add_section('vw_gardening_landscaping_products_record', array(
		'title'       => __('Products Records Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_products_record_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_record_text',array(
		'description' => __('<p>1. More options for Products Records section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Products Records section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_products_record',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_products_record_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_record_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_products_record',
		'type'=> 'hidden'
	));

	//Testimonials Section
	$wp_customize->add_section('vw_gardening_landscaping_testimonials', array(
		'title'       => __('Testimonials Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_testimonials_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_testimonials_text',array(
		'description' => __('<p>1. More options for Testimonials section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Testimonials section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_testimonials',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_testimonials_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_testimonials_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_testimonials',
		'type'=> 'hidden'
	));

	//Our Team Section
	$wp_customize->add_section('vw_gardening_landscaping_team', array(
		'title'       => __('Our Team Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_team_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_team_text',array(
		'description' => __('<p>1. More options for Our Team section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Our Team section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_team',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_team_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_team_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_team',
		'type'=> 'hidden'
	));

	//Why Choose Us Section
	$wp_customize->add_section('vw_gardening_landscaping_why_choose_us', array(
		'title'       => __('Why Choose Us Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_why_choose_us_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_why_choose_us_text',array(
		'description' => __('<p>1. More options for Why Choose Us section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Why Choose Us section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_why_choose_us',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_why_choose_us_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_why_choose_us_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_why_choose_us',
		'type'=> 'hidden'
	));

	//Blog Partners Section
	$wp_customize->add_section('vw_gardening_landscaping_blog_partners', array(
		'title'       => __('Blog Partners Section', 'vw-gardening-landscaping'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','vw-gardening-landscaping'),
		'priority'    => null,
		'panel'       => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_blog_partners_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_blog_partners_text',array(
		'description' => __('<p>1. More options for Blog Partners section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for Blog Partners section.</p>','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_blog_partners',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_blog_partners_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_blog_partners_btn',array(
		'description' => "<a class='go-pro' target='_blank' href=".esc_url(VW_GARDENING_LANDSCAPING_BUY_NOW).">More Info</a>",
		'section'=> 'vw_gardening_landscaping_blog_partners',
		'type'=> 'hidden'
	));

	//Footer Text
	$wp_customize->add_section('vw_gardening_landscaping_footer',array(
		'title'	=> __('Footer','vw-gardening-landscaping'),
		'description' => __('For more options of footer section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/landscaping-wordpress-theme">GET PRO</a>','vw-gardening-landscaping'),
		'panel' => 'vw_gardening_landscaping_homepage_panel',
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_footer_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new vw_gardening_landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_footer_hide_show',array(
      'label' => esc_html__( 'Show / Hide Footer','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_footer'
    )));

    // font size
	$wp_customize->add_setting('vw_gardening_landscaping_button_footer_font_size',array(
		'default'=> 25,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_footer_font_size',array(
		'label'	=> __('Footer Heading Font Size','vw-gardening-landscaping'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'vw_gardening_landscaping_footer',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_button_footer_heading_letter_spacing',array(
		'default'=> 1,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_footer_heading_letter_spacing',array(
		'label'	=> __('Heading Letter Spacing','vw-gardening-landscaping'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
	),
		'section'=> 'vw_gardening_landscaping_footer',
	));

	// text trasform
	$wp_customize->add_setting('vw_gardening_landscaping_button_footer_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_footer_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Heading Text Transform','vw-gardening-landscaping'),
		'choices' => array(
      'Uppercase' => __('Uppercase','vw-gardening-landscaping'),
      'Capitalize' => __('Capitalize','vw-gardening-landscaping'),
      'Lowercase' => __('Lowercase','vw-gardening-landscaping'),
    ),
		'section'=> 'vw_gardening_landscaping_footer',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_footer_heading_weight',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_footer_heading_weight',array(
        'type' => 'select',
        'label' => __('Heading Font Weight','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_footer',
        'choices' => array(
        	'100' => __('100','vw-gardening-landscaping'),
            '200' => __('200','vw-gardening-landscaping'),
            '300' => __('300','vw-gardening-landscaping'),
            '400' => __('400','vw-gardening-landscaping'),
            '500' => __('500','vw-gardening-landscaping'),
            '600' => __('600','vw-gardening-landscaping'),
            '700' => __('700','vw-gardening-landscaping'),
            '800' => __('800','vw-gardening-landscaping'),
            '900' => __('900','vw-gardening-landscaping'),
        ),
	) );

  $wp_customize->add_setting('vw_gardening_landscaping_footer_template',array(
      'default'	=> esc_html('vw_gardening_landscaping-footer-one'),
      'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
  ));
  $wp_customize->add_control('vw_gardening_landscaping_footer_template',array(
          'label'	=> esc_html__('Footer style','vw-gardening-landscaping'),
          'section'	=> 'vw_gardening_landscaping_footer',
          'setting'	=> 'vw_gardening_landscaping_footer_template',
          'type' => 'select',
          'choices' => array(
              'vw_gardening_landscaping-footer-one' => esc_html__('Style 1', 'vw-gardening-landscaping'),
              'vw_gardening_landscaping-footer-two' => esc_html__('Style 2', 'vw-gardening-landscaping'),
              'vw_gardening_landscaping-footer-three' => esc_html__('Style 3', 'vw-gardening-landscaping'),
              'vw_gardening_landscaping-footer-four' => esc_html__('Style 4', 'vw-gardening-landscaping'),
              'vw_gardening_landscaping-footer-five' => esc_html__('Style 5', 'vw-gardening-landscaping'),
              )
  ));

	$wp_customize->add_setting('vw_gardening_landscaping_footer_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_footer_background_color', array(
		'label'    => __('Footer Background Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_footer',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_footer_background_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'vw_gardening_landscaping_footer_background_image',array(
        'label' => __('Footer Background Image','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_footer'
	)));  

	// Footer
	$wp_customize->add_setting('vw_gardening_landscaping_img_footer',array(
		'default'=> 'scroll',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_img_footer',array(
		'type' => 'select',
		'label'	=> __('Footer Background Attatchment','vw-gardening-landscaping'),
		'choices' => array(
            'fixed' => __('fixed','vw-gardening-landscaping'),
            'scroll' => __('scroll','vw-gardening-landscaping'),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
	));

	// footer padding
	$wp_customize->add_setting('vw_gardening_landscaping_footer_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_footer_padding',array(
		'label'	=> __('Footer Top/Bottom Padding','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
    ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

     // footer social icon
  	$wp_customize->add_setting( 'vw_gardening_landscaping_footer_icon',array(
		'default' => false,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_footer_icon',array(
		'label' => esc_html__( 'Show / Hide Social Icon','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_footer'
    )));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_gardening_landscaping_footer_text', array(
		'selector' => '#footer-2 .copyright p',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_footer_text',
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_copyright_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new vw_gardening_landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_copyright_hide_show',array(
      'label' => esc_html__( 'Show / Hide Copyright','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_footer'
    )));

	$wp_customize->add_setting('vw_gardening_landscaping_copyright_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_copyright_background_color', array(
		'label'    => __('Copyright Background Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_footer',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_footer_text',array(
		'label'	=> __('Copyright Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2019, .....', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_copyright_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_copyright_font_size',array(
		'label'	=> __('Copyright Font Size','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_copyright_alignment',array(
        'default' => 'center',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Image_Radio_Control($wp_customize, 'vw_gardening_landscaping_copyright_alignment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_footer',
        'settings' => 'vw_gardening_landscaping_copyright_alignment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

	$wp_customize->add_setting( 'vw_gardening_landscaping_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','vw-gardening-landscaping' ),
      	'section' => 'vw_gardening_landscaping_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_gardening_landscaping_scroll_to_top_icon', array(
		'selector' => '.scrollup i',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_scroll_to_top_icon',
	));

    $wp_customize->add_setting('vw_gardening_landscaping_scroll_to_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_scroll_to_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_footer',
		'setting'	=> 'vw_gardening_landscaping_scroll_to_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_scroll_to_top_width',array(
		'label'	=> __('Icon Width','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_scroll_to_top_height',array(
		'label'	=> __('Icon Height','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_scroll_to_top_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Image_Radio_Control($wp_customize, 'vw_gardening_landscaping_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_footer',
        'settings' => 'vw_gardening_landscaping_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

    // footer social icon
	$wp_customize->add_setting( 'vw_gardening_landscaping_footer_icon',array(
		'default' => false,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
  	) );
	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_footer_icon',array(
		'label' => esc_html__( 'Show / Hide Footer Social Icon','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_footer'
  )));

    $wp_customize->add_setting('vw_gardening_landscaping_align_footer_social_icon',array(
        'default' => 'center',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_align_footer_social_icon',array(
        'type' => 'select',
        'label' => __('Social Icon Alignment ','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_footer',
        'choices' => array(
            'left' => __('Left','vw-gardening-landscaping'),
            'right' => __('Right','vw-gardening-landscaping'),
            'center' => __('Center','vw-gardening-landscaping'),
        ),
	) );

	$wp_customize->add_setting( 'vw_gardening_landscaping_copyright_sticky',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_copyright_sticky',array(
      'label' => esc_html__( 'Show / Hide Sticky Copyright','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_footer'
    )));

   $wp_customize->add_setting('vw_gardening_landscaping_footer_social_icons_font_size',array(
       'default'=> 16,
       'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('vw_gardening_landscaping_footer_social_icons_font_size',array(
    'label' => __('Social Icon Font Size','vw-gardening-landscaping'),
    	'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'vw_gardening_landscaping_footer',
	 ));

	//Blog Post Settings
	$wp_customize->add_panel( 'vw_gardening_landscaping_blog_post_parent_panel', array(
		'title' => esc_html__( 'Blog Post Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_panel_id',
		'priority' => 20,
	));

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'vw_gardening_landscaping_post_settings', array(
		'title' => __( 'Post Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_blog_post_parent_panel',
	));

	//Blog layout
    $wp_customize->add_setting('vw_gardening_landscaping_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
    ));
    $wp_customize->add_control(new VW_Gardening_Landscaping_Image_Radio_Control($wp_customize, 'vw_gardening_landscaping_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('vw_gardening_landscaping_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	) );
	$wp_customize->add_control('vw_gardening_landscaping_theme_options', array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','vw-gardening-landscaping'),
        'description' => __('Here you can change the sidebar layout for posts. ','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_post_settings',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-gardening-landscaping'),
            'Right Sidebar' => __('Right Sidebar','vw-gardening-landscaping'),
            'One Column' => __('One Column','vw-gardening-landscaping'),
            'Three Columns' => __('Three Columns','vw-gardening-landscaping'),
            'Four Columns' => __('Four Columns','vw-gardening-landscaping'),
            'Grid Layout' => __('Grid Layout','vw-gardening-landscaping')
        ),
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_gardening_landscaping_toggle_postdate', array(
		'selector' => '.post-main-box h2 a',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_toggle_postdate',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_toggle_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_toggle_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_post_settings',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_toggle_postdate',array(
        'label' => esc_html__( 'Show / Hide Post Date','vw-gardening-landscaping' ),
        'section' => 'vw_gardening_landscaping_post_settings'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_toggle_author_icon',array(
		'default'	=> 'far fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_toggle_author_icon',array(
		'label'	=> __('Add Author Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_post_settings',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_gardening_landscaping_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_post_settings'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_toggle_comments_icon',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_toggle_comments_icon',array(
		'label'	=> __('Add Comments Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_post_settings',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_gardening_landscaping_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_post_settings'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_toggle_time_icon',array(
		'default'	=> 'far fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_toggle_time_icon',array(
		'label'	=> __('Add Time Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_post_settings',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_gardening_landscaping_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_post_settings'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_featured_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_post_settings'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_gardening_landscaping_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Featured Image
	$wp_customize->add_setting('vw_gardening_landscaping_blog_post_featured_image_dimension',array(
	       'default' => 'default',
	       'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
	));
  	$wp_customize->add_control('vw_gardening_landscaping_blog_post_featured_image_dimension',array(
	     'type' => 'select',
	     'label'	=> __('Blog Post Featured Image Dimension','vw-gardening-landscaping'),
	     'section'	=> 'vw_gardening_landscaping_post_settings',
	     'choices' => array(
          'default' => __('Default','vw-gardening-landscaping'),
          'custom' => __('Custom Image Size','vw-gardening-landscaping'),
      ),
  	));

	$wp_customize->add_setting('vw_gardening_landscaping_blog_post_featured_image_custom_width',array(
			'default'=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
		));
	$wp_customize->add_control('vw_gardening_landscaping_blog_post_featured_image_custom_width',array(
			'label'	=> __('Featured Image Custom Width','vw-gardening-landscaping'),
			'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
			'input_attrs' => array(
	    	'placeholder' => __( '10px', 'vw-gardening-landscaping' ),),
			'section'=> 'vw_gardening_landscaping_post_settings',
			'type'=> 'text',
			'active_callback' => 'vw_gardening_landscaping_blog_post_featured_image_dimension'
		));

	$wp_customize->add_setting('vw_gardening_landscaping_blog_post_featured_image_custom_height',array(
			'default'=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_blog_post_featured_image_custom_height',array(
			'label'	=> __('Featured Image Custom Height','vw-gardening-landscaping'),
			'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
			'input_attrs' => array(
	    	'placeholder' => __( '10px', 'vw-gardening-landscaping' ),),
			'section'=> 'vw_gardening_landscaping_post_settings',
			'type'=> 'text',
			'active_callback' => 'vw_gardening_landscaping_blog_post_featured_image_dimension'
	));

    $wp_customize->add_setting( 'vw_gardening_landscaping_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_post_settings',
		'type'        => 'range',
		'settings'    => 'vw_gardening_landscaping_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-gardening-landscaping'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_post_settings',
		'type'=> 'text'
	));

    $wp_customize->add_setting('vw_gardening_landscaping_blog_page_posts_settings',array(
        'default' => 'Into Blocks',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_blog_page_posts_settings',array(
        'type' => 'select',
        'label' => __('Display Blog posts','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_post_settings',
        'choices' => array(
        	'Into Blocks' => __('Into Blocks','vw-gardening-landscaping'),
            'Without Blocks' => __('Without Blocks','vw-gardening-landscaping')
        ),
	) );

    $wp_customize->add_setting('vw_gardening_landscaping_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_post_settings',
        'choices' => array(
        	'Content' => __('Content','vw-gardening-landscaping'),
            'Excerpt' => __('Excerpt','vw-gardening-landscaping'),
            'No Content' => __('No Content','vw-gardening-landscaping')
        ),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_blog_pagination_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_blog_pagination_hide_show',array(
      'label' => esc_html__( 'Show / Hide Blog Pagination','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_post_settings'
    )));

	$wp_customize->add_setting( 'vw_gardening_landscaping_blog_pagination_type', array(
        'default'			=> 'blog-page-numbers',
        'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
    ));
    $wp_customize->add_control( 'vw_gardening_landscaping_blog_pagination_type', array(
        'section' => 'vw_gardening_landscaping_post_settings',
        'type' => 'select',
        'label' => __( 'Blog Pagination', 'vw-gardening-landscaping' ),
        'choices'		=> array(
            'blog-page-numbers'  => __( 'Numeric', 'vw-gardening-landscaping' ),
            'next-prev' => __( 'Older Posts/Newer Posts', 'vw-gardening-landscaping' ),
    )));

	// Button Settings
	$wp_customize->add_section( 'vw_gardening_landscaping_button_settings', array(
		'title' => __( 'Button Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_gardening_landscaping_button_text', array(
		'selector' => '.post-main-box .content-bttn a',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_button_text',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_button_text',array(
		'default'=> esc_html__( 'Read More', 'vw-gardening-landscaping' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_text',array(
		'label'	=> __('Add Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Read More', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_button_settings',
		'type'=> 'text'
	));

	// font size button
	$wp_customize->add_setting('vw_gardening_landscaping_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_font_size',array(
		'label'	=> __('Button Font Size','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
    ),
    'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'vw_gardening_landscaping_button_settings',
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_button_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_button_letter_spacing',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_letter_spacing',array(
		'label'	=> __('Button Letter Spacing','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
    ),
    	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'vw_gardening_landscaping_button_settings',
	));

	// text trasform
	$wp_customize->add_setting('vw_gardening_landscaping_button_text_transform',array(
		'default'=> 'Uppercase',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_button_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Button Text Transform','vw-gardening-landscaping'),
		'choices' => array(
            'Uppercase' => __('Uppercase','vw-gardening-landscaping'),
            'Capitalize' => __('Capitalize','vw-gardening-landscaping'),
            'Lowercase' => __('Lowercase','vw-gardening-landscaping'),
        ),
		'section'=> 'vw_gardening_landscaping_button_settings',
	));

	// Related Post Settings
	$wp_customize->add_section( 'vw_gardening_landscaping_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_gardening_landscaping_related_post_title', array(
		'selector' => '.related-post h3',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_related_post_title',
	));

    $wp_customize->add_setting( 'vw_gardening_landscaping_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_related_post',array(
		'label' => esc_html__( 'Related Post','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_related_posts_settings'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_related_post_title',array(
		'label'	=> __('Add Related Post Title','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('vw_gardening_landscaping_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_float'
	));
	$wp_customize->add_control('vw_gardening_landscaping_related_posts_count',array(
		'label'	=> __('Add Related Post Count','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_related_posts_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_related_posts_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_related_posts_excerpt_number', array(
		'label'       => esc_html__( 'Related Posts Excerpt length','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_related_posts_settings',
		'type'        => 'range',
		'settings'    => 'vw_gardening_landscaping_related_posts_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_gardening_landscaping_related_toggle_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
  	));
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_related_toggle_postdate',array(
	    'label' => esc_html__( 'Show / Hide Post Date','vw-gardening-landscaping' ),
	    'section' => 'vw_gardening_landscaping_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_gardening_landscaping_related_postdate_icon',array(
	    'default' => 'fas fa-calendar-alt',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_gardening_landscaping_related_postdate_icon',array(
	    'label' => __('Add Post Date Icon','vw-gardening-landscaping'),
	    'transport' => 'refresh',
	    'section' => 'vw_gardening_landscaping_related_posts_settings',
	    'setting' => 'vw_gardening_landscaping_related_postdate_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_related_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
  	));
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_related_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_gardening_landscaping_related_author_icon',array(
	    'default' => 'fas fa-user',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_gardening_landscaping_related_author_icon',array(
	    'label' => __('Add Author Icon','vw-gardening-landscaping'),
	    'transport' => 'refresh',
	    'section' => 'vw_gardening_landscaping_related_posts_settings',
	    'setting' => 'vw_gardening_landscaping_related_author_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_related_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
  	) );
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_related_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_gardening_landscaping_related_comments_icon',array(
	    'default' => 'fa fa-comments',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_gardening_landscaping_related_comments_icon',array(
	    'label' => __('Add Comments Icon','vw-gardening-landscaping'),
	    'transport' => 'refresh',
	    'section' => 'vw_gardening_landscaping_related_posts_settings',
	    'setting' => 'vw_gardening_landscaping_related_comments_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_related_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
  	) );
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_related_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_related_posts_settings'
  	)));

  	$wp_customize->add_setting('vw_gardening_landscaping_related_time_icon',array(
	    'default' => 'fas fa-clock',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
  	$wp_customize,'vw_gardening_landscaping_related_time_icon',array(
	    'label' => __('Add Time Icon','vw-gardening-landscaping'),
	    'transport' => 'refresh',
	    'section' => 'vw_gardening_landscaping_related_posts_settings',
	    'setting' => 'vw_gardening_landscaping_related_time_icon',
	    'type'    => 'icon'
  	)));

  	$wp_customize->add_setting('vw_gardening_landscaping_related_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_related_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-gardening-landscaping'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_related_posts_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_related_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	));
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_related_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_related_posts_settings'
  	)));

  	$wp_customize->add_setting( 'vw_gardening_landscaping_related_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_related_image_box_shadow', array(
		'label'       => esc_html__( 'Related post Image Box Shadow','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_related_posts_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

  	$wp_customize->add_setting('vw_gardening_landscaping_related_button_text',array(
		'default'=> esc_html__('Read More','vw-gardening-landscaping'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_related_button_text',array(
		'label'	=> esc_html__('Add Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
      'placeholder' => esc_html__( 'Read More', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_related_posts_settings',
		'type'=> 'text'
	));

	// Single Posts Settings
	$wp_customize->add_section( 'vw_gardening_landscaping_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_blog_post_parent_panel',
	));

  	$wp_customize->add_setting('vw_gardening_landscaping_single_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_single_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_single_blog_settings',
		'setting'	=> 'vw_gardening_landscaping_single_postdate_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_gardening_landscaping_single_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_postdate',array(
	    'label' => esc_html__( 'Show / Hide Date','vw-gardening-landscaping' ),
	   'section' => 'vw_gardening_landscaping_single_blog_settings'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_single_author_icon',array(
		'default'	=> 'far fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_single_author_icon',array(
		'label'	=> __('Add Author Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_single_blog_settings',
		'setting'	=> 'vw_gardening_landscaping_single_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_gardening_landscaping_single_author',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_author',array(
	    'label' => esc_html__( 'Show / Hide Author','vw-gardening-landscaping' ),
	    'section' => 'vw_gardening_landscaping_single_blog_settings'
	)));

   	$wp_customize->add_setting('vw_gardening_landscaping_single_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_single_comments_icon',array(
		'label'	=> __('Add Comments Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_single_blog_settings',
		'setting'	=> 'vw_gardening_landscaping_single_comments_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_single_comments',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_comments',array(
	    'label' => esc_html__( 'Show / Hide Comments','vw-gardening-landscaping' ),
	    'section' => 'vw_gardening_landscaping_single_blog_settings'
	)));

  	$wp_customize->add_setting('vw_gardening_landscaping_single_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_single_time_icon',array(
		'label'	=> __('Add Time Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_single_blog_settings',
		'setting'	=> 'vw_gardening_landscaping_single_time_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_single_time',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	) );
	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_time',array(
	    'label' => esc_html__( 'Show / Hide Time','vw-gardening-landscaping' ),
	    'section' => 'vw_gardening_landscaping_single_blog_settings'
	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Post Breadcrumb','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_single_blog_settings'
    )));

    // Single Posts Category
  	$wp_customize->add_setting( 'vw_gardening_landscaping_single_post_category',array(
		'default' => true,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_post_category',array(
		'label' => esc_html__( 'Show / Hide Post Category','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_single_blog_settings'
    )));

	$wp_customize->add_setting( 'vw_gardening_landscaping_toggle_tags',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_toggle_tags', array(
		'label' => esc_html__( 'Show / Hide Tags','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_single_blog_settings'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_singlepost_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_singlepost_image_box_shadow', array(
		'label'       => esc_html__( 'Single post Image Box Shadow','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_single_blog_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('vw_gardening_landscaping_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-gardening-landscaping'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_blog_post_navigation_show_hide', array(
		'label' => esc_html__( 'Show / Hide Post Navigation','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_single_blog_settings'
    )));

	//navigation text
	$wp_customize->add_setting('vw_gardening_landscaping_single_blog_prev_navigation_text',array(
		'default'=> 'PREVIOUS',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'PREVIOUS', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_single_blog_next_navigation_text',array(
		'default'=> 'NEXT',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_single_blog_comment_title',array(
		'default'=> 'Leave a Reply',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_gardening_landscaping_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Leave a Reply', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_single_blog_comment_button_text',array(
		'default'=> 'Post Comment',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_gardening_landscaping_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Post Comment', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in %. Example:50%','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '100%', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_single_blog_settings',
		'type'=> 'text'
	));

	// Grid layout setting
	$wp_customize->add_section( 'vw_gardening_landscaping_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_blog_post_parent_panel',
	));

  	$wp_customize->add_setting('vw_gardening_landscaping_grid_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_grid_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_grid_layout_settings',
		'setting'	=> 'vw_gardening_landscaping_grid_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'vw_gardening_landscaping_grid_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_grid_postdate',array(
        'label' => esc_html__( 'Show / Hide Date','vw-gardening-landscaping' ),
        'section' => 'vw_gardening_landscaping_grid_layout_settings'
    )));

	$wp_customize->add_setting('vw_gardening_landscaping_grid_author_icon',array(
		'default'	=> 'far fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_grid_author_icon',array(
		'label'	=> __('Add Author Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_grid_layout_settings',
		'setting'	=> 'vw_gardening_landscaping_grid_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_gardening_landscaping_grid_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_grid_author',array(
		'label' => esc_html__( 'Show / Hide Author','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_grid_layout_settings'
    )));

   	$wp_customize->add_setting('vw_gardening_landscaping_grid_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_grid_comments_icon',array(
		'label'	=> __('Add Comments Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_grid_layout_settings',
		'setting'	=> 'vw_gardening_landscaping_grid_comments_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'vw_gardening_landscaping_grid_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_grid_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_grid_layout_settings'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_grid_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
	));
  	$wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_grid_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_grid_layout_settings'
  	)));

 	$wp_customize->add_setting('vw_gardening_landscaping_grid_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_grid_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-gardening-landscaping'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-gardening-landscaping'),
		'section'=> 'vw_gardening_landscaping_grid_layout_settings',
		'type'=> 'text'
	)); 

  	$wp_customize->add_setting('vw_gardening_landscaping_display_grid_posts_settings',array(
	    'default' => 'Into Blocks',
	    'transport' => 'refresh',
	    'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_display_grid_posts_settings',array(
	    'type' => 'select',
	    'label' => __('Display Grid Posts','vw-gardening-landscaping'),
	    'section' => 'vw_gardening_landscaping_grid_layout_settings',
	    'choices' => array(
	    	'Into Blocks' => __('Into Blocks','vw-gardening-landscaping'),
	      	'Without Blocks' => __('Without Blocks','vw-gardening-landscaping')
      	),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_grid_button_text',array(
		'default'=> esc_html__('Read More','vw-gardening-landscaping'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_grid_button_text',array(
		'label'	=> esc_html__('Add Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
        'placeholder' => esc_html__( 'Read More', 'vw-gardening-landscaping' ),
      ),
		'section'=> 'vw_gardening_landscaping_grid_layout_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_grid_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_grid_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_grid_layout_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_grid_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_grid_excerpt_settings',array(
        'type' => 'select',
        'label' => esc_html__('Grid Post Content','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_grid_layout_settings',
        'choices' => array(
        	'Content' => esc_html__('Content','vw-gardening-landscaping'),
            'Excerpt' => esc_html__('Excerpt','vw-gardening-landscaping'),
            'No Content' => esc_html__('No Content','vw-gardening-landscaping')
        ),
	) );

	$wp_customize->add_setting( 'vw_gardening_landscaping_grid_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_grid_featured_image_border_radius', array(
		'label'       => esc_html__( 'Grid Featured Image Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_gardening_landscaping_grid_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_grid_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Grid Featured Image Box Shadow','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Others Settings
	$wp_customize->add_panel( 'vw_gardening_landscaping_others_panel', array(
		'title' => esc_html__( 'Others Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_panel_id',
		'priority' => 20,
	));

	// Layout
	$wp_customize->add_section( 'vw_gardening_landscaping_left_right', array(
    	'title' => esc_html__( 'General Settings', 'vw-gardening-landscaping' ),
		'panel' => 'vw_gardening_landscaping_others_panel',
		'priority' => 1,
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Image_Radio_Control($wp_customize, 'vw_gardening_landscaping_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','vw-gardening-landscaping'),
        'description' => __('Here you can change the width layout of Website.','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('vw_gardening_landscaping_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','vw-gardening-landscaping'),
        'description' => __('Here you can change the sidebar layout for pages. ','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-gardening-landscaping'),
            'Right Sidebar' => __('Right Sidebar','vw-gardening-landscaping'),
            'One Column' => __('One Column','vw-gardening-landscaping')
        ),
	) );

	$wp_customize->add_setting( 'vw_gardening_landscaping_single_page_breadcrumb',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_single_page_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Page Breadcrumb','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_left_right'
    )));

	//Wow Animation
	$wp_customize->add_setting( 'vw_gardening_landscaping_animation',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_animation',array(
        'label' => esc_html__( 'Show / Hide Animation ','vw-gardening-landscaping' ),
        'description' => __('Here you can disable overall site animation effect','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_left_right'
    )));

	//Pre-Loader
	$wp_customize->add_setting( 'vw_gardening_landscaping_loader_enable',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_loader_enable',array(
        'label' => esc_html__( 'Show / Hide Pre-Loader','vw-gardening-landscaping' ),
        'section' => 'vw_gardening_landscaping_left_right'
    )));

	$wp_customize->add_setting('vw_gardening_landscaping_preloader_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_left_right',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_preloader_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_left_right',
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_preloader_bg_img',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'vw_gardening_landscaping_preloader_bg_img',array(
        'label' => __('Preloader Background Image','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_left_right'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_bradcrumbs_alignment',array(
        'default' => 'Left',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_bradcrumbs_alignment',array(
        'type' => 'select',
        'label' => __('Bradcrumbs Alignment','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_left_right',
        'choices' => array(
            'Left' => __('Left','vw-gardening-landscaping'),
            'Right' => __('Right','vw-gardening-landscaping'),
            'Center' => __('Center','vw-gardening-landscaping'),
        ),
	) );

    //404 Page Setting
	$wp_customize->add_section('vw_gardening_landscaping_404_page',array(
		'title'	=> __('404 Page Settings','vw-gardening-landscaping'),
		'panel' => 'vw_gardening_landscaping_others_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_gardening_landscaping_404_page_title',array(
		'label'	=> __('Add Title','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_gardening_landscaping_404_page_content',array(
		'label'	=> __('Add Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_404_page_button_text',array(
		'label'	=> __('Add Button Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Return to the home page', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_404_page',
		'type'=> 'text'
	));

	//No Result Page Setting
	$wp_customize->add_section('vw_gardening_landscaping_no_results_page',array(
		'title'	=> __('No Results Page Settings','vw-gardening-landscaping'),
		'panel' => 'vw_gardening_landscaping_others_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_gardening_landscaping_no_results_page_title',array(
		'label'	=> __('Add Title','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_gardening_landscaping_no_results_page_content',array(
		'label'	=> __('Add Text','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_no_results_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('vw_gardening_landscaping_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','vw-gardening-landscaping'),
		'panel' => 'vw_gardening_landscaping_others_panel',
	));

	$wp_customize->add_setting('vw_gardening_landscaping_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_social_icon_padding',array(
		'label'	=> __('Icon Padding','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_social_icon_width',array(
		'label'	=> __('Icon Width','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_social_icon_height',array(
		'label'	=> __('Icon Height','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_social_icon_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('vw_gardening_landscaping_responsive_media',array(
		'title'	=> __('Responsive Media','vw-gardening-landscaping'),
		'panel' => 'vw_gardening_landscaping_others_panel',
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_resp_topbar_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_resp_topbar_hide_show',array(
		'label' => esc_html__( 'Show / Hide Topbar','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_stickyheader_hide_show',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_stickyheader_hide_show',array(
		'label' => esc_html__( 'Sticky Header','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_resp_slider_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_gardening_landscaping_responsive_preloader_hide',array(
        'default' => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_responsive_preloader_hide',array(
        'label' => esc_html__( 'Show / Hide Preloader','vw-gardening-landscaping' ),
        'section' => 'vw_gardening_landscaping_responsive_media'
    )));

     $wp_customize->add_setting( 'vw_gardening_landscaping_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','vw-gardening-landscaping' ),
      'section' => 'vw_gardening_landscaping_responsive_media'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_res_menu_open_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_res_menu_open_icon',array(
		'label'	=> __('Add Open Menu Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_responsive_media',
		'setting'	=> 'vw_gardening_landscaping_res_menu_open_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_res_close_menus_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new VW_Gardening_Landscaping_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_gardening_landscaping_res_close_menus_icon',array(
		'label'	=> __('Add Close Menu Icon','vw-gardening-landscaping'),
		'transport' => 'refresh',
		'section'	=> 'vw_gardening_landscaping_responsive_media',
		'setting'	=> 'vw_gardening_landscaping_res_close_menus_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_gardening_landscaping_resp_menu_toggle_btn_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_gardening_landscaping_resp_menu_toggle_btn_bg_color', array(
		'label'    => __('Toggle Button Bg Color', 'vw-gardening-landscaping'),
		'section'  => 'vw_gardening_landscaping_responsive_media',
	)));

    //Woocommerce settings
	$wp_customize->add_section('vw_gardening_landscaping_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'vw-gardening-landscaping'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_gardening_landscaping_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_woocommerce_shop_page_sidebar', ) );

	//Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'vw_gardening_landscaping_woocommerce_shop_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_woocommerce_section'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_shop_page_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_shop_page_layout',array(
        'type' => 'select',
        'label' => __('Shop Page Sidebar Layout','vw-gardening-landscaping'),
        'description' => __('Here you can change the sidebar layout for pages. ','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-gardening-landscaping'),
            'Right Sidebar' => __('Right Sidebar','vw-gardening-landscaping'),
        ),
	) );

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_gardening_landscaping_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product #sidebar',
		'render_callback' => 'vw_gardening_landscaping_customize_partial_vw_gardening_landscaping_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'vw_gardening_landscaping_woocommerce_single_product_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Product Sidebar','vw-gardening-landscaping' ),
		'section' => 'vw_gardening_landscaping_woocommerce_section'
    )));

    $wp_customize->add_setting('vw_gardening_landscaping_single_product_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_single_product_layout',array(
        'type' => 'select',
        'label' => __('Single Product Sidebar Layout','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-gardening-landscaping'),
            'Right Sidebar' => __('Right Sidebar','vw-gardening-landscaping'),
        ),
	) );

    //Products per page
    $wp_customize->add_setting('vw_gardening_landscaping_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_float'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_per_page',array(
		'label'	=> __('Products Per Page','vw-gardening-landscaping'),
		'description' => __('Display on shop page','vw-gardening-landscaping'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('vw_gardening_landscaping_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_per_row',array(
		'label'	=> __('Products Per Row','vw-gardening-landscaping'),
		'description' => __('Display on shop page','vw-gardening-landscaping'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('vw_gardening_landscaping_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'vw_gardening_landscaping_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'vw_gardening_landscaping_products_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_products_button_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_products_button_border_radius', array(
		'label'       => esc_html__( 'Products Button Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products Sale Badge
	$wp_customize->add_setting('vw_gardening_landscaping_woocommerce_sale_position',array(
        'default' => 'right',
        'sanitize_callback' => 'vw_gardening_landscaping_sanitize_choices'
	));
	$wp_customize->add_control('vw_gardening_landscaping_woocommerce_sale_position',array(
        'type' => 'select',
        'label' => __('Sale Badge Position','vw-gardening-landscaping'),
        'section' => 'vw_gardening_landscaping_woocommerce_section',
        'choices' => array(
            'left' => __('Left','vw-gardening-landscaping'),
            'right' => __('Right','vw-gardening-landscaping'),
        ),
	) );

	$wp_customize->add_setting('vw_gardening_landscaping_woocommerce_sale_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_woocommerce_sale_font_size',array(
		'label'	=> __('Sale Font Size','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_gardening_landscaping_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_gardening_landscaping_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','vw-gardening-landscaping'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-gardening-landscaping'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-gardening-landscaping' ),
        ),
		'section'=> 'vw_gardening_landscaping_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_gardening_landscaping_woocommerce_sale_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_gardening_landscaping_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_gardening_landscaping_woocommerce_sale_border_radius', array(
		'label'       => esc_html__( 'Sale Border Radius','vw-gardening-landscaping' ),
		'section'     => 'vw_gardening_landscaping_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    //Related Products
	$wp_customize->add_setting( 'vw_gardening_landscaping_related_product_show_hide',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_gardening_landscaping_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Gardening_Landscaping_Toggle_Switch_Custom_Control( $wp_customize, 'vw_gardening_landscaping_related_product_show_hide',array(
        'label' => esc_html__( 'Show / Hide Related product','vw-gardening-landscaping' ),
        'section' => 'vw_gardening_landscaping_woocommerce_section'
    )));

    // Has to be at the top
	$wp_customize->register_panel_type( 'VW_Gardening_Landscaping_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'VW_Gardening_Landscaping_WP_Customize_Section' );
}

add_action( 'customize_register', 'vw_gardening_landscaping_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class VW_Gardening_Landscaping_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'vw_gardening_landscaping_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class VW_Gardening_Landscaping_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'vw_gardening_landscaping_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function vw_gardening_landscaping_customize_controls_scripts() {
  wp_enqueue_script( 'customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'vw_gardening_landscaping_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class VW_Gardening_Landscaping_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'VW_Gardening_Landscaping_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(new VW_Gardening_Landscaping_Customize_Section_Pro($manager,'vw_gardening_landscaping_upgrade_pro_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'VW Gardening Pro', 'vw-gardening-landscaping' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'vw-gardening-landscaping' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/products/landscaping-wordpress-theme'),
		)));

		$manager->add_section(new VW_Gardening_Landscaping_Customize_Section_Pro($manager,'vw_gardening_landscaping_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'vw-gardening-landscaping' ),
			'pro_text' => esc_html__( 'DOCS', 'vw-gardening-landscaping' ),
			'pro_url'  => esc_url('https://preview.vwthemesdemo.com/docs/free-vw-gardening-landscaping/'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'vw-gardening-landscaping-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'vw-gardening-landscaping-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
VW_Gardening_Landscaping_Customize::get_instance();
