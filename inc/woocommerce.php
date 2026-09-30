<?php
/**
 * WooCommerce customizations for RIGX MOD AutoZone theme
 * Full version - all customizations
 *
 * @package RIGXMOD_AutoZone
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Change number of products per page
 */
function rigxmod_products_per_page( $cols ) {
    return 12;
}
add_filter( 'loop_shop_per_page', 'rigxmod_products_per_page', 20 );

/**
 * Customize add to cart button text
 */
function rigxmod_add_to_cart_text() {
    return __( 'Add to Cart', 'rigxmod-autozone' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'rigxmod_add_to_cart_text' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'rigxmod_add_to_cart_text' );

/**
 * Remove default sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Product card customizations
 */

// Remove default link wrappers
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Remove default sale flash
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

// Remove default thumbnail hook
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

// Remove default title and rating positioning
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// Add custom product card wrapper
add_action( 'woocommerce_before_shop_loop_item', 'rigxmod_product_card_open', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'rigxmod_product_card_close', 20 );

function rigxmod_product_card_open() {
    global $product;
    echo '<div class="product-card">';
    echo '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '" class="product-card-link" style="text-decoration:none;color:inherit;display:block;">';
}

function rigxmod_product_card_close() {
    echo '</a>';
    echo '</div>';
}

// Custom sale badge
add_action( 'woocommerce_before_shop_loop_item_title', 'rigxmod_sale_badge', 5 );
function rigxmod_sale_badge() {
    global $product;
    if ( $product->is_on_sale() ) {
        echo '<span class="sale-badge">Sale</span>';
    }
}

// Custom product image wrapper
add_action( 'woocommerce_before_shop_loop_item_title', 'rigxmod_product_image_open', 8 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'rigxmod_product_image_close', 15 );

function rigxmod_product_image_open() {
    echo '<div class="product-image">';
}

function rigxmod_product_image_close() {
    echo '</div>';
}

// Custom product info wrapper
add_action( 'woocommerce_shop_loop_item_title', 'rigxmod_product_info_open', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'rigxmod_product_info_close', 15 );

function rigxmod_product_info_open() {
    echo '<div class="product-info">';
}

function rigxmod_product_info_close() {
    echo '</div>';
}

// Add title back at right priority
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 12 );

/**
 * Product image size for loop
 */
function rigxmod_loop_product_image_size( $size ) {
    return 'rigxmod-product';
}
add_filter( 'woocommerce_get_image_size_woocommerce_thumbnail', 'rigxmod_loop_product_image_size' );
add_filter( 'subcategory_archive_thumbnail_size', 'rigxmod_loop_product_image_size' );

/**
 * Out of stock text
 */
function rigxmod_out_of_stock_text( $text, $product ) {
    return __( 'Out of Stock', 'rigxmod-autozone' );
}
add_filter( 'woocommerce_out_of_stock_text', 'rigxmod_out_of_stock_text', 10, 2 );

/**
 * Upsells columns
 */
function rigxmod_upsells_columns( $args ) {
    if ( is_array( $args ) ) {
        $args['columns'] = 4;
        $args['posts_per_page'] = 4;
    }
    return $args;
}
add_filter( 'woocommerce_upsell_display_args', 'rigxmod_upsells_columns' );

/**
 * Cross sells columns
 */
function rigxmod_cross_sells_columns( $columns ) {
    return 4;
}
add_filter( 'woocommerce_cross_sells_columns', 'rigxmod_cross_sells_columns' );

/**
 * Cross sells total
 */
function rigxmod_cross_sells_total( $total ) {
    return 4;
}
add_filter( 'woocommerce_cross_sells_total', 'rigxmod_cross_sells_total' );

/**
 * Shop page title
 */
function rigxmod_shop_page_title( $title ) {
    if ( is_shop() ) {
        return __( 'All Products', 'rigxmod-autozone' );
    }
    return $title;
}
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Cart fragments
 */
function rigxmod_cart_fragments( $fragments ) {
    global $woocommerce;
    $count = $woocommerce->cart->get_cart_contents_count();
    $fragments['span.cart-count'] = '<span class="cart-count">' . esc_html( $count ) . '</span>';
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'rigxmod_cart_fragments' );
