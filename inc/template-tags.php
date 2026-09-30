<?php
/**
 * Custom template tags for this theme
 *
 * @package RIGXMOD_AutoZone
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function rigxmod_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x( 'Posted on %s', 'post date', 'rigxmod-autozone' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>';
}

/**
 * Prints HTML with meta information for the current author.
 */
function rigxmod_posted_by() {
    $byline = sprintf(
        /* translators: %s: post author. */
        esc_html_x( 'by %s', 'post author', 'rigxmod-autozone' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>';
}

/**
 * Returns true if a blog has more than 1 category.
 */
function rigxmod_categorized_blog() {
    $all_the_cool_cats = get_transient( 'rigxmod_categories' );
    if ( false === $all_the_cool_cats ) {
        $all_the_cool_cats = get_categories( array(
            'fields'     => 'ids',
            'hide_empty' => 1,
            'number'     => 2,
        ) );
        $all_the_cool_cats = count( $all_the_cool_cats );
        set_transient( 'rigxmod_categories', $all_the_cool_cats );
    }

    if ( $all_the_cool_cats > 1 ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Flush out the transients used in rigxmod_categorized_blog.
 */
function rigxmod_category_transient_flusher() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    delete_transient( 'rigxmod_categories' );
}
add_action( 'edit_category', 'rigxmod_category_transient_flusher' );
add_action( 'save_post', 'rigxmod_category_transient_flusher' );

/**
 * Display breadcrumbs.
 */
function rigxmod_breadcrumbs() {
    if ( is_front_page() ) {
        return;
    }

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    echo '<div class="container">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'rigxmod-autozone' ) . '</a>';

    if ( is_home() && ! is_front_page() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) . '</span>';
    } elseif ( is_category() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html( single_cat_title( '', false ) ) . '</span>';
    } elseif ( is_tag() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html( single_tag_title( '', false ) ) . '</span>';
    } elseif ( is_author() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html( get_the_author() ) . '</span>';
    } elseif ( is_archive() && ! is_shop() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html( get_the_archive_title() ) . '</span>';
    } elseif ( is_search() ) {
        echo ' <span class="separator">/</span> <span class="current">' . sprintf( esc_html__( 'Search Results for: %s', 'rigxmod-autozone' ), esc_html( get_search_query() ) ) . '</span>';
    } elseif ( is_404() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html__( 'Page Not Found', 'rigxmod-autozone' ) . '</span>';
    } elseif ( is_single() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_page() ) {
        echo ' <span class="separator">/</span> <span class="current">' . esc_html( get_the_title() ) . '</span>';
    }

    echo '</div>';
    echo '</nav>';
}
