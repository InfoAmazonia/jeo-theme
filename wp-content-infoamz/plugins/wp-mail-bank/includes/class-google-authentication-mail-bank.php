<?php
/**
 * This file manages google authentication.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-token-manager-mail-bank.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'includes/class-token-manager-mail-bank.php';
}

if ( ! class_exists( 'Google_Authentication_Mail_Bank' ) ) {
	/**
	 * This class is used to manage google authentication.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Google_Authentication_Mail_Bank extends Token_Manager_Mail_Bank {
		/**
		 * Client Id for google authentication.
		 *
		 * @access   public
		 * @var      string    $client_id  client id for authentication.
		 */
		public $client_id;
		/**
		 * Client secret for google authentication.
		 *
		 * @access   public
		 * @var      string    $client_secret  client secret for authentication.
		 */
		public $client_secret;
		/**
		 * Callback uri for google authentication.
		 *
		 * @access   public
		 * @var      string    $callback_uri  callback uri for authentication.
		 */
		public $callback_uri;
		/**
		 * Sender email for google authentication.
		 *
		 * @access   public
		 * @var      string    $sender_email  sender email for authentication.
		 */
		public $sender_email;
		/**
		 * Token url for google authentication.
		 *
		 * @access   public
		 * @var      string    $token_url  token url for authentication.
		 */
		public $token_url;

		/**
		 * This function is used to create construct.
		 *
		 * @param Mail_Bank_Manage_Token $client_id  represent clent id.
		 * @param Mail_Bank_Manage_Token $client_secret  represent clent secret.
		 * @param Mail_Bank_Manage_Token $authorization_token  represent authorization token.
		 * @param Mail_Bank_Manage_Token $callback_uri  represent callback uri.
		 * @param Mail_Bank_Manage_Token $sender_email  represent sender email.
		 */
		public function __construct( $client_id, $client_secret, Mail_Bank_Manage_Token $authorization_token, $callback_uri, $sender_email ) {
			$this->sender_email  = $sender_email;
			$this->client_id     = $client_id;
			$this->client_secret = $client_secret;
			$this->callback_uri  = $callback_uri;
			$this->token_url     = 'https://www.googleapis.com/oauth2/v3/token';
			parent::__construct( $client_id, $client_secret, $authorization_token, $callback_uri );
		}
		/**
		 * This function request the token code.
		 *
		 * @param string $state_id  represent state id.
		 */
		public function get_token_code( $state_id ) {
			$configurations = array(
				'response_type'   => 'code',
				'redirect_uri'    => rawurlencode( $this->callback_uri ),
				'client_id'       => $this->client_id,
				'scope'           => rawurlencode( 'https://mail.google.com/' ),
				'access_type'     => 'offline',
				'approval_prompt' => 'force',
				'state'           => $state_id,
				'login_hint'      => $this->sender_email,
			);

			$oauth_url = 'https://accounts.google.com/o/oauth2/auth?' . build_query( $configurations );
			echo $oauth_url;// @codingStandardsIgnoreLine.
		}
		/**
		 * This function process the token code.
		 *
		 * @param string $state_id  represent state id.
		 */
		public function process_token_Code( $state_id ) {
			if ( isset( $_REQUEST['access_token'] ) ) { // WPCS: CSRF ok, WPCS: input var ok.
				$code           = esc_attr( $_REQUEST['access_token'] ); // @codingStandardsIgnoreLine.
				$configurations = array(
					'client_id'     => $this->client_id,
					'client_secret' => $this->client_secret,
					'grant_type'    => 'authorization_code',
					'redirect_uri'  => $this->callback_uri,
					'code'          => $code,
				);
				$response       = Mail_Bank_Zend_Mail_Helper::retrieve_body_from_response_mail_bank( $this->token_url, $configurations );
				$test_error     = $this->process_response( $response );
				if ( isset( $test_error->error ) ) {
					return $test_error;
				} else {
					$this->get_authorization_token()->set_vendorname_mail_bank( 'google' );
					return '1';
				}
			} else {
				return false;
			}
		}
	}
}
