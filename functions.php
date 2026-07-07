<?php

function brutalist_portfolio_enqueue_styles_scripts() {
  wp_enqueue_style('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css', array(), null);
  wp_enqueue_script('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', array(), null, true);

  wp_enqueue_script('jquery');

  wp_enqueue_script('jobs-accordion', get_template_directory_uri() . '/js/jobs-accordion.js', array('jquery'), null, true);

  wp_enqueue_script('brutalist-blocks', get_template_directory_uri() . '/js/custom-blocks.js', array('wp-blocks', 'wp-element', 'wp-editor', 'jquery'), null, true);
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
    wp_enqueue_style(
        'brutalist-portfolio-style',
        get_template_directory_uri() . '/build/css/style.min.css',
        array('aos'),
        filemtime(get_template_directory() . '/build/css/style.min.css')
    );

    wp_enqueue_script(
        'theme-main',
        get_template_directory_uri() . '/build/js/main.min.js',
        array('jquery', 'aos'),
        filemtime(get_template_directory() . '/build/js/main.min.js'),
        true
    );
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

function theme_file_ver($file_path) {
    return file_exists($file_path) ? filemtime($file_path) : null;
}

/* ---------------------------------
 * Block: brutalist-portfolio/vertical-showcase
 * --------------------------------- */
add_action('init', function () {
    $block_dir_fs  = trailingslashit(get_stylesheet_directory()) . 'blocks/vertical-showcase/';
    $block_dir_uri = trailingslashit(get_stylesheet_directory_uri()) . 'blocks/vertical-showcase/';

    $block_json_fs = $block_dir_fs . 'block.json';

    if (!file_exists($block_json_fs)) {
        error_log('[blocks] vertical-showcase block.json not found at ' . $block_json_fs);
        return;
    }

    $editor_fs = $block_dir_fs . 'editor.js';

    if (file_exists($editor_fs)) {
        wp_register_script(
            'theme-vertical-showcase-editor',
            $block_dir_uri . 'editor.js',
            ['wp-blocks', 'wp-element', 'wp-i18n', 'wp-block-editor', 'wp-components', 'wp-data'],
            theme_file_ver($editor_fs),
            true
        );
    }

    $script_fs = $block_dir_fs . 'script.js';

    if (file_exists($script_fs)) {
        wp_register_script(
            'theme-vertical-showcase-script',
            $block_dir_uri . 'script.js',
            ['jquery'],
            theme_file_ver($script_fs),
            true
        );
    }

    $style_fs = $block_dir_fs . 'style.css';

    if (file_exists($style_fs)) {
        wp_register_style(
            'theme-vertical-showcase-style',
            $block_dir_uri . 'style.css',
            [],
            theme_file_ver($style_fs)
        );
    }

    $registry = WP_Block_Type_Registry::get_instance();

    if ($registry->is_registered('brutalist-portfolio/vertical-showcase')) {
        return;
    }

    register_block_type_from_metadata($block_dir_fs);
});

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

add_action('wp_head', function () { ?>
  <noscript>
    <style>
      /* If JS is off, never hide AOS elements */
      [data-aos] { opacity: 1 !important; transform: none !important; }

      /* Accordion relies on JS toggling [hidden], reveal bodies without JS */
      .js-job-card-body[hidden] { display: block !important; }

      /* Remove any transitions that assume JS */
      .projects-list [data-aos], .jobs-section [data-aos] { transition: none !important; }
    </style>
  </noscript>
<?php });

/* Vertical showcase CPT for vertical slider block */
add_action('init', function () {
    register_post_type('showcase_slide', [
        'labels' => [
            'name' => 'Showcase Slides',
            'singular_name' => 'Showcase Slide',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-slides',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'show_in_rest' => true,
    ]);
});

add_action('init', function () {
    register_taxonomy('showcase_group', ['showcase_slide'], [
        'labels' => [
            'name' => 'Showcase Groups',
            'singular_name' => 'Showcase Group',
        ],
        'public' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'hierarchical' => false,
        'rewrite' => false,
    ]);
});

/* Block styles */
add_action('init', function(){
    register_block_style('core/columns', [
        'name' => 'motion-cards',
        'label' => __('Motion Cards', 'brutalist-portfolio'),
    ]);

    register_block_style('core/paragraph', [
        'name' => 'aos-fade-up',
        'label' => __('AOS Fade Up', 'brutalist-portfolio'),
    ]);
});

/* Design Overrides */
wp_enqueue_style(
    'brutalist-portfolio-overrides',
    get_template_directory_uri() . '/css/overrides.css',
    array('brutalist-portfolio-style'),
    filemtime(get_template_directory() . '/css/overrides.css')
);