<?php
/**
 * This file is used to manage email address.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
if ( ! class_exists( 'Mail_Bank_Manage_Email_Address' ) ) {
	/**
	 * This class used to manage email address.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Manage_Email_Address {
		/**
		 * Manage email address name variable details.
		 *
		 * @access   public
		 * @var      string    $name  name details.
		 */
		public $name;
		/**
		 * Manage email address email variable details.
		 *
		 * @access   public
		 * @var      string    $email  email details.
		 */
		public $email;
			/**
			 * This function is used to create construct.
			 *
			 * @param string $email email logs details.
			 * @param int    $name email message details.
			 */
		public function __construct( $email, $name = null ) {
			if ( preg_match( '/(.*)<(.+)>/', $email, $matches ) ) {
				if ( 3 == count( $matches ) ) { // WPCS: loose comparison ok.
					$name  = $matches [1];
					$email = $matches [2];
				}
			}
			$this->mb_set_email( trim( $email ) );
			$this->mb_set_name( trim( $name ) );
		}
		/**
		 * This function is used to get name.
		 */
		public function mb_get_name() {
			return $this->name;
		}
		/**
		 * This function is used to get email.
		 */
		public function mb_get_email() {
			return $this->email;
		}
		/**
		 * This function is used to get email format.
		 */
		public function mb_email_format() {
			$name = $this->mb_get_name();
			if ( ! empty( $name ) ) {
				return sprintf( '%s <%s>', $this->mb_get_name(), $this->mb_get_email() );
			} else {
				return sprintf( '%s', $this->mb_get_email() );
			}
		}
		/**
		 * This function is used to set name.
		 *
		 * @param string $name set name.
		 */
		public function mb_set_name( $name ) {
			$this->name = $name;
		}
		/**
		 * This function is used to set email.
		 *
		 * @param string $email set email.
		 */
		public function mb_set_email( $email ) {
			$this->email = $email;
		}
		/**
		 * This function validate the email address.
		 *
		 * @param string $description validate email content.
		 * @throws Exception $message throws exception.
		 */
		public function validate_email_contents_mail_bank( $description = '' ) {
			if ( ! Mail_Bank_Zend_Mail_Helper::email_validation_mail_bank( $this->email ) ) {
				if ( empty( $description ) ) {
					$message = sprintf( 'Invalid e-mail address "%s"', $this->email );
				} else {
					$message = sprintf( 'Invalid "%1$s" e-mail address "%2$s"', $description, $this->email );
				}
				throw new Exception( $message );
			}
		}
		/**
		 * This function takes a string or array of addresses and return an array.
		 *
		 * @param string $emails takes strings as an array.
		 */
		public static function convert_string_to_array_mail_bank( $emails ) {
			if ( ! is_array( $emails ) ) {
				$t      = explode( ',', $emails );
				$emails = array();
				foreach ( $t as $k => $v ) {
					if ( strpos( $v, ',' ) !== false ) {
						$t[ $k ] = '"' . str_replace( ' <', '" <', $v );
					}
					$simplified_email = trim( $t [ $k ] );
					array_push( $emails, $simplified_email );
				}
			}
			return $emails;
		}
	}
}
