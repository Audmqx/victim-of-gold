<?php
get_header();

// Fonction pour détecter si l'utilisateur est sur mobile
function is_mobile_device()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone', 'BlackBerry'];

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

// Fonction pour réorganiser les images pour mobile
function get_mobile_image_order($images)
{
    // Ordre personnalisé pour mobile - vous pouvez modifier cet ordre
    $mobileOrder = [5, 1, 2, 4, 3, 0]; // Exemple: 1,3,5,2,4,6

    $reorderedImages = [];
    foreach ($mobileOrder as $index) {
        if (isset($images[$index])) {
            $reorderedImages[] = $images[$index];
        }
    }

    return $reorderedImages;
}
?>
<main id="main" class="site-main atelier-main">
    <!-- SECTION 1 : Atelier Graphisme avec image de fond dummy -->
    <section class="atelier-hero-bg">
        <div class="container atelier-hero-container">
            <div class="atelier-hero-graphic">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/atelier.svg" alt="Atelier Graphisme">
            </div>
            <div class="atelier-hero-text">
                <?php
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
?>
            </div>
        </div>
    </section>

    <!-- SECTION 2 : Galerie Lightbox avec images WordPress optimisées -->
    <section class="atelier-gallery">
        <div class="container atelier-gallery-container">
            <div class="atelier-gallery-grid">
                <?php
                // Images spécifiques de la galerie atelier
                $atelier_images = [
                    'https://victimofgold.com/wp-content/uploads/2025/08/atelier-1-scaled.jpg',
                    'https://victimofgold.com/wp-content/uploads/2025/08/atelier-2-scaled.jpg',
                    'https://victimofgold.com/wp-content/uploads/2025/08/atelier-3-scaled.jpg',
                    'https://victimofgold.com/wp-content/uploads/2025/08/atelier-4-scaled.jpg',
                    'https://victimofgold.com/wp-content/uploads/2025/08/atelier-5-scaled.jpg',
                    'https://victimofgold.com/wp-content/uploads/2025/08/atelier-6-scaled.jpg'
                ];

// Réorganiser les images si on est sur mobile
if (is_mobile_device()) {
    $atelier_images = get_mobile_image_order($atelier_images);
}

foreach ($atelier_images as $image_url) {
    echo '<a href="' . $image_url . '" data-lightbox="atelier-gallery">';
    echo '<img src="' . $image_url . '" alt="Atelier" loading="lazy">';
    echo '</a>';
}
?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>