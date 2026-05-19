<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Returns true if the current page is any language version of the given French slug.
 * Works with or without Polylang.
 */
function vog_is_any_translation_of(string $fr_slug): bool
{
    if (!is_page()) {
        return false;
    }
    if (is_page($fr_slug)) {
        return true;
    }
    if (function_exists('pll_get_post_translations')) {
        $source = get_page_by_path($fr_slug);
        if ($source) {
            $ids = array_values(pll_get_post_translations($source->ID));
            return in_array(get_the_ID(), $ids, true);
        }
    }
    return false;
}

/**
 * Returns true when the current URL has an explicit language prefix (/en/, /ru/, /zh/, /fr/).
 * Works at any point in the WordPress lifecycle (URL is available from the start).
 * French home is at / (no prefix), so / returns false.
 */
function vog_url_has_lang_prefix(): bool
{
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    return (bool) preg_match('#^/(en|ru|zh|fr)(/|$|\?)#', $path);
}

/**
 * Returns the current 2-letter language code.
 *
 * Prefixed URLs (/en/, /ru/, /zh/) → Polylang détecte depuis l'URL, fiable dès init.
 * URLs sans préfixe (/boutique/, /checkout/, /, etc.) → on lit le cookie vog_lang.
 *   Le cookie peut être mis à jour par vog_set_language_cookie() pendant template_redirect,
 *   donc on ne met en cache qu'après que cet hook ait eu lieu.
 */
function vog_current_lang(): string
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }

    if (function_exists('pll_current_language')) {
        if (vog_url_has_lang_prefix()) {
            // URL avec préfixe : Polylang est autoritaire, on peut cacher immédiatement.
            $cached = pll_current_language('slug') ?: 'fr';
            return $cached;
        }

        // URL sans préfixe : le cookie est la source de vérité.
        // On ne met pas en cache avant template_redirect car vog_set_language_cookie()
        // peut encore modifier $_COOKIE['vog_lang'] pendant cet hook.
        $cookie = isset($_COOKIE['vog_lang']) ? sanitize_key($_COOKIE['vog_lang']) : '';
        $lang   = in_array($cookie, ['en', 'ru', 'zh', 'fr'], true)
            ? $cookie
            : (pll_current_language('slug') ?: 'fr');

        if (did_action('template_redirect')) {
            $cached = $lang;
        }
        return $lang;
    }

    $param = isset($_GET['lang']) ? sanitize_key($_GET['lang']) : '';
    if (in_array($param, ['en', 'ru', 'zh'], true)) {
        $cached = $param;
        return $cached;
    }
    $wplang = defined('WPLANG') ? WPLANG : get_option('WPLANG', 'fr_FR');
    $cached = substr($wplang, 0, 2) ?: 'fr';
    return $cached;
}

/**
 * Persiste la langue Polylang dans le cookie vog_lang.
 * On saute TOUTES les pages WooCommerce (boutique, produit, panier, checkout,
 * compte) car leur URL est sans préfixe et pll y retourne toujours 'fr',
 * quelle que soit la langue réelle de l'utilisateur.
 */
