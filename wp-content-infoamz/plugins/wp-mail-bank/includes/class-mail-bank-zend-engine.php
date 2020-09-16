<?php
/**
 * This file is used for zend engine.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-registry.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-registry.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-message.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-message.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-part.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-part.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-interface.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-interface.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-validate.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-validate.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-ip.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-ip.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-hostname.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-hostname.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mail.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mail.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-smtp.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-smtp.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-sendmail.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-sendmail.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-abstract.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-abstract.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-smtp.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-smtp.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-oauth2.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-oauth2.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-plain.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-plain.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/auth/class-mail-bank-zend-mail-protocol-smtp-auth-crammd5.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/auth/class-mail-bank-zend-mail-protocol-smtp-auth-crammd5.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-login.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-login.php';
}
if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-configuration-provider.php' ) ) {
	include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-configuration-provider.php';
}

if ( ! class_exists( 'Mail_Bank_Zend_Engine' ) ) {
	/**
	 * This class used for zend engine.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Zend_Engine {
		/**
		 * Mail bank zend engine transcript.
		 *
		 * @access   public
		 * @var      string    $transcript zend engine transcript.
		 */
		public $transcript;
		/**
		 * Mail bank zend engine options.
		 *
		 * @access   public
		 * @var      string    $mail_bank_options  zend engine options.
		 */
		public $mail_bank_options;
			/**
			 * Mail bank  zend engine transport.
			 *
			 * @access   public
			 * @var      string    $transport   zend engine transport.
			 */
		public $transport;
			/**
			 * This function is used to create construct.
			 *
			 * @param string $transport zend transport transport.
			 */
		public function __construct( $transport ) {
			$this->transport         = $transport;
			$mb_config_provider_obj  = new Mail_Bank_Configuration_Provider();
			$this->mail_bank_options = $mb_config_provider_obj->get_configuration_settings();
		}
		/**
		 * This Function is used to send Email.
		 *
		 * @param Mail_Bank_Manage_Email $message used to send meassage.
		 * @throws Exception Throw exception.
		 */
		public function send_email_mail_bank( Mail_Bank_Manage_Email $message ) {
			$envelope_from = new Mail_Bank_Manage_Email_Address( $this->mail_bank_options['email_address'] );
			$envelope_from->validate_email_contents_mail_bank( 'Envelope From' );
			$charset = $message->mb_get_charset();
			$mail    = new Mail_Bank_Zend_Mail( $charset );
			/**
			 * Add date.
			 */
			$date = $message->mb_get_date();
			if ( ! empty( $date ) ) {
				$mail->setDate( $date );
			}
			/**
			 *  Add to recipients.
			 */
			foreach ( (array) $message->mb_get_to_recipients() as $recipient ) {
				$mail->addTo( $recipient->mb_get_email(), $recipient->mb_get_name() );
			}
			/**
			 * Add the from header.
			 */
			$from_header = $this->get_sender_from_email_mail_bank( $message, $mail );
			/**
			 * Add subject of the email.
			 */
			if ( null !== $message->mb_get_subject() ) {
				$mail->setSubject( $message->mb_get_subject() );
			}
			/**
			 * Add message id.
			 */
			$message_id = $message->mb_get_message_id();
			if ( ! empty( $message_id ) ) {
				$mail->setMessageId( $message_id );
			}
			/**
			 * Add headers.
			 */
			$mail->addHeader( 'X-Mailer', sprintf( 'Mail Bank SMTP %s for WordPress (%s)', MAIL_BANK_VERSION_NUMBER, 'https://tech-banker.com/wp-mail-bank/' ) );
			foreach ( (array) $message->mb_get_headers() as $header ) {
				$mail->addHeader( $header['name'], $header['content'], true );
			}

			$content_type = $message->mb_get_content_type();
			if ( ! empty( $content_type ) ) {
				$mail->addHeader( 'Content-Type', $content_type, false );
			}
			/**
			 *  Add cc recipients.
			 */
			if ( '' === $this->mail_bank_options['cc'] ) {
				foreach ( (array) $message->mb_get_cc_recipients() as $recipient ) {
					$mail->addCc( $recipient->mb_get_email(), $recipient->mb_get_name() );
				}
			} else {
				$cc_address_array = explode( ',', $this->mail_bank_options['cc'] );
				foreach ( $cc_address_array as $cc_address ) {
					$mail->addCc( $cc_address );
				}
			}
			/**
			 *  Add bcc recepients.
			 */
			if ( '' === $this->mail_bank_options['bcc'] ) {
				foreach ( (array) $message->mb_get_bcc_recipients() as $recipient ) {
					$mail->addBcc( $recipient->mb_get_email(), $recipient->mb_get_name() );
				}
			} else {
				$bcc_address_array = explode( ',', $this->mail_bank_options['bcc'] );
				foreach ( $bcc_address_array as $bcc_address ) {
					$mail->addBcc( $bcc_address );
				}
			}
			/**
			 *  Add reply to.
			 */
			$reply_to = $message->mb_get_reply_to();
			if ( '' !== $this->mail_bank_options['reply_to'] ) {
				$mail->set_reply_to( $this->mail_bank_options['reply_to'] );
			} elseif ( isset( $reply_to ) ) {
				$mail->set_reply_to( $reply_to->mb_get_email() );
			}
			/**
			 * Add message content of the email.
			 */
			$text_part = $message->mb_get_body_text_part();
			if ( ! empty( $text_part ) ) {
				$mail->setBodyText( $text_part );
			}
			$html_part = $message->mb_get_body_html_part();
			if ( ! empty( $html_part ) ) {
				$mail->setBodyHtml( $html_part );
			}
			/**
			 * Add attachments to the email.
			 */
			$message->mb_add_attachments_to_mail( $mail );
			/**
			 * Create the SMTP transport.
			 */
			$zend_transport = $this->transport->initiate_zendmail_transport_mail_bank( $this->mail_bank_options['hostname'], array() );
			try {
				/**
				 * Send the message.
				 */
				$mail->send( $zend_transport );
				if ( $zend_transport->get_connection() && ! Mail_Bank_Zend_Mail_Helper::check_field_mail_bank( $zend_transport->get_connection()->get_log() ) ) {
					$this->transcript = $zend_transport->get_connection()->get_log();
				} elseif ( method_exists( $zend_transport, 'get_output_mail_bank' ) && ! Mail_Bank_Zend_Mail_Helper::check_field_mail_bank( $zend_transport->get_output_mail_bank() ) ) {
					/**
					 * Use the API response.
					 */
					$this->transcript = $zend_transport->get_output_mail_bank();
				} elseif ( method_exists( $zend_transport, 'getMessage' ) && ! Mail_Bank_Zend_Mail_Helper::check_field_mail_bank( $zend_transport->getMessage() ) ) {
					/**
					 * Use the raw message as the transcript.
					 */
					$this->transcript = $zend_transport->getMessage();
				}
			} catch ( Exception $e ) {
				/**
				 * In case of Error.
				 */
				if ( $zend_transport->get_connection() && ! Mail_Bank_Zend_Mail_Helper::check_field_mail_bank( $zend_transport->get_connection()->get_log() ) ) {
					$this->transcript = $zend_transport->get_connection()->get_log();
				} elseif ( method_exists( $zend_transport, 'get_output_mail_bank' ) && ! Mail_Bank_Zend_Mail_Helper::check_field_mail_bank( $zend_transport->get_output_mail_bank() ) ) {
					/**
					 * Use API response.
					 */
					$this->transcript = $zend_transport->get_output_mail_bank();
				} elseif ( method_exists( $zend_transport, 'getMessage' ) && ! Mail_Bank_Zend_Mail_Helper::check_field_mail_bank( $zend_transport->getMessage() ) ) {
					/**
					 * Use message as the transcript.
					 */
					$this->transcript = $zend_transport->getMessage();
				}
				/**
				 *  Get the current exception message.
				 */
				$message = $e->getMessage();
				if ( $e->getCode() === 334 ) {
					$message = 'From Email should be of same account used to create the Client Id.';
				}
				$exception = new Exception( $message, $e->getCode() );
				/**
				 *  Throws the new exception.
				 */
				throw $exception;
			}
		}
		/**
		 * This function is used to get the sender from Mail_Bank_Manage_Email and add it to the Mail_Bank_Zend_Mail object.
		 *
		 * @param string $message Get the sender message.
		 * @param string $mail get the sender mail.
		 */
		public function get_sender_from_email_mail_bank( $message, $mail ) {
			$sender       = $message->get_email_address_mail_bank();
			$sender_email = $sender->mb_get_email();
			$sender_name  = $sender->mb_get_name();
			if ( ( 'override' === $this->mail_bank_options['sender_name_configuration'] ) && ( 'override' === $this->mail_bank_options['from_email_configuration'] ) ) {
				$mail->setFrom( $this->mail_bank_options['sender_email'], html_entity_decode( $this->mail_bank_options['sender_name'], ENT_QUOTES ) );
			} elseif ( ( 'dont_override' === $this->mail_bank_options['sender_name_configuration'] ) && ( 'dont_override' === $this->mail_bank_options['from_email_configuration'] ) ) {
				$mail->setFrom( $sender_email, $sender_name );
			} elseif ( ( 'override' === $this->mail_bank_options['sender_name_configuration'] ) && ( 'dont_override' === $this->mail_bank_options['from_email_configuration'] ) ) {
				$mail->setFrom( $sender_email, html_entity_decode( $this->mail_bank_options['sender_name'], ENT_QUOTES ) );
			} else {
				$mail->setFrom( $this->mail_bank_options['sender_email'], $sender_name );
			}
			return $sender;
		}
		/**
		 * This funtion is used to return SMTP session Transcript.
		 */
		public function get_output_mail_bank() {
			return $this->transcript;
		}
	}
}
