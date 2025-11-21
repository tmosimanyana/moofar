<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Load theme textdomain
function moofar_fse_setup() {
    load_theme_textdomain( 'moofar-fse', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'moofar_fse_setup' );

// Enqueue frontend styles
function moofar_fse_enqueue_assets() {
    wp_enqueue_style( 'moofar-fse-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'moofar_fse_enqueue_assets' );

// Register custom post types: Service, Project
function moofar_fse_register_cpts() {
    // Services
    register_post_type('service', array(
        'labels' => array(
            'name' => __('Services', 'moofar-fse'),
            'singular_name' => __('Service', 'moofar-fse')
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array('title','editor','thumbnail','excerpt'),
        'menu_icon' => 'dashicons-hammer',
        'rewrite' => array('slug' => 'services')
    ));

    // Projects
    register_post_type('project', array(
        'labels' => array(
            'name' => __('Projects', 'moofar-fse'),
            'singular_name' => __('Project', 'moofar-fse')
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array('title','editor','thumbnail','excerpt'),
        'menu_icon' => 'dashicons-portfolio',
        'rewrite' => array('slug' => 'projects')
    ));
}
add_action('init', 'moofar_fse_register_cpts');

// Auto-register all block patterns
function moofar_fse_register_patterns() {
    $pattern_dir = get_template_directory() . '/patterns';
    if ( ! is_dir($pattern_dir) ) return;
    foreach (glob($pattern_dir.'/*.php') as $file) {
        register_block_pattern_from_file($file);
    }
}
add_action('init', 'moofar_fse_register_patterns');
?>
