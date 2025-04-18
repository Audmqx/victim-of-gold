<?php
/**
 * The Template for displaying product archives, including the main shop page
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<div class="shop-container">
    <div class="shop-hero">
        <div class="shop-hero__content">
            <h1 class="shop-hero__title">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Boutique Graphisme.svg" alt="Boutique" class="shop-hero__title-svg">
            </h1>
        </div>
    </div>

    <div class="shop-content">
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