<?php
/**
 * The template for displaying WooCommerce pages
 */

get_header();

if (is_checkout()) {
    do_action('woocommerce_before_main_content');
    echo do_shortcode('[woocommerce_checkout]');
    do_action('woocommerce_after_main_content');
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