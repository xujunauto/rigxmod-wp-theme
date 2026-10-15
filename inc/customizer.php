<?php
/**
 * Customizer additions for RIGX MOD AutoZone theme
 *
 * @package RIGXMOD_AutoZone
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Add customizer settings.
 */
function rigxmod_customize_register( $wp_customize ) {

    // Top Bar Section
    $wp_customize->add_section( 'rigxmod_top_bar_section', array(
        'title'    => __( 'Top Bar', 'rigxmod-autozone' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'rigxmod_top_bar_text', array(
        'default'           => __( 'FREE SHIPPING on orders over $299. Worldwide delivery.', 'rigxmod-autozone' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rigxmod_top_bar_text', array(
        'label'   => __( 'Top Bar Text', 'rigxmod-autozone' ),
        'section' => 'rigxmod_top_bar_section',
        'type'    => 'text',
    ) );

    // Hero Section
    $wp_customize->add_section( 'rigxmod_hero_section', array(
        'title'    => __( 'Hero Banner', 'rigxmod-autozone' ),
        'priority' => 31,
    ) );

    $wp_customize->add_setting( 'rigxmod_hero_title', array(
        'default'           => __( 'CONQUER ANY TERRAIN', 'rigxmod-autozone' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rigxmod_hero_title', array(
        'label'   => __( 'Hero Title', 'rigxmod-autozone' ),
        'section' => 'rigxmod_hero_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'rigxmod_hero_subtitle', array(
        'default'           => __( 'Premium off-road upgrades for Jetour T1, T2 and Zongheng G700. Aerospace-grade aluminum parts, engineered for extreme conditions.', 'rigxmod-autozone' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'rigxmod_hero_subtitle', array(
        'label'   => __( 'Hero Subtitle', 'rigxmod-autozone' ),
        'section' => 'rigxmod_hero_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'rigxmod_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'rigxmod_hero_image', array(
        'label'   => __( 'Hero Background Image', 'rigxmod-autozone' ),
        'section' => 'rigxmod_hero_section',
    ) ) );

    // Campaign Section
    $wp_customize->add_section( 'rigxmod_campaign_section', array(
        'title'    => __( 'Campaign Zone', 'rigxmod-autozone' ),
        'priority' => 33,
    ) );

    $wp_customize->add_setting( 'rigxmod_campaign_name', array(
        'default'           => __( 'Limited-Time Offer', 'rigxmod-autozone' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'rigxmod_campaign_name', array(
        'label'   => __( 'Campaign Name (e.g. Procurement Festival, Black Friday)', 'rigxmod-autozone' ),
        'section' => 'rigxmod_campaign_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'rigxmod_campaign_subtitle', array(
        'default'           => __( 'Grab exclusive coupon codes and enjoy campaign prices on selected products.', 'rigxmod-autozone' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'rigxmod_campaign_subtitle', array(
        'label'   => __( 'Campaign Subtitle', 'rigxmod-autozone' ),
        'section' => 'rigxmod_campaign_section',
        'type'    => 'textarea',
    ) );

    // Colors Section
    $wp_customize->add_section( 'rigxmod_colors_section', array(
        'title'    => __( 'Brand Colors', 'rigxmod-autozone' ),
        'priority' => 32,
    ) );

    $wp_customize->add_setting( 'rigxmod_primary_color', array(
        'default'           => '#E31937',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'rigxmod_primary_color', array(
        'label'   => __( 'Primary Color (Tesla Red)', 'rigxmod-autozone' ),
        'section' => 'rigxmod_colors_section',
    ) ) );

    $wp_customize->add_setting( 'rigxmod_secondary_color', array(
        'default'           => '#F38020',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'rigxmod_secondary_color', array(
        'label'   => __( 'Secondary / Promo Color (Cloudflare Orange)', 'rigxmod-autozone' ),
        'section' => 'rigxmod_colors_section',
    ) ) );

}
add_action( 'customize_register', 'rigxmod_customize_register' );

/**
 * Output custom CSS from customizer.
 */
function rigxmod_customize_css() {
    $primary = get_theme_mod( 'rigxmod_primary_color', '#E31937' );
    $secondary = get_theme_mod( 'rigxmod_secondary_color', '#F38020' );

    if ( $primary === '#E31937' && $secondary === '#F38020' ) {
        return; // Defaults match CSS variables, no need to output.
    }

    ?>
    <style type="text/css">
        :root {
            --rm-primary: <?php echo esc_attr( $primary ); ?>;
            --rm-secondary: <?php echo esc_attr( $secondary ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'rigxmod_customize_css' );
