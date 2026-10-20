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
define( 'RIGXMOD_VERSION', '1.1.2' );
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
 * Force English as the default site language for GTranslate.
 * The plugin's "detect browser language" option causes the site to render
 * in Chinese for visitors whose browser is zh-CN. We hard-disable that flag
 * at read time so even if it is re-enabled in wp-admin it stays off.
 */
add_filter( 'option_gtranslate', 'rigxmod_gtranslate_force_default_en' );
function rigxmod_gtranslate_force_default_en( $g ) {
    if ( is_array( $g ) ) {
        $g['detect_browser_language'] = '';
        $g['default_language']        = 'en';
    }
    return $g;
}

/**
 * Aliyun DirectMail SMTP — hard-configure wp_mail so order notifications,
 * password resets and registration confirmations actually reach users.
 *
 * Credentials (provided by user, DirectMail "Trigger Mail" sender):
 *   Host:       smtpdm.aliyun.com
 *   Port:       465
 *   Security:   SSL (PHPMailer::ENCRYPTION_SMTPS)
 *   Username:   sales@mail.rigxmod.com
 *   Password:   set via DirectMail console — "设置 SMTP 密码"
 *
 * Reply-To is kept as sales@rigxmod.com so customers replying to order
 * mails land in a mailbox the team actually reads.
 */
add_action( 'phpmailer_init', 'rigxmod_configure_smtp' );
function rigxmod_configure_smtp( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtpdm.aliyun.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Username   = 'sales@mail.rigxmod.com';
    $phpmailer->Password   = 'RIGXMODsmtp2026';
    $phpmailer->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
    $phpmailer->Port       = 465;
    $phpmailer->Timeout    = 20;
}

// Default "From" for all wp_mail() calls.
add_filter( 'wp_mail_from', function ( $from ) { return 'sales@mail.rigxmod.com'; } );
add_filter( 'wp_mail_from_name', function ( $name ) { return 'RIGX MOD'; } );

// WooCommerce overrides (stops using the placeholder admin@exmaple.com).
add_filter( 'woocommerce_email_from_address', function ( $addr ) { return 'sales@mail.rigxmod.com'; } );
add_filter( 'woocommerce_email_from_name', function ( $name ) { return 'RIGX MOD'; } );
add_filter( 'woocommerce_email_reply_to_addresses', function ( $addrs ) {
    return array( 'sales@rigxmod.com' );
} );

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
        // GTranslate mistranslation overrides (machine translation cannot be configured on the free plan)
        var FIX = [
            ['宗恒', '纵横'],           // "Zongheng" -> wrong 宗恒, correct 纵横
            ['畅销书', '热销商品']       // "Best Sellers" -> wrong 畅销书 (books)
        ];
        // GTranslate renders "Moxi" as several different wrong transliterations (摩西/魔曦/魔喜...);
        // catch every variant when it appears in the company name
        var REGEX_FIX = [
            [/[摩魔莫墨][西曦喜熙]科技有限公司/g, '沫熹科技有限公司']
        ];
        var SKIP_TAGS = { SCRIPT: 1, STYLE: 1, NOSCRIPT: 1, TEXTAREA: 1 };

        function applyFix(value) {
            var out = value;
            for (var i = 0; i < FIX.length; i++) {
                if (out.indexOf(FIX[i][0]) > -1) {
                    out = out.split(FIX[i][0]).join(FIX[i][1]);
                }
            }
            for (var j = 0; j < REGEX_FIX.length; j++) {
                out = out.replace(REGEX_FIX[j][0], REGEX_FIX[j][1]);
            }
            return out === value ? null : out;
        }

        function scan() {
            try {
                var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null);
                var node, changed = 0;
                while ((node = walker.nextNode())) {
                    var parent = node.parentNode;
                    if (!parent || SKIP_TAGS[parent.nodeName]) {
                        continue;
                    }
                    var result = applyFix(node.nodeValue);
                    if (result !== null) {
                        node.nodeValue = result;
                        if (++changed >= 300) {
                            break;
                        }
                    }
                }
            } catch (e) { /* no-op */ }
        }

        scan();
        // GTranslate replaces text asynchronously (and lazily on scroll);
        // re-run on a schedule so later translations are corrected too.
        [300, 800, 1500, 3000, 6000, 10000].forEach(function (delay) {
            setTimeout(scan, delay);
        });

        var pending = false;
        function scheduleScan() {
            if (pending) {
                return;
            }
            pending = true;
            setTimeout(function () {
                pending = false;
                scan();
            }, 150);
        }

        new MutationObserver(scheduleScan).observe(document.body, {
            childList: true,
            subtree: true,
            characterData: true
        });

        window.addEventListener('scroll', scheduleScan, { passive: true });
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

/**
 * FAQPage structured data for the FAQs page (SEO rich results).
 */
