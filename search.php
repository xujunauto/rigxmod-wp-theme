<?php
/**
 * The template for displaying search results pages
 *
 * @package RIGXMOD_AutoZone
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <div class="page-header">
                <div class="container">
                    <h1>
                        <?php
                        printf(
                            /* translators: %s: search query. */
                            esc_html__( 'Search Results for: %s', 'rigxmod-autozone' ),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                </div>
            </div>

            <div class="container" style="padding: 48px 0;">
                <?php if ( have_posts() ) : ?>

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
                                        $post_type = get_post_type();
                                        if ( 'product' === $post_type ) {
                                            esc_html_e( 'Product', 'rigxmod-autozone' );
                                        } elseif ( 'post' === $post_type ) {
                                            $categories = get_the_category();
                                            if ( $categories ) {
                                                echo esc_html( $categories[0]->name );
                                            }
                                        } else {
                                            echo esc_html( ucfirst( $post_type ) );
                                        }
                                        ?>
                                    </div>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="news-card-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                                    <div class="news-card-meta">
                                        <span><i class="far fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></span>
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

                <?php else : ?>

                    <div style="text-align: center; padding: 64px 0;">
                        <h2 style="margin-bottom: 16px;"><?php esc_html_e( 'Nothing Found', 'rigxmod-autozone' ); ?></h2>
                        <p style="color: var(--rm-text-secondary); margin-bottom: 24px;"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'rigxmod-autozone' ); ?></p>
                        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="max-width: 500px; margin: 0 auto; display: flex; gap: 8px;">
                            <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search...', 'rigxmod-autozone' ); ?>" value="<?php echo get_search_query(); ?>" style="flex: 1; padding: 12px; border: 1px solid var(--rm-gray-300); border-radius: 4px;">
                            <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'rigxmod-autozone' ); ?></button>
                        </form>
                    </div>

                <?php endif; ?>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