function vog_set_language_cookie(): void
{
    if (!function_exists('pll_current_language')) {
        return;
    }

    // Toutes les pages WooCommerce : URL sans préfixe → pll non fiable.
    if (
        (function_exists('is_woocommerce') && is_woocommerce()) || // boutique, produit, catégorie
        (function_exists('is_cart')         && is_cart())         ||
        (function_exists('is_checkout')     && is_checkout())     ||
        (function_exists('is_account_page') && is_account_page())
    ) {
        return;
    }

    $lang = pll_current_language('slug');
    if (!$lang || !in_array($lang, ['en', 'ru', 'zh', 'fr'], true)) {
        return;
    }

    if (!empty($_COOKIE['vog_lang']) && $_COOKIE['vog_lang'] === $lang) {
        return;
    }

    setcookie('vog_lang', $lang, [
        'expires'  => time() + 30 * DAY_IN_SECONDS,
        'path'     => COOKIEPATH ?: '/',
        'secure'   => is_ssl(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    $_COOKIE['vog_lang'] = $lang;
}
add_action('template_redirect', 'vog_set_language_cookie', 1);

/**
 * Returns the HTML for the language switcher.
 *
 * When Polylang is active, uses pll_the_languages() raw data so links
 * point to the correct translated page (not just the home URL).
 * Falls back to ?lang= query params when Polylang is not active.
 */
function vog_lang_switcher_html(): string
{
    $labels  = ['fr' => 'FR', 'en' => 'EN', 'ru' => 'RU', 'zh' => '中文'];
    $current = vog_current_lang();
    $parts   = [];

    if (function_exists('pll_the_languages')) {
        $pll_langs       = pll_the_languages(['raw' => 1, 'hide_if_no_translation' => 0]);
        $on_unprefixed   = !vog_url_has_lang_prefix();
        foreach ($pll_langs as $lang) {
            $code  = $lang['slug'];
            $label = $labels[$code] ?? strtoupper($code);
            $class = ($code === $current) ? 'lang-link lang-link--active' : 'lang-link';

            // Sur les pages sans préfixe (checkout, panier, pages FR…), Polylang
            // renvoie la même URL pour la langue par défaut (FR → /checkout/).
            // On force le lien vers la home de chaque langue pour garantir
            // que le cookie vog_lang sera mis à jour à l'arrivée.
            $url = ($on_unprefixed && function_exists('pll_home_url'))
                ? pll_home_url($code)
                : $lang['url'];

            $parts[] = sprintf(
                '<a href="%s" class="%s" lang="%s" hreflang="%s">%s</a>',
                esc_url($url),
                esc_attr($class),
                esc_attr($code),
                esc_attr($code),
                esc_html($label)
            );
        }
    } else {
        foreach ($labels as $code => $label) {
            $url   = $code === 'fr'
                ? remove_query_arg('lang')
                : add_query_arg('lang', $code);
            $class = $code === $current ? 'lang-link lang-link--active' : 'lang-link';
            $parts[] = sprintf(
                '<a href="%s" class="%s" lang="%s" hreflang="%s">%s</a>',
                esc_url($url),
                esc_attr($class),
                esc_attr($code),
                esc_attr($code),
                esc_html($label)
            );
        }
    }

    return '<div class="language-selector">'
        . implode('<span class="lang-sep" aria-hidden="true"> | </span>', $parts)
        . '</div>';
}

/**
 * Returns the hero SVG path for the current language.
 */
function vog_hero_svg_path(): string
{
    $lang = vog_current_lang();
    $map = [
        'en' => '/assets/images/hero-text-en.svg',
        'ru' => '/assets/images/hero-text-en.svg',
        'zh' => '/assets/images/hero-text-en.svg',
    ];
    $file = $map[$lang] ?? '/assets/images/hero-text.svg';
    $full = get_template_directory() . $file;
    return file_exists($full) ? $full : get_template_directory() . '/assets/images/hero-text.svg';
}

// Theme Setup
function victim_of_gold_setup()
{
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for custom logo
    add_theme_support('custom-logo', [
        'height' => 64,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    // Register Navigation Menus
    register_nav_menus([
        'primary' => esc_html__('Primary Menu', 'victim-of-gold'),
    ]);
}
add_action('after_setup_theme', 'victim_of_gold_setup');

/**
 * Declare WooCommerce support
 */
function victim_of_gold_add_woocommerce_support()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 300,
        'single_image_width' => 600,
        'product_grid' => [
            'default_rows' => 3,
            'min_rows' => 2,
            'max_rows' => 8,
            'default_columns' => 3,
            'min_columns' => 2,
            'max_columns' => 4,
        ],
    ]);
}
add_action('after_setup_theme', 'victim_of_gold_add_woocommerce_support');

// Activer AJAX Add to Cart sur les pages produits
function victim_of_gold_ajax_add_to_cart_js()
{
    if (function_exists('is_product') && is_product()) {
        wp_enqueue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'victim_of_gold_ajax_add_to_cart_js');

// Enqueue scripts and styles
function victim_of_gold_scripts()
{
    // Enqueue theme stylesheet
    wp_enqueue_style('victim-of-gold-style', get_stylesheet_uri(), [], '1.0.0');
    
    // Enqueue custom fonts
    wp_enqueue_style('priori-serif', get_template_directory_uri() . '/assets/fonts/priori-serif.css', [], '1.0.0');
    
    // Enqueue WooCommerce custom scripts
    if (function_exists('is_woocommerce')) {
        wp_enqueue_script('victim-of-gold-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', ['jquery'], '1.0.0', true);
        
        // Localize the script with new data
        wp_localize_script('victim-of-gold-woocommerce', 'victim_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'wc_ajax_url' => WC_AJAX::get_endpoint("%%endpoint%%")
        ]);
    }
    
    // Hero animation : home uniquement
    if (is_front_page() || is_home()) {
        wp_enqueue_script('hero-animation', get_template_directory_uri() . '/js/hero-animation.js', [], '1.0.0', true);
    }

    wp_enqueue_script('horaires', get_template_directory_uri() . '/js/horaires.js', [], '1.0.0', true);

    // Leaflet — dans le footer sur toutes les pages
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true);

    wp_localize_script('leaflet-js', 'shopLocation', [
        'lat'     => 43.5518889,
        'lng'     => 7.0205556,
        'address' => '9 rue des Serbes, 06400 Cannes',
    ]);

    wp_enqueue_script('victim-of-gold-map', get_template_directory_uri() . '/js/map.js', ['leaflet-js'], '1.0.0', true);
    wp_enqueue_script('victim-of-gold-leaflet-map', get_template_directory_uri() . '/js/leaflet-map.js', ['leaflet-js'], '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'victim_of_gold_scripts');

// Charger les styles WooCommerce
function victim_of_gold_woocommerce_styles()
{
    if (!class_exists('WooCommerce')) {
        return;
    }

    // Charger les styles WooCommerce par défaut
    wp_enqueue_style('woocommerce-general');
    wp_enqueue_style('woocommerce-layout');
    wp_enqueue_style('woocommerce-smallscreen', WC()->plugin_url() . '/assets/css/woocommerce-smallscreen.css', [], WC_VERSION, 'only screen and (max-width: ' . apply_filters('woocommerce_style_smallscreen_breakpoint', '768px') . ')');
    
    // Charger les styles du thème Twenty Twenty-Five pour WooCommerce
    wp_enqueue_style('twentytwentyfive-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', ['woocommerce-general', 'woocommerce-layout'], '1.0.0');
    
    // Charger les styles du thème après WooCommerce
    wp_enqueue_style('victim-of-gold-style', get_stylesheet_uri(), ['woocommerce-general', 'woocommerce-layout'], '1.0.0');
    
    // Styles spécifiques pour la page shop
    if (is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_style('victim-of-gold-shop', get_template_directory_uri() . '/assets/css/shop.css', ['woocommerce-general', 'woocommerce-layout'], '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'victim_of_gold_woocommerce_styles', 20);

// Ajouter le mini panier dans le header
function victim_of_gold_add_to_cart_fragment($fragments)
{
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'victim_of_gold_add_to_cart_fragment');

// Custom image sizes
function victim_of_gold_image_sizes()
{
    add_image_size('news-thumbnail', 629, 400, true);
}
add_action('after_setup_theme', 'victim_of_gold_image_sizes');

// Vérifier l'initialisation de WooCommerce
function victim_of_gold_check_woocommerce()
{
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p>WooCommerce n\'est pas activé. Veuillez l\'activer pour utiliser ce thème.</p></div>';
        });
        return;
    }

    // Vérifier si les pages WooCommerce sont configurées
    $cart_page_id = get_option('woocommerce_cart_page_id');
    $checkout_page_id = get_option('woocommerce_checkout_page_id');
    $myaccount_page_id = get_option('woocommerce_myaccount_page_id');

    if (!$cart_page_id || !$checkout_page_id || !$myaccount_page_id) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p>Les pages WooCommerce ne sont pas correctement configurées. Veuillez vérifier les paramètres WooCommerce.</p></div>';
        });
    }
}
add_action('admin_init', 'victim_of_gold_check_woocommerce');


