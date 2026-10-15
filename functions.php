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
define( 'RIGXMOD_VERSION', '1.0.4' );
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

/**
 * DDU (Delivered Duty Unpaid) notice for the WooCommerce Blocks checkout.
 * Duties, taxes and customs clearance charges are the buyer's responsibility.
 * Written in English; other languages are served automatically by GTranslate.
 */
function rigxmod_ddu_notice_html() {
    return '<div class="rigxmod-ddu-notice" style="background:#fdf0f1;border:1px solid #E31937;border-left:4px solid #E31937;border-radius:4px;padding:12px 14px;margin:0 0 20px;font-size:13px;line-height:1.6;color:#333;">'
        . '<strong style="color:#B3121D;">' . esc_html__( 'Important - Customs, Duties and Taxes (DDU):', 'rigxmod-autozone' ) . '</strong> '
        . esc_html__( 'All prices, shipping fees and order totals shown exclude import duties, taxes and customs clearance charges levied by the destination country. These charges are the buyer\'s responsibility and must be paid directly to the customs authority or the carrier. We ship DDU (Delivered Duty Unpaid). Please check with your local customs office before placing your order.', 'rigxmod-autozone' )
        . '</div>';
}

function rigxmod_ddu_notice_block( $block_content, $block ) {
    if ( is_admin() ) {
        return $block_content;
    }
    if ( isset( $block['blockName'] ) && 'woocommerce/checkout' === $block['blockName'] ) {
        return rigxmod_ddu_notice_html() . $block_content;
    }
    return $block_content;
}
add_filter( 'render_block', 'rigxmod_ddu_notice_block', 10, 2 );

/**
 * Fix GTranslate mistranslation: "Zongheng" (纵横, zònghéng) is translated as 宗恒 (zōnghéng).
 * Runs after GTranslate replaces text and on any subsequent DOM mutations.
 */
