<?php
/**
 * RIGX MOD AutoZone theme functions and definitions
 *
 * @package RIGXMOD_AutoZone
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Theme version
define( 'RIGXMOD_VERSION', '1.0.2' );
define( 'RIGXMOD_DIR', get_template_directory() );
define( 'RIGXMOD_URI', get_template_directory_uri() );

/**
 * Theme setup
 */
function rigxmod_theme_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'rigxmod-autozone', RIGXMOD_DIR . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus.
    register_nav_menus( array(
        'primary'   => esc_html__( 'Primary Menu', 'rigxmod-autozone' ),
        'category'  => esc_html__( 'Category Menu', 'rigxmod-autozone' ),
        'footer'    => esc_html__( 'Footer Menu', 'rigxmod-autozone' ),
    ) );

    // Switch default core markup to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for responsive embedded content.
    add_theme_support( 'responsive-embeds' );

    // Add support for align-wide and align-full.
    add_theme_support( 'align-wide' );

    // WooCommerce support.
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Custom image sizes
    add_image_size( 'rigxmod-product', 600, 600, true );
    add_image_size( 'rigxmod-product-thumb', 120, 120, true );
    add_image_size( 'rigxmod-blog', 800, 500, true );
}
add_action( 'after_setup_theme', 'rigxmod_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function rigxmod_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'rigxmod_content_width', 1200 );
}
add_action( 'after_setup_theme', 'rigxmod_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function rigxmod_scripts() {
    // Main stylesheet
    wp_enqueue_style( 'rigxmod-style', RIGXMOD_URI . '/style.css', array(), RIGXMOD_VERSION );

    // Font Awesome (for icons)
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1' );

    // Main JS
    wp_enqueue_script( 'rigxmod-main', RIGXMOD_URI . '/js/main.js', array( 'jquery' ), RIGXMOD_VERSION, true );

    // Localize script for AJAX
    wp_localize_script( 'rigxmod-main', 'rigxmod_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'rigxmod_nonce' ),
    ) );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'rigxmod_scripts' );

/**
 * Register widget areas.
 */
function rigxmod_widgets_init() {
    // Footer widgets
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', 'rigxmod-autozone' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here.', 'rigxmod-autozone' ),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', 'rigxmod-autozone' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here.', 'rigxmod-autozone' ),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3', 'rigxmod-autozone' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here.', 'rigxmod-autozone' ),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    // Shop sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'Shop Sidebar', 'rigxmod-autozone' ),
        'id'            => 'shop-sidebar',
        'description'   => esc_html__( 'Shop page sidebar widgets.', 'rigxmod-autozone' ),
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="sidebar-widget-title">',
        'after_title'   => '</div>',
    ) );
}
add_action( 'widgets_init', 'rigxmod_widgets_init' );

/**
 * Custom template tags for this theme.
 */
require RIGXMOD_DIR . '/inc/template-tags.php';

/**
 * WooCommerce customizations.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require RIGXMOD_DIR . '/inc/woocommerce.php';
}

/**
 * Customizer additions.
 */
require RIGXMOD_DIR . '/inc/customizer.php';

/**
 * Add body classes.
 */
function rigxmod_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class for WooCommerce pages.
    if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product_tag() || is_product() ) ) {
        $classes[] = 'woocommerce-page';
    }

    return $classes;
}
add_filter( 'body_class', 'rigxmod_body_classes' );

/**
 * Custom excerpt length.
 */
function rigxmod_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'rigxmod_excerpt_length', 999 );

/**
 * Custom excerpt "more" link.
 */
function rigxmod_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'rigxmod_excerpt_more' );

/**
 * Change number of products per row.
 */
function rigxmod_loop_columns() {
    return 4;
}
add_filter( 'loop_shop_columns', 'rigxmod_loop_columns' );

/**
 * Change number of related products.
 */
function rigxmod_related_products_args( $args ) {
    $args['posts_per_page'] = 4;
    $args['columns']        = 4;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'rigxmod_related_products_args' );

/**
 * Remove WooCommerce sidebar (we use our own layout).
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
