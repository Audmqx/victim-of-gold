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
        // Ne pas utiliser les hooks before/after_main_content ici car ils sont déjà dans le shortcode
        echo do_shortcode('[woocommerce_checkout]');
    }
} elseif (is_cart()) {
    // Ne pas utiliser les hooks before/after_main_content ici car ils sont déjà dans le shortcode
    echo do_shortcode('[woocommerce_cart]');
} elseif (is_account_page()) {
    // Ne pas utiliser les hooks before/after_main_content ici car ils sont déjà dans le shortcode
    echo do_shortcode('[woocommerce_my_account]');
} else {
    // Pour les autres pages WooCommerce, utiliser les hooks standard
    do_action('woocommerce_before_main_content');
    woocommerce_content();
    do_action('woocommerce_after_main_content');
}

get_footer(); 