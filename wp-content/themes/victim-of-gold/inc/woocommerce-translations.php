<?php
/**
 * WooCommerce translations
 */

function vog_woocommerce_translations($translated_text, $text, $domain) {
    if ($domain === 'woocommerce') {
        switch ($text) {
            case 'Update cart':
                $translated_text = 'Mettre à jour le panier';
                break;
            case 'Apply coupon':
                $translated_text = 'Appliquer';
                break;
            case 'Proceed to checkout':
                $translated_text = 'Paiement';
                break;
            case 'Subtotal':
                $translated_text = 'Sous-total';
                break;
            case 'Total':
                $translated_text = 'Total';
                break;
            case 'Coupon code':
                $translated_text = 'Code promo';
                break;
            case 'Apply':
                $translated_text = 'Appliquer';
                break;
            case 'Coupon "%s" does not exist!':
                $translated_text = 'Le code promo "%s" n\'existe pas !';
                break;
            case 'Coupon code applied successfully.':
                $translated_text = 'Code promo appliqué avec succès.';
                break;
            case 'Coupon code already applied!':
                $translated_text = 'Ce code promo a déjà été appliqué !';
                break;
            case 'Please enter a coupon code.':
                $translated_text = 'Veuillez entrer un code promo.';
                break;
            case 'Coupon "%s" removed.':
                $translated_text = 'Code promo "%s" supprimé.';
                break;
            case 'Sorry, this coupon is not applicable to your cart contents.':
                $translated_text = 'Désolé, ce code promo n\'est pas applicable aux articles de votre panier.';
                break;
            case 'Coupon "%s" has been applied to your cart.':
                $translated_text = 'Le code promo "%s" a été appliqué à votre panier.';
                break;
        }
    }
    return $translated_text;
}
add_filter('gettext', 'vog_woocommerce_translations', 20, 3); 