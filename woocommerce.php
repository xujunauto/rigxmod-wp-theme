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

            <?php woocommerce_content(); ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
