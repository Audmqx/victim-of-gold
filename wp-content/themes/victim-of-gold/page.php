<?php
get_header();
?>
<main id="main" class="site-main">
    <section class="page-section">
        <div class="container">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </section>
</main>
<?php get_footer(); ?> 