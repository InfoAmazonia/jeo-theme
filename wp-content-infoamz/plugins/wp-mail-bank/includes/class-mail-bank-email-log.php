<?php
/**
 * This file is used to configure transport.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( ! class_exists( 'Mail_Bank_Email_Log' ) ) {
	/**
	 * This class used in the configuration of transport.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Email_Log {
		/**
		 * Email login to recipient details.
		 *
		 * @access   public
		 * @var      string    $to_recipients  to recipient for email logs.
		 */
		public $to_recipients;
		/**
		 * Email login subject details.
		 *
		 * @access   public
		 * @var      string    $subject  subject for email logs.
		 */
		public $subject;
		/**
		 * Email login body details.
		 *
		 * @access   public
		 * @var      string    $body  body for email logs.
		 */
		public $body;
	}
}

if ( ! class_exists( 'Mail_Bank_Email_Log_Writter' ) ) {
	/**
	 * This class is used to create logs.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Email_Log_Writter {// @codingStandardsIgnoreLine.
		/**
		 * This function is used to write success logs.
		 *
		 * @param string $email_logs email logs details.
		 * @param string $email_message email message details.
		 * @param string $debug_mode debug mode details.
		 * @param string $email_configuration_settings configuration settings details.
		 * @param string $obj_mail_bank_manage_email manage email.
		 */
		public function mb_success_log( $email_logs, $email_message, $debug_mode, $email_configuration_settings, $obj_mail_bank_manage_email ) {
			$status  = 'Sent';
			$subject = $email_message->mb_get_subject();
			$this->mb_create_email_log( $email_logs, $email_message );
			$this->mb_email_log( $email_logs, $debug_mode, $status, $email_configuration_settings, $obj_mail_bank_manage_email, $email_message );
		}
		/**
		 * This function is used to write failure logs.
		 *
		 * @param string $email_logs email logs details.
		 * @param int    $email_message email message details.
		 * @param string $debug_mode debug mode details.
		 * @param string $email_configuration_settings configuration settings details.
		 * @param string $obj_mail_bank_manage_email manage email.
		 */
		public function mb_failure_log( $email_logs, $email_message = null, $debug_mode, $email_configuration_settings, $obj_mail_bank_manage_email ) {
			$status = 'Not Sent';
			$this->mb_create_email_log( $email_logs, $email_message );
			$this->mb_email_log( $email_logs, $debug_mode, $status, $email_configuration_settings, $obj_mail_bank_manage_email, $email_message );
		}

		/**
		 * This function writes the Email Logs.
		 *
		 * @param string $email_logs email logs details.
		 * @param string $debug_mode debug mode details.
		 * @param string $status email status.
		 * @param string $email_configuration_settings configuration settings details.
		 * @param string $obj_mail_bank_manage_email manage email.
		 * @param string $message message to send.
		 */
		public function mb_email_log( $email_logs, $debug_mode, $status, $email_configuration_settings, $obj_mail_bank_manage_email, $message ) {
			$sender = $message->get_email_address_mail_bank();

			$sender_email = 'override' === $email_configuration_settings['from_email_configuration'] ? $email_configuration_settings['sender_email'] : $sender->mb_get_email();
			$sender_name  = 'override' === $email_configuration_settings['sender_name_configuration'] ? $email_configuration_settings['sender_name'] : $sender->mb_get_name();

			$cc_recipients  = $obj_mail_bank_manage_email->mb_get_cc_recipients();
			$bcc_recipients = $obj_mail_bank_manage_email->mb_get_bcc_recipients();
			$cc_address     = '';
			if ( '' === $email_configuration_settings['cc'] ) {
				$cc_array = array();
				foreach ( $cc_recipients as $recipient ) {
					array_push( $cc_array, $recipient->email );
				}
				$cc_address = implode( ',', $cc_array );
			} else {
				$cc_address = $email_configuration_settings['cc'];
			}
			$bcc_address = '';
			if ( '' === $email_configuration_settings['bcc'] ) {
				$bcc_array = array();
				foreach ( $bcc_recipients as $recipient ) {
					array_push( $bcc_array, $recipient->email );
				}
				$bcc_address = implode( ',', $bcc_array );
			} else {
				$bcc_address = $email_configuration_settings['bcc'];
			}
			$email_logs_data_array                 = array();
			$email_logs_data_array['email_to']     = $email_logs->to_recipients;
			$email_logs_data_array['cc']           = $cc_address;
			$email_logs_data_array['bcc']          = $bcc_address;
			$email_logs_data_array['subject']      = $email_logs->subject;
			$email_logs_data_array['content']      = $email_logs->body;
			$email_logs_data_array['sender_name']  = $sender_name;
			$email_logs_data_array['sender_email'] = $sender_email;
			if ( 'enable' === $debug_mode ) {
				$email_logs_data_array['debug_mode']       = $debug_mode;
				$email_logs_data_array['debugging_output'] = get_option( 'mail_bank_mail_status' );
			}
			$email_logs_data_array['timestamp'] = MAIL_BANK_LOCAL_TIME;
			$email_logs_data_array['status']    = $status;
			global $wpdb;
			$wpdb->insert( mail_bank_logs(), $email_logs_data_array );// db call ok; no-cache ok.
		}
		/**
		 * This function is used to create email logs.
		 *
		 * @param Mail_Bank_Manage_Email $email_logs email logs details.
		 * @param Mail_Bank_Manage_Email $email_message debug mode details.
		 */
		public function mb_create_email_log( $email_logs, Mail_Bank_Manage_Email $email_message = null ) {
			if ( $email_message ) {
				$email_logs->to_recipients = $this->mb_flat_emails( $email_message->mb_get_to_recipients() );
				$email_logs->subject       = $email_message->mb_get_subject();
				$email_logs->body          = $email_message->mb_get_body();
			}
			return $email_logs;
		}
		/**
		 * This function creates a readable "TO" entry based on the recipient header.
		 *
		 * @param array $addresses email details.
		 */
		public static function mb_flat_emails( array $addresses ) {
			$flat  = '';
			$count = 0;
			foreach ( $addresses as $address ) {
				if ( $count >= 3 ) {
					$flat .= sprintf( '.. +%d more', count( $addresses ) - $count );
					break;
				}
				if ( $count > 0 ) {
					$flat .= ', ';
				}
				$flat .= $address->mb_email_format();
				$count ++;
			}
			return $flat;
		}
	}
}
