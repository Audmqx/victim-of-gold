<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register hardcoded theme strings with Polylang so they appear
 * in Languages → String Translations and can be translated from the admin.
 */
function vog_polylang_register_strings(): void
{
    if (!function_exists('pll_register_string')) {
        return;
    }

    $group = 'Victim of Gold';

    $strings = [
        'home-about'          => "Victim of Gold est un concept store qui allie l'or pur 24 carats et un savoir-faire unique au monde\u{a0}: Atelier, Boutique & Café pour découvrir et vivre une expérience en or.",
        'home-read-more'      => 'Lire',
        'home-video-fallback' => 'Votre navigateur ne supporte pas la lecture de vidéos.',
        'cafe-p1'             => "Un lieu hors du temps pour vivre une aventure enchantée. Maison de tradition revisitée pour un voyage culinaire, sensoriel et interactif.",
        'cafe-p2'             => "Pour un déjeuner en amoureux, un café entre amis, un repas d'affaire ou un moment de partage en famille, venez vivre une expérience unique ou la passion de l'or devient magique.",
        'contact-title'       => 'PRENONS CONTACT',
    ];

    foreach ($strings as $name => $value) {
        pll_register_string($name, $value, $group);
    }
}
add_action('init', 'vog_polylang_register_strings');


/**
 * Automatically route translated pages to their source template.
 *
 * e.g. /en/workshop/ → page-atelier.php
 *      /ru/workshop/ → page-atelier.php
 *
 * Keyed by the French source page slug → template file.
 */
function vog_polylang_template_for_translations(string $template): string
{
    if (!function_exists('pll_get_post_translations') || !is_page()) {
        return $template;
    }

    $slug_to_template = [
        'atelier' => 'page-atelier.php',
        'cafe'    => 'page-cafe.php',
        'contact' => 'page-contact.php',
    ];

    foreach ($slug_to_template as $fr_slug => $tpl_file) {
        $source = get_page_by_path($fr_slug);
        if (!$source) {
            continue;
        }
        $translations = pll_get_post_translations($source->ID);
        if (in_array(get_the_ID(), array_values($translations), true)) {
            $found = locate_template($tpl_file);
            if ($found) {
                return $found;
            }
        }
    }

    return $template;
}
add_filter('template_include', 'vog_polylang_template_for_translations', 99);
