<?php
/**
 * This file manages authentication.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-google-authentication-mail-bank.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'includes/class-google-authentication-mail-bank.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-microsoft-authentication-mail-bank.php' ) ) {
		include_once MAIL_BANK_DIR_PATH . 'includes/class-microsoft-authentication-mail-bank.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-yahoo-authentication-mail-bank.php' ) ) {
		include_once MAIL_BANK_DIR_PATH . 'includes/class-yahoo-authentication-mail-bank.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-register-transport.php' ) ) {
		include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-register-transport.php';
}

if ( ! class_exists( 'Authentication_Manager_Mail_Bank' ) ) {
	/**
	 * This class is used to manage authentication.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Authentication_Manager_Mail_Bank {
		/**
		 * This Function is used to create authentication manager.
		 */
		public function create_authentication_manager() {
			$obj_mail_bank_register_transport = new Mail_Bank_Register_Transport();
			$transport                        = $obj_mail_bank_register_transport->retrieve_mailertype_mail_bank();
			return $this->create_manager( $transport );
		}
		/**
		 * This function checks for the service providers.
		 *
		 * @param Mail_Bank_Smtp_Transport $transport type of transport.
		 */
		public function create_manager( Mail_Bank_Smtp_Transport $transport ) {
				$obj_mb_config_provider = new Mail_Bank_Configuration_Provider();
				$configuration_settings = $obj_mb_config_provider->get_configuration_settings();
				$authorization_token    = Mail_Bank_Manage_Token::get_instance();
				$hostname               = $configuration_settings['hostname'];
				$client_id              = $configuration_settings['client_id'];
				$client_secret          = $configuration_settings['client_secret'];
				$sender_email           = $configuration_settings['sender_email'];
				$redirect_uri           = admin_url( 'admin-ajax.php' );
			if ( $this->check_google_service_provider_mail_bank( $hostname ) ) {
					$obj_service_provider = new Google_Authentication_Mail_Bank( $client_id, $client_secret, $authorization_token, $redirect_uri, $sender_email );
			} elseif ( $this->check_microsoft_service_provider_mail_bank( $hostname ) ) {
					$obj_service_provider = new Microsoft_Authentication_Mail_Bank( $client_id, $client_secret, $authorization_token, $redirect_uri );
			} elseif ( $this->check_yahoo_service_provider_mail_bank( $hostname ) ) {
					$obj_service_provider = new Yahoo_Authentication_Mail_Bank( $client_id, $client_secret, $authorization_token, $redirect_uri );
			}
				return $obj_service_provider;
		}
		/**
		 * This function checks for the google service providers.
		 *
		 * @param  string $hostname type of transport.
		 */
		public function check_google_service_provider_mail_bank( $hostname ) {
				return Mail_Bank_Zend_Mail_Helper::email_domains_mail_bank( $hostname, 'gmail.com' ) || Mail_Bank_Zend_Mail_Helper::email_domains_mail_bank( $hostname, 'googleapis.com' );
		}
		/**
		 * This function checks for the microsoft service providers.
		 *
		 * @param  string $hostname type of transport.
		 */
		public function check_microsoft_service_provider_mail_bank( $hostname ) {
				return Mail_Bank_Zend_Mail_Helper::email_domains_mail_bank( $hostname, 'live.com' );
		}
		/**
		 * This function checks for the yahoo service providers.
		 *
		 * @param  string $hostname type of transport.
		 */
		public function check_yahoo_service_provider_mail_bank( $hostname ) {
				return strpos( $hostname, 'yahoo' );
		}
	}
}
