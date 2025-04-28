<?php get_header(); ?>

<main id="main" class="site-main">
    <!-- HERO SECTION -->
    <section class="hero">
        <video class="hero-video" autoplay muted loop playsinline preload="auto">
            <source src="<?php echo get_template_directory_uri(); ?>/assets/images/acceuil-short.mp4" type="video/mp4">
            Votre navigateur ne supporte pas la lecture de vidéos.
        </video>
        <div class="hero-text">
            <?php include get_template_directory() . '/assets/images/hero-text.svg'; ?>
        </div>
    </section>

    <!-- NEWS / ACTUALITÉS SECTION alternée -->
    <section class="news-section">
        <div class="news-alternating-list">
            <?php
            $news_query = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 3
            ));
            $i = 0;
            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
                    $is_even = $i % 2 === 1;
            ?>
                <div class="news-alternating-item <?php echo $is_even ? 'reverse' : ''; ?>">
                    <div class="news-alternating-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('news-thumbnail'); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mock.png" alt="Mock News">
                        <?php endif; ?>
                    </div>
                    <div class="news-alternating-content">
                        <h3 class="news-alternating-title"><?php the_title(); ?></h3>
                        <div class="news-alternating-meta">
                            <span><?php echo get_the_date('d.m.Y'); ?></span>
                            <?php $category = get_the_category(); if ($category) { echo ' &mdash; ' . esc_html($category[0]->name); } ?>
                        </div>
                        <div class="news-alternating-excerpt"><?php echo get_the_excerpt(); ?></div>
                        <a href="<?php the_permalink(); ?>" class="news-alternating-btn">Lire</a>
                    </div>
                </div>
            <?php $i++; endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var video = document.querySelector('.hero-video');
    if (video) {
        video.play().catch(function(error) {
            console.log("Erreur de lecture automatique:", error);
        });
    }
});
</script>

<?php get_footer(); ?> 