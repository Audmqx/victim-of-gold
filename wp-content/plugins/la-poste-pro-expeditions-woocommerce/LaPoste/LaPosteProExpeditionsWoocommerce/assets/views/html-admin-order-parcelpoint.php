<?php
/**
 * Order parcelpoint rendering
 *
 * @package     LaPoste\LaPosteProExpeditionsWoocommerce\Assets\Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$weekday_initials = array(
	'MONDAY'    => substr( __( 'MONDAY', 'la-poste-pro-expeditions-woocommerce' ), 0, 1 ),
	'TUESDAY'   => substr( __( 'TUESDAY', 'la-poste-pro-expeditions-woocommerce' ), 0, 1 ),
	'WEDNESDAY' => substr( __( 'WEDNESDAY', 'la-poste-pro-expeditions-woocommerce' ), 0, 1 ),
	'THURSDAY'  => substr( __( 'THURSDAY', 'la-poste-pro-expeditions-woocommerce' ), 0, 1 ),
	'FRIDAY'    => substr( __( 'FRIDAY', 'la-poste-pro-expeditions-woocommerce' ), 0, 1 ),
	'SATURDAY'  => substr( __( 'SATURDAY', 'la-poste-pro-expeditions-woocommerce' ), 0, 1 ),
	'SUNDAY'    => substr( __( 'SUNDAY', 'la-poste-pro-expeditions-woocommerce' ), 0, 1 ),
);

$has_opening_hours = is_array( $parcelpoint->opening_hours );
$has_address       = null !== $parcelpoint->name
	&& null !== $parcelpoint->address
	&& null !== $parcelpoint->zipcode
	&& null !== $parcelpoint->city
	&& null !== $parcelpoint->country;

if ( $has_opening_hours ) {
	$lines = array();
	foreach ( $parcelpoint->opening_hours as $index => $opening_hour ) {
		$am = '';
		$pm = '';
		if ( isset( $opening_hour->opening_periods[0] ) ) {
			$hours = $opening_hour->opening_periods[0];
			if ( strlen( $hours->open ) > 0 && strlen( $hours->close ) > 0 ) {
				$am = $hours->open . '-' . $hours->close;
			}
		}
		if ( isset( $opening_hour->opening_periods[1] ) ) {
			$hours = $opening_hour->opening_periods[1];
			if ( strlen( $hours->open ) > 0 && strlen( $hours->close ) > 0 ) {
				$pm = $hours->open . '-' . $hours->close;
			}
		}

		$line = $weekday_initials[ $opening_hour->weekday ] . ' ' . str_pad( $am, 11 ) . ' ' . str_pad( $pm, 11 );

		if ( 0 === $index % 2 ) {
			$line = '<span style="background-color: #d8d8d8;">' . $line . '</span>';
		}

		$lines[] = $line;
	}

	$opening_hours = implode( "\n", $lines );
}

if ( $has_address ) {
	?>
	<h4><?php esc_html_e( 'Pickup point address', 'la-poste-pro-expeditions-woocommerce' ); ?></h4>
	<p>
		<?php echo esc_html( $parcelpoint->name ); ?><br/>
		<?php echo esc_html( $parcelpoint->address ); ?><br/>
		<?php echo esc_html( $parcelpoint->zipcode . ' ' . $parcelpoint->city . ' ' . $parcelpoint->country ); ?>
	</p>
	<?php
}
if ( $has_opening_hours ) {
	?>
	<h4><?php esc_html_e( 'Opening hours', 'la-poste-pro-expeditions-woocommerce' ); ?></h4>
	<pre style="background-color: inherit;"><?php echo wp_kses( $opening_hours, array( 'span' => array( 'style' => array() ) ) ); ?></pre>
	<?php
}
?>