/**
 * Wrap WooCommerce pages
 */
function victim_of_gold_woocommerce_wrapper_before()
{
    // Vérifier si nous sommes sur une page WooCommerce
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
        ?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <div class="container woocommerce-container">
        <?php
    }
}
add_action('woocommerce_before_main_content', 'victim_of_gold_woocommerce_wrapper_before', 10);

function victim_of_gold_woocommerce_wrapper_after()
{
    // Vérifier si nous sommes sur une page WooCommerce
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
        ?>
                </div>
            </main>
        </div>
        <?php
    }
}
add_action('woocommerce_after_main_content', 'victim_of_gold_woocommerce_wrapper_after', 10);

// Remove default wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Ensure WooCommerce templates are loaded from theme
 */
function victim_of_gold_woocommerce_template_path()
{
    return 'woocommerce/';
}
add_filter('woocommerce_template_path', 'victim_of_gold_woocommerce_template_path');

/**
 * Customize WooCommerce checkout fields
 */
function victim_of_gold_woocommerce_checkout_fields($fields)
{
    // Personnaliser les champs si nécessaire
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'victim_of_gold_woocommerce_checkout_fields');

/**
 * Add custom body classes for WooCommerce pages
 */
function victim_of_gold_woocommerce_body_class($classes)
{
    if (is_woocommerce()) {
        $classes[] = 'woocommerce-page-custom';
        
        if (is_checkout()) {
            $classes[] = 'woocommerce-checkout-custom';
        } elseif (is_cart()) {
            $classes[] = 'woocommerce-cart-custom';
        } elseif (is_account_page()) {
            $classes[] = 'woocommerce-account-custom';
        }
    }
    return $classes;
}
add_filter('body_class', 'victim_of_gold_woocommerce_body_class');

