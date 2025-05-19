<?php

function brutalist_portfolio_enqueue_styles_scripts() {
  // AOS CSS
  wp_enqueue_style('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css', array(), null);
  // AOS JS
  wp_enqueue_script('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', array(), null, true);

  // (Removed default style.css enqueue, using compiled CSS instead)

  // Enqueue jQuery (bundled with WordPress)
  wp_enqueue_script('jquery');

  // Main JS file
  wp_enqueue_script('brutalist-main', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true);

  // Jobs Accordion JS (load in footer)
  wp_enqueue_script('jobs-accordion', get_template_directory_uri() . '/js/jobs-accordion.js', array('jquery'), null, true);

  // Custom Gutenberg block JS (if needed)
  wp_enqueue_script('brutalist-blocks', get_template_directory_uri() . '/js/custom-blocks.js', array('wp-blocks', 'wp-element', 'wp-editor', 'jquery'), null, true);

  // (Removed block style enqueue, not needed unless you have custom block CSS)
}

add_action('wp_enqueue_scripts', 'brutalist_portfolio_enqueue_styles_scripts');

function brutalist_portfolio_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');
  register_nav_menus([
    'primary' => __('Primary Menu', 'brutalist-portfolio'),
  ]);
}
add_action('after_setup_theme', 'brutalist_portfolio_setup');

function brutalist_portfolio_enqueue_assets() {
    wp_enqueue_style('brutalist-portfolio-style', get_template_directory_uri() . '/build/css/style.min.css', array(), null);
    wp_enqueue_script('theme-main', get_template_directory_uri() . '/build/js/main.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'brutalist_portfolio_enqueue_assets');

// Register and enqueue hero-blob block editor.js for Gutenberg
function brutalist_portfolio_register_block_editor_assets() {
    $block_path = get_template_directory_uri() . '/blocks/hero-blob/editor.js';
    wp_register_script(
        'brutalist-portfolio-hero-blob-editor',
        $block_path,
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n', 'wp-block-editor' ),
        filemtime( get_template_directory() . '/blocks/hero-blob/editor.js' )
    );
}
add_action( 'init', 'brutalist_portfolio_register_block_editor_assets' );

function register_native_hero_blob_block() {
    register_block_type_from_metadata(
        __DIR__ . '/blocks/hero-blob',
        array(
            'editor_script' => 'brutalist-portfolio-hero-blob-editor'
        )
    );
}
add_action( 'init', 'register_native_hero_blob_block' );

// Register 'job' custom post type
function register_job_post_type() {
    $labels = array(
        'name' => __('Jobs'),
        'singular_name' => __('Job'),
        'menu_name' => __('Jobs'),
        'name_admin_bar' => __('Job'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Job'),
        'edit_item' => __('Edit Job'),
        'new_item' => __('New Job'),
        'view_item' => __('View Job'),
        'search_items' => __('Search Jobs'),
        'not_found' => __('No jobs found'),
        'not_found_in_trash' => __('No jobs found in Trash'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => false,
        'rewrite' => array('slug' => 'jobs'),
        'show_in_rest' => true,
    );
    register_post_type('job', $args);
}
add_action('init', 'register_job_post_type');

