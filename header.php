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
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rigxmod-autozone' ); ?></a>

    <header id="masthead" class="site-header">
        <!-- Top Promo Bar -->
        <div class="header-top-bar">
            <div class="container">
                <span><?php echo esc_html( get_theme_mod( 'rigxmod_top_bar_text', 'FREE SHIPPING on orders over $299. Worldwide delivery.' ) ); ?></span>
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
                        <span><?php esc_html_e( 'Cart', 'rigxmod-autozone' ); ?></span>
                        <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
                            <span class="cart-badge"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
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
                    // Fallback: show product categories
                    $categories = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'parent'     => 0,
                        'number'     => 8,
                    ) );
                    if ( $categories && ! is_wp_error( $categories ) ) {
                        echo '<ul>';
                        foreach ( $categories as $cat ) {
                            echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
                        }
                        echo '</ul>';
                    }
                }
                ?>
            </div>
        </nav>
    </header><!-- #masthead -->

    <!-- Vehicle Modal -->
    <style>
        #vehicle-modal .vm-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
        #vehicle-modal .vm-card{border:1px solid #e5e5e5;border-radius:6px;padding:18px 12px;text-align:center;cursor:pointer;transition:all .2s;background:#fff;}
        #vehicle-modal .vm-card:hover{border-color:#E31937;box-shadow:0 2px 8px rgba(0,0,0,.1);}
        #vehicle-modal .vm-card.selected{border-color:#E31937;background:#fdf0f1;box-shadow:0 2px 8px rgba(227,25,55,.15);}
        #vehicle-modal .vm-card i{font-size:24px;color:#E31937;margin-bottom:8px;}
        #vehicle-modal .vm-card strong{display:block;font-size:13px;line-height:1.3;}
        #vehicle-modal .vm-step-label{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#999;margin-bottom:10px;}
        #vehicle-modal #vm-confirm{width:100%;padding:12px;margin-top:20px;background:#E31937;color:#fff;border:none;border-radius:4px;font-weight:600;cursor:pointer;}
        #vehicle-modal #vm-confirm:disabled{background:#ccc;cursor:not-allowed;}
        #vehicle-modal #vm-back{background:none;border:none;color:#666;font-size:13px;cursor:pointer;padding:0;margin-bottom:12px;}
        #vehicle-modal #vm-back:hover{color:#E31937;}
        #vehicle-modal #vm-clear{width:100%;padding:10px;margin-top:10px;background:none;color:#999;border:1px solid #e5e5e5;border-radius:4px;font-size:13px;cursor:pointer;}
        #vehicle-modal #vm-clear:hover{color:#E31937;border-color:#E31937;}
        #vehicle-modal .vm-current{background:#fdf0f1;border:1px solid #E31937;border-radius:6px;padding:12px;margin-bottom:16px;font-size:14px;display:none;}
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
                <div class="vm-grid">
                    <div class="vm-card" data-make="gwm"><i class="fas fa-truck-pickup"></i><strong>GWM TANK</strong></div>
                    <div class="vm-card" data-make="jetour"><i class="fas fa-truck-pickup"></i><strong>Jetour</strong></div>
                    <div class="vm-card" data-make="byd"><i class="fas fa-truck-pickup"></i><strong>BYD</strong></div>
                </div>
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

    <script>
    (function () {
        var VEHICLES = {
            gwm:    { name: 'GWM',    models: [ { name: 'TANK 300', query: 'TANK 300' } ] },
            jetour: { name: 'Jetour', models: [ { name: 'T2', query: 'Jetour T2' } ] },
            byd:    { name: 'BYD',    models: [ { name: 'Formula Leopard 5', query: 'Formula Leopard 5' } ] }
        };
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

        // Make selection
        Array.prototype.forEach.call(stepMake.querySelectorAll('.vm-card'), function (card) {
            card.addEventListener('click', function () {
                Array.prototype.forEach.call(stepMake.querySelectorAll('.vm-card'), function (c) {
                    c.classList.remove('selected');
                });
                card.classList.add('selected');
                selectedMake = card.getAttribute('data-make');
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
        });

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
            window.location.href = HOME_URL + '?s=' + encodeURIComponent(selectedModel.query) + '&post_type=product';
        });

        btnClear.addEventListener('click', function () {
            localStorage.removeItem(STORE_KEY);
            renderHeader();
            resetSteps();
            renderCurrentBox();
        });

        // Init + re-init every time modal opens
        renderHeader();
        document.querySelector('.header-vehicle-selector').addEventListener('click', function () {
            resetSteps();
            renderCurrentBox();
        });
    })();
    </script>

    <div id="content" class="site-content">
