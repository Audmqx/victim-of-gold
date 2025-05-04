<?php
/**
 * Template personnalisé Mon Compte pour Victim of Gold
 * Basé sur WooCommerce 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="vog-account-wrapper">
    <aside class="vog-account-nav">
        <?php do_action( 'woocommerce_account_navigation' ); ?>
    </aside>
    <main class="vog-account-content">
        <?php
            /**
             * My Account content.
             *
             * @since 2.6.0
             */
            do_action( 'woocommerce_account_content' );
        ?>
    </main>
</div> 