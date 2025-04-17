<?php
/**
 * The Template for displaying product archives, including the main shop page
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<div class="shop-container">
    <div class="shop-header">
        <div class="shop-header-content">
            <h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>
            <div class="shop-filters">
                <?php do_action('woocommerce_before_shop_loop'); ?>
            </div>
        </div>
    </div>

    <div class="shop-content">
        <div class="shop-sidebar">
            <div class="shop-sidebar-content">
                <?php do_action('woocommerce_sidebar'); ?>
            </div>
        </div>

        <div class="shop-products">
            <?php
            if (woocommerce_product_loop()) {
                woocommerce_product_loop_start();

                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();
                        do_action('woocommerce_shop_loop');
                        wc_get_template_part('content', 'product');
                    }
                }

                woocommerce_product_loop_end();

                do_action('woocommerce_after_shop_loop');
            } else {
                do_action('woocommerce_no_products_found');
            }
            ?>
        </div>
    </div>
</div>

<?php
get_footer('shop'); 