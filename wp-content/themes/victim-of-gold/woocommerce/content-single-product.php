<?php
/**
 * The template for displaying product content in the single-product.php template
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>

<section class="product-section">
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'vog-single-product', $product ); ?>>
        <div class="vog-product-container">
            <div class="vog-product-gallery">
                <div class="woocommerce-product-gallery">
                    <?php
                    $post_thumbnail_id = $product->get_image_id();
                    $attachment_ids = $product->get_gallery_image_ids();
                    array_unshift($attachment_ids, $post_thumbnail_id); // Ajouter l'image principale aux miniatures
                    
                    // Image principale avec zoom
                    if ($post_thumbnail_id) {
                        $html = wc_get_gallery_image_html($post_thumbnail_id, true);
                        echo '<div class="woocommerce-product-gallery__image gallery-main-image">' . $html . '</div>';
                    }
                    ?>
                </div>

                <?php if ($attachment_ids) : ?>
                <div class="vog-thumbnails">
                    <?php
                    foreach ($attachment_ids as $index => $attachment_id) {
                        $full_size_image = wp_get_attachment_image_src($attachment_id, 'full');
                        $thumbnail = wp_get_attachment_image($attachment_id, 'thumbnail');
                        echo '<div class="vog-thumbnail" data-full-image="' . esc_url($full_size_image[0]) . '" data-index="' . $index . '">';
                        echo $thumbnail;
                        echo '</div>';
                    }
                    ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="vog-product-info">
                <?php
                // Titre et informations principales
                ?>
                <h1 class="product_title"><?php the_title(); ?></h1>
                <?php if ($product->get_short_description()) : ?>
                    <div class="product-subtitle"><?php echo apply_filters('the_excerpt', $product->get_short_description()); ?></div>
                <?php endif; ?>
                <div class="product-price"><?php echo $product->get_price_html(); ?></div>
                
                <?php
                // Bouton Ajouter au panier
                ?>
                <div class="vog-add-to-cart">
                    <?php 
                    // Modifier le texte du bouton
                    add_filter('woocommerce_product_single_add_to_cart_text', function($text) {
                        return 'Ajouter au panier';
                    });
                    woocommerce_template_single_add_to_cart(); 
                    ?>
                </div>

                <?php if ($product->get_sku()) : ?>
                    <div class="product-reference">
                        <?php echo esc_html__('Référence produit : ', 'victim-of-gold') . $product->get_sku(); ?>
                    </div>
                <?php endif; ?>
                
                <?php
                // Accordéon
                ?>
                <div class="product-accordion">
                    <div class="accordion-item">
                        <h3><?php esc_html_e('Description', 'victim-of-gold'); ?></h3>
                        <div class="accordion-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3><?php esc_html_e('Entretien', 'victim-of-gold'); ?></h3>
                        <div class="accordion-content">
                            <?php echo wpautop($product->get_meta('_entretien')); ?>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h3><?php esc_html_e('Taille', 'victim-of-gold'); ?></h3>
                        <div class="accordion-content">
                            <?php echo wpautop($product->get_meta('_taille')); ?>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h3><?php esc_html_e('Livraison & Retours', 'victim-of-gold'); ?></h3>
                        <div class="accordion-content">
                            <?php echo wpautop($product->get_meta('_livraison_retours')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
// Section "Vous aimerez aussi"
$upsells = $product->get_upsell_ids();

if ($upsells) : ?>
<section class="vog-upsells">
    <div class="vog-upsells-container">
        <h2><?php esc_html_e('Vous aimerez aussi', 'victim-of-gold'); ?></h2>
        <div class="vog-upsells-grid">
            <?php
            foreach ($upsells as $upsell_id) {
                $upsell_product = wc_get_product($upsell_id);
                if (!$upsell_product || !$upsell_product->is_visible()) {
                    continue;
                }
                ?>
                <div class="vog-upsell-item">
                    <a href="<?php echo esc_url($upsell_product->get_permalink()); ?>">
                        <?php echo $upsell_product->get_image('woocommerce_thumbnail'); ?>
                        <h3><?php echo esc_html($upsell_product->get_title()); ?></h3>
                        <div class="price"><?php echo $upsell_product->get_price_html(); ?></div>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php do_action( 'woocommerce_after_single_product' ); ?> 