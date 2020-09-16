<?php
/**
 * This file is used for handling redirection.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/lib
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
$code = isset( $_REQUEST['code'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['code'] ) ) : ''; // WPCS: CSRF ok, WPCS: input var ok.
$url  = admin_url( "admin.php?page=mb_email_configuration&access_token=$code" );
header( "location: $url" );
exit();
