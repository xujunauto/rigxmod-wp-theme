<?php
/**
 * WooCommerce customizations for RIGX MOD AutoZone theme
 *
 * @package RIGXMOD_AutoZone
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Remove default WooCommerce wrappers and add our own.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'rigxmod_wc_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'rigxmod_wc_wrapper_end', 10 );

function rigxmod_wc_wrapper_start() {
    echo '<div class="shop-layout container">';
    echo '<aside class="shop-sidebar">';
    if ( is_active_sidebar( 'shop-sidebar' ) ) {
        dynamic_sidebar( 'shop-sidebar' );
    }
    echo '</aside>';
    echo '<main class="shop-products">';
}

function rigxmod_wc_wrapper_end() {
    echo '</main>';
    echo '</div>';
}

/**
 * Remove default WooCommerce breadcrumbs (use our own).
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Change product per page count.
 */
function rigxmod_products_per_page( $cols ) {
    return 12;
}
add_filter( 'loop_shop_per_page', 'rigxmod_products_per_page', 20 );

/**
 * Custom product image size for loop.
 */
function rigxmod_loop_product_image_size() {
    return 'woocommerce_thumbnail';
}

/**
 * Add product card wrapper.
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

add_action( 'woocommerce_before_shop_loop_item', 'rigxmod_product_card_open', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'rigxmod_product_card_close', 20 );

function rigxmod_product_card_open() {
    echo '<div class="product-card">';
}

function rigxmod_product_card_close() {
    echo '</div>';
}

/**
 * Modify sale badge to use Cloudflare orange.
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'rigxmod_sale_badge', 10 );

function rigxmod_sale_badge() {
    global $product;
    if ( $product && $product->is_on_sale() ) {
        echo '<span class="product-badge product-badge-sale">' . esc_html__( 'Sale', 'rigxmod-autozone' ) . '</span>';
    }
}

/**
 * Add product info wrapper.
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'rigxmod_product_image_open', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'rigxmod_product_image_close', 15 );

function rigxmod_product_image_open() {
    echo '<div class="product-image">';
}

function rigxmod_product_image_close() {
    echo '</div>';
}

/**
 * Add product info wrapper around title, price, etc.
 */
add_action( 'woocommerce_shop_loop_item_title', 'rigxmod_product_info_open', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'rigxmod_product_info_close', 15 );

function rigxmod_product_info_open() {
    echo '<div class="product-info">';
}

function rigxmod_product_info_close() {
    echo '</div>';
}

/**
 * Customize add to cart button text.
 */
function rigxmod_add_to_cart_text() {
    return __( 'Add to Cart', 'rigxmod-autozone' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'rigxmod_add_to_cart_text' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'rigxmod_add_to_cart_text' );

/**
 * Customize "Out of stock" text.
 */
function rigxmod_out_of_stock_text() {
    return __( 'Out of Stock', 'rigxmod-autozone' );
}

/**
 * Add cart count in header via AJAX fragments.
 */
function rigxmod_cart_fragments( $fragments ) {
    ob_start();
    ?>
    <span class="cart-badge"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
    <?php
    $fragments['span.cart-badge'] = ob_get_clean();
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'rigxmod_cart_fragments' );

/**
 * Change number of related products.
 */
function rigxmod_related_products_columns() {
    return 4;
}
add_filter( 'woocommerce_related_products_columns', 'rigxmod_related_products_columns' );

/**
 * Change number of upsells.
 */
function rigxmod_upsells_columns() {
    return 4;
}
add_filter( 'woocommerce_upsells_columns', 'rigxmod_upsells_columns' );

/**
 * Change number of cross sells.
 */
function rigxmod_cross_sells_columns() {
    return 4;
}
add_filter( 'woocommerce_cross_sells_columns', 'rigxmod_cross_sells_columns' );

/**
 * Change number of cross sells to display.
 */
function rigxmod_cross_sells_total() {
    return 4;
}
add_filter( 'woocommerce_cross_sells_total', 'rigxmod_cross_sells_total' );

/**
 * Remove default sidebar from shop pages.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Ensure shop page has proper title.
 */
function rigxmod_shop_page_title( $title ) {
    if ( is_shop() && in_the_loop() ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id ) {
            $title = get_the_title( $shop_page_id );
        }
    }
    return $title;
}
add_filter( 'the_title', 'rigxmod_shop_page_title' );
