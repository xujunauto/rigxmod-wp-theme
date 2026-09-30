<?php
/**
 * The header for our theme
 *
 * @package RIGXMOD_AutoZone
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rigxmod-autozone' ); ?></a>

    <header id="masthead" class="site-header">
        <!-- Top Promo Bar -->
        <div class="header-top-bar">
            <div class="container">
                <span><?php echo esc_html( get_theme_mod( 'rigxmod_top_bar_text', 'FREE SHIPPING on orders over $299. Worldwide delivery.' ) ); ?></span>
            </div>
        </div>

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <!-- Logo -->
                <div class="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php if ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            RIGX <span>MOD</span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Vehicle Selector (for off-road parts - "Add Your Vehicle" style) -->
                <div class="header-vehicle-selector" onclick="document.getElementById('vehicle-modal').style.display='flex'">
                    <div class="header-vehicle-selector-icon">
                        <i class="fas fa-truck-pickup"></i>
                    </div>
                    <div>
                        <div class="header-vehicle-selector-label"><?php esc_html_e( 'Select Your', 'rigxmod-autozone' ); ?></div>
                        <div class="header-vehicle-selector-value"><?php esc_html_e( 'Vehicle', 'rigxmod-autozone' ); ?></div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="header-search">
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search for parts, products...', 'rigxmod-autozone' ); ?>" value="<?php echo get_search_query(); ?>">
                        <button type="submit" aria-label="<?php esc_attr_e( 'Search', 'rigxmod-autozone' ); ?>">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="hidden" name="post_type" value="product">
                    </form>
                </div>

                <!-- Header Actions -->
                <div class="header-actions">
                    <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="header-action-item">
                        <i class="fas fa-user"></i>
                        <span><?php esc_html_e( 'Account', 'rigxmod-autozone' ); ?></span>
                    </a>

                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-action-item">
                        <i class="fas fa-shopping-cart"></i>
                        <span><?php esc_html_e( 'Cart', 'rigxmod-autozone' ); ?></span>
                        <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
                            <span class="cart-badge"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Category Navigation -->
        <nav class="header-cat-nav">
            <div class="container">
                <?php
                if ( has_nav_menu( 'category' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'category',
                        'menu_id'        => 'category-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ) );
                } else {
                    // Fallback: show product categories
                    $categories = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'parent'     => 0,
                        'number'     => 8,
                    ) );
                    if ( $categories && ! is_wp_error( $categories ) ) {
                        echo '<ul>';
                        foreach ( $categories as $cat ) {
                            echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
                        }
                        echo '</ul>';
                    }
                }
                ?>
            </div>
        </nav>
    </header><!-- #masthead -->

    <!-- Vehicle Modal -->
    <div id="vehicle-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;" onclick="if(event.target===this)this.style.display='none'">
        <div style="background:#fff;padding:40px;border-radius:8px;max-width:500px;width:90%;">
            <h3 style="margin-bottom:20px;"><?php esc_html_e( 'Select Your Vehicle', 'rigxmod-autozone' ); ?></h3>
            <p style="color:#666;margin-bottom:20px;"><?php esc_html_e( 'Find parts that fit your off-road vehicle', 'rigxmod-autozone' ); ?></p>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;">
                <?php
                $makes = array( 'GWM Tank', 'Jetour', 'BYD Formula Leopard' );
                foreach ( $makes as $make ) {
                    echo '<div style="border:1px solid #e5e5e5;border-radius:6px;padding:16px;text-align:center;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.borderColor=\'#E31937\';this.style.boxShadow=\'0 2px 8px rgba(0,0,0,0.1)\'" onmouseout="this.style.borderColor=\'#e5e5e5\';this.style.boxShadow=\'none\'"><i class="fas fa-car" style="font-size:24px;color:#E31937;margin-bottom:8px;"></i><br><strong>' . esc_html( $make ) . '</strong></div>';
                }
                ?>
            </div>
            <button style="width:100%;padding:12px;background:#E31937;color:#fff;border:none;border-radius:4px;font-weight:600;cursor:pointer;" onclick="document.getElementById('vehicle-modal').style.display='none'"><?php esc_html_e( 'Close', 'rigxmod-autozone' ); ?></button>
        </div>
    </div>

    <div id="content" class="site-content">
