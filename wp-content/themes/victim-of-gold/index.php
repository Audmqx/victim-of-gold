<?php get_header(); ?>

<main>
    <section class="hero">
        <?php
        // Hero section background image will be set via CSS
        ?>
    </section>

    <section class="news-section">
        <div class="news-grid">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $news_query = new WP_Query($args);

            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
            ?>
                <article class="news-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('news-thumbnail'); ?>
                    <?php endif; ?>
                    
                    <div class="news-content">
                        <h2 class="news-title"><?php the_title(); ?></h2>
                        <div class="news-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?> 