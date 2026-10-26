<?php
/**
 * The header for our theme
 *
 * @package RIGXMOD_AutoZone
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'rigxmod-autozone' ); ?></a>

    <header id="masthead" class="site-header">
        <!-- Top Promo Bar -->
        <div class="header-top-bar">
            <div class="container">
                <span><?php echo esc_html( get_theme_mod( 'rigxmod_top_bar_text', 'Premium Off-Road Parts | Worldwide Shipping | Quality Guaranteed' ) ); ?></span>
            </div>
        </div>

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <!-- Logo -->
                <div class="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php if ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            RIGX <span>MOD</span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Mobile hamburger -->
                <button type="button" class="header-mobile-toggle" id="rigx-mobile-toggle" aria-label="Menu" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>


                <!-- Vehicle Selector (for off-road parts - "Add Your Vehicle" style) -->
                <div class="header-vehicle-selector" onclick="document.getElementById('vehicle-modal').style.display='flex'">
                    <div class="header-vehicle-selector-icon">
                        <i class="fas fa-truck-pickup"></i>
                    </div>
                    <div>
                        <div class="header-vehicle-selector-label" id="vm-header-label"><?php esc_html_e( 'Select Your', 'rigxmod-autozone' ); ?></div>
                        <div class="header-vehicle-selector-value" id="vm-header-value"><?php esc_html_e( 'Vehicle', 'rigxmod-autozone' ); ?></div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="header-search">
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search for parts, products...', 'rigxmod-autozone' ); ?>" value="<?php echo get_search_query(); ?>">
                        <button type="submit" aria-label="<?php esc_attr_e( 'Search', 'rigxmod-autozone' ); ?>">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="hidden" name="post_type" value="product">
                    </form>
                </div>

                <!-- Header Actions -->
                <div class="header-actions">
                    <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="header-action-item">
                        <i class="fas fa-user"></i>
                        <span><?php esc_html_e( 'Account', 'rigxmod-autozone' ); ?></span>
                    </a>

                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-action-item">
                        <i class="fas fa-shopping-cart"></i>
                        <span><?php esc_html_e( 'Shopping Cart', 'rigxmod-autozone' ); ?></span>
                        <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
                            <span class="cart-badge"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                        <?php endif; ?>
                    </a>

                    <div class="header-action-item header-gtranslate">
                        <?php echo do_shortcode( '[gtranslate]' ); ?>
                    </div>
                </div>
                <style>
                    .header-gtranslate { display:flex; align-items:center; position:relative; }
                    .header-gtranslate .gtranslate_wrapper,
                    .header-gtranslate #gt_float_wrapper { position:static !important; box-shadow:none !important; }
                    .header-gtranslate .gt_float_switcher { position:relative !important; box-shadow:none !important; border:1px solid #e5e5e5 !important; border-radius:4px !important; font-size:13px !important; padding:4px 8px !important; cursor:pointer !important; }
                    .header-gtranslate .gt_options {
                        position:absolute !important;
                        top:100% !important;
                        bottom:auto !important;
                        left:0 !important;
                        right:auto !important;
                        margin-top:4px !important;
                        max-height:300px !important;
                        overflow-y:auto !important;
                        box-shadow:0 4px 12px rgba(0,0,0,0.15) !important;
                        border-radius:4px !important;
                        z-index:99999 !important;
                        background:#fff !important;
                    }
                    .header-gtranslate .gt_options a {
                        display:block !important;
                        padding:8px 12px !important;
                        white-space:nowrap !important;
                        font-size:13px !important;
                        color:#333 !important;
                    }
                    .header-gtranslate .gt_options a:hover { background:#f5f5f5 !important; }
                    .header-gtranslate img { vertical-align:middle; }
                    .header-gtranslate select { font-size:13px; padding:4px 8px; border:1px solid #ddd; border-radius:4px; background:#fff; }
                </style>
            </div>
        </div>

        <!-- Category Navigation -->
        <nav class="header-cat-nav">
            <div class="container">
                <?php
                if ( has_nav_menu( 'category' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'category',
                        'menu_id'        => 'category-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ) );
                } else {
                    // Fallback: three main entry points (scales as the model line-up grows)
                    $rigx_shop_url    = get_permalink( wc_get_page_id( 'shop' ) );
                    $rigx_about_page  = get_page_by_path( 'about-us' );
                    $rigx_contact_page = get_page_by_path( 'contact' );
                    $rigx_about_url   = $rigx_about_page ? get_permalink( $rigx_about_page ) : home_url( '/about-us/' );
                    $rigx_contact_url = $rigx_contact_page ? get_permalink( $rigx_contact_page ) : home_url( '/contact/' );

                    echo '<ul>';
                    echo '<li><a href="' . esc_url( $rigx_shop_url ) . '">' . esc_html__( 'Products', 'rigxmod-autozone' ) . '</a></li>';
                    echo '<li><a href="' . esc_url( $rigx_about_url ) . '">' . esc_html__( 'About Us', 'rigxmod-autozone' ) . '</a></li>';
                    echo '<li><a href="' . esc_url( $rigx_contact_url ) . '">' . esc_html__( 'Contact Us', 'rigxmod-autozone' ) . '</a></li>';
                    echo '</ul>';
                }
                ?>
            </div>
        </nav>
    </header><!-- #masthead -->

    <!-- Vehicle Modal -->
    <style>
        #vehicle-modal .vm-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
        #vehicle-modal .vm-card{border:1px solid #e5e5e5;border-radius:6px;padding:18px 12px;text-align:center;cursor:pointer;transition:all .2s;background:#fff;}
        #vehicle-modal .vm-card:hover{border-color:var(--rm-primary);box-shadow:0 2px 8px rgba(0,0,0,.1);}
        #vehicle-modal .vm-card.selected{border-color:var(--rm-primary);background:#fdf0f1;box-shadow:0 2px 8px rgba(227,25,55,.15);}
        #vehicle-modal .vm-card i{font-size:24px;color:var(--rm-primary);margin-bottom:8px;}
        #vehicle-modal .vm-card strong{display:block;font-size:13px;line-height:1.3;}
        #vehicle-modal .vm-step-label{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#999;margin-bottom:10px;}
        #vehicle-modal #vm-confirm{width:100%;padding:12px;margin-top:20px;background:var(--rm-primary);color:#fff;border:none;border-radius:4px;font-weight:600;cursor:pointer;}
        #vehicle-modal #vm-confirm:disabled{background:#ccc;cursor:not-allowed;}
        #vehicle-modal #vm-back{background:none;border:none;color:#666;font-size:13px;cursor:pointer;padding:0;margin-bottom:12px;}
        #vehicle-modal #vm-back:hover{color:var(--rm-primary);}
        #vehicle-modal #vm-clear{width:100%;padding:10px;margin-top:10px;background:none;color:#999;border:1px solid #e5e5e5;border-radius:4px;font-size:13px;cursor:pointer;}
        #vehicle-modal #vm-clear:hover{color:var(--rm-primary);border-color:var(--rm-primary);}
        #vehicle-modal .vm-current{background:#fdf0f1;border:1px solid var(--rm-primary);border-radius:6px;padding:12px;margin-bottom:16px;font-size:14px;display:none;}
        @media (max-width:480px){#vehicle-modal .vm-grid{grid-template-columns:1fr;}}
    </style>
    <div id="vehicle-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;" onclick="if(event.target===this)this.style.display='none'">
        <div style="background:#fff;padding:32px 40px;border-radius:8px;max-width:520px;width:90%;position:relative;">
            <button type="button" aria-label="<?php esc_attr_e( 'Close', 'rigxmod-autozone' ); ?>" onclick="document.getElementById('vehicle-modal').style.display='none'" style="position:absolute;top:12px;right:16px;background:none;border:none;font-size:22px;color:#999;cursor:pointer;line-height:1;">&times;</button>
            <h3 style="margin-bottom:8px;"><?php esc_html_e( 'Select Your Vehicle', 'rigxmod-autozone' ); ?></h3>
            <p style="color:#666;margin-bottom:20px;font-size:13px;"><?php esc_html_e( 'Choose your make and model to see parts that fit.', 'rigxmod-autozone' ); ?></p>

            <div class="vm-current" id="vm-current"></div>

            <div id="vm-step-make">
                <div class="vm-step-label"><?php esc_html_e( '1. Select Make', 'rigxmod-autozone' ); ?></div>
                <div class="vm-grid" id="vm-make-list"></div>
            </div>

            <div id="vm-step-model" style="display:none;margin-top:20px;">
                <button type="button" id="vm-back">&larr; <?php esc_html_e( 'Back to makes', 'rigxmod-autozone' ); ?></button>
                <div class="vm-step-label"><?php esc_html_e( '2. Select Model', 'rigxmod-autozone' ); ?></div>
                <div class="vm-grid" id="vm-model-list"></div>
            </div>

            <button type="button" id="vm-confirm" disabled><?php esc_html_e( 'Confirm &amp; View Parts', 'rigxmod-autozone' ); ?></button>
            <button type="button" id="vm-clear" style="display:none;"><?php esc_html_e( 'Clear my vehicle', 'rigxmod-autozone' ); ?></button>
        </div>
    </div>

    <?php
    // Read the vehicle categories that actually contain products.
    // NOTE: the Jetour vehicle categories (Jetour T1 / T2 / G700) live at the
    // top level of product_cat, so query top-level terms and keep the Jetour ones.
    $rigx_vehicles = array();
    $rigx_terms    = get_terms( array(
        'taxonomy'   => 'product_cat',
        'parent'     => 0,
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ) );
    if ( ! is_wp_error( $rigx_terms ) ) {
        foreach ( $rigx_terms as $rigx_term ) {
            if ( false === stripos( $rigx_term->name, 'Jetour' ) ) {
                continue;
            }
            $rigx_link = get_term_link( $rigx_term );
            if ( is_wp_error( $rigx_link ) ) {
                continue;
            }
            $rigx_parts = preg_split( '/\s+/', trim( $rigx_term->name ), 2 );
            $rigx_brand = isset( $rigx_parts[0] ) ? $rigx_parts[0] : $rigx_term->name;
            $rigx_key   = sanitize_title( $rigx_brand );
            if ( ! isset( $rigx_vehicles[ $rigx_key ] ) ) {
                $rigx_vehicles[ $rigx_key ] = array( 'name' => $rigx_brand, 'models' => array() );
            }
            $rigx_vehicles[ $rigx_key ]['models'][] = array(
                'name' => $rigx_term->name,
                'url'  => $rigx_link,
            );
        }
    }
    ?>
    <script>
    (function () {
        var VEHICLES = <?php echo wp_json_encode( $rigx_vehicles ); ?>;
        var HOME_URL = '<?php echo esc_js( home_url( '/' ) ); ?>';
        var STORE_KEY = 'rigxmod_vehicle';

        var modal       = document.getElementById('vehicle-modal');
        var stepMake    = document.getElementById('vm-step-make');
        var stepModel   = document.getElementById('vm-step-model');
        var modelList   = document.getElementById('vm-model-list');
        var btnConfirm  = document.getElementById('vm-confirm');
        var btnBack     = document.getElementById('vm-back');
        var btnClear    = document.getElementById('vm-clear');
        var currentBox  = document.getElementById('vm-current');
        var headerLabel = document.getElementById('vm-header-label');
        var headerValue = document.getElementById('vm-header-value');

        var selectedMake = null, selectedModel = null;

        function getStored() {
            try { return JSON.parse(localStorage.getItem(STORE_KEY) || 'null'); } catch (e) { return null; }
        }

        function renderHeader() {
            var v = getStored();
            if (v && VEHICLES[v.make]) {
                headerLabel.textContent = '<?php echo esc_js( __( 'Your Vehicle', 'rigxmod-autozone' ) ); ?>';
                headerValue.textContent = v.model;
            } else {
                headerLabel.textContent = '<?php echo esc_js( __( 'Select Your', 'rigxmod-autozone' ) ); ?>';
                headerValue.textContent = '<?php echo esc_js( __( 'Vehicle', 'rigxmod-autozone' ) ); ?>';
            }
        }

        function renderCurrentBox() {
            var v = getStored();
            if (v && VEHICLES[v.make]) {
                currentBox.style.display = 'block';
                currentBox.textContent = '<?php echo esc_js( __( 'Currently selected:', 'rigxmod-autozone' ) ); ?> ' +
                    VEHICLES[v.make].name + ' ' + v.model;
                btnClear.style.display = 'block';
            } else {
                currentBox.style.display = 'none';
                btnClear.style.display = 'none';
            }
        }

        function resetSteps() {
            selectedMake = null;
            selectedModel = null;
            stepMake.style.display = 'block';
            stepModel.style.display = 'none';
            btnConfirm.disabled = true;
            Array.prototype.forEach.call(stepMake.querySelectorAll('.vm-card'), function (card) {
                card.classList.remove('selected');
            });
        }

        // Make selection (vehicle data is generated from the product catalog)
        function renderMakes() {
            var makeBox = document.getElementById('vm-make-list');
            makeBox.innerHTML = '';
            Object.keys(VEHICLES).forEach(function (makeKey) {
                var make = VEHICLES[makeKey];
                var card = document.createElement('div');
                card.className = 'vm-card';
                card.setAttribute('data-make', makeKey);
                card.innerHTML = '<i class="fas fa-truck-pickup"></i><strong>' + make.name + '</strong>';
                card.addEventListener('click', function () {
                    Array.prototype.forEach.call(makeBox.querySelectorAll('.vm-card'), function (c) {
                        c.classList.remove('selected');
                    });
                    card.classList.add('selected');
                    selectedMake = makeKey;
                    selectedModel = null;

                    // Render models for chosen make
                    modelList.innerHTML = '';
                    VEHICLES[selectedMake].models.forEach(function (m) {
                        var div = document.createElement('div');
                        div.className = 'vm-card';
                        div.innerHTML = '<i class="fas fa-car"></i><strong>' + m.name + '</strong>';
                        div.addEventListener('click', function () {
                            Array.prototype.forEach.call(modelList.querySelectorAll('.vm-card'), function (c) {
                                c.classList.remove('selected');
                            });
                            div.classList.add('selected');
                            selectedModel = m;
                            btnConfirm.disabled = false;
                        });
                        modelList.appendChild(div);
                    });

                    stepModel.style.display = 'block';
                    btnConfirm.disabled = true;
                });
                makeBox.appendChild(card);
            });
        }

        btnBack.addEventListener('click', function () {
            stepModel.style.display = 'none';
            selectedMake = null;
            selectedModel = null;
            btnConfirm.disabled = true;
            Array.prototype.forEach.call(stepMake.querySelectorAll('.vm-card'), function (c) {
                c.classList.remove('selected');
            });
        });

        btnConfirm.addEventListener('click', function () {
            if (!selectedMake || !selectedModel) { return; }
            localStorage.setItem(STORE_KEY, JSON.stringify({ make: selectedMake, model: selectedModel.name }));
            renderHeader();
            modal.style.display = 'none';
            window.location.href = selectedModel.url;
        });

        btnClear.addEventListener('click', function () {
            localStorage.removeItem(STORE_KEY);
            renderHeader();
            resetSteps();
            renderCurrentBox();
        });

        // Init + re-init every time modal opens
        renderMakes();
        renderHeader();
        document.querySelector('.header-vehicle-selector').addEventListener('click', function () {
            resetSteps();
            renderCurrentBox();
        });
    })();
    </script>

    <script>
    // Mobile hamburger: toggle header nav + search drawer
    (function(){
        var btn = document.getElementById('rigx-mobile-toggle');
        if (!btn) return;
        var nav = document.querySelector('.header-cat-nav');
        var search = document.querySelector('.header-search');
        btn.addEventListener('click', function(){
            var isOpen = nav.classList.toggle('is-open');
            if (search) {
                if (isOpen) { search.classList.add('is-open'); }
                else { search.classList.remove('is-open'); }
            }
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    })();
    </script>

    <div id="content" class="site-content" tabindex="-1">


