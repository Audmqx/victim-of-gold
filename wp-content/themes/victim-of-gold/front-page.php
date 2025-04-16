<?php get_header(); ?>

<main id="main" class="site-main">
    <!-- HERO SECTION -->
    <section class="hero">
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

    <!-- HORAIRES SECTION -->
    <section class="horaires-section">
        <div class="adresse-container">
            <p class="adresse">112 Allée des Tournesols,<br> 06400 Cannes</p>
        </div>
        
        <div class="map-container">
            <div id="google-map"></div>
            <div class="map-overlay"></div>
        </div>

        <div class="horaires-container">
            <div class="horaires-list">
                <div class="horaire-item" data-day="1">
                    <span class="jour">Lundi</span>
                    <span class="heures">10.00 - 19.00</span>
                </div>
                <div class="horaire-item" data-day="2">
                    <span class="jour">Mardi</span>
                    <span class="heures">10.00 - 19.00</span>
                </div>
                <div class="horaire-item" data-day="3">
                    <span class="jour">Mercredi</span>
                    <span class="heures">10.00 - 19.00</span>
                </div>
                <div class="horaire-item" data-day="4">
                    <span class="jour">Jeudi</span>
                    <span class="heures">10.00 - 19.00</span>
                </div>
                <div class="horaire-item" data-day="5">
                    <span class="jour">Vendredi</span>
                    <span class="heures">10.00 - 19.00</span>
                </div>
                <div class="horaire-item" data-day="6">
                    <span class="jour">Samedi</span>
                    <span class="heures">10.00 - 19.00</span>
                </div>
                <div class="horaire-item" data-day="0">
                    <span class="jour">Dimanche</span>
                    <span class="heures">10.00 - 19.00</span>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?> 