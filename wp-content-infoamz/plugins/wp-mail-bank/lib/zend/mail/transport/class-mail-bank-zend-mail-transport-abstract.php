<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category Zend
 * @package Mail_Bank_Zend_Mail
 * @subpackage Transport
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/** Zend Mime File Included.

 * @see Mail_Bank_Zend_Mime
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php';
}
/**
 * Abstract for sending eMails through different
 * ways of transport
 *
 * @category    Zend
 * @package  Mail_Bank_Zend_Mail
 * @subpackage Transport
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license  http://framework.zend.com/license/new-bsd    New BSD License
 */
abstract class Mail_Bank_Zend_Mail_Transport_Abstract {
	/**
	 * Mail body
	 *
	 * @var string
	 * @access public
	 */
	public $body = '';
	/**
	 * MIME boundary
	 *
	 * @var string
	 * @access public
	 */
	public $boundary = '';
	/**
	 * Mail header string
	 *
	 * @var string
	 * @access public
	 */
	public $header = '';
	/**
	 * Array of message headers
	 *
	 * @var array
	 * @access protected
	 */
	protected $_headers = array();
	/**
	 * Message is a multipart message
	 *
	 * @var boolean
	 * @access protected
	 */
	protected $is_multipart = false;
	/**
	 * Mail_Bank_Zend_Mail object
	 *
	 * @var false|Mail_Bank_Zend_Mail
	 * @access protected
	 */
	protected $_mail = false;
	/**
	 * Array of message parts
	 *
	 * @var array
	 * @access protected
	 */
	protected $_parts = array();
	/**
	 * Recipients string
	 *
	 * @var string
	 * @access public
	 */
	public $recipients = '';
	/**
	 * Eol character string used by transport
	 *
	 * @var string
	 * @access public
	 */
	public $eol = "\r\n";
	/**
	 * Send an email independent from the used transport
	 *
	 * The requisite information for the email will be found in the following
	 * properties:
	 *
	 * - {@link $recipients} - list of recipients (string)
	 * - {@link $header} - message header
	 * - {@link $body} - message body
	 */
	abstract protected function send_mail();
	/**
	 * Return all mail headers as an array
	 *
	 * If a boundary is given, a multipart header is generated with a
	 * Content-Type of either multipart/alternative or multipart/mixed depending
	 * on the mail parts present in the {@link $_mail Mail_Bank_Zend_Mail object} present.
	 *
	 * @param string $boundary MANDATORY.
	 * @return array
	 */
	protected function get_headers( $boundary ) {
		if ( null !== $boundary ) {
			// Build multipart mail.
			$type = $this->_mail->getType();
			if ( ! $type ) {
				if ( $this->_mail->has_attachments ) {
					$type = Mail_Bank_Zend_Mime::MULTIPART_MIXED;
				} elseif ( $this->_mail->getBodyText() && $this->_mail->getBodyHtml() ) {
					$type = Mail_Bank_Zend_Mime::MULTIPART_ALTERNATIVE;
				} else {
					$type = Mail_Bank_Zend_Mime::MULTIPART_MIXED;
				}
			}

			$this->_headers['Content-Type'] = array(
				$type . ';'
				. $this->eol
				. ' boundary="' . $boundary . '"',
			);
			$this->boundary                 = $boundary;
		}

		$this->_headers['MIME-Version'] = array( '1.0' );

		return $this->_headers;
	}
	/**
	 * Prepend header name to header value
	 *
	 * @param string $item MANDATORY.
	 * @param string $key MANDATORY.
	 * @param string $prefix MANDATORY.
	 * @static
	 * @access protected
	 * @return void
	 */
	protected static function format_header( &$item, $key, $prefix ) {
		$item = $prefix . ': ' . $item;
	}
	/**
	 * Prepare header string for use in transport
	 *
	 * Prepares and generates {@link $header} based on the headers provided.
	 *
	 * @param mixed $headers MANDATORY.
	 * @access protected
	 * @return void
	 * @throws Mail_Bank_Zend_Mail_Transport_Exception If any header lines exceed 998 characters.
	 * @throws Mail_Bank_Zend_Mail_Exception Throws Exception.
	 */
	protected function prepare_headers( $headers ) {
		if ( ! $this->_mail ) {
			/** Mail Transport Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Transport_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Transport_Exception( 'Missing Zend_Mail object in _mail property' );
		}

		$this->header = '';

		foreach ( $headers as $header => $content ) {
			if ( isset( $content['append'] ) ) {
				unset( $content['append'] );
				$value         = implode( ',' . $this->eol . ' ', $content );
				$this->header .= $header . ': ' . $value . $this->eol;
			} else {
				array_walk( $content, array( get_class( $this ), 'format_header' ), $header );
				$this->header .= implode( $this->eol, $content ) . $this->eol;
			}
		}

		// Sanity check on headers -- should not be > 998 characters.
		$sane = true;
		foreach ( explode( $this->eol, $this->header ) as $line ) {
			if ( strlen( trim( $line ) ) > 998 ) {
				$sane = false;
				break;
			}
		}
		if ( ! $sane ) {

			/** Transport Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Transport_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'At least one mail header line is too long' );
		}
	}
	/**
	 * Generate MIME compliant message from the current configuration
	 *
	 * If both a text and HTML body are present, generates a
	 * multipart/alternative Mail_Bank_Zend_Mime_Part containing the headers and contents
	 * of each. Otherwise, uses whichever of the text or HTML parts present.
	 *
	 * The content part is then prepended to the list of Mail_Bank_Zend_Mime_Parts for
	 * this message.
	 *
	 * @return void
	 * @throws Mail_Bank_Zend_Mail_Transport_Exception Throws Exception.
	 */
	protected function build_body() {
		$text = $this->_mail->getBodyText();
		$html = $this->_mail->getBodyHtml();
		if ( $text && $html ) {
			// Generate unique boundary for multipart/alternative.
			$mime          = new Mail_Bank_Zend_Mime( null );
			$boundary_line = $mime->boundary_line( $this->eol );
			$boundary_end  = $mime->mime_end( $this->eol );

			$text->disposition = false;
			$html->disposition = false;

			$body = $boundary_line
			. $text->get_headers( $this->eol )
			. $this->eol
			. $text->get_content( $this->eol )
			. $this->eol
			. $boundary_line
			. $html->get_headers( $this->eol )
			. $this->eol
			. $html->get_content( $this->eol )
			. $this->eol
			. $boundary_end;

			$mp           = new Mail_Bank_Zend_Mime_Part( $body );
			$mp->type     = Mail_Bank_Zend_Mime::MULTIPART_ALTERNATIVE;
			$mp->boundary = $mime->boundary();

			$this->is_multipart = true;

			// Ensure first part contains text alternatives.
			array_unshift( $this->_parts, $mp );

			// Get headers.
			$this->_headers = $this->_mail->get_headers();
			return;
		}

		// If not multipart, then get the body.
		$body = $this->_mail->getBodyHtml();
		if ( false !== $body ) {
			array_unshift( $this->_parts, $body );
		} elseif ( false !== $this->_mail->getBodyText() ) {
			$body = $this->_mail->getBodyText();
			array_unshift( $this->_parts, $body );
		}

		if ( ! $body ) {
			/** Transport Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Transport_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Transport_Exception( 'No body specified' );
		}

		// Get headers.
		$this->_headers = $this->_mail->get_headers();
		$headers        = $body->get_headers_array( $this->eol );
		foreach ( $headers as $header ) {
			// Headers in Mail_Bank_Zend_Mime_Part are kept as arrays with two elements, a
			// key and a value.
			$this->_headers[ $header[0] ] = array( $header[1] );
		}
	}
	/**
	 * Send a mail using this transport
	 *
	 * @param  Mail_Bank_Zend_Mail $mail MANDATORY.
	 * @access public
	 * @return void
	 * @throws Mail_Bank_Zend_Mail_Transport_Exception If mail is empty.
	 */
	public function send( Mail_Bank_Zend_Mail $mail ) {
		$this->is_multipart = false;
		$this->_mail        = $mail;
		$this->_parts       = $mail->get_parts();
		$mime               = $mail->get_mime();

		// Build body content.
		$this->build_body();

		// Determine number of parts and boundary.
		$count    = count( $this->_parts );
		$boundary = null;
		if ( $count < 1 ) {
			/** Transport Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Transport_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Transport_Exception( 'Empty mail cannot be sent' );
		}

		if ( $count > 1 ) {
			// Multipart message; create new MIME object and boundary.
			$mime     = new Mail_Bank_Zend_Mime( $this->_mail->getMimeBoundary() );
			$boundary = $mime->boundary();
		} elseif ( $this->is_multipart ) {
			// multipart/alternative -- grab boundary.
			$boundary = $this->_parts[0]->boundary;
		}

		// Determine recipients, and prepare headers.
		$this->recipients = implode( ',', $mail->getRecipients() );
		$this->prepare_headers( $this->get_headers( $boundary ) );

		// Create message body
		// This is done so that the same Mail_Bank_Zend_Mail object can be used in
		// multiple transports.
		$message = new Mail_Bank_Zend_Mime_Message();
		$message->set_parts( $this->_parts );
		$message->set_mime( $mime );
		$this->body = $message->generate_message( $this->eol );

		// Send to transport!
		$this->send_mail();
	}
}
