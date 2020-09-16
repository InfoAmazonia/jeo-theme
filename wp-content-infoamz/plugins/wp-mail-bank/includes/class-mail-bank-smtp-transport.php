<?php
/**
 * This file is used for smtp transport.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
/**
 * This class used for smtp transport.
 *
 * @package    wp-mail-bank
 * @subpackage includes
 *
 * @author  Tech Banker
 */
class Mail_Bank_Smtp_Transport {
	/**
	 * Smtp transport configuration settings.
	 *
	 * @access   public
	 * @var      string    $configuration_settings  smtp transport configuration settings.
	 */
	public $configuration_settings;
	/**
	 * This function is used to create construct.
	 */
	public function __construct() {
		$obj_mb_config_provider       = new Mail_Bank_Configuration_Provider();
		$this->configuration_settings = $obj_mb_config_provider->get_configuration_settings();
	}
	/**
	 * This function is used to create mail engine for sending emails.
	 */
	public function initiate_mail_engine_mail_bank() {
		require_once 'class-mail-bank-zend-engine.php';
		return new Mail_Bank_Zend_Engine( $this );
	}
	/**
	 * This function is used to create zend mail transport.
	 *
	 * @param string $fake_hostname host name for smtp transport.
	 * @param string $fake_config configuration for smtp transport.
	 */
	public function initiate_zendmail_transport_mail_bank( $fake_hostname, $fake_config ) {
		$obj_mb_configure_transport = new Mail_Bank_Configure_Transport();
		if ( 'oauth2' === $this->configuration_settings['auth_type'] ) {
			$config = $obj_mb_configure_transport->configure_oauth_transport();
		} else {
			$config = $obj_mb_configure_transport->configure_plain_transport();
		}
		return new Mail_Bank_Zend_Mail_Transport_Smtp( $this->configuration_settings['hostname'], $config );
	}
}
