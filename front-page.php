<?php
/**
 * Template Name: Front Page
 *
 * The front page template - AutoZone style homepage
 *
 * @package RIGXMOD_AutoZone
 */

get_header();
?>

    <main id="main" class="site-main">

        <!-- Hero Banner -->
        <section class="hero-section">
            <div class="hero-banner">
                <div class="container">
                    <div class="hero-banner-content">
                        <h1><?php echo esc_html( get_theme_mod( 'rigxmod_hero_title', 'CONQUER ANY TERRAIN' ) ); ?></h1>
                        <p><?php echo esc_html( get_theme_mod( 'rigxmod_hero_subtitle', 'Premium off-road upgrades for GWM TANK, Jetour & BYD Formula Leopard. Aerospace-grade aluminum parts, engineered for extreme conditions.' ) ); ?></p>
                        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary btn-lg">
                            <?php esc_html_e( 'Shop Now', 'rigxmod-autozone' ); ?>
                        </a>
                    </div>
                </div>
                <div class="hero-banner-image" style="background-image: url('<?php echo esc_url( get_theme_mod( 'rigxmod_hero_image', '' ) ); ?>');"></div>
            </div>
        </section>

        <!-- Quick Category Access -->
        <section class="category-quick-access">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e( 'Shop by Category', 'rigxmod-autozone' ); ?></h2>
                <div class="category-grid">
                    <?php
                    $cat_args = array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'parent'     => 0,
                        'number'     => 6,
                    );
                    $categories = get_terms( $cat_args );

                    if ( $categories && ! is_wp_error( $categories ) ) {
                        $icons = array(
                            'fa-car-side',
                            'fa-bolt',
                            'fa-sun',
                            'fa-road',
                            'fa-shield-halved',
                            'fa-gear',
                        );

                        $i = 0;
                        foreach ( $categories as $cat ) {
                            $icon = isset( $icons[ $i ] ) ? $icons[ $i ] : 'fa-cog';
                            echo '<a href="' . esc_url( get_term_link( $cat ) ) . '" class="category-card">';
                            echo '<div class="category-card-icon"><i class="fas ' . esc_attr( $icon ) . '"></i></div>';
                            echo '<h3>' . esc_html( $cat->name ) . '</h3>';
                            echo '</a>';
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Promo Banners -->
        <section class="promo-section">
            <div class="container">
                <div class="promo-grid">
                    <div class="promo-banner promo-banner-red">
                        <div class="promo-banner-content">
                            <h3><?php esc_html_e( 'TANK 300 UPGRADES', 'rigxmod-autozone' ); ?></h3>
                            <p><?php esc_html_e( 'Complete bolt-on performance kits. Free shipping worldwide.', 'rigxmod-autozone' ); ?></p>
                            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn">
                                <?php esc_html_e( 'Shop Now', 'rigxmod-autozone' ); ?>
                            </a>
                        </div>
                    </div>
                    <div class="promo-banner promo-banner-orange">
                        <div class="promo-banner-content">
                            <h3 style="font-size: 20px;"><?php esc_html_e( 'NEW ARRIVALS', 'rigxmod-autozone' ); ?></h3>
                            <p style="font-size: 13px;"><?php esc_html_e( 'Jetour T2 accessories just dropped', 'rigxmod-autozone' ); ?></p>
                            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn">
                                <?php esc_html_e( 'View', 'rigxmod-autozone' ); ?>
                            </a>
                        </div>
                    </div>
                    <div class="promo-banner promo-banner-gray">
                        <div class="promo-banner-content">
                            <h3 style="font-size: 20px;"><?php esc_html_e( 'BEST SELLERS', 'rigxmod-autozone' ); ?></h3>
                            <p style="font-size: 13px;"><?php esc_html_e( 'Fan favorites, proven on trails', 'rigxmod-autozone' ); ?></p>
                            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn">
                                <?php esc_html_e( 'Explore', 'rigxmod-autozone' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="products-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e( 'Featured Products', 'rigxmod-autozone' ); ?></h2>
                <?php
                echo do_shortcode( '[products limit="8" columns="4" visibility="featured" orderby="date" order="DESC"]' );
                ?>
            </div>
        </section>

        <!-- Latest News -->
        <section class="news-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e( 'Latest News & Guides', 'rigxmod-autozone' ); ?></h2>
                <div class="news-grid">
                    <?php
                    $news_args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                    );
                    $news_query = new WP_Query( $news_args );

                    if ( $news_query->have_posts() ) {
                        while ( $news_query->have_posts() ) {
                            $news_query->the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card' ); ?>>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="news-card-image" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');"></a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="news-card-image"></a>
                                <?php endif; ?>
                                <div class="news-card-content">
                                    <div class="news-card-category">
                                        <?php
                                        $categories = get_the_category();
                                        if ( $categories ) {
                                            echo esc_html( $categories[0]->name );
                                        }
                                        ?>
                                    </div>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="news-card-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                                    <div class="news-card-meta">
                                        <span><i class="far fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></span>
                                        <span><i class="far fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></span>
                                    </div>
                                </div>
                            </article>
                            <?php
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
        </section>

    </main><!-- #main -->

<?php
get_footer();
