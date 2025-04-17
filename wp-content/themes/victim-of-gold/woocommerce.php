<?php
/**
 * The template for displaying WooCommerce pages
 */

get_header();

if (is_checkout()) {
    // Vérifier si le panier est vide
    if (WC()->cart->is_empty() && !is_customize_preview()) {
        // Afficher un message si le panier est vide
        echo '<div class="woocommerce-notices-wrapper"><div class="woocommerce-error">Votre panier est vide. <a href="' . esc_url(wc_get_page_permalink('shop')) . '">Continuer vos achats</a></div></div>';
    } else {
        do_action('woocommerce_before_main_content');
        echo do_shortcode('[woocommerce_checkout]');
        do_action('woocommerce_after_main_content');
    }
} elseif (is_cart()) {
    do_action('woocommerce_before_main_content');
    echo do_shortcode('[woocommerce_cart]');
    do_action('woocommerce_after_main_content');
} elseif (is_account_page()) {
    do_action('woocommerce_before_main_content');
    echo do_shortcode('[woocommerce_my_account]');
    do_action('woocommerce_after_main_content');
} else {
    do_action('woocommerce_before_main_content');
    woocommerce_content();
    do_action('woocommerce_after_main_content');
}

get_footer(); 