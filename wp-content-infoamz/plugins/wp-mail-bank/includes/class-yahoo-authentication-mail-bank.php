<?php
/**
 * This file is yahoo authentication.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-token-manager-mail-bank.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'includes/class-token-manager-mail-bank.php';
}
if ( ! class_exists( 'Yahoo_Authentication_Mail_Bank' ) ) {
	/**
	 * This class is used to authentication for yahoo.
	 *
	 * @package wp-mail-bank
	 * @subpackage includes
	 * @author Tech Banker
	 */
	class Yahoo_Authentication_Mail_Bank extends Token_Manager_Mail_Bank {
		/**
		 * Manage client id.
		 *
		 * @access   public
		 * @var      string    $client_id  from details eygfsyd.
		 */
		public $client_id;
		/**
		 * Manage client secret.
		 *
		 * @access   public
		 * @var      string    $client_secret  from details eygfsyd.
		 */
		public $client_secret;
			/**
			 * Manage callback uri.
			 *
			 * @access   public
			 * @var      string    $callback_uri  from details eygfsyd.
			 */
		public $callback_uri;
			/**
			 * Manage token url.
			 *
			 * @access   public
			 * @var      string    $token_url  from details eygfsyd.
			 */
		public $token_url;
			/**
			 * This function is used to.
			 *
			 * @param Mail_Bank_Manage_Token $client_id .
			 * @param Mail_Bank_Manage_Token $client_secret .
			 * @param Mail_Bank_Manage_Token $authorization_token .
			 * @param Mail_Bank_Manage_Token $callback_uri .
			 */
		public function __construct( $client_id, $client_secret, Mail_Bank_Manage_Token $authorization_token, $callback_uri ) {
			$this->client_id     = $client_id;
			$this->client_secret = $client_secret;
			$this->callback_uri  = $callback_uri;
			$this->token_url     = 'https://api.login.yahoo.com/oauth2/get_token';
			parent::__construct( $client_id, $client_secret, $authorization_token, $callback_uri );
		}
		/**
		 * This function is used to get token code.
		 *
		 * @param int $transaction_id transaction id.
		 */
		public function get_token_code( $transaction_id ) {
			$configurations = array(
				'response_type' => 'code',
				'redirect_uri'  => rawurlencode( $this->callback_uri ),
				'client_id'     => $this->client_id,
				'state'         => $transaction_id,
				'language'      => get_locale(),
			);
			$auth_url       = 'https://api.login.yahoo.com/oauth2/request_auth?' . build_query( $configurations );
			echo $auth_url;// @codingStandardsIgnoreLine.
		}
		/**
		 * This function is used to process token code.
		 *
		 * @param int $transaction_id transaction id.
		 */
		public function process_token_Code( $transaction_id ) {
			if ( isset( $_REQUEST['access_token'] ) ) {// WPCS: CSRF ok, WPCS: input var ok.
				$code = esc_attr( $_REQUEST['access_token'] ); // @codingStandardsIgnoreLine.

				$headers          = array(
					'Authorization' => sprintf( 'Basic %s', base64_encode( $this->client_id . ':' . $this->client_secret ) ),
				);
				$configurations   = array(
					'code'         => $code,
					'grant_type'   => 'authorization_code',
					'redirect_uri' => $this->callback_uri,
				);
				$response         = Mail_Bank_Zend_Mail_Helper::retrieve_body_from_response_mail_bank( $this->token_url, $configurations, $headers );
				$yahoo_secret_key = $this->process_response( $response );
				if ( isset( $yahoo_secret_key->error ) ) {
					return $yahoo_secret_key;
				} else {
					$this->get_authorization_token()->set_vendorname_mail_bank( 'yahoo' );
					return '1';
				}
			} else {
				return false;
			}
		}
		/**
		 * This function is used to get refresh token for new access token.
		 */
		public function get_refresh_token() {
			$refresh_url  = $this->token_url;
			$callback_uri = $this->callback_uri;
			$headers      = array(
				'Authorization' => sprintf( 'Basic %s', base64_encode( $this->client_id . ':' . $this->client_secret ) ),
			);

			$configurations = array(
				'redirect_uri'  => $callback_uri,
				'grant_type'    => 'refresh_token',
				'refresh_token' => $this->get_authorization_token()->retrieve_refresh_token_mail_bank(),
			);
			$response       = Mail_Bank_Zend_Mail_Helper::retrieve_body_from_response_mail_bank( $this->token_url, $configurations, $headers );
			$this->process_response( $response );
		}
	}
}
