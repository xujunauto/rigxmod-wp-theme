<?php
/**
 * The template for displaying the footer
 *
 * @package RIGXMOD_AutoZone
 */
?>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <!-- Brand Column -->
                    <div class="footer-col footer-brand-col">
                        <div class="footer-brand-logo">
                            RIGX <span>MOD</span>
                        </div>
                        <p>
                            <?php esc_html_e( 'Precision-engineered off-road upgrade parts for GWM TANK, Jetour & BYD Formula Leopard. Aerospace-grade aluminum. Bolt-on installation. Worldwide shipping.', 'rigxmod-autozone' ); ?>
                        </p>
                        <div class="footer-contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>Sales@rigxmod.com</span>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>+86 191 5729 8808</span>
                        </div>
                        <div class="footer-social">
                            <a href="https://www.instagram.com/rigxmod" target="_blank" rel="noopener" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.youtube.com/@rigxmod" target="_blank" rel="noopener" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="https://www.tiktok.com/@rigxmod" target="_blank" rel="noopener" aria-label="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            <a href="https://www.facebook.com/rigxmod" target="_blank" rel="noopener" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://x.com/rigxmod" target="_blank" rel="noopener" aria-label="X">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="footer-col">
                        <h4><?php esc_html_e( 'Products', 'rigxmod-autozone' ); ?></h4>
                        <?php
                        $footer_cats = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'parent'     => 0,
                            'number'     => 8,
                        ) );
                        if ( $footer_cats && ! is_wp_error( $footer_cats ) ) {
                            echo '<ul>';
                            foreach ( $footer_cats as $cat ) {
                                echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>

                    <!-- Customer Service -->
                    <div class="footer-col">
                        <h4><?php esc_html_e( 'Customer Service', 'rigxmod-autozone' ); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'My Account', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ); ?>"><?php esc_html_e( 'Shopping Cart', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ); ?>"><?php esc_html_e( 'Checkout', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Track Order', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ?: '#' ); ?>"><?php esc_html_e( 'Contact Us', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'faqs' ) ) ?: '#' ); ?>"><?php esc_html_e( 'FAQs', 'rigxmod-autozone' ); ?></a></li>
                        </ul>
                    </div>

                    <!-- Policies -->
                    <div class="footer-col">
                        <h4><?php esc_html_e( 'Policies', 'rigxmod-autozone' ); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'privacy-policy' ) ) ?: '#' ); ?>"><?php esc_html_e( 'Privacy Policy', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'terms-of-service' ) ) ?: '#' ); ?>"><?php esc_html_e( 'Terms of Service', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'shipping-policy' ) ) ?: '#' ); ?>"><?php esc_html_e( 'Shipping Policy', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'return-policy' ) ) ?: '#' ); ?>"><?php esc_html_e( 'Return Policy', 'rigxmod-autozone' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'warranty' ) ) ?: '#' ); ?>"><?php esc_html_e( 'Warranty', 'rigxmod-autozone' ); ?></a></li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div class="footer-col">
                        <h4><?php esc_html_e( 'Newsletter', 'rigxmod-autozone' ); ?></h4>
                        <p style="color:rgba(255,255,255,0.7);font-size:13px;margin-bottom:16px;">
                            <?php esc_html_e( 'Subscribe for exclusive deals, new products and off-road tips.', 'rigxmod-autozone' ); ?>
                        </p>
                        <form style="display:flex;gap:8px;">
                            <input type="email" placeholder="<?php esc_attr_e( 'Your email', 'rigxmod-autozone' ); ?>" style="flex:1;padding:10px 12px;border:none;border-radius:4px;font-size:13px;">
                            <button type="submit" style="padding:10px 16px;background:#E31937;color:#fff;border:none;border-radius:4px;font-weight:600;cursor:pointer;font-size:13px;">
                                <?php esc_html_e( 'Join', 'rigxmod-autozone' ); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
                <div class="footer-copyright">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'rigxmod-autozone' ); ?>
                </div>
                <div class="footer-payment-methods">
                    <span>PayPal</span>
                    <span>VISA</span>
                    <span>MC</span>
                    <span>AMEX</span>
                    <span>Apple Pay</span>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
