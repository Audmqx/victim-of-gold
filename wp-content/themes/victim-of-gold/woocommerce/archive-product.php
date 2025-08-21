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
            // Récupérer tous les produits avec un ordre personnalisé
            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1, // Afficher tous les produits (-1 = pas de limite)
                'orderby' => 'menu_order', // Ordre par menu_order (ordre personnalisé)
                'order' => 'ASC', // Ordre croissant
                'meta_query' => [
                    [
                        'key' => '_visibility',
                        'value' => ['catalog', 'visible'],
                        'compare' => 'IN'
                    ]
                ]
            ];

$products_query = new WP_Query($args);

if ($products_query->have_posts()) {
    woocommerce_product_loop_start();

    while ($products_query->have_posts()) {
        $products_query->the_post();
        do_action('woocommerce_shop_loop');
        wc_get_template_part('content', 'product');
    }

    woocommerce_product_loop_end();

    // Réinitialiser les données de post
    wp_reset_postdata();

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
