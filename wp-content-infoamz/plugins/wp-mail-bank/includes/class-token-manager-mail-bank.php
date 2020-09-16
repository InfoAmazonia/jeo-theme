<?php
/**
 * This file is token management
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( ! class_exists( 'Token_Manager_Mail_Bank' ) ) {
	/**
	 * This function sets token manager.
	 *
	 * @package wp-mail-bank
	 * @subpackage includes
	 * @author Tech Banker
	 */
	class Token_Manager_Mail_Bank {
		/**
		 * Manage client id.
		 *
		 * @access   public
		 * @var      string    $client_id  sets client id.
		 */
		public $client_id;
		/**
		 * Manage client id.
		 *
		 * @access   public
		 * @var      string    $client_secret  sets client secret.
		 */
		public $client_secret;
			/**
			 * Manage client id.
			 *
			 * @access   public
			 * @var      string    $authorization_token sets authorization token.
			 */
		public $authorization_token;
			/**
			 * Manage client id.
			 *
			 * @access   public
			 * @var      string    $callback_uri  sets callback uri.
			 */
		public $callback_uri;
			/**
			 * This function is used to.
			 *
			 * @param Mail_Bank_Manage_Token $client_id .
			 * @param Mail_Bank_Manage_Token $client_secret .
			 * @param Mail_Bank_Manage_Token $authorization_token .
			 * @param Mail_Bank_Manage_Token $callback_uri .
			 */
		public function __construct( $client_id, $client_secret, Mail_Bank_Manage_Token $authorization_token, $callback_uri ) {
			$this->client_id           = $client_id;
			$this->client_secret       = $client_secret;
			$this->authorization_token = $authorization_token;
			$this->callback_uri        = $callback_uri;
		}
		/**
		 * This function is used to get authorization token.
		 */
		public function get_authorization_token() {
			return $this->authorization_token;
		}
		/**
		 * This function is used to check access token.
		 */
		public function check_access_token() {
			$expiry_time   = intval( $this->authorization_token->retrieve_token_expiry_time_mail_bank() ) - 60;
			$token_expired = time() > $expiry_time;
			return $token_expired;
		}
		/**
		 * This function is used to decoded the received token.
		 *
		 * @param string $response process respose.
		 * @throws Exception Process response.
		 */
		public function process_response( $response ) {
			$oauth_token = json_decode( stripslashes( $response ) );
			if ( null === $oauth_token ) {
				throw new Exception( $response );
			} elseif ( isset( $oauth_token->{'error'} ) ) {
				if ( isset( $oauth_token->{'error_description'} ) ) {
					return $oauth_token;
				} else {
					throw new Exception( $oauth_token->{'error'} );
				}
			} else {
				$this->receive_decode_authorization_token( $oauth_token );
			}
		}
		/**
		 * This function is used to decoded the authorization token.
		 *
		 * @param string $new_token decode authorization token.
		 * @throws Exception Decode authorization token.
		 */
		public function receive_decode_authorization_token( $new_token ) {
			// Update expiry time.
			if ( empty( $new_token->{'expires_in'} ) ) {
				throw new Exception( '[expires_in] value is missing from token' );
			}
			$changed_expiry_time = time() + $new_token->{'expires_in'};
			$this->get_authorization_token()->set_token_expirytime_mail_bank( $changed_expiry_time );

			// Update access token.
			if ( empty( $new_token->{'access_token'} ) ) {
				throw new Exception( '[access_token] value is missing from token' );
			}
			$new_access_token = $new_token->{'access_token'};
			$this->get_authorization_token()->set_access_token_mail_bank( $new_access_token );

			// Update refresh token.
			if ( isset( $new_token->{'refresh_token'} ) ) {
				$new_refresh_token = $new_token->{'refresh_token'};
				$this->get_authorization_token()->set_refresh_token_mail_bank( $new_refresh_token );
			}
		}
		/**
		 * This function is used to get_refresh_token function is used to give specific URL and redirectUri to refresh the access token.
		 */
		public function get_refresh_token() {
			$refresh_uri    = $this->token_url;
			$callback_uri   = $this->callback_uri;
			$configurations = array(
				'client_id'     => $this->client_id,
				'client_secret' => $this->client_secret,
				'redirect_uri'  => $callback_uri,
				'grant_type'    => 'refresh_token',
				'refresh_token' => $this->get_authorization_token()->retrieve_refresh_token_mail_bank(),
			);
			$response       = Mail_Bank_Zend_Mail_Helper::retrieve_body_from_response_mail_bank( $refresh_uri, $configurations );
			$this->process_response( $response );
		}
	}
}
