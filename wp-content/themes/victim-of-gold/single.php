<?php
get_header();
if (have_posts()) :
    while (have_posts()) : the_post(); ?>
        <main id="main" class="site-main">
            <article <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <div class="post-meta">
                    <span class="post-date"><?php echo get_the_date('d.m.Y'); ?></span>
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) :
                        echo '<span class="post-category">' . esc_html($categories[0]->name) . '</span>';
                    endif;
                    ?>
                </div>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
            </article>
        </main>
    <?php endwhile;
endif;
get_footer(); 