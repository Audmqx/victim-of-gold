<?php
/**
 * The Template for displaying all single products
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' );

?>

<?php while ( have_posts() ) : ?>
    <?php the_post(); ?>
    <?php wc_get_template_part( 'content', 'single-product' ); ?>
<?php endwhile; ?>

<?php
get_footer( 'shop' ); 