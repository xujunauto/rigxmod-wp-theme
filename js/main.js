/**
 * RIGX MOD AutoZone - Main JavaScript
 *
 * @package RIGXMOD_AutoZone
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        // Mobile search toggle
        $('.mobile-search-toggle').on('click', function() {
            $('.header-search').toggleClass('active');
        });

        // Quantity input handlers
        $('.quantity-input .qty-plus').on('click', function() {
            var input = $(this).siblings('input');
            var val = parseInt(input.val(), 10) || 1;
            var max = parseInt(input.attr('max'), 10) || 999;
            if (val < max) {
                input.val(val + 1).trigger('change');
            }
        });

        $('.quantity-input .qty-minus').on('click', function() {
            var input = $(this).siblings('input');
            var val = parseInt(input.val(), 10) || 1;
            var min = parseInt(input.attr('min'), 10) || 1;
            if (val > min) {
                input.val(val - 1).trigger('change');
            }
        });

        // Product tabs
        $('.product-tabs-nav button').on('click', function() {
            var tabId = $(this).data('tab');

            $('.product-tabs-nav button').removeClass('active');
            $(this).addClass('active');

            $('.product-tab-content').removeClass('active');
            $('#' + tabId).addClass('active');
        });

        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
            }
        });

        // Sticky header shadow on scroll
        var header = $('.site-header');
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 10) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
        });

        // Add to cart AJAX feedback
        $(document).on('added_to_cart', function() {
            // Update cart count in header
            $.ajax({
                url: wc_cart_fragments_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'woocommerce_get_refreshed_fragments'
                },
                success: function(response) {
                    if (response.fragments) {
                        // Cart fragments are handled by WooCommerce automatically
                    }
                }
            });
        });

        // Vehicle modal close on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                var modal = document.getElementById('vehicle-modal');
                if (modal && modal.style.display === 'flex') {
                    modal.style.display = 'none';
                }
            }
        });

    });

})(jQuery);
