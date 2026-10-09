<?php
/**
 * Template Name: Contact Page
 *
 * The template for displaying the contact page with a functional contact form.
 *
 * @package RIGXMOD_AutoZone
 */

get_header();

// Contact form handler
$cf_message = '';
$cf_type    = '';
if ( isset( $_POST['rigxmod_cf_submit'] ) ) {
    $cf_nonce = isset( $_POST['rigxmod_cf_nonce'] ) ? wp_unslash( $_POST['rigxmod_cf_nonce'] ) : '';
    if ( ! wp_verify_nonce( $cf_nonce, 'rigxmod_contact_form' ) ) {
        $cf_message = __( 'Security check failed. Please try again.', 'rigxmod-autozone' );
        $cf_type    = 'error';
    } else {
        $cf_name    = sanitize_text_field( wp_unslash( $_POST['rigxmod_cf_name'] ?? '' ) );
        $cf_email   = sanitize_email( wp_unslash( $_POST['rigxmod_cf_email'] ?? '' ) );
        $cf_subject = sanitize_text_field( wp_unslash( $_POST['rigxmod_cf_subject'] ?? '' ) );
        $cf_msg     = sanitize_textarea_field( wp_unslash( $_POST['rigxmod_cf_message'] ?? '' ) );

        if ( empty( $cf_name ) || empty( $cf_msg ) ) {
            $cf_message = __( 'Please fill in your name and message.', 'rigxmod-autozone' );
            $cf_type    = 'error';
        } elseif ( ! is_email( $cf_email ) ) {
            $cf_message = __( 'Please enter a valid email address.', 'rigxmod-autozone' );
            $cf_type    = 'error';
        } else {
            // Store in database
            $messages       = get_option( 'rigxmod_contact_messages', array() );
            $messages[]     = array(
                'name'    => $cf_name,
                'email'   => $cf_email,
                'subject' => $cf_subject,
                'message' => $cf_msg,
                'date'    => current_time( 'mysql' ),
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
            );
            update_option( 'rigxmod_contact_messages', $messages );

            // Attempt email notification
            $mail_subject = '[Contact] ' . ( $cf_subject ? $cf_subject : __( 'New inquiry from ', 'rigxmod-autozone' ) . $cf_name );
            $mail_body    = "Name: $cf_name\nEmail: $cf_email\nSubject: $cf_subject\n\nMessage:\n$cf_msg\n\nDate: " . current_time( 'mysql' );
            wp_mail( 'sales@rigxmod.com', $mail_subject, $mail_body, "From: $cf_name <$cf_email>" );

            $cf_message = __( 'Thank you! Your message has been sent. We will get back to you within 24 hours.', 'rigxmod-autozone' );
            $cf_type    = 'success';
        }
    }
}
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="page-header">
            <div class="container">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>

        <div class="container" style="padding: 48px 0;">
            <div style="display:grid;grid-template-columns:1fr 1.5fr;gap:48px;align-items:start;">

                <!-- Contact Info -->
                <div>
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>

                    <div style="margin-top:32px;padding:24px;background:#f8f8f8;border-radius:8px;">
                        <h3 style="font-size:18px;margin-bottom:20px;color:#222;"><?php esc_html_e( 'Get in Touch', 'rigxmod-autozone' ); ?></h3>

                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                            <div style="width:40px;height:40px;background:#E31937;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-envelope" style="color:#fff;font-size:16px;"></i>
                            </div>
                            <div>
                                <div style="font-size:12px;color:#999;text-transform:uppercase;letter-spacing:0.05em;"><?php esc_html_e( 'Email', 'rigxmod-autozone' ); ?></div>
                                <a href="mailto:sales@rigxmod.com" style="color:#222;font-size:14px;">sales@rigxmod.com</a>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                            <div style="width:40px;height:40px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fab fa-whatsapp" style="color:#fff;font-size:16px;"></i>
                            </div>
                            <div>
                                <div style="font-size:12px;color:#999;text-transform:uppercase;letter-spacing:0.05em;"><?php esc_html_e( 'WhatsApp', 'rigxmod-autozone' ); ?></div>
                                <a href="https://wa.me/8619157298808" target="_blank" rel="noopener" style="color:#222;font-size:14px;">+86 191 5729 8808</a>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:40px;height:40px;background:#F38020;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-clock" style="color:#fff;font-size:16px;"></i>
                            </div>
                            <div>
                                <div style="font-size:12px;color:#999;text-transform:uppercase;letter-spacing:0.05em;"><?php esc_html_e( 'Business Hours', 'rigxmod-autozone' ); ?></div>
                                <span style="color:#222;font-size:14px;"><?php esc_html_e( 'Mon-Fri 9:00 - 18:00 (GMT+8)', 'rigxmod-autozone' ); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div>
                    <?php if ( $cf_message ) : ?>
                        <div style="padding:16px 20px;border-radius:6px;margin-bottom:24px;background:<?php echo $cf_type === 'success' ? '#e8f5e9' : '#fce4e4'; ?>;border:1px solid <?php echo $cf_type === 'success' ? '#4caf50' : '#E31937'; ?>;color:<?php echo $cf_type === 'success' ? '#2e7d32' : '#B3121D'; ?>;font-size:14px;">
                            <?php echo esc_html( $cf_message ); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="" style="display:flex;flex-direction:column;gap:20px;">
                        <?php wp_nonce_field( 'rigxmod_contact_form', 'rigxmod_cf_nonce' ); ?>

                        <div>
                            <label for="rigxmod_cf_name" style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#222;"><?php esc_html_e( 'Your Name *', 'rigxmod-autozone' ); ?></label>
                            <input type="text" id="rigxmod_cf_name" name="rigxmod_cf_name" required style="width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:4px;font-size:14px;box-sizing:border-box;">
                        </div>

                        <div>
                            <label for="rigxmod_cf_email" style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#222;"><?php esc_html_e( 'Email Address *', 'rigxmod-autozone' ); ?></label>
                            <input type="email" id="rigxmod_cf_email" name="rigxmod_cf_email" required style="width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:4px;font-size:14px;box-sizing:border-box;">
                        </div>

                        <div>
                            <label for="rigxmod_cf_subject" style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#222;"><?php esc_html_e( 'Subject', 'rigxmod-autozone' ); ?></label>
                            <input type="text" id="rigxmod_cf_subject" name="rigxmod_cf_subject" style="width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:4px;font-size:14px;box-sizing:border-box;">
                        </div>

                        <div>
                            <label for="rigxmod_cf_message" style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#222;"><?php esc_html_e( 'Message *', 'rigxmod-autozone' ); ?></label>
                            <textarea id="rigxmod_cf_message" name="rigxmod_cf_message" rows="6" required style="width:100%;padding:12px 14px;border:1px solid #ddd;border-radius:4px;font-size:14px;box-sizing:border-box;resize:vertical;"></textarea>
                        </div>

                        <button type="submit" name="rigxmod_cf_submit" value="1" style="padding:14px 32px;background:#E31937;color:#fff;border:none;border-radius:4px;font-size:15px;font-weight:600;cursor:pointer;align-self:flex-start;transition:background 0.2s;" onmouseover="this.style.background='#B3121D'" onmouseout="this.style.background='#E31937'">
                            <?php esc_html_e( 'Send Message', 'rigxmod-autozone' ); ?>
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
