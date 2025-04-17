<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if cart is not empty
if ( ! WC()->cart->is_empty() ) :

	do_action( 'woocommerce_before_checkout_form', $checkout );

	// If checkout registration is disabled and not logged in, the user cannot checkout.
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
		echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
		return;
	}

?>

<div class="checkout-container">
	<div class="checkout-wrapper">
		<div class="checkout-form-wrapper">
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div class="checkout-fields">
						<div class="col2-set" id="customer_details">
							<div class="col-1">
								<div class="woocommerce-billing-fields">
									<h3><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>
									<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>
									<?php foreach ($checkout->get_checkout_fields('billing') as $key => $field) : ?>
										<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
									<?php endforeach; ?>
									<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
								</div>
							</div>

							<div class="col-2">
								<div class="woocommerce-shipping-fields">
									<h3><?php esc_html_e('Shipping details', 'woocommerce'); ?></h3>
									<?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>
									<?php foreach ($checkout->get_checkout_fields('shipping') as $key => $field) : ?>
										<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
									<?php endforeach; ?>
									<?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
								</div>
							</div>
						</div>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
					</div>

				<?php endif; ?>
				
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
				
				<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
				
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			</form>
		</div>
	</div>
</div>

<?php else : ?>
	<div class="empty-cart-message">
		<p><?php esc_html_e('Your cart is currently empty.', 'woocommerce'); ?></p>
		<a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button">
			<?php esc_html_e('Return to shop', 'woocommerce'); ?>
		</a>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