/**
 * Force WooCommerce shortcodes
 */
function victim_of_gold_force_woocommerce_shortcodes()
{
    // Ne pas exécuter cette fonction sur la page checkout
    if (is_checkout()) {
        return;
    }
    
    if (is_cart()) {
        echo do_shortcode('[woocommerce_cart]');
    } elseif (is_account_page()) {
        echo do_shortcode('[woocommerce_my_account]');
    }
}
add_action('woocommerce_before_main_content', 'victim_of_gold_force_woocommerce_shortcodes', 5);

// Désactiver la redirection automatique du checkout vers le panier
function victim_of_gold_disable_checkout_redirect()
{
    return false;
}
add_filter('woocommerce_checkout_redirect_empty_cart', 'victim_of_gold_disable_checkout_redirect');

/**
 * Force WooCommerce to use our custom templates
 */
function victim_of_gold_force_woocommerce_templates()
{
    if (class_exists('WooCommerce')) {
        add_filter('template_include', function ($template) {
            if (is_shop() || is_product_category() || is_product_tag()) {
                $new_template = locate_template(['woocommerce/archive-product.php']);
                if (!empty($new_template)) {
                    return $new_template;
                }
            }
            return $template;
        }, 99);
    }
}
add_action('after_setup_theme', 'victim_of_gold_force_woocommerce_templates');

