<?php
/**
 * This Template is used for pricing-plan.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/views/pricing-plan
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( ! is_user_logged_in() ) {
	return;
} else {
	$access_granted = false;
	foreach ( $user_role_permission as $permission ) {
		if ( current_user_can( $permission ) ) {
			$access_granted = true;
			break;
		}
	}
	if ( ! $access_granted ) {
		return;
	}
	?>
	<div class="row">
		<div class="col-md-12">
			<iframe src="https://tech-banker.com/wp-mail-bank/pricing/" class="wpmb-iframe-pricing"></iframe>
		</div>
	</div>
	<?php
}
