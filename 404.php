<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package RIGXMOD_AutoZone
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <div class="container" style="padding: 96px 0; text-align: center;">
                <h1 style="font-size: 96px; font-weight: 800; color: var(--rm-primary); margin-bottom: 16px;">404</h1>
                <h2 style="margin-bottom: 16px;"><?php esc_html_e( 'Page Not Found', 'rigxmod-autozone' ); ?></h2>
                <p style="color: var(--rm-text-secondary); margin-bottom: 32px; max-width: 500px; margin-left: auto; margin-right: auto;">
                    <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'rigxmod-autozone' ); ?>
                </p>
                <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Go to Homepage', 'rigxmod-autozone' ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-secondary">
                        <?php esc_html_e( 'Browse Products', 'rigxmod-autozone' ); ?>
                    </a>
                </div>

                <div style="margin-top: 64px; padding-top: 48px; border-top: 1px solid var(--rm-border-color);">
                    <h3 style="margin-bottom: 24px;"><?php esc_html_e( 'Popular Categories', 'rigxmod-autozone' ); ?></h3>
                    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                        <?php
                        $cats = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'number'     => 6,
                        ) );
                        if ( $cats && ! is_wp_error( $cats ) ) {
                            foreach ( $cats as $cat ) {
                                echo '<a href="' . esc_url( get_term_link( $cat ) ) . '" class="btn btn-secondary btn-sm">' . esc_html( $cat->name ) . '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
