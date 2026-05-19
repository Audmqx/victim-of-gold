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

    // vog_current_lang() gère le fallback cookie pour les pages WooCommerce
    // où Polylang ne détecte pas la langue (URL sans préfixe).
    $lang = function_exists('vog_current_lang') ? vog_current_lang() : 'fr';

    if ($lang === 'fr') {
        $fr = [
            // Panier
            'Update cart'                                                => 'Mettre à jour le panier',
            'Apply coupon'                                               => 'Appliquer',
            'Proceed to checkout'                                        => 'Paiement',
            'Cart totals'                                                => 'Récapitulatif',
            'Subtotal'                                                   => 'Sous-total',
            'Total'                                                      => 'Total',
            'Coupon code'                                                => 'Code promo',
            'Apply'                                                      => 'Appliquer',
            'Product'                                                    => 'Produit',
            'Price'                                                      => 'Prix',
            'Quantity'                                                   => 'Quantité',
            'Remove this item'                                           => 'Supprimer cet article',
            'Return to shop'                                             => 'Retour à la boutique',
            '(estimated for %s)'                                         => '(estimé pour %s)',
            // Checkout
            'You must be logged in to checkout.'                         => 'Vous devez être connecté pour passer à la caisse.',
            'Checkout'                                                   => 'Paiement',
            'Your order'                                                 => 'Votre commande',
            'Billing details'                                            => 'Coordonnées de facturation',
            'First name'                                                 => 'Prénom',
            'Last name'                                                  => 'Nom',
            'Company name (optional)'                                    => 'Nom de la société (facultatif)',
            'Country / Region'                                           => 'Pays / Région',
            'Street address'                                             => 'Adresse',
            'Apartment, suite, unit, etc. (optional)'                    => 'Appartement, suite, unité, etc. (facultatif)',
            'Town / City'                                                => 'Ville',
            'State / County'                                             => 'Département / Région',
            'Postcode / ZIP'                                             => 'Code postal',
            'Phone'                                                      => 'Téléphone',
            'Email address'                                              => 'Adresse e-mail',
            'Order notes'                                                => 'Notes de commande',
            'Notes about your order, e.g. special notes for delivery.'   => 'Notes concernant votre commande, ex. : instructions de livraison particulières.',
            'Place order'                                                => 'Commander',
            'Payment'                                                    => 'Paiement',
            // Messages coupons
            'Coupon "%s" does not exist!'                                => 'Le code promo "%s" n\'existe pas !',
            'Coupon code applied successfully.'                          => 'Code promo appliqué avec succès.',
            'Coupon code already applied!'                               => 'Ce code promo a déjà été appliqué !',
            'Please enter a coupon code.'                                => 'Veuillez entrer un code promo.',
            'Coupon "%s" removed.'                                       => 'Code promo "%s" supprimé.',
            'Sorry, this coupon is not applicable to your cart contents.' => 'Désolé, ce code promo n\'est pas applicable.',
            'Coupon "%s" has been applied to your cart.'                 => 'Le code promo "%s" a été appliqué.',
            // Page de confirmation de commande
            'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.' => 'Votre commande n\'a pas pu être traitée car votre banque a refusé la transaction. Veuillez réessayer.',
            'Pay'                                                        => 'Payer',
            'My account'                                                 => 'Mon compte',
            'Order number:'                                              => 'Numéro de commande :',
            'Date:'                                                      => 'Date :',
            'Email:'                                                     => 'E-mail :',
            'Total:'                                                     => 'Total :',
            'Payment method:'                                            => 'Mode de paiement :',
            // Mon compte
            'Username or email address'                                  => 'Identifiant ou adresse e-mail',
            'Password'                                                   => 'Mot de passe',
            'Remember me'                                                => 'Se souvenir de moi',
            'Log in'                                                     => 'Se connecter',
            'Lost your password?'                                        => 'Mot de passe oublié ?',
            'Add to cart'                                                => 'Ajouter au panier',
            'View cart'                                                  => 'Voir le panier',
        ];
        return $fr[$text] ?? $translated_text;
    }

    if ($lang === 'en') {
        // $text is always the English source string in WooCommerce
        return $text;
    }

    if ($lang === 'ru') {
        $ru = [
            // Panier
            'Update cart'                                                => 'Обновить корзину',
            'Apply coupon'                                               => 'Применить',
            'Proceed to checkout'                                        => 'Оформить заказ',
            'Cart totals'                                                => 'Итого по корзине',
            'Subtotal'                                                   => 'Подытог',
            'Total'                                                      => 'Итого',
            'Coupon code'                                                => 'Промокод',
            'Apply'                                                      => 'Применить',
            'Product'                                                    => 'Товар',
            'Price'                                                      => 'Цена',
            'Quantity'                                                   => 'Количество',
            'Remove this item'                                           => 'Удалить этот товар',
            'Return to shop'                                             => 'Вернуться в магазин',
            '(estimated for %s)'                                         => '(оценка для %s)',
            'Add to cart'                                                => 'В корзину',
            'View cart'                                                  => 'Просмотр корзины',
            // Checkout
            'You must be logged in to checkout.'                         => 'Для оформления заказа необходимо войти в систему.',
            'Checkout'                                                   => 'Оформление заказа',
            'Your order'                                                 => 'Ваш заказ',
            'Billing details'                                            => 'Платёжные данные',
            'First name'                                                 => 'Имя',
            'Last name'                                                  => 'Фамилия',
            'Company name (optional)'                                    => 'Название компании (необязательно)',
            'Country / Region'                                           => 'Страна / Регион',
            'Street address'                                             => 'Адрес',
            'Apartment, suite, unit, etc. (optional)'                    => 'Квартира, офис и т.д. (необязательно)',
            'Town / City'                                                => 'Город',
            'State / County'                                             => 'Регион / Область',
            'Postcode / ZIP'                                             => 'Почтовый индекс',
            'Phone'                                                      => 'Телефон',
            'Email address'                                              => 'Адрес эл. почты',
            'Order notes'                                                => 'Примечания к заказу',
            'Notes about your order, e.g. special notes for delivery.'   => 'Примечания к заказу, например особые пожелания по доставке.',
            'Place order'                                                => 'Разместить заказ',
            'Payment'                                                    => 'Оплата',
            // Page de confirmation de commande
            'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.' => 'К сожалению, ваш заказ не может быть обработан — банк отклонил транзакцию. Пожалуйста, попробуйте снова.',
            'Pay'                                                        => 'Оплатить',
            'My account'                                                 => 'Мой аккаунт',
            'Order number:'                                              => 'Номер заказа:',
            'Date:'                                                      => 'Дата:',
            'Email:'                                                     => 'Эл. почта:',
            'Total:'                                                     => 'Итого:',
            'Payment method:'                                            => 'Способ оплаты:',
            // Mon compte
            'Username or email address'                                  => 'Имя пользователя или адрес эл. почты',
            'Password'                                                   => 'Пароль',
            'Remember me'                                                => 'Запомнить меня',
            'Log in'                                                     => 'Войти',
            'Lost your password?'                                        => 'Забыли пароль?',
        ];
        return $ru[$text] ?? $text;
    }

    if ($lang === 'zh') {
        $zh = [
            // Panier
            'Update cart'                                                => '更新购物车',
            'Apply coupon'                                               => '使用',
            'Proceed to checkout'                                        => '结账',
            'Cart totals'                                                => '购物车合计',
            'Subtotal'                                                   => '小计',
            'Total'                                                      => '合计',
            'Coupon code'                                                => '优惠码',
            'Apply'                                                      => '使用',
            'Product'                                                    => '商品',
            'Price'                                                      => '价格',
            'Quantity'                                                   => '数量',
            'Remove this item'                                           => '删除此商品',
            'Return to shop'                                             => '返回商店',
            '(estimated for %s)'                                         => '（%s 的估算）',
            'Add to cart'                                                => '加入购物车',
            'View cart'                                                  => '查看购物车',
            // Checkout
            'You must be logged in to checkout.'                         => '您必须登录才能结账。',
            'Checkout'                                                   => '结账',
            'Your order'                                                 => '您的订单',
            'Billing details'                                            => '账单信息',
            'First name'                                                 => '名字',
            'Last name'                                                  => '姓氏',
            'Company name (optional)'                                    => '公司名称（选填）',
            'Country / Region'                                           => '国家 / 地区',
            'Street address'                                             => '街道地址',
            'Apartment, suite, unit, etc. (optional)'                    => '公寓、套房、单元等（选填）',
            'Town / City'                                                => '城市',
            'State / County'                                             => '省份 / 地区',
            'Postcode / ZIP'                                             => '邮政编码',
            'Phone'                                                      => '电话',
            'Email address'                                              => '电子邮箱',
            'Order notes'                                                => '订单备注',
            'Notes about your order, e.g. special notes for delivery.'   => '订单备注，例如特别的配送说明。',
            'Place order'                                                => '提交订单',
            'Payment'                                                    => '付款',
            // Page de confirmation de commande
            'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.' => '很抱歉，您的订单因银行拒绝交易而无法处理。请重新尝试购买。',
            'Pay'                                                        => '支付',
            'My account'                                                 => '我的账户',
            'Order number:'                                              => '订单号：',
            'Date:'                                                      => '日期：',
            'Email:'                                                     => '邮箱：',
            'Total:'                                                     => '合计：',
            'Payment method:'                                            => '付款方式：',
            // Mon compte
            'Username or email address'                                  => '用户名或邮箱地址',
            'Password'                                                   => '密码',
            'Remember me'                                                => '记住我',
            'Log in'                                                     => '登录',
            'Lost your password?'                                        => '忘记密码？',
        ];
        return $zh[$text] ?? $text;
    }

    // Langue inconnue ou non détectée → on laisse WooCommerce/WordPress décider
    return $translated_text;
}
add_filter('gettext', 'vog_woocommerce_translations', 20, 3);
