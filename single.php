<?php
/**
 * The template for displaying all single posts
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
                        <div class="breadcrumbs">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rigxmod-autozone' ); ?></a>
                            <span class="separator">/</span>
                            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'News', 'rigxmod-autozone' ); ?></a>
                            <span class="separator">/</span>
                            <span class="current"><?php the_title(); ?></span>
                        </div>
                        <h1 style="margin-top:16px;"><?php the_title(); ?></h1>
                        <div style="color:var(--rm-text-secondary);font-size:14px;margin-top:8px;">
                            <span><i class="far fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></span>
                            <span style="margin:0 12px;">|</span>
                            <span><i class="far fa-folder"></i> <?php the_category( ', ' ); ?></span>
                            <span style="margin:0 12px;">|</span>
                            <span><i class="far fa-comment"></i> <?php comments_number( '0 comments', '1 comment', '% comments' ); ?></span>
                        </div>
                    </div>
                </div>

                <div class="container" style="padding: 48px 0; max-width: 800px;">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div style="margin-bottom: 32px; border-radius: 8px; overflow: hidden;">
                                <?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content" style="font-size: 16px; line-height: 1.8; color: var(--rm-text-primary);">
                            <?php
                            the_content();

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rigxmod-autozone' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--rm-border-color);">
                            <?php the_tags( '<div class="post-tags" style="display:flex;flex-wrap:wrap;gap:8px;"><strong>Tags:</strong> ', '', '</div>' ); ?>
                        </div>
                    </article>

                    <?php
                    // Previous/next post navigation.
                    the_post_navigation( array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'rigxmod-autozone' ) . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'rigxmod-autozone' ) . '</span> <span class="nav-title">%title</span>',
                    ) );
                    ?>

                    <?php if ( comments_open() || get_comments_number() ) : ?>
                        <?php comments_template(); ?>
                    <?php endif; ?>
                </div>

            <?php endwhile; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
