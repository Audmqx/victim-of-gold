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
    
    // Enqueue Leaflet CSS
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4');
    
    // Enqueue hero animation script
    wp_enqueue_script('hero-animation', get_template_directory_uri() . '/js/hero-animation.js', array(), '1.0.0', true);
    
    // Enqueue horaires script
    wp_enqueue_script('horaires', get_template_directory_uri() . '/js/horaires.js', array(), '1.0.0', true);
    
    // Enqueue Leaflet JS
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', false);
    
    // Pass shop coordinates to JavaScript
    wp_localize_script('leaflet-js', 'shopLocation', array(
        'lat' => 43.5500, // Latitude de Cannes
        'lng' => 7.0167,  // Longitude de Cannes
        'address' => '112 Allée des Tournesols, 06400 Cannes'
    ));
    
    // Enqueue custom map script (after Leaflet)
    wp_enqueue_script('victim-of-gold-map', get_template_directory_uri() . '/js/map.js', array('leaflet-js'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'victim_of_gold_scripts');

// Custom image sizes
function victim_of_gold_image_sizes() {
    add_image_size('news-thumbnail', 629, 400, true);
}
add_action('after_setup_theme', 'victim_of_gold_image_sizes'); 