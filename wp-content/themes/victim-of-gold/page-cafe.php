<?php
/**
 * Template Name: Café
 */
get_header();

$img = get_template_directory_uri() . '/assets/images/cafe';

$mobile_slides = [
    ['src' => $img . '/cafe-terrasse-3.jpg',   'alt' => 'Terrasse du Café'],
    ['src' => $img . '/cafe-vanille-2.jpg',    'alt' => 'Dessert vanille'],
    ['src' => $img . '/cafe-champagne-2.jpg',  'alt' => 'Champagne'],
    ['src' => $img . '/cafe-gold-2.jpg',        'alt' => 'Café Gold'],
    ['src' => $img . '/cafe-glace-doree.jpg',  'alt' => 'Glace dorée'],
];
?>

<main id="main" class="site-main cafe-main">

    <!-- HERO + TEXTE (wrapper pour le graphisme en overlay) -->
    <div class="cafe-hero-wrapper">

        <section class="cafe-hero">
            <picture>
                <source media="(max-width: 767px)" srcset="<?php echo $img; ?>/cafe-hero-mobile.jpg">
                <img class="cafe-hero__img"
                     src="<?php echo $img; ?>/cafe-hero.jpg"
                     alt="<?php echo esc_attr(vog_t('cafe.alt.hero', 'Le Café Victim of Gold')); ?>">
            </picture>
        </section>

        <section class="cafe-text-section">
            <div class="cafe-text-section__inner">
                <div class="cafe-text-section__text">
                    <p><?php echo vog_t('cafe.p1', 'Un lieu hors du temps pour vivre une aventure enchantée.<br class="desktop-break"> Maison de tradition revisitée pour un voyage culinaire, sensoriel et interactif.'); ?></p>
                    <p><?php echo vog_t('cafe.p2', "Pour un déjeuner en amoureux, un café entre amis, un repas d'affaire ou un moment de partage en famille,<br class=\"desktop-break\"> venez vivre une expérience unique ou la passion de l'or devient magique."); ?></p>
                </div>
            </div>
        </section>

        <div class="cafe-graphisme" aria-hidden="true">
            <img class="cafe-graphisme__back" src="<?php echo $img; ?>/cafe-graphisme-1.svg" alt="">
            <img class="cafe-graphisme__front" src="<?php echo $img; ?>/cafe-graphisme-2.svg" alt="">
        </div>

    </div><!-- .cafe-hero-wrapper -->

    <!-- GRILLES D'IMAGES DESKTOP -->
    <section class="cafe-images cafe-images--desktop" aria-label="Galerie Café">

        <div class="cafe-grid-row">
            <div class="cafe-grid-img cafe-grid-img--large">
                <img src="<?php echo $img; ?>/cafe-terrasse-1.jpg" alt="<?php echo esc_attr(vog_t('cafe.alt.terrasse', 'Terrasse du Café Victim of Gold')); ?>" loading="lazy">
            </div>
            <div class="cafe-grid-img cafe-grid-img--small">
                <img src="<?php echo $img; ?>/cafe-vanille.jpg" alt="<?php echo esc_attr(vog_t('cafe.alt.vanille', 'Dessert vanille dorée')); ?>" loading="lazy">
            </div>
        </div>

        <div class="cafe-grid-row">
            <div class="cafe-grid-img cafe-grid-img--small">
                <img src="<?php echo $img; ?>/cafe-gold.jpg" alt="<?php echo esc_attr(vog_t('cafe.alt.gold', 'Café Gold')); ?>" loading="lazy">
            </div>
            <div class="cafe-grid-img cafe-grid-img--large">
                <img src="<?php echo $img; ?>/cafe-champagne.jpg" alt="<?php echo esc_attr(vog_t('cafe.alt.champagne', 'Champagne')); ?>" loading="lazy">
            </div>
        </div>

        <div class="cafe-grid-row">
            <div class="cafe-grid-img cafe-grid-img--large">
                <img src="<?php echo $img; ?>/cafe-terrasse-2.jpg" alt="<?php echo esc_attr(vog_t('cafe.alt.terrasse', 'Terrasse et vue')); ?>" loading="lazy">
            </div>
            <div class="cafe-grid-img cafe-grid-img--small">
                <img src="<?php echo $img; ?>/cafe-glace-choco.jpg" alt="<?php echo esc_attr(vog_t('cafe.alt.choco', 'Glace chocolat')); ?>" loading="lazy">
            </div>
        </div>

    </section>

    <!-- CAROUSEL MOBILE -->
    <section class="cafe-images cafe-images--mobile" aria-label="Galerie Café">
        <div class="cafe-carousel" data-carousel>

            <div class="cafe-carousel__track" data-carousel-track>
                <?php foreach ($mobile_slides as $slide) : ?>
                <div class="cafe-carousel__slide">
                    <img src="<?php echo esc_url($slide['src']); ?>"
                         alt="<?php echo esc_attr($slide['alt']); ?>"
                         loading="lazy">
                </div>
                <?php endforeach; ?>
            </div>

            <div class="cafe-carousel__dots" data-carousel-dots>
                <?php foreach ($mobile_slides as $i => $slide) : ?>
                <button class="cafe-carousel__dot<?php echo $i === 0 ? ' cafe-carousel__dot--active' : ''; ?>"
                        data-dot="<?php echo $i; ?>"
                        aria-label="Image <?php echo $i + 1; ?>"></button>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>
