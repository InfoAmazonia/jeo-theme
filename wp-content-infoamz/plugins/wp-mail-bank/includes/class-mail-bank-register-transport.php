<?php
/**
 * This file is used to register transport.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-configure-transport.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-configure-transport.php';
}
/**
 * This class used to register transport.
 *
 * @package    wp-mail-bank
 * @subpackage includes
 *
 * @author  Tech Banker
 */
class Mail_Bank_Register_Transport {
	/**
	 * Mail bank register transport.
	 *
	 * @access   public
	 * @var      string    $transport  register transport.
	 */
	public static $transport;
	/**
	 * This function is used to list transport.
	 *
	 * @param string $instance list transport.
	 */
	public function listing_transport_mail_bank( $instance ) {
		self::$transport = $instance;
	}
	/**
	 * This function is used to get the transport.
	 */
	public function retrieve_mailertype_mail_bank() {
		return self::$transport;
	}
}
