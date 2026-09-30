<?php
/**
 * The main template file
 *
 * @package RIGXMOD_AutoZone
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php if ( have_posts() ) : ?>

                <div class="container">
                    <div class="blog-archive" style="padding: 48px 0;">
                        <h1 style="margin-bottom: 32px;"><?php esc_html_e( 'Latest News', 'rigxmod-autozone' ); ?></h1>
                        <div class="news-grid">
                            <?php while ( have_posts() ) : the_post(); ?>
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
                            <?php endwhile; ?>
                        </div>

                        <div class="pagination" style="margin-top: 32px; text-align: center;">
                            <?php
                            the_posts_pagination( array(
                                'prev_text' => '&laquo; ' . esc_html__( 'Previous', 'rigxmod-autozone' ),
                                'next_text' => esc_html__( 'Next', 'rigxmod-autozone' ) . ' &raquo;',
                            ) );
                            ?>
                        </div>
                    </div>
                </div>

            <?php else : ?>

                <div class="container" style="padding: 64px 0; text-align: center;">
                    <h2><?php esc_html_e( 'Nothing Found', 'rigxmod-autozone' ); ?></h2>
                    <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'rigxmod-autozone' ); ?></p>
                </div>

            <?php endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
