<?php
/**
 * Front order tracking rendering
 *
 * @package     LaPoste\LaPosteProExpeditionsWoocommerce\Assets\Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="laposteproexp-order-tracking">
	<h2><?php esc_html_e( 'Order tracking', 'la-poste-pro-expeditions-woocommerce' ); ?></h2>

	<?php
		require 'html-admin-order-tracking.php';
	?>
</div>
