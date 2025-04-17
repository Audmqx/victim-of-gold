<?php 
// Si c'est une page WooCommerce, on laisse WooCommerce gérer l'affichage
if (function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
    get_template_part('woocommerce');
    return;
}

get_header(); ?>

<main id="main" class="site-main">
    <!-- HERO SECTION -->
    <section class="news-hero">
        <div class="news-hero-content">
            <h1 class="news-hero-title">Actualités</h1>
            <p class="news-hero-subtitle">Découvrez les dernières nouvelles de Victim of Gold</p>
        </div>
    </section>

    <!-- NEWS SECTION -->
    <section class="news-page-section">
        <div class="news-container">
            <div class="news-grid">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 9,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'paged' => $paged
                );

                $news_query = new WP_Query($args);

                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) : $news_query->the_post();
                ?>
                    <article class="news-item">
                        <div class="news-item-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('news-thumbnail'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mock.png" alt="Article image">
                            <?php endif; ?>
                        </div>
                        
                        <div class="news-item-content">
                            <div class="news-item-meta">
                                <span class="news-item-date"><?php echo get_the_date('d.m.Y'); ?></span>
                                <?php 
                                $categories = get_the_category();
                                if (!empty($categories)) : 
                                    echo '<span class="news-item-category">' . esc_html($categories[0]->name) . '</span>';
                                endif; 
                                ?>
                            </div>
                            <h2 class="news-item-title"><?php the_title(); ?></h2>
                            <div class="news-item-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="news-item-link">Lire la suite</a>
                        </div>
                    </article>
                <?php
                    endwhile;
                    
                    // Pagination
                    echo '<div class="news-pagination">';
                    echo paginate_links(array(
                        'total' => $news_query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => '&laquo; Précédent',
                        'next_text' => 'Suivant &raquo;'
                    ));
                    echo '</div>';
                    
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-posts">
                        <p>Aucun article trouvé.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?> 