// Enqueue newsletter styles
function victim_of_gold_newsletter_styles()
{
    wp_enqueue_style('victim-of-gold-newsletter', get_template_directory_uri() . '/assets/css/newsletter.css', [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'victim_of_gold_newsletter_styles');

/**
 * Enqueue WooCommerce single product scripts and styles
 */
function vog_enqueue_single_product_assets()
{
    if (is_product()) {
        wp_enqueue_style(
            'vog-single-product',
            get_template_directory_uri() . '/assets/css/woocommerce-single-product.css',
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'vog-single-product',
            get_template_directory_uri() . '/js/single-product.js',
            ['jquery'],
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'vog_enqueue_single_product_assets');

/**
 * Add custom product data tabs
 */
function vog_product_tabs($tabs)
{
    $tabs['additional_info'] = [
        'label' => __('Informations additionnelles', 'victim-of-gold'),
        'target' => 'additional_product_data',
        'class' => ['show_if_simple', 'show_if_variable'],
        'priority' => 21
    ];
    return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'vog_product_tabs');

/**
 * Add custom product data fields
 */
function vog_product_data_fields()
{
    global $post;
    
    echo '<div id="additional_product_data" class="panel woocommerce_options_panel">';
    
    // Champ Entretien
    woocommerce_wp_textarea_input([
        'id' => '_entretien',
        'label' => __('Entretien', 'victim-of-gold'),
        'desc_tip' => true,
        'description' => __('Instructions d\'entretien du produit', 'victim-of-gold')
    ]);
    
    // Champ Taille
    woocommerce_wp_textarea_input([
        'id' => '_taille',
        'label' => __('Taille', 'victim-of-gold'),
        'desc_tip' => true,
        'description' => __('Informations de taille du produit', 'victim-of-gold')
    ]);
    
    // Champ Livraison & Retours
    woocommerce_wp_textarea_input([
        'id' => '_livraison_retours',
        'label' => __('Livraison & Retours', 'victim-of-gold'),
        'desc_tip' => true,
        'description' => __('Informations de livraison et retours', 'victim-of-gold')
    ]);
    
    echo '</div>';
}
add_action('woocommerce_product_data_panels', 'vog_product_data_fields');

/**
 * Save custom product data fields
 */
function vog_save_product_data($post_id)
{
    if (!isset($_POST['woocommerce_meta_nonce']) || !wp_verify_nonce($_POST['woocommerce_meta_nonce'], 'woocommerce_save_data')) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $entretien = isset($_POST['_entretien']) ? wp_kses_post($_POST['_entretien']) : '';
    update_post_meta($post_id, '_entretien', $entretien);

    $taille = isset($_POST['_taille']) ? wp_kses_post($_POST['_taille']) : '';
    update_post_meta($post_id, '_taille', $taille);

    $livraison_retours = isset($_POST['_livraison_retours']) ? wp_kses_post($_POST['_livraison_retours']) : '';
    update_post_meta($post_id, '_livraison_retours', $livraison_retours);
}
add_action('woocommerce_process_product_meta', 'vog_save_product_data');

// Traduction des messages WooCommerce
function vog_custom_wc_add_to_cart_message($message, $products)
{
    $titles = [];
    $count = 0;

    if (is_array($products)) {
        foreach ($products as $product_id => $qty) {
            $titles[] = get_the_title($product_id);
            $count += $qty;
        }
    }

    if (count($titles) === 1) {
        $message = sprintf(vog_t('wc.added_single', '%s a été ajouté à votre panier.'), $titles[0]);
    } elseif (count($titles) > 1) {
        $message = vog_t('wc.added_multiple', 'Les produits ont été ajoutés à votre panier.');
    }

    return $message;
}
add_filter('wc_add_to_cart_message_html', 'vog_custom_wc_add_to_cart_message', 10, 2);

// Modifier le texte du bouton "View cart"
function vog_change_view_cart_button_text($translated_text, $text, $domain)
{
    if ($domain === 'woocommerce') {
        switch ($text) {
            case 'View cart':
                $translated_text = substr(get_locale(), 0, 2) === 'fr' ? 'Voir le panier' : $text;
                break;
            case 'Add to cart':
                $translated_text = substr(get_locale(), 0, 2) === 'fr' ? 'Ajouter au panier' : $text;
                break;
        }
    }
    return $translated_text;
}
add_filter('gettext', 'vog_change_view_cart_button_text', 20, 3);

/**
 * Include WooCommerce translations
 */
require get_template_directory() . '/inc/woocommerce-translations.php';
require get_template_directory() . '/inc/translations.php';
require get_template_directory() . '/inc/polylang.php';

// Notification MailPoet : envoi d'un email à chaque inscription via le formulaire n°2
add_action('mailpoet_subscription_before_subscribe', function ($data, $segmentIds, $form) {
    if ($form && method_exists($form, 'getId') && $form->getId() == 2) {
        $to = 'jc@victimofgold.com';
        $subject = 'Un nouveau message est arrivé depuis la page d\'accueil / maintenance';
        $message = "Un nouveau message est arrivé depuis la page d'accueil / maintenance :\n";
        foreach ($data as $key => $value) {
            $message .= ucfirst($key) . " : " . $value . "\n";
        }
        $headers = ['From: Victim of Gold <contact@victimofgold.com>'];
        wp_mail($to, $subject, $message, $headers);
    }
}, 10, 3);

// Enqueue les assets de la page Café
function cafe_enqueue_assets()
{
    if (vog_is_any_translation_of('cafe') || is_page_template('page-cafe.php')) {
        wp_enqueue_style('cafe-css', get_template_directory_uri() . '/assets/css/cafe.css', [], '1.0.0');
        wp_enqueue_script('cafe-carousel', get_template_directory_uri() . '/js/cafe-carousel.js', [], '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'cafe_enqueue_assets');

// Enqueue Lightbox2 pour la galerie de la page Atelier
function atelier_enqueue_lightbox()
{
    if (vog_is_any_translation_of('atelier')) {
        wp_enqueue_style('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css');
        wp_enqueue_script('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js', ['jquery'], null, true);
    }
}
add_action('wp_enqueue_scripts', 'atelier_enqueue_lightbox');

// Enqueue le CSS spécifique pour la page Atelier
function atelier_enqueue_styles()
{
    if (vog_is_any_translation_of('atelier')) {
        wp_enqueue_style('atelier-css', get_template_directory_uri() . '/assets/css/atelier.css');
    }
}
add_action('wp_enqueue_scripts', 'atelier_enqueue_styles');

// Enqueue le JavaScript d'optimisation pour la page Atelier
function atelier_enqueue_optimization()
{
    if (vog_is_any_translation_of('atelier')) {
        wp_enqueue_script('atelier-optimization', get_template_directory_uri() . '/assets/js/atelier-optimization.js', [], '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'atelier_enqueue_optimization');



add_action('wp_enqueue_scripts', function () {
    if (function_exists('is_cart') && is_cart()) {
        wp_enqueue_style(
            'victim-of-gold-woocommerce-blocks',
            get_template_directory_uri() . '/assets/css/woocommerce-blocks.css',
            [],
            '1.0.0'
        );
    }
});

// Masquer les options de paiement et d'expédition dans le panier
function victim_of_gold_hide_cart_payment_options()
{
    if (is_cart()) {
        // Masquer les totaux du panier (qui incluent les options de paiement)
        // remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);
        
        // Masquer les champs de coupon dans le panier
        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        
        // Masquer les options d'expédition dans le panier
        remove_action('woocommerce_cart_collaterals', 'woocommerce_shipping_calculator', 5);
    }
}
add_action('wp', 'victim_of_gold_hide_cart_payment_options');

// S'assurer que le bouton "Proceed to checkout" est bien visible dans le panier
function victim_of_gold_ensure_checkout_button()
{
    if (is_cart()) {
        // Ajouter un bouton de checkout personnalisé si nécessaire
        add_action('woocommerce_after_cart_table', function () {
            echo '<div class="cart-checkout-button-wrapper">';
            echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="button checkout-button">' . esc_html(substr(get_locale(), 0, 2) === 'fr' ? 'Paiement' : __('Proceed to checkout', 'woocommerce')) . '</a>';
            echo '</div>';
        });
    }
}
add_action('wp', 'victim_of_gold_ensure_checkout_button');

// Désactiver les boutons de paiement express (PayPal, Apple Pay, etc.) sur la page panier
add_filter('woocommerce_cart_checkout_payment_buttons_enabled', '__return_false');

// Personnalisation des métadonnées Open Graph et Twitter Cards
function victim_of_gold_custom_meta_tags()
{
    // Ajouter des métadonnées personnalisées
    if (is_front_page()) {
        echo '<meta property="og:title" content="Victim of Gold - Bijouterie Cannes" />' . "\n";
        echo '<meta property="og:description" content="Un savoir faire unique au monde, des créations et des produits originaux ainsi que la possibilité de personnaliser et sublimer vos objets ou vos décors avec de l\'or ou du platine. Artisanat de luxe, services exclusifs, innovation… nous inventons pour vous la dorure du futur." />' . "\n";
        echo '<meta property="og:image" content="' . get_template_directory_uri() . '/assets/images/metadonne.jpg" />' . "\n";
        echo '<meta property="og:url" content="' . home_url() . '" />' . "\n";
        echo '<meta property="og:type" content="website" />' . "\n";
        
        // Twitter Cards
        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        echo '<meta name="twitter:title" content="Victim of Gold - Bijouterie Cannes" />' . "\n";
        echo '<meta name="twitter:description" content="Un savoir faire unique au monde, des créations et des produits originaux ainsi que la possibilité de personnaliser et sublimer vos objets ou vos décors avec de l\'or ou du platine. Artisanat de luxe, services exclusifs, innovation… nous inventons pour vous la dorure du futur." />' . "\n";
        echo '<meta name="twitter:image" content="' . get_template_directory_uri() . '/assets/images/metadonne.jpg" />' . "\n";
    }
}
add_action('wp_head', 'victim_of_gold_custom_meta_tags', 1);

// Personnaliser les métadonnées Jetpack Open Graph
function victim_of_gold_custom_jetpack_og_tags($tags)
{
    // Modifier les tags Open Graph générés par Jetpack
    if (is_front_page()) {
        $tags['og:title'] = 'Victim of Gold - Bijouterie Cannes';
        $tags['og:description'] = 'Un savoir faire unique au monde, des créations et des produits originaux ainsi que la possibilité de personnaliser et sublimer vos objets ou vos décors avec de l\'or ou du platine. Artisanat de luxe, services exclusifs, innovation… nous inventons pour vous la dorure du futur.';
        $tags['og:image'] = get_template_directory_uri() . '/assets/images/metadonne.jpg';
    }
    
    return $tags;
}
add_filter('jetpack_open_graph_tags', 'victim_of_gold_custom_jetpack_og_tags');

/**
 * Gérer correctement les erreurs 404 et éviter les redirections incorrectes
 */
function victim_of_gold_handle_404_redirects()
{
    // Vérifier si c'est une erreur 404
    if (is_404()) {
        // Empêcher les redirections automatiques vers d'autres pages
        remove_action('template_redirect', 'wp_redirect_admin_locations');
        
        // S'assurer que la page 404 est bien affichée
        status_header(404);
        nocache_headers();
    }
}
add_action('template_redirect', 'victim_of_gold_handle_404_redirects', 1);

/**
 * Désactiver les redirections automatiques de Jetpack qui pourraient causer des problèmes
 */
function victim_of_gold_disable_jetpack_redirects()
{
    // Désactiver les redirections automatiques de Jetpack
    if (class_exists('Jetpack')) {
        remove_action('template_redirect', ['Jetpack', 'wp_redirect_admin_locations']);
    }
}
add_action('init', 'victim_of_gold_disable_jetpack_redirects');

/**
 * Forcer l'affichage de la page 404 pour les produits supprimés
 */
function victim_of_gold_force_404_for_deleted_products()
{
    global $wp_query;
    
    // Vérifier si on est sur une page produit qui n'existe plus
    if (is_singular('product')) {
        $product = wc_get_product(get_the_ID());
        if (!$product || !$product->exists()) {
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
        }
    }
}
add_action('template_redirect', 'victim_of_gold_force_404_for_deleted_products', 5);
