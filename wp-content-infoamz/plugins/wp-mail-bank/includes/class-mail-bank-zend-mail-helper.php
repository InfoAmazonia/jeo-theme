<?php
/**
 * This file is used for zend mail helper.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( ! class_exists( 'Mail_Bank_Zend_Mail_Helper' ) ) {
	/**
	 * This class used for zend mail helper.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Zend_Mail_Helper {
		/**
		 * Mail bank zend mail helper validate email.
		 *
		 * @access   public
		 * @var      string    $validate_email zend mail helper validate emailt.
		 */
		public static $validate_email;
		/**
		 * This function is used for email domains.
		 *
		 * @param string $hostname zend mail helper host name.
		 * @param string $needle zend mail helper needle.
		 */
		public static function email_domains_mail_bank( $hostname, $needle ) {
			$length = strlen( $needle );
			return( substr( $hostname, - $length ) === $needle );
		}
		/**
		 * This function is used to retrieve body from response.
		 *
		 * @param string $url retrieve url.
		 * @param string $parameters retrieve parameters.
		 * @param array  $headers retrieve headers.
		 */
		public static function retrieve_body_from_response_mail_bank( $url, $parameters, array $headers = array() ) {
			$response = Mail_Bank_Zend_Mail_Helper::post_request_mail_bank( $url, $parameters, $headers );
			if ( isset( $response['error'] ) ) {
				return wp_json_encode( $response );
			}
			$body = wp_remote_retrieve_body( $response );
			return $body;
		}
		/**
		 * This function is used to make outgoing Http requests.
		 *
		 * @param string $url request for url.
		 * @param array  $parameters request for parameters.
		 * @param array  $headers request for headers.
		 */
		public static function post_request_mail_bank( $url, $parameters = array(), array $headers = array() ) {
			$args     = array(
				'timeout' => '10000',
				'headers' => $headers,
				'body'    => $parameters,
			);
			$response = wp_remote_post( $url, $args );

			if ( is_wp_error( $response ) ) {
				return array(
					'error'             => 'An error occured',
					'error_description' => $response->get_error_message(),
				);
			} else {
				return $response;
			}
		}
		/**
		 * This function is used for basic field validation.
		 *
		 * @param string $text text of the field.
		 */
		public static function check_field_mail_bank( $text ) {
			return( ! isset( $text ) || trim( $text ) === '' );
		}
		/**
		 * This function is used to validate an email-address.
		 *
		 * @param string $email email of the field.
		 */
		public static function email_validation_mail_bank( $email ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-registry.php';
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php';
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-interface.php';
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php';
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-ip.php';
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-hostname.php';
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-emailaddress.php';
			if ( ! isset( Mail_Bank_Zend_Mail_Helper::$validate_email ) ) {
				Mail_Bank_Zend_Mail_Helper::$validate_email = new Mail_Bank_Zend_Validate_EmailAddress();
			}
			return Mail_Bank_Zend_Mail_Helper::$validate_email->is_valid( $email );
		}
	}
}
