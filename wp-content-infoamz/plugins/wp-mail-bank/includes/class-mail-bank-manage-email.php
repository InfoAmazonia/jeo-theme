<?php
/**
 * This file is used to manage email.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
if ( ! class_exists( 'Mail_Bank_Manage_Email' ) ) {
	if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-email-address.php' ) ) {
		require_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-manage-email-address.php';
	}
	/**
	 * This class used to manage email.
	 *
	 * @package    wp-mail-bank
	 * @subpackage includes
	 *
	 * @author  Tech Banker
	 */
	class Mail_Bank_Manage_Email {
		/**
		 * Manage email from variable details.
		 *
		 * @access   public
		 * @var      string    $from  from details.
		 */
		public $from;
		/**
		 * Manage email reply to variable details.
		 *
		 * @access   public
		 * @var      string    $reply_to  reply to details.
		 */
		public $reply_to;
		/**
		 * Manage email to recipients variable details.
		 *
		 * @access   public
		 * @var      string    $to_recipients  to recipients details.
		 */
		public $to_recipients;
		/**
		 * Manage email cc recipients variable details.
		 *
		 * @access   public
		 * @var      string    $cc_recipients  cc recipients details.
		 */
		public $cc_recipients;
		/**
		 * Manage email bcc recipients variable details.
		 *
		 * @access   public
		 * @var      string    $bcc_recipients  bcc recipients details.
		 */
		public $bcc_recipients;
		/**
		 * Manage email subject variable details.
		 *
		 * @access   public
		 * @var      string    $subject  subject details.
		 */
		public $subject;
		/**
		 * Manage email body variable details.
		 *
		 * @access   public
		 * @var      string    $body  body details.
		 */
		public $body;
		/**
		 * Manage email body text part variable details.
		 *
		 * @access   public
		 * @var      string    $body_textpart  body text part details.
		 */
		public $body_textpart;
		/**
		 * Manage email body html part variable details.
		 *
		 * @access   public
		 * @var      string    $body_htmlpart  body html part details.
		 */
		public $body_htmlpart;
		/**
		 * Manage email headers variable details.
		 *
		 * @access   public
		 * @var      string    $headers  headers details.
		 */
		public $headers;
		/**
		 * Manage email attachments variable details.
		 *
		 * @access   public
		 * @var      string    $attachments  attachments details.
		 */
		public $attachments;
		/**
		 * Manage email date variable details.
		 *
		 * @access   public
		 * @var      int    $date  date details.
		 */
		public $date;
		/**
		 * Manage email message id variable details.
		 *
		 * @access   public
		 * @var      int    $message_id  message id details.
		 */
		public $message_id;
		/**
		 * Manage email content type variable details.
		 *
		 * @access   public
		 * @var      string    $content_type  content type details.
		 */
		public $content_type;
		/**
		 * Manage email charset variable details.
		 *
		 * @access   public
		 * @var      string    $charset  charset details.
		 */
		public $charset;
		/**
		 * Manage email boundary variable details.
		 *
		 * @access   public
		 * @var      string    $boundary  boundary details.
		 */
		public $boundary;
		/**
		 * This function is used to get name.
		 */
		public function __construct() {
			$this->headers        = array();
			$this->to_recipients  = array();
			$this->cc_recipients  = array();
			$this->bcc_recipients = array();
		}
		/**
		 * This function is used to check email body parts.
		 */
		public function check_email_body_parts_mail_bank() {
			return empty( $this->body_textpart ) && empty( $this->body_htmlpart );
		}
		/**
		 * This function is used to validate email contents.
		 *
		 * @param string $transport type of email validation.
		 */
		public function validate_email_contents_mail_bank( $transport ) {
			$this->validate_email_headers_mail_bank();
		}
		/**
		 * This function create body parts based on content type.
		 */
		public function create_body_parts() {
			if ( false !== stripos( $this->content_type, 'multipart' ) && ! empty( $this->boundary ) ) {
				$this->content_type = sprintf( "%s;\r\n\t boundary=\"%s\"", $this->content_type, $this->mb_get_boundary() );
			}

			$body         = $this->mb_get_body();
			$content_type = $this->mb_get_content_type();
			if ( '' == $content_type ) {// WPCS: loose comparison ok.
				$content_type = apply_filters( 'wp_mail_content_type', $content_type );
			}
			if ( substr( $content_type, 0, 9 ) === 'text/html' ) {
				$this->mb_set_body_html_part( $body );
			} elseif ( substr( $content_type, 0, 10 ) === 'text/plain' ) {
				$this->mb_set_body_textpart( $body );
			} elseif ( substr( $content_type, 0, 21 ) === 'multipart/alternative' ) {
				$arr       = explode( PHP_EOL, $body );
				$text_body = '';
				$html_body = '';
				$mode      = '';
				foreach ( $arr as $s ) {
					if ( stripos( $s, 'text/plain' ) !== false ) {
						$mode = 'foundText';
					} elseif ( stripos( $s, 'text/html' ) !== false ) {
						$mode = 'foundHtml';
					}
					if ( 'foundText' == $mode ) {// WPCS: loose comparison ok.
						$trim = trim( $s );
						if ( ! empty( $trim ) ) {
							$text_body .= $s;
						}
					} elseif ( 'foundHtml' == $mode ) {// WPCS: loose comparison ok.
						$trim = trim( $s );
						if ( ! empty( $trim ) ) {
							$html_body .= $s;
						}
					}
				}
				$this->mb_set_body_html_part( $html_body );
				$this->mb_set_body_textpart( $text_body );
			} else {
				$this->mb_set_body_textpart( $body );
			}
		}
		/**
		 * This function validate email headers.
		 */
		public function validate_email_headers_mail_bank() {
			if ( isset( $this->reply_to ) ) {
				$this->mb_get_reply_to()->validate_email_contents_mail_bank( 'Reply-To' );
			}
			/**
			 * This function validate the from address.
			 */
			$this->get_email_address_mail_bank()->validate_email_contents_mail_bank( 'From' );
			/**
			 * This function validate the to recipients.
			 */
			foreach ( (array) $this->mb_get_to_recipients() as $to_address ) {
				$to_address->validate_email_contents_mail_bank( 'To' );
			}
			/**
			 * This function validate the cc recipients.
			 */
			foreach ( (array) $this->mb_get_cc_recipients() as $cc_address ) {
				$cc_address->validate_email_contents_mail_bank( 'Cc' );
			}
			/**
			 * This function validate the bcc recipients.
			 */
			foreach ( (array) $this->mb_get_bcc_recipients() as $bcc_address ) {
				$bcc_address->validate_email_contents_mail_bank( 'Bcc' );
			}
		}
		/**
		 * Get email address.
		 */
		public function get_email_address_mail_bank() {
			return $this->from;
		}
		/**
		 * Get the charset.
		 */
		public function mb_get_charset() {
			return $this->charset;
		}
		/**
		 * Set the charset.
		 *
		 * @param string $charset set the charset.
		 */
		public function mb_set_charset( $charset ) {
			$this->charset = $charset;
		}
		/**
		 * Get the content type.
		 */
		public function mb_get_content_type() {
			return $this->content_type;
		}
		/**
		 * Set the content type.
		 *
		 * @param string $content_type set the content type.
		 */
		public function mb_set_content_type( $content_type ) {
			$this->content_type = $content_type;
		}
		/**
		 * Add to field details.
		 *
		 * @param string $to add to field details.
		 */
		public function mb_addto( $to ) {
			$this->mb_add_recipients( $this->to_recipients, $to );
		}
		/**
		 * Add cc field details.
		 *
		 * @param string $cc add cc field details.
		 */
		public function mb_add_cc( $cc ) {
			$this->mb_add_recipients( $this->cc_recipients, $cc );
		}
		/**
		 * Add bcc field details.
		 *
		 * @param string $bcc add bcc field details.
		 */
		public function mb_add_bcc( $bcc ) {
			$this->mb_add_recipients( $this->bcc_recipients, $bcc );
		}
		/**
		 * Add recipients.
		 *
		 * @param string $all_recipients add all recipients.
		 * @param string $recipients recipients.
		 */
		public function mb_add_recipients( &$all_recipients, $recipients ) {
			if ( ! empty( $recipients ) ) {
				$recipients = Mail_Bank_Manage_Email_Address::convert_string_to_array_mail_bank( $recipients );
				foreach ( $recipients as $recipient ) {
					if ( ! empty( $recipient ) ) {
						array_push( $all_recipients, new Mail_Bank_Manage_Email_Address( $recipient ) );
					}
				}
			}
		}
		/**
		 * This function add headers.
		 *
		 * @param string $headers add headers.
		 */
		public function mb_add_headers( $headers ) {
			if ( ! is_array( $headers ) ) {
				$headers = explode( "\n", str_replace( "\r\n", "\n", $headers ) );
			}
			foreach ( $headers as $header ) {
				if ( ! empty( $header ) ) {
					if ( strpos( $header, ':' ) === false ) {
						if ( false !== stripos( $header, 'boundary=' ) ) {
							$parts          = preg_split( '/boundary=/i', trim( $header ) );
							$this->boundary = trim(
								str_replace(
									array(
										"'",
										'"',
									), '', $parts [1]
								)
							);
						}
						continue;
					}
					list($name, $content) = explode( ':', trim( $header ), 2 );
					$this->mb_process_header( $name, $content );
				}
			}
		}
		/**
		 * This function process headers.
		 *
		 * @param string $name add name.
		 * @param string $content add content.
		 */
		public function mb_process_header( $name, $content ) {
			$name    = trim( $name );
			$content = trim( $content );
			switch ( strtolower( $name ) ) {
				case 'content-type':
					if ( strpos( $content, ';' ) !== false ) {
						list($type, $charset) = explode( ';', $content );
						$this->mb_set_content_type( trim( $type ) );
						if ( false !== stripos( $charset, 'charset=' ) ) {
							$charset = trim(
								str_replace(
									array(
										'charset=',
										'"',
									), '', $charset
								)
							);
						} elseif ( false !== stripos( $charset, 'boundary=' ) ) {
							$this->boundary = trim(
								str_replace(
									array(
										'BOUNDARY=',
										'boundary=',
										'"',
									), '', $charset
								)
							);
							$charset        = '';
						}
						if ( ! empty( $charset ) ) {
							$this->mb_set_charset( $charset );
						}
					} else {
						$this->mb_set_content_type( trim( $content ) );
					}
					break;
				case 'to':
					$this->mb_addto( $content );
					break;
				case 'cc':
					$this->mb_add_cc( $content );
					break;
				case 'bcc':
					$this->mb_add_bcc( $content );
					break;
				case 'from':
					$this->mb_set_from( $content );
					break;
				case 'subject':
					$this->mb_set_subject( $content );
					break;
				case 'reply-to':
					$this->mb_set_replyto( $content );
					break;
				case 'sender':
					break;
				case 'return-path':
					break;
				case 'date':
					$this->mb_set_date( $content );
					break;
				case 'message-id':
					$this->mb_set_messageid( $content );
					break;
				default:
					array_push(
						$this->headers, array(
							'name'    => $name,
							'content' => $content,
						)
					);
					break;
			}
		}
		/**
		 * Add attachments to the message.
		 *
		 * @param Mail_Bank_Zend_Mail $mail add mail attachments.
		 */
		public function mb_add_attachments_to_mail( Mail_Bank_Zend_Mail $mail ) {
			$attachments = $this->attachments;
			if ( ! is_array( $attachments ) ) {
				$attributes_array = explode( PHP_EOL, $attachments );
			} else {
				$attributes_array = $attachments;
			}
			foreach ( $attributes_array as $file ) {
				if ( file_exists( $file ) ) {
					$at              = new Mail_Bank_Zend_Mime_Part( file_get_contents( $file ) );// @codingStandardsIgnoreLine.
					$at->disposition = Mail_Bank_Zend_Mime::DISPOSITION_ATTACHMENT;
					$at->encoding    = Mail_Bank_Zend_Mime::ENCODING_BASE64;
					$at->filename    = basename( $file );
					$mail->addAttachment( $at );
				}
			}
		}
		/**
		 * Set mail body.
		 *
		 * @param string $body set mail body.
		 */
		public function mb_set_body( $body ) {
			$this->body = $body;
		}
		/**
		 * Set mail body text part.
		 *
		 * @param string $body_textpart set mail body text part.
		 */
		public function mb_set_body_textpart( $body_textpart ) {
			$this->body_textpart = $body_textpart;
		}
		/**
		 * Set mail body html part.
		 *
		 * @param string $body_htmlpart set mail body html part.
		 */
		public function mb_set_body_html_part( $body_htmlpart ) {
			$this->body_htmlpart = $body_htmlpart;
		}
		/**
		 * Set mail subject.
		 *
		 * @param string $subject set mail subject.
		 */
		public function mb_set_subject( $subject ) {
			$this->subject = $subject;
		}
		/**
		 * Set mail attachments.
		 *
		 * @param string $attachments set mail attachments.
		 */
		public function mb_set_attachments( $attachments ) {
			$this->attachments = $attachments;
		}
		/**
		 * Set mail from details.
		 *
		 * @param string $email set mail.
		 * @param int    $name set name.
		 */
		public function mb_set_from( $email, $name = null ) {
			if ( ! empty( $email ) ) {
				$this->from = new Mail_Bank_Manage_Email_Address( $email, $name );
			}
		}
		/**
		 * Set mail reply to.
		 *
		 * @param string $reply_to set mail reply to.
		 */
		public function mb_set_replyto( $reply_to ) {
			if ( ! empty( $reply_to ) ) {
				$this->reply_to = new Mail_Bank_Manage_Email_Address( $reply_to );
			}
		}
		/**
		 * Set mail message id.
		 *
		 * @param int $message_id set mail message id.
		 */
		public function mb_set_messageid( $message_id ) {
			$this->message_id = $message_id;
		}
		/**
		 * Set mail date.
		 *
		 * @param int $date set mail date.
		 */
		public function mb_set_date( $date ) {
			$this->date = $date;
		}
		/**
		 * Get mail headers.
		 */
		public function mb_get_headers() {
			return $this->headers;
		}
		/**
		 * Get mail boundary.
		 */
		public function mb_get_boundary() {
			return $this->boundary;
		}
		/**
		 * Get mail to recipients.
		 */
		public function mb_get_to_recipients() {
			return $this->to_recipients;
		}
		/**
		 * Get mail cc recipients.
		 */
		public function mb_get_cc_recipients() {
			return $this->cc_recipients;
		}
		/**
		 * Get mail bcc recipients.
		 */
		public function mb_get_bcc_recipients() {
			return $this->bcc_recipients;
		}
		/**
		 * Get mail reply to.
		 */
		public function mb_get_reply_to() {
			return $this->reply_to;
		}
		/**
		 * Get mail date.
		 */
		public function mb_get_date() {
			return $this->date;
		}
		/**
		 * Get mail message id.
		 */
		public function mb_get_message_id() {
			return $this->message_id;
		}
		/**
		 * Get mail subject.
		 */
		public function mb_get_subject() {
			return $this->subject;
		}
		/**
		 * Get mail body.
		 */
		public function mb_get_body() {
			return $this->body;
		}
		/**
		 * Get mail body text part.
		 */
		public function mb_get_body_text_part() {
			return $this->body_textpart;
		}
		/**
		 * Get mail body html part.
		 */
		public function mb_get_body_html_part() {
			return $this->body_htmlpart;
		}
		/**
		 * Get mail attachments.
		 */
		public function get_attachments() {
			return $this->attachments;
		}
	}
}
