<?php
if (!defined('ABSPATH')) {
    exit;
}

// Theme Setup
function victim_of_gold_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 64,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'victim-of-gold'),
    ));
}
add_action('after_setup_theme', 'victim_of_gold_setup');

/**
 * Declare WooCommerce support
 */
function victim_of_gold_add_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Support des shortcodes WooCommerce
    add_filter('widget_text', 'do_shortcode');
    add_filter('the_excerpt', 'do_shortcode');
    add_filter('the_content', 'do_shortcode');
    
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 3,
            'min_columns'     => 2,
            'max_columns'     => 4,
        ),
    ));
}
add_action('after_setup_theme', 'victim_of_gold_add_woocommerce_support');

// Activer AJAX Add to Cart sur les pages produits
function victim_of_gold_ajax_add_to_cart_js() {
    if (function_exists('is_product') && is_product()) {
        wp_enqueue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'victim_of_gold_ajax_add_to_cart_js');

// Enqueue scripts and styles
function victim_of_gold_scripts() {
    // Enqueue Google Fonts
    $google_fonts_url = add_query_arg(
        array(
            'family' => 'Verdana:400,700',
            'display' => 'swap',
        ),
        'https://fonts.googleapis.com/css2'
    );
    wp_enqueue_style('google-fonts', $google_fonts_url, array(), null);
    
    // Enqueue theme stylesheet
    wp_enqueue_style('victim-of-gold-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue custom fonts
    wp_enqueue_style('priori-serif', get_template_directory_uri() . '/assets/fonts/priori-serif.css', array(), '1.0.0');
    
    // Enqueue WooCommerce custom scripts
    if (function_exists('is_woocommerce')) {
        wp_enqueue_script('victim-of-gold-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array('jquery'), '1.0.0', true);
        
        // Localize the script with new data
        wp_localize_script('victim-of-gold-woocommerce', 'victim_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'wc_ajax_url' => WC_AJAX::get_endpoint("%%endpoint%%")
        ));
    }
    
    // Autres scripts existants...
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4');
    wp_enqueue_script('hero-animation', get_template_directory_uri() . '/js/hero-animation.js', array(), '1.0.0', true);
    wp_enqueue_script('horaires', get_template_directory_uri() . '/js/horaires.js', array(), '1.0.0', true);
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', false);
    
    wp_localize_script('leaflet-js', 'shopLocation', array(
        'lat' => 43.5500,
        'lng' => 7.0167,
        'address' => '112 Allée des Tournesols, 06400 Cannes'
    ));
    
    wp_enqueue_script('victim-of-gold-map', get_template_directory_uri() . '/js/map.js', array('leaflet-js'), '1.0.0', true);
    wp_enqueue_script('victim-of-gold-leaflet-map', get_template_directory_uri() . '/js/leaflet-map.js', array('leaflet-js'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'victim_of_gold_scripts');

// Charger les styles WooCommerce
function victim_of_gold_woocommerce_styles() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    // Charger les styles WooCommerce par défaut
    wp_enqueue_style('woocommerce-general');
    wp_enqueue_style('woocommerce-layout');
    wp_enqueue_style('woocommerce-smallscreen', WC()->plugin_url() . '/assets/css/woocommerce-smallscreen.css', array(), WC_VERSION, 'only screen and (max-width: ' . apply_filters('woocommerce_style_smallscreen_breakpoint', '768px') . ')');
    
    // Charger les styles du thème Twenty Twenty-Five pour WooCommerce
    wp_enqueue_style('twentytwentyfive-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('woocommerce-general', 'woocommerce-layout'), '1.0.0');
    
    // Charger les styles du thème après WooCommerce
    wp_enqueue_style('victim-of-gold-style', get_stylesheet_uri(), array('woocommerce-general', 'woocommerce-layout'), '1.0.0');
    
    // Styles spécifiques pour la page shop
    if (is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_style('victim-of-gold-shop', get_template_directory_uri() . '/assets/css/shop.css', array('woocommerce-general', 'woocommerce-layout'), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'victim_of_gold_woocommerce_styles', 20);

// Ajouter le mini panier dans le header
function victim_of_gold_add_to_cart_fragment($fragments) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'victim_of_gold_add_to_cart_fragment');

// Custom image sizes
function victim_of_gold_image_sizes() {
    add_image_size('news-thumbnail', 629, 400, true);
}
add_action('after_setup_theme', 'victim_of_gold_image_sizes');

// Vérifier l'initialisation de WooCommerce
function victim_of_gold_check_woocommerce() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function() {
            echo '<div class="error"><p>WooCommerce n\'est pas activé. Veuillez l\'activer pour utiliser ce thème.</p></div>';
        });
        return;
    }

    // Vérifier si les pages WooCommerce sont configurées
    $cart_page_id = get_option('woocommerce_cart_page_id');
    $checkout_page_id = get_option('woocommerce_checkout_page_id');
    $myaccount_page_id = get_option('woocommerce_myaccount_page_id');

    if (!$cart_page_id || !$checkout_page_id || !$myaccount_page_id) {
        add_action('admin_notices', function() {
            echo '<div class="error"><p>Les pages WooCommerce ne sont pas correctement configurées. Veuillez vérifier les paramètres WooCommerce.</p></div>';
        });
    }
}
add_action('admin_init', 'victim_of_gold_check_woocommerce');

// Débogage WooCommerce
function victim_of_gold_debug_woocommerce() {
    // Vérifier si WooCommerce est actif et chargé
    if (!class_exists('WooCommerce')) {
        error_log('WooCommerce n\'est pas actif');
        return;
    }

    // Vérifier si les fonctions WooCommerce sont disponibles
    if (!function_exists('is_checkout') || !function_exists('wc_get_page_id')) {
        error_log('Les fonctions WooCommerce ne sont pas disponibles');
        return;
    }
    
    if (is_checkout()) {
        error_log('Page checkout demandée');
        
        // Vérifie si la page checkout est configurée
        $checkout_page_id = wc_get_page_id('checkout');
        error_log('ID de la page checkout : ' . $checkout_page_id);
        
        // Vérifie si le shortcode est présent
        $checkout_page = get_post($checkout_page_id);
        if ($checkout_page) {
            error_log('Contenu de la page checkout : ' . $checkout_page->post_content);
        }
    }
}
add_action('wp', 'victim_of_gold_debug_woocommerce');

/**
 * Wrap WooCommerce pages
 */
function victim_of_gold_woocommerce_wrapper_before() {
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

function victim_of_gold_woocommerce_wrapper_after() {
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
function victim_of_gold_woocommerce_template_path() {
    return 'woocommerce/';
}
add_filter('woocommerce_template_path', 'victim_of_gold_woocommerce_template_path');

/**
 * Customize WooCommerce checkout fields
 */
function victim_of_gold_woocommerce_checkout_fields($fields) {
    // Personnaliser les champs si nécessaire
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'victim_of_gold_woocommerce_checkout_fields');

/**
 * Add custom body classes for WooCommerce pages
 */
function victim_of_gold_woocommerce_body_class($classes) {
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
function victim_of_gold_force_woocommerce_shortcodes() {
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
function victim_of_gold_disable_checkout_redirect() {
    return false;
}
add_filter('woocommerce_checkout_redirect_empty_cart', 'victim_of_gold_disable_checkout_redirect');

/**
 * Force WooCommerce to use our custom templates
 */
function victim_of_gold_force_woocommerce_templates() {
    if (class_exists('WooCommerce')) {
        // Définir le chemin des templates WooCommerce
        add_filter('woocommerce_template_path', function() {
            return 'woocommerce/';
        });

        // S'assurer que WooCommerce utilise nos templates
        add_filter('template_include', function($template) {
            if (is_shop() || is_product_category() || is_product_tag()) {
                $new_template = locate_template(array('woocommerce/archive-product.php'));
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
function victim_of_gold_newsletter_styles() {
    wp_enqueue_style('victim-of-gold-newsletter', get_template_directory_uri() . '/assets/css/newsletter.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'victim_of_gold_newsletter_styles');

/**
 * Enqueue WooCommerce single product scripts and styles
 */
function vog_enqueue_single_product_assets() {
    if (is_product()) {
        wp_enqueue_style(
            'vog-single-product',
            get_template_directory_uri() . '/assets/css/woocommerce-single-product.css',
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'vog-single-product',
            get_template_directory_uri() . '/js/single-product.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'vog_enqueue_single_product_assets');

/**
 * Add custom product data tabs
 */
function vog_product_tabs($tabs) {
    $tabs['additional_info'] = array(
        'label'    => __('Informations additionnelles', 'victim-of-gold'),
        'target'   => 'additional_product_data',
        'class'    => array('show_if_simple', 'show_if_variable'),
        'priority' => 21
    );
    return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'vog_product_tabs');

/**
 * Add custom product data fields
 */
function vog_product_data_fields() {
    global $post;
    
    echo '<div id="additional_product_data" class="panel woocommerce_options_panel">';
    
    // Champ Entretien
    woocommerce_wp_textarea_input(array(
        'id'          => '_entretien',
        'label'       => __('Entretien', 'victim-of-gold'),
        'desc_tip'    => true,
        'description' => __('Instructions d\'entretien du produit', 'victim-of-gold')
    ));
    
    // Champ Taille
    woocommerce_wp_textarea_input(array(
        'id'          => '_taille',
        'label'       => __('Taille', 'victim-of-gold'),
        'desc_tip'    => true,
        'description' => __('Informations de taille du produit', 'victim-of-gold')
    ));
    
    // Champ Livraison & Retours
    woocommerce_wp_textarea_input(array(
        'id'          => '_livraison_retours',
        'label'       => __('Livraison & Retours', 'victim-of-gold'),
        'desc_tip'    => true,
        'description' => __('Informations de livraison et retours', 'victim-of-gold')
    ));
    
    echo '</div>';
}
add_action('woocommerce_product_data_panels', 'vog_product_data_fields');

/**
 * Save custom product data fields
 */
function vog_save_product_data($post_id) {
    // Entretien
    $entretien = isset($_POST['_entretien']) ? wp_kses_post($_POST['_entretien']) : '';
    update_post_meta($post_id, '_entretien', $entretien);
    
    // Taille
    $taille = isset($_POST['_taille']) ? wp_kses_post($_POST['_taille']) : '';
    update_post_meta($post_id, '_taille', $taille);
    
    // Livraison & Retours
    $livraison_retours = isset($_POST['_livraison_retours']) ? wp_kses_post($_POST['_livraison_retours']) : '';
    update_post_meta($post_id, '_livraison_retours', $livraison_retours);
}
add_action('woocommerce_process_product_meta', 'vog_save_product_data');

// Traduction des messages WooCommerce
function vog_custom_wc_add_to_cart_message($message, $products) {
    $titles = array();
    $count  = 0;

    if (is_array($products)) {
        foreach ($products as $product_id => $qty) {
            $titles[] = get_the_title($product_id);
            $count += $qty;
        }
    }

    if (count($titles) === 1) {
        $message = sprintf('%s a été ajouté à votre panier.', $titles[0]);
    } elseif (count($titles) > 1) {
        $message = 'Les produits ont été ajoutés à votre panier.';
    }

    return $message;
}
add_filter('wc_add_to_cart_message_html', 'vog_custom_wc_add_to_cart_message', 10, 2);

// Modifier le texte du bouton "View cart"
function vog_change_view_cart_button_text($translated_text, $text, $domain) {
    if ($domain === 'woocommerce') {
        switch ($text) {
            case 'View cart':
                $translated_text = 'Voir le panier';
                break;
            case 'Add to cart':
                $translated_text = 'Ajouter au panier';
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

// Notification MailPoet : envoi d'un email à chaque inscription via le formulaire n°2
add_action('mailpoet_subscription_before_subscribe', function ($data, $segmentIds, $form) {
    if ($form && method_exists($form, 'getId') && $form->getId() == 2) {
        $to = 'jc@victimofgold.com';
        $subject = 'Un nouveau message est arrivé depuis la page d\'accueil / maintenance';
        $message = "Un nouveau message est arrivé depuis la page d'accueil / maintenance :\n";
        foreach ($data as $key => $value) {
            $message .= ucfirst($key) . " : " . $value . "\n";
        }
        $headers = array('From: Victim of Gold <contact@victimofgold.com>');
        wp_mail($to, $subject, $message, $headers);
    }
}, 10, 3);

// Enqueue Lightbox2 pour la galerie de la page Atelier
function atelier_enqueue_lightbox() {
    if (is_page('atelier')) {
        wp_enqueue_style('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css');
        wp_enqueue_script('lightbox2', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'atelier_enqueue_lightbox');

// Enqueue le CSS spécifique pour la page Atelier
function atelier_enqueue_styles() {
    if (is_page('atelier')) {
        wp_enqueue_style('atelier-css', get_template_directory_uri() . '/assets/css/atelier.css');
    }
}
add_action('wp_enqueue_scripts', 'atelier_enqueue_styles'); 