function rigxmod_faq_schema() {
    if ( ! is_page( 'faqs' ) ) {
        return;
    }

    $faqs = array(
        array( 'Are your parts specifically designed for Jetour T1, T2 and Zongheng G700?', 'Yes. Every RIGX MOD part is engineered for a specific Jetour model, trim and seat layout (5-seat or 6-seat). Check the compatibility table on each product page, or send your model year and a photo of your vehicle to engineering@rigxmod.com and we will confirm fitment before you order.' ),
        array( 'What materials are your off-road parts made from?', 'Our armor, roof racks and structural parts use aerospace-grade aluminum alloy (and reinforced steel where load requires), with precision CNC machining, laser cutting and powder-coated finishes. Every product is tested against vibration, corrosion and real off-road conditions.' ),
        array( 'Are the parts bolt-on, or do they require drilling and modification?', 'Most RIGX MOD parts are direct bolt-on replacements using the original vehicle mounting points. No welding or cutting is required. Each product includes an installation guide, and basic hand tools are usually sufficient.' ),
        array( 'Do I need professional installation?', 'Many customers install our parts at home. For bumpers, suspension lifts and electrical items such as light bars, professional installation is recommended to ensure safety and preserve the product warranty.' ),
        array( 'Do you ship worldwide? How much does shipping cost?', 'Yes, we ship to most countries via express partners including DHL, FedEx and UPS. Shipping is calculated at checkout based on weight, volume and destination. Bulk and freight (LCL) orders can be quoted by sales@rigxmod.com.' ),
        array( 'How long does delivery take?', 'Orders are processed within 1-3 business days. Express delivery usually takes 7-15 business days; standard/freight delivery takes 20-45 business days depending on destination and customs clearance. You receive a tracking number by email as soon as the order ships.' ),
        array( 'Will I pay import duties and taxes?', 'Prices on our website do not include destination import duties, VAT or customs fees, which are charged by your local customs authority. We support both DDU and DDP terms. Contact us before ordering if you need a DDP (duties paid) quotation.' ),
        array( 'What payment methods do you accept?', 'We accept PayPal, major credit/debit cards (Visa, Mastercard, American Express), Apple Pay and bank transfer for large or wholesale orders.' ),
        array( 'Can I cancel or change my order?', 'Orders can be changed or cancelled free of charge before they ship. If the package has already left our warehouse, please follow our return process after delivery. Contact sales@rigxmod.com as soon as possible.' ),
        array( 'What is your return policy?', 'Unused, uninstalled products in original packaging can be returned within 30 days of delivery. Custom, special-order and clearly marked final-sale items are non-returnable. Full conditions are on our Return Policy page.' ),
        array( 'What warranty do RIGX MOD products carry?', 'All products carry a 12-month limited warranty against manufacturing defects in materials and workmanship from the date of purchase. Normal wear, off-road impact damage and improper installation are not covered.' ),
        array( 'My order arrived damaged or a part is missing. What should I do?', 'Please take photos of the outer packaging and the item within 48 hours of delivery and email them to sales@rigxmod.com with your order number. We will arrange replacement parts or a reshipment according to the claim.' ),
        array( 'Do you offer wholesale, ODM or OEM services?', 'Yes. We support distributors, workshops and brands with wholesale pricing, private-label/OEM production and ODM development from drawings or samples. Minimum order quantities apply. Email sales@rigxmod.com for a trade account and catalog.' ),
        array( 'How do I use a coupon code?', 'Enter the code in the coupon field at checkout or cart page and click apply. Codes are case sensitive and cannot be combined unless the campaign rules state otherwise.' ),
    );

    $entities = array();
    foreach ( $faqs as $f ) {
        $entities[] = array(
            '@type'           => 'Question',
            'name'            => $f[0],
            'acceptedAnswer'  => array(
                '@type' => 'Answer',
                'text'  => $f[1],
            ),
        );
    }

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $entities,
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'rigxmod_faq_schema', 20 );

/* ============================================================
 * RigxMod — Prevent GTranslate from translating WooCommerce UI
 * GTranslate wraps text in <font> and rewrites aria-labels, causing
 * accessibility failures (label-content-name-mismatch, color-contrast).
 * We add translate="no" to the product card wrapper, keeping
 * Add-to-Cart buttons, star ratings, stock text, and prices in English.
 * ============================================================ */
add_filter( 'post_class', function ( $classes, $class, $post_id ) {
    if ( get_post_type( $post_id ) === 'product' ) {
        $classes[] = 'translate-no';
    }
    return $classes;
}, 10, 3 );

add_filter( 'woocommerce_post_class', function ( $classes ) {
    $classes[] = 'translate-no';
    return $classes;
} );

/* Also block GTranslate translation on product loop button aria-labels
 * by returning English button text directly from the WooCommerce filter. */
add_filter( 'woocommerce_product_add_to_cart_text', function ( $text, $product ) {
    if ( $product->is_type( 'variable' ) ) {
        return 'Select options';
    }
    return 'Add to cart';
}, 10, 2 );

add_filter( 'woocommerce_product_add_to_cart_url', function ( $url, $product ) {
    // We don't want to change URL, but the callback signature needs both args
    return $url;
}, 10, 2 );

/* ============================================================
 * RigxMod — Placeholder slots for external tracking code
 * These are intentionally empty. Fill them when you receive your:
 *   1. GA4 measurement ID  (G-XXXXXXXXXX)
 *   2. Google Search Console verification meta tag
 * ============================================================ */
add_action( 'wp_head', function () {
    // Google Search Console — paste <meta name="google-site-verification" content="..."> here
    // echo '<meta name="google-site-verification" content="REPLACE_WITH_YOUR_VERIFICATION_CODE">' . "\n";

    // Google Analytics 4 — replace G-XXXXXXXXXX with your measurement ID
    // echo "<!-- Google tag (gtag.js) -->
    // <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    // <script>
    //   window.dataLayer = window.dataLayer || [];
    //   function gtag(){dataLayer.push(arguments);}
    //   gtag('js', new Date());
    //   gtag('config', 'G-XXXXXXXXXX');
    // </script>
    // " . "\n";
}, 5 );
