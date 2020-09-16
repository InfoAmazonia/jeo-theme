<?php
/**
 * This file is used for authenticating and sending Emails.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( ! class_exists( 'Mail_Bank_Auth_Host' ) ) {
	/**
	 * This class is used to host authentication.
	 *
	 * @package wp-mail-bank
	 * @subpackage includes
	 * @author Tech Banker
	 */
	class Mail_Bank_Auth_Host {
		/**
		 * Manage from name
		 *
		 * @access   public
		 * @var      string    $from_name  holds from name.
		 */
		public $from_name;
		/**
		 * Manage smtp host
		 *
		 * @access   public
		 * @var      string    $smtp_host  holds smtp host.
		 */
		public $smtp_host;
		/**
		 * Manage smtp port
		 *
		 * @access   public
		 * @var      string    $smtp_port  holds smtp port.
		 */
		public $smtp_port;
		/**
		 * Manage client id
		 *
		 * @access   public
		 * @var      string    $client_id  holds client id.
		 */
		public $client_id;
		/**
		 * Manage client secret
		 *
		 * @access   public
		 * @var      string    $client_secret  holds client secret.
		 */
		public $client_secret;
		/**
		 * Manage redirect uri
		 *
		 * @access   public
		 * @var      string    $redirect_uri  holds redirect uri.
		 */
		public $redirect_uri;
		/**
		 * Manage api key
		 *
		 * @access   public
		 * @var      string    $api_key  holds api key.
		 */
		public $api_key;
		/**
		 * Manage authorization token
		 *
		 * @access   public
		 * @var      string    $authorization_token  holds from authorization token.
		 */
		public $authorization_token;
		/**
		 * Manage oauth domains
		 *
		 * @access   public
		 * @var      array    $oauth_domains array holds from authorization domains.
		 */
		public $oauth_domains = array(
			'hotmail.com'  => 'smtp.live.com',
			'outlook.com'  => 'smtp.live.com',
			'yahoo.ca'     => 'smtp.mail.yahoo.ca',
			'yahoo.co.id'  => 'smtp.mail.yahoo.co.id',
			'yahoo.co.in'  => 'smtp.mail.yahoo.co.in',
			'yahoo.co.kr'  => 'smtp.mail.yahoo.com',
			'yahoo.com'    => 'smtp.mail.yahoo.com',
			'ymail.com'    => 'smtp.mail.yahoo.com',
			'yahoo.com.ar' => 'smtp.mail.yahoo.com.ar',
			'yahoo.com.au' => 'smtp.mail.yahoo.com.au',
			'yahoo.com.br' => 'smtp.mail.yahoo.com.br',
			'yahoo.com.cn' => 'smtp.mail.yahoo.com.cn',
			'yahoo.com.hk' => 'smtp.mail.yahoo.com.hk',
			'yahoo.com.mx' => 'smtp.mail.yahoo.com',
			'yahoo.com.my' => 'smtp.mail.yahoo.com.my',
			'yahoo.com.ph' => 'smtp.mail.yahoo.com.ph',
			'yahoo.com.sg' => 'smtp.mail.yahoo.com.sg',
			'yahoo.com.tw' => 'smtp.mail.yahoo.com.tw',
			'yahoo.com.vn' => 'smtp.mail.yahoo.com.vn',
			'yahoo.co.nz'  => 'smtp.mail.yahoo.com.au',
			'yahoo.co.th'  => 'smtp.mail.yahoo.co.th',
			'yahoo.co.uk'  => 'smtp.mail.yahoo.co.uk',
			'yahoo.de'     => 'smtp.mail.yahoo.de',
			'yahoo.es'     => 'smtp.correo.yahoo.es',
			'yahoo.fr'     => 'smtp.mail.yahoo.fr',
			'yahoo.ie'     => 'smtp.mail.yahoo.co.uk',
			'yahoo.it'     => 'smtp.mail.yahoo.it',
			'gmail.com'    => 'smtp.gmail.com',
		);
		/**
		 * Manage yahoo domains
		 *
		 * @access   public
		 * @var      array    $yahoo_domains array holds from yahoo domains.
		 */
		public $yahoo_domains = array(
			'smtp.mail.yahoo.ca',
			'smtp.mail.yahoo.co.id',
			'smtp.mail.yahoo.co.in',
			'smtp.mail.yahoo.com',
			'smtp.mail.yahoo.com',
			'smtp.mail.yahoo.com.ar',
			'smtp.mail.yahoo.com.au',
			'smtp.mail.yahoo.com.br',
			'smtp.mail.yahoo.com.cn',
			'smtp.mail.yahoo.com.hk',
			'smtp.mail.yahoo.com',
			'smtp.mail.yahoo.com.my',
			'smtp.mail.yahoo.com.ph',
			'smtp.mail.yahoo.com.sg',
			'smtp.mail.yahoo.com.tw',
			'smtp.mail.yahoo.com.vn',
			'smtp.mail.yahoo.com.au',
			'smtp.mail.yahoo.co.th',
			'smtp.mail.yahoo.co.uk',
			'smtp.mail.yahoo.de',
			'smtp.correo.yahoo.es',
			'smtp.mail.yahoo.fr',
			'smtp.mail.yahoo.co.uk',
			'smtp.mail.yahoo.it',
		);
		/**
		 * This function is used to.
		 *
		 * @param array $settings_array passes as a settings array .
		 */
		public function __construct( $settings_array ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-token.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-token.php';
			}
			$this->authorization_token = mail_bank_manage_token::get_instance();
			$this->from_name           = $settings_array['sender_name'];
			$this->from_email          = $settings_array['sender_email'];
			$this->smtp_host           = $settings_array['hostname'];
			$this->smtp_port           = $settings_array['port'];
			$this->client_id           = $settings_array['client_id'];
			$this->client_secret       = $settings_array['client_secret'];
			$this->redirect_uri        = $settings_array['redirect_uri'];
			$this->sender_email        = $settings_array['email_address'];
		}
		/**
		 * This function is used to send test email.
		 *
		 * @param Mail_Bank_Manage_Token $to .
		 * @param Mail_Bank_Manage_Token $subject .
		 * @param Mail_Bank_Manage_Token $message .
		 * @param Mail_Bank_Manage_Token $headers .
		 * @param Mail_Bank_Manage_Token $attachments .
		 * @param Mail_Bank_Manage_Token $email_configuration_settings .
		 */
		public function send_test_mail_bank( $to, $subject, $message, $headers = '', $attachments = '', $email_configuration_settings ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-send-mail.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-send-mail.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-token.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-token.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-smtp-transport.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-smtp-transport.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-register-transport.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-register-transport.php';
			}
			$obj_transport_registry = new Mail_Bank_Register_Transport();
			$obj_transport_registry->listing_transport_mail_bank( new Mail_Bank_Smtp_Transport( $email_configuration_settings ) );
			$obj_wp_mail = new Mail_Bank_Send_Mail();
			return $obj_wp_mail->send_email_message_mail_bank( $to, $subject, $message, $headers, $attachments, $email_configuration_settings );
		}
		/**
		 * This function is used for microsoft authentication.
		 */
		public function microsoft_authentication() {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-microsoft-authentication-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-microsoft-authentication-mail-bank.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php';
			}
			$obj_microsoft_authentication_mail_bank = new Microsoft_Authentication_Mail_Bank( $this->client_id, $this->client_secret, $this->authorization_token, $this->redirect_uri );

			$obj_microsoft_authentication_mail_bank->get_token_code( 'wp-mail-bank' );
		}
		/**
		 * This function is used google authentication.
		 */
		public function google_authentication() {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-google-authentication-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-google-authentication-mail-bank.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php';
			}
			$obj_google_authentication_mail_bank = new Google_Authentication_Mail_Bank( $this->client_id, $this->client_secret, $this->authorization_token, $this->redirect_uri, $this->sender_email );

			$obj_google_authentication_mail_bank->get_token_code( 'wp-mail-bank' );
		}
		/**
		 * This function is used to send test email.
		 *
		 * @param  string $code .
		 */
		public function microsoft_authentication_token( $code ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-microsoft-authentication-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-microsoft-authentication-mail-bank.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php';
			}
			$obj_microsoft_authentication_mail_bank = new Microsoft_Authentication_Mail_Bank( $this->client_id, $this->client_secret, $this->authorization_token, $this->redirect_uri );

			$test_error = $obj_microsoft_authentication_mail_bank->process_token_Code( md5( rand() ) );
			if ( isset( $test_error->error ) ) {
				return $test_error;
			}
			$this->authorization_token->save_token_mail_bank();
		}
		/**
		 * This function is used for google authentication.
		 *
		 * @param string $code .
		 */
		public function google_authentication_token( $code ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-google-authentication-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-google-authentication-mail-bank.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php';
			}
			$obj_google_authentication_mail_bank = new Google_Authentication_Mail_Bank( $this->client_id, $this->client_secret, $this->authorization_token, $this->redirect_uri, $this->sender_email );

			$test_error1 = $obj_google_authentication_mail_bank->process_token_Code( md5( rand() ) );
			if ( isset( $test_error1->error ) ) {
				return $test_error1;
			}

			$this->authorization_token->save_token_mail_bank();
		}
		/**
		 * This function is used for yahoo authentication.
		 */
		public function yahoo_authentication() {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-yahoo-authentication-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-yahoo-authentication-mail-bank.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php';
			}

			$obj_yahoo_authentication_mail_bank = new Yahoo_Authentication_Mail_Bank( $this->client_id, $this->client_secret, $this->authorization_token, $this->redirect_uri );
			$obj_yahoo_authentication_mail_bank->get_token_code( 'wp-mail-bank' );
		}
		/**
		 * This function is used for yahoo authentication.
		 *
		 * @param string $code .
		 */
		public function yahoo_authentication_token( $code ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-zend-mail-helper.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-yahoo-authentication-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-yahoo-authentication-mail-bank.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php';
			}
			$obj_yahoo_authentication_mail_bank = new Yahoo_Authentication_Mail_Bank( $this->client_id, $this->client_secret, $this->authorization_token, $this->redirect_uri, $this->sender_email );

			$test_error1 = $obj_yahoo_authentication_mail_bank->process_token_Code( md5( rand() ) );
			if ( isset( $test_error1->error ) ) {
				return $test_error1;
			}
			$this->authorization_token->save_token_mail_bank();
		}
		/**
		 * This function is used for override wp mail function.
		 */
		public static function override_wp_mail_function() {
			global $wpdb, $email_configuration_settings;
			$mail_bank_version_number = get_option( 'mail-bank-version-number' );
			if ( false !== $mail_bank_version_number ) {
				$mb_table_prefix = $wpdb->prefix;
				if ( is_multisite() ) {
					$settings_data       = $wpdb->get_var(
						$wpdb->prepare(
							'SELECT meta_value FROM ' . $wpdb->base_prefix . 'mail_bank_meta WHERE meta_key=%s', 'settings'
						)
					);// WPCS: db call ok; no-cache ok.
					$settings_data_array = maybe_unserialize( $settings_data );
					if ( isset( $settings_data_array['fetch_settings'] ) && 'network_site' === $settings_data_array['fetch_settings'] ) {
						$mb_table_prefix = $wpdb->base_prefix;
					}
				}
				$email_configuration_data     = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT meta_value FROM ' . $mb_table_prefix . 'mail_bank_meta WHERE meta_key = %s', 'email_configuration'
					)
				);// db call ok; no-cache ok, unprepared SQL ok.
				$email_configuration_settings = maybe_unserialize( $email_configuration_data );
				if ( 'smtp' === $email_configuration_settings['mailer_type'] ) {
					if ( ! function_exists( 'wp_mail' ) ) {
						/**
						 * This function is used to send mail.
						 *
						 * @param string $to .
						 * @param string $subject .
						 * @param string $message .
						 * @param string $headers .
						 * @param string $attachments .
						 */
						function wp_mail( $to, $subject, $message, $headers = '', $attachments = '' ) {
							/**
							 * Filters the wp_mail() arguments.
							 *
							 * @since 2.2.0
							 *
							 * @param array $args A compacted array of wp_mail() arguments, including the "to" email,
							 *                    subject, message, headers, and attachments values.
							 */
							$atts = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ) );

							if ( isset( $atts['to'] ) ) {
								$to = $atts['to'];
							}

							if ( ! is_array( $to ) ) {
								$to = explode( ',', $to );
							}

							if ( isset( $atts['subject'] ) ) {
								$subject = $atts['subject'];
							}

							if ( isset( $atts['message'] ) ) {
								$message = $atts['message'];
							}

							if ( isset( $atts['headers'] ) ) {
								$headers = $atts['headers'];
							}

							if ( isset( $atts['attachments'] ) ) {
								$attachments = $atts['attachments'];
							}

							if ( ! is_array( $attachments ) ) {
								$attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );
							}

							global $wpdb, $email_configuration_settings;
							$obj_send_test_mail = new Mail_Bank_Auth_Host( $email_configuration_settings );
							$result             = $obj_send_test_mail->send_test_mail_bank( $to, $subject, $message, $headers, $attachments, $email_configuration_settings );
							return $result;
						}
					}
				}
			}
		}
	}
}