function rigxmod_fix_zongheng_translation() {
    ?>
    <script>
    (function () {
        var FIX = { '宗恒': '纵横' };
        function walk(nodes) {
            for (var i = 0; i < nodes.length; i++) {
                var n = nodes[i];
                if (n.nodeType === 3) {
                    var v = n.nodeValue;
                    if (v.indexOf('宗恒') > -1) {
                        n.nodeValue = v.replace(/宗恒/g, '纵横');
                    }
                } else if (n.nodeType === 1 && n.childNodes && n.childNodes.length) {
                    walk(n.childNodes);
                }
            }
        }
        walk(document.body.childNodes);
        var timer;
        var mo = new MutationObserver(function (muts) {
            if (timer) return;
            timer = setTimeout(function () {
                timer = null;
                for (var k = 0; k < m.length; k++) {
                    if (m[k].addedNodes && m[k].addedNodes.length) walk(m[k].addedNodes);
                    if (m[k].target && m[k].target.nodeType === 3) walk([m[k].target]);
                }
            }, 120);
        });
        mo.observe(document.body, { childList: true, characterData: true, subtree: true });
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'rigxmod_fix_zongheng_translation', 99 );

/**
 * Cart partial selection (Taobao-style): select some items to checkout,
 * keep the rest in the cart. Unselected items are stashed during checkout
 * and automatically restored when the shopper returns to the cart.
 */
function rigxmod_cart_partial_selection_assets() {
    // is_cart() can return false when the cart uses the WooCommerce Cart block,
    // so load site-wide and let the JS bail out when no cart rows are present.
    ?>
    <style>
        .rigx-cart-check { width: 18px; height: 18px; cursor: pointer; }
        .rigx-select-all-cell { text-align: center; width: 40px; }
        .rigx-cart-check-cell { text-align: center; vertical-align: middle; }
        .rigx-selected-count { font-weight: 700; color: var(--rm-primary, #E31937); }
        .rigx-checkout-selected { margin-left: 12px; }
    </style>
    <script>
    (function () {
        var ajaxUrl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
        var nonce   = '<?php echo esc_js( wp_create_nonce( 'rigxmod_cart_select' ) ); ?>';
        var proceed = document.querySelector('a.checkout-button');
        if (!proceed) return;

        var rows = document.querySelectorAll('tr.cart_item');
        if (!rows.length) return;

        // Add a column header for the checkbox
        var headRow = document.querySelector('.shop_table thead tr');
        if (headRow) {
            var th = document.createElement('th');
            th.className = 'rigx-select-all-cell';
            th.innerHTML = '<input type="checkbox" class="rigx-cart-check rigx-select-all" checked title="Select all">';
            headRow.insertBefore(th, headRow.firstChild);
        }

        // Add a checkbox to each row
        rows.forEach(function (row) {
            var td = document.createElement('td');
            td.className = 'rigx-cart-check-cell';
            var key = row.getAttribute('data-key') || '';
            td.innerHTML = '<input type="checkbox" class="rigx-cart-check rigx-row-check" data-key="' + key + '" checked>';
            row.insertBefore(td, row.firstChild);
        });

        // Select-all toggle
        var selectAll = document.querySelector('.rigx-select-all');
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                document.querySelectorAll('.rigx-row-check').forEach(function (cb) {
                    cb.checked = selectAll.checked;
                });
                updateButton();
            });
        }
        document.querySelectorAll('.rigx-row-check').forEach(function (cb) {
            cb.addEventListener('change', updateButton);
        });

        function selectedKeys() {
            return Array.prototype.slice.call(document.querySelectorAll('.rigx-row-check:checked'))
                .map(function (cb) { return cb.getAttribute('data-key'); })
                .filter(Boolean);
        }

        function updateButton() {
            var keys = selectedKeys();
            var label = '<?php echo esc_js( __( 'Checkout', 'rigxmod-autozone' ) ); ?>';
            proceed.textContent = keys.length
                ? label + ' (' + keys.length + ')'
                : '<?php echo esc_js( __( 'Select items to checkout', 'rigxmod-autozone' ) ); ?>';
            proceed.style.pointerEvents = keys.length ? 'auto' : 'none';
            proceed.style.opacity = keys.length ? '1' : '0.5';
        }
        updateButton();

        // Override checkout click: stash unselected, then go to checkout
        proceed.addEventListener('click', function (e) {
            var keys = selectedKeys();
            if (!keys.length) { e.preventDefault(); return; }
            e.preventDefault();
            var fd = new FormData();
            fd.append('action', 'rigxmod_checkout_selected');
            fd.append('nonce', nonce);
            fd.append('keys', JSON.stringify(keys));
            proceed.textContent = '<?php echo esc_js( __( 'Loading...', 'rigxmod-autozone' ) ); ?>';
            fetch(ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data && data.success && data.data && data.data.checkout_url) {
                        window.location.href = data.data.checkout_url;
                    } else {
                        window.location.href = proceed.getAttribute('href');
                    }
                })
                .catch(function () { window.location.href = proceed.getAttribute('href'); });
        });
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'rigxmod_cart_partial_selection_assets', 99 );

// AJAX: stash unselected cart items and return checkout URL
function rigxmod_ajax_checkout_selected() {
    check_ajax_referer( 'rigxmod_cart_select', 'nonce' );

    $selected = json_decode( wp_unslash( $_POST['keys'] ?? '[]' ), true );
    if ( ! is_array( $selected ) ) {
        $selected = array();
    }
    $selected = array_flip( $selected );

    $cart = WC()->cart;
    $stashed = array();

    foreach ( $cart->get_cart() as $cart_item_key => $item ) {
        if ( ! isset( $selected[ $cart_item_key ] ) ) {
            $stashed[ $cart_item_key ] = $item;
        }
    }

    // Store stashed items in session, then remove from active cart
    WC()->session->set( 'rigxmod_stashed_cart', $stashed );
    foreach ( array_keys( $stashed ) as $k ) {
        $cart->remove_cart_item( $k );
    }
    $cart->calculate_totals();

    wp_send_json_success( array( 'checkout_url' => wc_get_checkout_url() ) );
}
add_action( 'wp_ajax_rigxmod_checkout_selected', 'rigxmod_ajax_checkout_selected' );
add_action( 'wp_ajax_nopriv_rigxmod_checkout_selected', 'rigxmod_ajax_checkout_selected' );

// Restore stashed items when the shopper returns to the cart
function rigxmod_restore_stashed_cart() {
    if ( is_cart() && ! empty( WC()->session ) ) {
        $stashed = WC()->session->get( 'rigxmod_stashed_cart', array() );
        if ( ! empty( $stashed ) ) {
            foreach ( $stashed as $cart_item_key => $item ) {
                if ( ! WC()->cart->get_cart_item( $cart_item_key ) ) {
                    WC()->cart->add_to_cart(
                        $item['product_id'],
                        $item['quantity'],
                        $item['variation_id'] ?? 0,
                        $item['variation'] ?? array(),
                        $item
                    );
                }
            }
            WC()->session->set( 'rigxmod_stashed_cart', array() );
        }
    }
}
add_action( 'template_redirect', 'rigxmod_restore_stashed_cart', 20 );
