<?php
get_header();
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