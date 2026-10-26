<?php
/**
 * The template for displaying WooCommerce pages
 *
 * @package RIGXMOD_AutoZone
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php if ( is_product_category() || is_product_tag() || is_shop() ) : ?>
                <div class="shop-cat-header">
                    <div class="container">
                        <h1 class="shop-cat-title"><?php
                            if ( is_shop() ) {
                                echo esc_html( woocommerce_page_title( false ) );
                            } else {
                                echo esc_html( single_term_title( '', false ) );
                            }
                        ?></h1>
                    </div>
                </div>
            <?php endif; ?>

            <div class="shop-layout container">
                <aside class="shop-sidebar">
                    <?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
                        <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                    <?php else : ?>
                        <div class="widget">
                            <h3 class="widget-title"><?php esc_html_e( 'Categories', 'rigxmod-autozone' ); ?></h3>
                            <ul>
                                <?php wp_list_categories( array(
                                    'taxonomy' => 'product_cat',
                                    'title_li' => '',
                                ) ); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </aside>
                <div class="shop-products">
                    <?php woocommerce_content(); ?>
                </div>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
