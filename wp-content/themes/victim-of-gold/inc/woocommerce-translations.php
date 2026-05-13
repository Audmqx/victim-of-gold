<?php
/**
 * WooCommerce translations
 */

/**
 * WooCommerce string overrides per language.
 *
 * WordPress runs with fr_FR locale, so WooCommerce loads French .mo files
 * for everyone. We intercept here and return the right string per language.
 * For EN we return $text (the original English source string).
 * For RU/ZH we return manual translations.
 */
function vog_woocommerce_translations($translated_text, $text, $domain) {
    if ($domain !== 'woocommerce') {
        return $translated_text;
    }

    // get_locale() est switché par Polylang dès le début de la requête,
    // plus fiable que vog_current_lang() sur les pages WooCommerce.
    $lang = substr(get_locale(), 0, 2);

    if ($lang === 'fr') {
        $fr = [
            'Update cart'                                                => 'Mettre à jour le panier',
            'Apply coupon'                                               => 'Appliquer',
            'Proceed to checkout'                                        => 'Paiement',
            'Subtotal'                                                   => 'Sous-total',
            'Coupon code'                                                => 'Code promo',
            'Apply'                                                      => 'Appliquer',
            'Coupon "%s" does not exist!'                                => 'Le code promo "%s" n\'existe pas !',
            'Coupon code applied successfully.'                          => 'Code promo appliqué avec succès.',
            'Coupon code already applied!'                               => 'Ce code promo a déjà été appliqué !',
            'Please enter a coupon code.'                                => 'Veuillez entrer un code promo.',
            'Coupon "%s" removed.'                                       => 'Code promo "%s" supprimé.',
            'Sorry, this coupon is not applicable to your cart contents.' => 'Désolé, ce code promo n\'est pas applicable.',
            'Coupon "%s" has been applied to your cart.'                 => 'Le code promo "%s" a été appliqué.',
        ];
        return $fr[$text] ?? $translated_text;
    }

    if ($lang === 'en') {
        // $text is always the English source string in WooCommerce
        return $text;
    }

    if ($lang === 'ru') {
        $ru = [
            'Update cart'          => 'Обновить корзину',
            'Apply coupon'         => 'Применить',
            'Proceed to checkout'  => 'Оформить заказ',
            'Subtotal'             => 'Подытог',
            'Coupon code'          => 'Промокод',
            'Apply'                => 'Применить',
            'Add to cart'          => 'В корзину',
            'View cart'            => 'Просмотр корзины',
        ];
        return $ru[$text] ?? $text;
    }

    if ($lang === 'zh') {
        $zh = [
            'Update cart'          => '更新购物车',
            'Apply coupon'         => '使用',
            'Proceed to checkout'  => '结账',
            'Subtotal'             => '小计',
            'Coupon code'          => '优惠码',
            'Apply'                => '使用',
            'Add to cart'          => '加入购物车',
            'View cart'            => '查看购物车',
        ];
        return $zh[$text] ?? $text;
    }

    // Langue inconnue ou non détectée → on laisse WooCommerce/WordPress décider
    return $translated_text;
}
add_filter('gettext', 'vog_woocommerce_translations', 20, 3); 