<?php
/**
 * This file is used for authentication of microsoft.
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

if ( ! class_exists( 'Microsoft_Authentication_Mail_Bank' ) ) {
	/**
	 * This class is used to authentication of microsoft.
	 *
	 * @package wp-mail-bank
	 * @subpackage includes
	 * @author Tech Banker
	 */
	class Microsoft_Authentication_Mail_Bank extends Token_Manager_Mail_Bank {
		/**
		 * Manage client id.
		 *
		 * @access   public
		 * @var      string    $client_id  holds client id.
		 */
		public $client_id;
		/**
		 * Manage client secret.
		 *
		 * @access   public
		 * @var      string    $client_secret  holds client secret.
		 */
		public $client_secret;
		/**
		 * Manage callback uri.
		 *
		 * @access   public
		 * @var      string    $callback_uri  holds callback uri.
		 */
		public $callback_uri;
		/**
		 * Manage token url.
		 *
		 * @access   public
		 * @var      string    $token_url  holds token url.
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
			$this->token_url     = 'https://login.live.com/oauth20_token.srf';
			parent::__construct( $client_id, $client_secret, $authorization_token, $callback_uri );
		}
		/**
		 * This function return the verification code after successfull authentication.
		 *
		 * @param string $transaction_id passes transaction id.
		 */
		public function get_token_code( $transaction_id ) {
			$configurations = array(
				'response_type'   => 'code',
				'redirect_uri'    => rawurlencode( $this->callback_uri ),
				'client_id'       => $this->client_id,
				'client_secret'   => $this->client_secret,
				'scope'           => rawurlencode( 'wl.imap,wl.offline_access' ),
				'state'           => $transaction_id,
				'access_type'     => 'offline',
				'approval_prompt' => 'force',
			);
			$oauth_url      = 'https://login.live.com/oauth20_authorize.srf?' . build_query( $configurations );
			echo $oauth_url;// @codingStandardsIgnoreLine.
		}
		/**
		 * This function is used to proccess the grant code.
		 *
		 * @param int $transaction_id transaction id.
		 */
		public function process_token_Code( $transaction_id ) {
			if ( isset( $_REQUEST['access_token'] ) ) {// WPCS: CSRF ok, WPCS: input var ok.
				$code                 = esc_attr( $_REQUEST['access_token'] ); // @codingStandardsIgnoreLine.
				$configurations       = array(
					'client_id'     => $this->client_id,
					'client_secret' => $this->client_secret,
					'grant_type'    => 'authorization_code',
					'redirect_uri'  => $this->callback_uri,
					'code'          => $code,
				);
				$response             = Mail_Bank_Zend_Mail_Helper::retrieve_body_from_response_mail_bank( $this->token_url, $configurations );
				$microsoft_secret_key = $this->process_response( $response );
				if ( isset( $microsoft_secret_key->error ) ) {
					return $microsoft_secret_key;
				} else {
					$this->get_authorization_token()->set_vendorname_mail_bank( 'microsoft' );
					return '1';
				}
			} else {
				return false;
			}
		}
	}
}
