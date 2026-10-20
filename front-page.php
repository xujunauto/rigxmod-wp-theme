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

        <!-- Hero Banner — full-width slider -->
        <section class="hero-section">
            <?php
            $rigxmod_hero_slides = array_filter( array(
                get_theme_mod( 'rigxmod_hero_image', '' ),
                get_theme_mod( 'rigxmod_hero_image_2', '' ),
                get_theme_mod( 'rigxmod_hero_image_3', '' ),
            ) );
            $rigxmod_hero_slides = array_values( $rigxmod_hero_slides );
            ?>
            <div class="hero-slider" id="rigxmod-hero-slider">
                <?php foreach ( $rigxmod_hero_slides as $rigxmod_i => $rigxmod_img ) : ?>
                    <div class="hero-slide<?php echo 0 === $rigxmod_i ? ' is-active' : ''; ?>" style="background-image: url('<?php echo esc_url( $rigxmod_img ); ?>');"></div>
                <?php endforeach; ?>
                <div class="hero-slider-overlay"></div>
                <div class="container">
                    <div class="hero-banner-content">
                        <h1><?php echo esc_html( get_theme_mod( 'rigxmod_hero_title', 'CONQUER ANY TERRAIN' ) ); ?></h1>
                        <p><?php echo esc_html( get_theme_mod( 'rigxmod_hero_subtitle', 'Premium off-road upgrades for Jetour T1, T2 and Zongheng G700. Aerospace-grade aluminum parts, engineered for extreme conditions.' ) ); ?></p>
                        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary btn-lg">
                            <?php esc_html_e( 'Shop Now', 'rigxmod-autozone' ); ?>
                        </a>
                    </div>
                </div>
                <?php if ( count( $rigxmod_hero_slides ) > 1 ) : ?>
                    <button type="button" class="hero-slider-arrow hero-slider-prev" aria-label="Previous slide">&#8249;</button>
                    <button type="button" class="hero-slider-arrow hero-slider-next" aria-label="Next slide">&#8250;</button>
                    <div class="hero-slider-dots">
                        <?php foreach ( $rigxmod_hero_slides as $rigxmod_i => $rigxmod_img ) : ?>
                            <button type="button" class="hero-slider-dot<?php echo 0 === $rigxmod_i ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr( $rigxmod_i ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Slide %d', $rigxmod_i + 1 ) ); ?>"></button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( count( $rigxmod_hero_slides ) > 1 ) : ?>
            <script>
            (function () {
                var slider = document.getElementById('rigxmod-hero-slider');
                if (!slider) return;
                var slides = slider.querySelectorAll('.hero-slide');
                var dots = slider.querySelectorAll('.hero-slider-dot');
                var prev = slider.querySelector('.hero-slider-prev');
                var next = slider.querySelector('.hero-slider-next');
                var current = 0, timer = null;
                function go(n) {
                    slides[current].classList.remove('is-active');
                    if (dots.length) dots[current].classList.remove('is-active');
                    current = (n + slides.length) % slides.length;
                    slides[current].classList.add('is-active');
                    if (dots.length) dots[current].classList.add('is-active');
                }
                function start() { timer = setInterval(function () { go(current + 1); }, 6000); }
                function stop() { if (timer) { clearInterval(timer); timer = null; } }
                if (prev) prev.addEventListener('click', function () { stop(); go(current - 1); start(); });
                if (next) next.addEventListener('click', function () { stop(); go(current + 1); start(); });
                dots.forEach(function (dot) {
                    dot.addEventListener('click', function () { stop(); go(parseInt(this.getAttribute('data-slide'), 10)); start(); });
                });
                slider.addEventListener('mouseenter', stop);
                slider.addEventListener('mouseleave', function () { if (!timer) start(); });
                start();
            })();
            </script>
            <?php endif; ?>
        </section>

        <!-- Best Sellers -->
        <section class="products-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e( 'Best Sellers', 'rigxmod-autozone' ); ?></h2>
                <?php
                echo do_shortcode( '[products limit="8" columns="4" orderby="popularity" order="DESC"]' );
                ?>
            </div>
        </section>

        <!-- Campaign Zone -->
        <section class="campaign-section">
            <div class="container">
                <div class="campaign-banner">
                    <div class="campaign-banner-inner">
                        <div>
                            <span class="campaign-tag"><?php esc_html_e( 'Campaign', 'rigxmod-autozone' ); ?></span>
                            <h2 class="campaign-title"><?php echo esc_html( get_theme_mod( 'rigxmod_campaign_name', 'Limited-Time Offer' ) ); ?></h2>
                            <p class="campaign-subtitle"><?php echo esc_html( get_theme_mod( 'rigxmod_campaign_subtitle', 'Grab exclusive coupon codes and enjoy campaign prices on selected products.' ) ); ?></p>
                        </div>
                        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary">
                            <?php esc_html_e( 'Shop Campaign', 'rigxmod-autozone' ); ?>
                        </a>
                    </div>
                </div>

                <?php
                $coupons = get_posts( array(
                    'post_type'      => 'shop_coupon',
                    'post_status'    => 'publish',
                    'posts_per_page' => 6,
                ) );

                if ( $coupons ) :
                    ?>
                    <div class="coupon-grid">
                        <?php foreach ( $coupons as $coupon_post ) :
                            $coupon = new WC_Coupon( $coupon_post->ID );
                            $code   = $coupon->get_code();
                            $type   = $coupon->get_discount_type();
                            $amount = $coupon->get_amount();
                            $desc   = $coupon->get_description();
                            if ( 'percent' === $type ) {
                                $discount = $amount . '%';
                            } elseif ( 'fixed_cart' === $type || 'fixed_product' === $type ) {
                                $discount = '$' . $amount;
                            } else {
                                $discount = $amount;
                            }
                            ?>
                            <div class="coupon-card">
                                <div class="coupon-amount"><?php echo esc_html( $discount ); ?></div>
                                <div class="coupon-code-row">
                                    <code class="coupon-code"><?php echo esc_html( $code ); ?></code>
                                    <button type="button" class="coupon-copy" data-code="<?php echo esc_attr( $code ); ?>"><?php esc_html_e( 'Copy', 'rigxmod-autozone' ); ?></button>
                                </div>
                                <?php if ( $desc ) : ?>
                                    <p class="coupon-desc"><?php echo esc_html( $desc ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <script>
                    document.querySelectorAll('.coupon-copy').forEach(function(btn){
                        btn.addEventListener('click', function(){
                            var code = btn.getAttribute('data-code');
                            if (navigator.clipboard) {
                                navigator.clipboard.writeText(code).then(function(){
                                    btn.textContent = '<?php echo esc_js( __( 'Copied!', 'rigxmod-autozone' ) ); ?>';
                                    setTimeout(function(){ btn.textContent = '<?php echo esc_js( __( 'Copy', 'rigxmod-autozone' ) ); ?>'; }, 1500);
                                });
                            } else {
                                var ta = document.createElement('textarea');
                                ta.value = code; document.body.appendChild(ta); ta.select();
                                try { document.execCommand('copy'); btn.textContent = '<?php echo esc_js( __( 'Copied!', 'rigxmod-autozone' ) ); ?>'; setTimeout(function(){ btn.textContent = '<?php echo esc_js( __( 'Copy', 'rigxmod-autozone' ) ); ?>'; }, 1500); } catch(e){}
                                document.body.removeChild(ta);
                            }
                        });
                    });
                    </script>
                <?php else : ?>
                    <p class="campaign-empty"><?php esc_html_e( 'No active coupons right now. New campaigns are coming soon — stay tuned!', 'rigxmod-autozone' ); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Latest News -->
        <section class="news-section">
            <div class="container">
                <h2 class="section-title"><?php esc_html_e( 'News & Insights', 'rigxmod-autozone' ); ?></h2>
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
                                    <a href="<?php the_permalink(); ?>" class="news-card-image" aria-label="<?php echo esc_attr( get_the_title() ); ?>" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');"></a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="news-card-image" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
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
                    } else {
                        echo '<p>' . esc_html__( 'Articles are on the way. Check back soon for brand stories, company news and off-road guides.', 'rigxmod-autozone' ) . '</p>';
                    }
                    ?>
                </div>
            </div>
        </section>

    </main><!-- #main -->

<?php
get_footer();
