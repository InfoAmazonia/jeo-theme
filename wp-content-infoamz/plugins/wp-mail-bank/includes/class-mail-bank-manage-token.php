<?php
/**
 * This file is used to manage token.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
if ( ! class_exists( 'Mail_Bank_Manage_Token' ) ) {
	/**
	 * This class used to manage token.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Manage_Token {
		/**
		 * Manage token vender name.
		 *
		 * @access   public
		 * @var      string    $vendor_name  token vendor name.
		 */
		public $vendor_name;
		/**
		 * Manage email from variable details.
		 *
		 * @access   public
		 * @var      string    $access_token  from details.
		 */
		public $access_token;
		/**
		 * Manage email from variable details.
		 *
		 * @access   public
		 * @var      string    $refresh_token  from details.
		 */
		public $refresh_token;
		/**
		 * Manage email from variable details.
		 *
		 * @access   public
		 * @var      int    $expiry_time  from details.
		 */
		public $expiry_time;
		/**
		 * This function is used to create construct.
		 */
		public function __construct() {
			$this->get_token_mail_bank();
		}
		/**
		 * This function is used to get instance.
		 */
		public static function get_instance() {
			static $instance = null;
			if ( null === $instance ) {
				$instance = new Mail_Bank_Manage_Token();
			}
			return $instance;
		}
		/**
		 * This function is used to check is_valid.
		 */
		public function is_valid() {
			$access_token  = $this->retrieve_access_token_mail_bank();
			$refresh_token = $this->retrieve_refresh_token_mail_bank();
			return ! ( empty( $access_token ) || empty( $refresh_token ) );
		}
		/**
		 * This function is used to get token.
		 */
		public function get_token_mail_bank() {
			$oauth_token = get_option( 'mail_bank_auth' );
			$this->set_access_token_mail_bank( $oauth_token['access_token'] );
			$this->set_refresh_token_mail_bank( $oauth_token['refresh_token'] );
			$this->set_token_expirytime_mail_bank( $oauth_token['auth_token_expires'] );
			$this->set_vendorname_mail_bank( $oauth_token['vendor_name'] );
		}
		/**
		 * Save the mail bank oauth token properties to the database.
		 */
		public function save_token_mail_bank() {
			$oauth_token['access_token']       = $this->retrieve_access_token_mail_bank();
			$oauth_token['refresh_token']      = $this->retrieve_refresh_token_mail_bank();
			$oauth_token['auth_token_expires'] = $this->retrieve_token_expiry_time_mail_bank();
			$oauth_token['vendor_name']        = $this->get_vendor_mail_bank();
			update_option( 'mail_bank_auth', $oauth_token );
		}
		/**
		 * This function is used to get vendor.
		 */
		public function get_vendor_mail_bank() {
			return $this->vendor_name;
		}
		/**
		 * This function is used to retrieve token expiry time.
		 */
		public function retrieve_token_expiry_time_mail_bank() {
			return $this->expiry_time;
		}
		/**
		 * This function is used to retrieve access token.
		 */
		public function retrieve_access_token_mail_bank() {
			return $this->access_token;
		}
		/**
		 * This function is used to retrieve refresh token.
		 */
		public function retrieve_refresh_token_mail_bank() {
			return $this->refresh_token;
		}
		/**
		 * This function is used to set vendor name.
		 *
		 * @param string $name get name information.
		 */
		public function set_vendorname_mail_bank( $name ) {
			$this->vendor_name = esc_html( $name );
		}
		/**
		 * This function is used to set token expiry time.
		 *
		 * @param int $time set token expiry time.
		 */
		public function set_token_expirytime_mail_bank( $time ) {
			$this->expiry_time = esc_html( $time );
		}
		/**
		 * This function is used to set access token.
		 *
		 * @param string $token set access token.
		 */
		public function set_access_token_mail_bank( $token ) {
			$this->access_token = esc_html( $token );
		}
		/**
		 * This function is used to set refresh token.
		 *
		 * @param string $token set refresh token.
		 */
		public function set_refresh_token_mail_bank( $token ) {
			$this->refresh_token = esc_html( $token );
		}
	}
}
