<?php
/**
 * The template for displaying all pages
 *
 * @package RIGXMOD_AutoZone
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php while ( have_posts() ) : the_post(); ?>

                <div class="page-header">
                    <div class="container">
                        <h1><?php the_title(); ?></h1>
                    </div>
                </div>

                <div class="container" style="padding: 48px 0;">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php
                            the_content();

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rigxmod-autozone' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>
                    </article>

                    <?php if ( comments_open() || get_comments_number() ) : ?>
                        <?php comments_template(); ?>
                    <?php endif; ?>
                </div>

            <?php endwhile; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
