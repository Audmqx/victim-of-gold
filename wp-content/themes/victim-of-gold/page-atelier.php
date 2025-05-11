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
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </div>
        <div class="atelier-hero-overlay"></div>
    </section>

    <!-- SECTION 2 : Galerie Lightbox avec images dummy -->
    <section class="atelier-gallery">
        <div class="container atelier-gallery-container">
            <div class="atelier-gallery-grid">
                <?php
                $dummy = get_template_directory_uri() . '/assets/images/mock.png';
                for ($i = 1; $i <= 9; $i++) {
                    echo '<a href="' . $dummy . '" data-lightbox="atelier-gallery"><img src="' . $dummy . '" alt="Atelier ' . $i . '"></a>';
                }
                ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?> 