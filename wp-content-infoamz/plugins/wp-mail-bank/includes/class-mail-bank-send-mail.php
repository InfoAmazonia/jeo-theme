<?php
/**
 * This file is used to send mail.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-configuration-provider.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-configuration-provider.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-email.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-email.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-email-log.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-email-log.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'includes/class-authentication-manager-mail-bank.php';
}

if ( ! class_exists( 'Mail_Bank_Send_Mail' ) ) {
	/**
	 * This class used to send email.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Send_Mail {
		/**
		 * Throws exception.
		 *
		 * @access   public
		 * @var      string    $exception  throws exception.
		 */
		public $exception;
		/**
		 * This is used for configuration settings.
		 *
		 * @access   public
		 * @var      string    $configuration_settings  configuration settings.
		 */
		public $configuration_settings;
			/**
			 * This is used to register transport.
			 *
			 * @access   public
			 * @var      string    $obj_mail_bank_register_transport  register transport.
			 */
		public $obj_mail_bank_register_transport;
			/**
			 * This function is used to create construct.
			 */
		public function __construct() {
			$obj_mb_config_provider                 = new Mail_Bank_Configuration_Provider();
			$this->obj_mail_bank_register_transport = new Mail_Bank_Register_Transport();
			$this->configuration_settings           = $obj_mb_config_provider->get_configuration_settings();
		}
		/**
		 * This function is used to send the message and return the result.
		 *
		 * @param string $to send to field details.
		 * @param string $subject send subject field details.
		 * @param string $message send message field details.
		 * @param string $headers send header field details.
		 * @param array  $attachments send attachments details.
		 * @param string $email_configuration_settings configuration settings.
		 */
		public function send_email_message_mail_bank( $to, $subject, $message, $headers = '', $attachments = array(), $email_configuration_settings ) {
			$mail_bank_manage_email = $this->build_message_mail_bank( $to, $subject, $message, $headers, $attachments );

			$log                = new Mail_Bank_Email_Log();
			$log->email_to      = $to;
			$log->email_subject = $subject;
			$log->email_message = $message;
			$log->email_headers = $headers;

			return $this->get_message_content_mail_bank( $mail_bank_manage_email, $log, $email_configuration_settings );
		}
		/**
		 * This function is used to build a message based on the WordPress wp_mail parameters.
		 *
		 * @param string $to send to field details.
		 * @param string $subject send subject field details.
		 * @param string $message send message field details.
		 * @param string $headers send header field details.
		 * @param string $attachments send attachments details.
		 */
		public function build_message_mail_bank( $to, $subject, $message, $headers, $attachments ) {
			if ( ! is_array( $attachments ) ) {
				$attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );
			}
			/**
			 * Creates the message.
			 *
			 * @param string $mail_bank_manage_email manage emails.
			 * @param string $to send to field details.
			 * @param string $subject send subject field details.
			 * @param string $message send message field details.
			 * @param string $headers send header field details.
			 * @param string $attachments send attachments details.
			 */
			$mail_bank_manage_email = $this->create_message_mail_bank();
			$this->get_entire_message_content_mail_bank( $mail_bank_manage_email, $to, $subject, $message, $headers, $attachments );

			/**
			 * Return the message.
			 */
			return $mail_bank_manage_email;
		}
		/**
		 * This function is used to create the instance of Mail_Bank_Manage_Email.
		 */
		public function create_message_mail_bank() {
			$message   = new Mail_Bank_Manage_Email();
			$transport = $this->obj_mail_bank_register_transport->retrieve_mailertype_mail_bank();
			$message->mb_set_from( $this->configuration_settings['email_address'], html_entity_decode( $this->configuration_settings['sender_name'], ENT_QUOTES ) );
			$message->mb_set_charset( get_bloginfo( 'charset' ) );
			return $message;
		}
		/**
		 * This function is used to get the options and token generated to send the message.
		 *
		 * @param Mail_Bank_Manage_Email $message send the message.
		 * @param Mail_Bank_Email_Log    $log log details.
		 * @param Mail_Bank_Manage_Email $email_configuration_settings email configuration settings.
		 */
		public function get_message_content_mail_bank( Mail_Bank_Manage_Email $message, Mail_Bank_Email_Log $log, $email_configuration_settings ) {
			global $wpdb;
			$mail_bank_settings_data = $wpdb->get_row(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key = %s', 'settings'
				)
			); // db call ok; no-cache ok.

			$settings_data                = maybe_unserialize( $mail_bank_settings_data->meta_value );
			$ob_mb_config_provider        = new Mail_Bank_Configuration_Provider();
			$this->configuration_settings = $ob_mb_config_provider->get_configuration_settings();
			$authorization_token          = Mail_Bank_Manage_Token::get_instance();

			$transport = $this->obj_mail_bank_register_transport->retrieve_mailertype_mail_bank();
			$engine    = $transport->initiate_mail_engine_mail_bank();
			if ( isset( $this->configuration_settings['headers'] ) && '' !== $this->configuration_settings['headers'] ) {
				$message->mb_add_headers( $this->configuration_settings['headers'] );
			}
			if ( $message->check_email_body_parts_mail_bank() ) {
				$message->create_body_parts();
			}
			$obj_mail_bank_manage_email = new Mail_Bank_Manage_Email();

			try {
				$message->validate_email_contents_mail_bank( $transport );

				if ( 'oauth2' === $this->configuration_settings['auth_type'] ) {
					$this->check_authtoken_mail_bank( $transport, $authorization_token );
				}
				$engine->send_email_mail_bank( $message );

				// writes the log on success.
				if ( '' !== $engine->get_output_mail_bank() && 'enable' === $settings_data['debug_mode'] ) {
					update_option( 'mail_bank_mail_status', $engine->get_output_mail_bank() );
				} else {
					update_option( 'mail_bank_mail_status', true );
				}
				$obj_mb_log_writter = new Mail_Bank_Email_Log_Writter();
				update_option( 'mail_bank_is_mail_sent', 'Sent' );
				if ( 'enable' === $settings_data['monitor_email_logs'] ) {
					$obj_mb_log_writter->mb_success_log( $log, $message, $settings_data['debug_mode'], $email_configuration_settings, $obj_mail_bank_manage_email );
				}
				return true;
			} catch ( Exception $e ) {
				$this->exception = $e;
				// Writes the log on failure.
				if ( $e->getCode() === 334 && 'enable' === $settings_data['debug_mode'] ) {
					update_option( 'mail_bank_mail_status', $e->getMessage() );
				} elseif ( $engine->get_output_mail_bank() != '' && 'enable' === $settings_data['debug_mode'] ) {// WPCS: loose comparison ok.
					update_option( 'mail_bank_mail_status', $engine->get_output_mail_bank() );
				} elseif ( $engine->get_output_mail_bank() == '' && 'enable' === $settings_data['debug_mode'] ) {// WPCS: loose comparison ok.
					update_option( 'mail_bank_mail_status', $e->getMessage() );
				} else {
					update_option( 'mail_bank_mail_status', false );
				}
				$obj_mb_log_writter = new Mail_Bank_Email_Log_Writter();
				update_option( 'mail_bank_is_mail_sent', 'Not Sent' );
				if ( 'enable' === $settings_data['monitor_email_logs'] ) {
					$obj_mb_log_writter->mb_failure_log( $log, $message, $settings_data['debug_mode'], $email_configuration_settings, $obj_mail_bank_manage_email );
				}
				return false;
			}
		}
		/**
		 * This function is used to ensure the token is updated.
		 *
		 * @param string $transport ensure token transport.
		 * @param string $authorization_token authenticate token.
		 */
		public function check_authtoken_mail_bank( $transport, $authorization_token ) {
			$authentication_manager               = new Authentication_Manager_Mail_Bank();
			$obj_authentication_manager_mail_bank = $authentication_manager->create_authentication_manager();
			if ( $obj_authentication_manager_mail_bank->check_access_token() ) {
				$obj_authentication_manager_mail_bank->get_refresh_token();
				$authorization_token->save_token_mail_bank();
			}
		}
		/**
		 * This function is used to set all the content into a message.
		 *
		 * @param string $message set message content.
		 * @param string $to set mail to field.
		 * @param string $subject setmail subject.
		 * @param string $body set body of mail.
		 * @param string $headers set mail header.
		 * @param string $attachments set mail attachments.
		 */
		public function get_entire_message_content_mail_bank( $message, $to, $subject, $body, $headers, $attachments ) {
			$message->mb_add_headers( $headers );
			$message->mb_set_body( $body );
			$message->mb_set_subject( $subject );
			$message->mb_addto( $to );
			$message->mb_set_attachments( $attachments );
			return $message;
		}
	}
}
