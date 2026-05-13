<?php
/**
 * WooCommerce translations
 */

/**
 * Apply French WooCommerce string overrides only when the current language is French.
 * For other languages, WooCommerce's own .mo translations take over.
 */
function vog_woocommerce_translations($translated_text, $text, $domain) {
    if ($domain !== 'woocommerce' || vog_current_lang() !== 'fr') {
        return $translated_text;
    }

    $fr = [
        'Update cart'                                                        => 'Mettre à jour le panier',
        'Apply coupon'                                                        => 'Appliquer',
        'Proceed to checkout'                                                 => 'Paiement',
        'Subtotal'                                                            => 'Sous-total',
        'Total'                                                               => 'Total',
        'Coupon code'                                                         => 'Code promo',
        'Apply'                                                               => 'Appliquer',
        'Coupon "%s" does not exist!'                                         => 'Le code promo "%s" n\'existe pas !',
        'Coupon code applied successfully.'                                   => 'Code promo appliqué avec succès.',
        'Coupon code already applied!'                                        => 'Ce code promo a déjà été appliqué !',
        'Please enter a coupon code.'                                         => 'Veuillez entrer un code promo.',
        'Coupon "%s" removed.'                                                => 'Code promo "%s" supprimé.',
        'Sorry, this coupon is not applicable to your cart contents.'         => 'Désolé, ce code promo n\'est pas applicable aux articles de votre panier.',
        'Coupon "%s" has been applied to your cart.'                          => 'Le code promo "%s" a été appliqué à votre panier.',
    ];

    return $fr[$text] ?? $translated_text;
}
add_filter('gettext', 'vog_woocommerce_translations', 20, 3); 