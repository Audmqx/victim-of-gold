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
            // Récupérer les produits dans l'ordre spécifique des IDs
            $product_ids = [217, 122, 116, 119, 125, 129, 138, 135, 136, 137];

// Première requête : produits spécifiques dans l'ordre défini
$args_specific = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post__in' => $product_ids,
    'orderby' => 'post__in', // Respecte l'ordre du tableau post__in
];

$products_specific = new WP_Query($args_specific);

// Deuxième requête : tous les autres produits
$args_others = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post__not_in' => $product_ids, // Exclut les produits déjà affichés
    'orderby' => 'menu_order',
    'order' => 'ASC',
];

$products_others = new WP_Query($args_others);

// Afficher les produits
if ($products_specific->have_posts() || $products_others->have_posts()) {
    woocommerce_product_loop_start();

    // 1. Afficher d'abord les produits spécifiques
    if ($products_specific->have_posts()) {
        while ($products_specific->have_posts()) {
            $products_specific->the_post();
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
        }
        wp_reset_postdata();
    }

    // 2. Puis afficher tous les autres produits
    if ($products_others->have_posts()) {
        while ($products_others->have_posts()) {
            $products_others->the_post();
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
        }
        wp_reset_postdata();
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
