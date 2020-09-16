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
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/** Includes Transport Abstract File.

 * @see Mail_Bank_Zend_Mail_Transport_Abstract
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php';
}

/** Includes Zend Mime File.

 * @see Mail_Bank_Zend_Mime
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php';
}

/** Includes Mime Message File.

 * @see Mail_Bank_Zend_Mime_Message
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-message.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-message.php';
}

/** Includes Mime Part File.

 * @see Mail_Bank_Zend_Mime_Part
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-part.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-part.php';
}
/**
 * Class for sending an email.
 *
 * @category     Zend
 * @package     Mail_Bank_Zend_Mail
 * @copyright   Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license     http://framework.zend.com/license/new-bsd        New BSD License
 */
class Mail_Bank_Zend_Mail extends Mail_Bank_Zend_Mime_Message {
	/*
	* @access protected
	*/
	/** Variable Declaration.

	 * @var Mail_Bank_Zend_Mail_Transport_Abstract
	 * @static
	 */
	protected static $default_transport = null;
	/** Variable Declaration.

	 * @var array
	 * @static
	 */
	protected static $default_from;
	/** Variable Declaration.

	 * @var array
	 * @static
	 */
	protected static $default_reply_to;
	/**
	 * Mail character set
	 *
	 * @var string
	 */
	protected $_charset = 'iso-8859-1';
	/**
	 * Mail headers
	 *
	 * @var array
	 */
	protected $_headers = array();
	/**
	 * Encoding of Mail headers
	 *
	 * @var string
	 */
	protected $header_encoding = Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE;
	/**
	 * From: address
	 *
	 * @var string
	 */
	protected $_from = null;
	/**
	 * To: addresses
	 *
	 * @var array
	 */
	protected $_to = array();
	/**
	 * Array of all recipients
	 *
	 * @var array
	 */
	protected $_recipients = array();
	/**
	 * Reply-To header
	 *
	 * @var string
	 */
	protected $reply_to = null;
	/**
	 * Return-Path header
	 *
	 * @var string
	 */
	protected $return_path = null;
	/**
	 * Subject: header
	 *
	 * @var string
	 */
	protected $_subject = null;
	/**
	 * Date: header
	 *
	 * @var string
	 */
	protected $_date = null;
	/**
	 * Message-ID: header
	 *
	 * @var string
	 */
	protected $message_id = null;
	/**
	 * Text/plain MIME part
	 *
	 * @var false|Mail_Bank_Zend_Mime_Part
	 */
	protected $body_text = false;
	/**
	 * Text/html MIME part.
	 *
	 * @var false|Zend_Mime_Part
	 */
	protected $body_html = false;
	/**
	 * MIME boundary string
	 *
	 * @var string
	 */
	protected $mime_boundary = null;
	/**
	 * Content type of the message
	 *
	 * @var string
	 */
	protected $_type = null;

	/*    * #@- */
	/**
	 * Flag: whether or not email has attachments
	 *
	 * @var boolean
	 */
	public $has_attachments = false;
	/**
	 * Sets the default mail transport for all following uses of
	 * Mail_Bank_Zend_Mail::send();
	 *
	 * @todo Allow passing a string to indicate the transport to load
	 * @todo Allow passing in optional options for the transport to load
	 * @param    Mail_Bank_Zend_Mail_Transport_Abstract $transport MANDATORY.
	 */
	public static function setDefaultTransport( Mail_Bank_Zend_Mail_Transport_Abstract $transport ) {
		self::$default_transport = $transport;
	}
	/**
	 * Gets the default mail transport for all following uses of
	 * unittests
	 *
	 * @todo Allow passing a string to indicate the transport to load
	 * @todo Allow passing in optional options for the transport to load
	 */
	public static function getDefaultTransport() {
		return self::$default_transport;
	}
	/**
	 * Clear the default transport property
	 */
	public static function clearDefaultTransport() {
		self::$default_transport = null;
	}
	/**
	 * Public constructor
	 *
	 * @param    string $charset OPTIONAL.
	 */
	public function __construct( $charset = null ) {
		if ( null != $charset ) {// WPCS: loose comparison ok.
			$this->_charset = $charset;
		}
	}
	/**
	 * Return charset string
	 *
	 * @return string
	 */
	public function getCharset() {
		return $this->_charset;
	}
	/**
	 * Set content type
	 *
	 * Should only be used for manually setting multipart content types.
	 *
	 * @param    string $type Content type.
	 * @return Mail_Bank_Zend_Mail Implements fluent interface
	 * @throws Mail_Bank_Zend_Mail_Exception For types not supported by Mail_Bank_Zend_Mime.
	 */
	public function setType( $type ) {
		$allowed = array(
			Mail_Bank_Zend_Mime::MULTIPART_ALTERNATIVE,
			Mail_Bank_Zend_Mime::MULTIPART_MIXED,
			Mail_Bank_Zend_Mime::MULTIPART_RELATED,
		);
		if ( ! in_array( $type, $allowedm, true ) ) {
			/** Includes File for Exception.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Invalid content type "' . $type . '"' );
		}

		$this->_type = $type;
		return $this;
	}
	/**
	 * Get content type of the message
	 *
	 * @return string
	 */
	public function getType() {
		return $this->_type;
	}
	/**
	 * Set an arbitrary mime boundary for the message
	 *
	 * If not set, Mail_Bank_Zend_Mime will generate one.
	 *
	 * @param string $boundary MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function setMimeBoundary( $boundary ) {
		$this->mime_boundary = $boundary;

		return $this;
	}
	/**
	 * Return the boundary string used for the message
	 *
	 * @return string
	 */
	public function getMimeBoundary() {
		return $this->mime_boundary;
	}
	/**
	 * Return encoding of mail headers
	 *
	 * @deprecated use {@link getHeaderEncoding()} instead
	 * @return string
	 */
	public function getEncodingOfHeaders() {
		return $this->getHeaderEncoding();
	}
	/**
	 * Return the encoding of mail headers
	 *
	 * Either Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE or Mail_Bank_Zend_Mime::ENCODING_BASE64
	 *
	 * @return string
	 */
	public function getHeaderEncoding() {
		return $this->header_encoding;
	}
	/**
	 * Set the encoding of mail headers
	 *
	 * @deprecated Use {@link setHeaderEncoding()} instead.
	 * @param    string $encoding MANDATORY.
	 * @return Mail_Bank_Zend_Mail
	 */
	public function setEncodingOfHeaders( $encoding ) {
		return $this->setHeaderEncoding( $encoding );
	}
	/**
	 * Set the encoding of mail headers
	 *
	 * @param    string $encoding Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE or
	 *    Mail_Bank_Zend_Mime::ENCODING_BASE64.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 * @throws Mail_Bank_Zend_Mail_Exception Exception.
	 */
	public function setHeaderEncoding( $encoding ) {
		$allowed = array(
			Mail_Bank_Zend_Mime::ENCODING_BASE64,
			Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE,
		);
		if ( ! in_array( $encoding, $allowed, true ) ) {
			/** Includes Exception File.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Invalid encoding "' . $encoding . '"' );
		}
		$this->header_encoding = $encoding;

		return $this;
	}
	/**
	 * Sets the text body for the message.
	 *
	 * @param    string $txt MANDATORY.
	 * @param    string $charset OPTIONAL.
	 * @param    string $encoding MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function setBodyText( $txt, $charset = null, $encoding = Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE ) {
		if ( null === $charset ) {
			$charset = $this->_charset;
		}

		$mp              = new Mail_Bank_Zend_Mime_Part( $txt );
		$mp->encoding    = $encoding;
		$mp->type        = Mail_Bank_Zend_Mime::TYPE_TEXT;
		$mp->disposition = Mail_Bank_Zend_Mime::DISPOSITION_INLINE;
		$mp->charset     = $charset;

		$this->body_text = $mp;

		return $this;
	}
	/**
	 * Return text body Mail_Bank_Zend_Mime_Part or string
	 *
	 * @param    bool $text_only Whether to return just the body text content or
	 * the MIME part; defaults to false, the MIME part.
	 * @return false|Mail_Bank_Zend_Mime_Part|string
	 */
	public function getBodyText( $text_only = false ) {
		if ( $text_only && $this->body_text ) {
			$body = $this->body_text;
			return $body->get_content();
		}

		return $this->body_text;
	}
	/**
	 * Sets the HTML body for the message
	 *
	 * @param string $html MANDATORY.
	 * @param string $charset OPTIONAL.
	 * @param string $encoding MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function setBodyHtml( $html, $charset = null, $encoding = Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE ) {
		if ( null === $charset ) {
			$charset = $this->_charset;
		}

		$mp              = new Mail_Bank_Zend_Mime_Part( $html );
		$mp->encoding    = $encoding;
		$mp->type        = Mail_Bank_Zend_Mime::TYPE_HTML;
		$mp->disposition = Mail_Bank_Zend_Mime::DISPOSITION_INLINE;
		$mp->charset     = $charset;

		$this->body_html = $mp;

		return $this;
	}
	/**
	 * Return Mail_Bank_Zend_Mime_Part representing body HTML
	 *
	 * @param    bool $html_only Whether to return the body HTML only, or the MIME part; defaults to false, the MIME part.
	 * @return false|Mail_Bank_Zend_Mime_Part|string
	 */
	public function getBodyHtml( $html_only = false ) {
		if ( $html_only && $this->body_html ) {
			$body = $this->body_html;
			return $body->get_content();
		}

		return $this->body_html;
	}
	/**
	 * Adds an existing attachment to the mail message
	 *
	 * @param    Mail_Bank_Zend_Mime_Part $attachment MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function addAttachment( Mail_Bank_Zend_Mime_Part $attachment ) {
		$this->add_part( $attachment );
		$this->has_attachments = true;

		return $this;
	}
	/**
	 * Creates a Mail_Bank_Zend_Mime_Part attachment
	 *
	 * Attachment is automatically added to the mail object after creation. The
	 * attachment object is returned to allow for further manipulation.
	 *
	 * @param string $body MANDATORY.
	 * @param string $mime_type MANDATORY.
	 * @param string $disposition MANDATORY.
	 * @param string $encoding MANDATORY.
	 * @param string $filename OPTIONAL A filename for the attachment.
	 * @return Mail_Bank_Zend_Mime_Part Newly created Mail_Bank_Zend_Mime_Part object (to allow
	 * advanced settings)
	 */
	public function createAttachment( $body, $mime_type = Mail_Bank_Zend_Mime::TYPE_OCTETSTREAM, $disposition = Mail_Bank_Zend_Mime::DISPOSITION_ATTACHMENT, $encoding = Mail_Bank_Zend_Mime::ENCODING_BASE64, $filename = null ) {
		$mp              = new Mail_Bank_Zend_Mime_Part( $body );
		$mp->encoding    = $encoding;
		$mp->type        = $mime_type;
		$mp->disposition = $disposition;
		$mp->filename    = $filename;

		$this->addAttachment( $mp );

		return $mp;
	}
	/**
	 * Return a count of message parts
	 *
	 * @return integer
	 */
	public function getPartCount() {
		return count( $this->_parts );
	}
	/**
	 * Encode header fields
	 *
	 * Encodes header content according to RFC1522 if it contains non-printable
	 * characters.
	 *
	 * @param string $value MANDATORY.
	 * @return string
	 */
	protected function encode_header( $value ) {
		if ( Mail_Bank_Zend_Mime::is_printable( $value ) === false ) {
			if ( $this->getHeaderEncoding() === Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE ) {
				$value = Mail_Bank_Zend_Mime::encode_quoted_printable_header( $value, $this->getCharset(), Mail_Bank_Zend_Mime::LINELENGTH, Mail_Bank_Zend_Mime::LINEEND );
			} else {
				$value = Mail_Bank_Zend_Mime::encode_base64_header( $value, $this->getCharset(), Mail_Bank_Zend_Mime::LINELENGTH, Mail_Bank_Zend_Mime::LINEEND );
			}
		}

		return $value;
	}
	/**
	 * Add a header to the message
	 *
	 * Adds a header to this message. If append is true and the header already
	 * exists, raises a flag indicating that the header should be appended.
	 *
	 * @param string $header_name MANDATORY.
	 * @param string $value MANDATORY.
	 * @param bool   $append OPTIONAL.
	 */
	protected function store_header( $header_name, $value, $append = false ) {
		if ( isset( $this->_headers[ $header_name ] ) ) {
			$this->_headers[ $header_name ][] = $value;
		} else {
			$this->_headers[ $header_name ] = array( $value );
		}

		if ( $append ) {
			$this->_headers[ $header_name ]['append'] = true;
		}
	}
	/**
	 * Helper function for adding a recipient and the corresponding header
	 *
	 * @param string $header_name MANDATORY.
	 * @param string $email MANDATORY.
	 * @param string $name MANDATORY.
	 */
	protected function add_recipient_and_header( $header_name, $email, $name ) {
		$email = $this->filter_email( $email );
		$name  = $this->filter_name( $name );
		// prevent duplicates.
		$this->_recipients[ $email ] = 1;
		$this->store_header( $header_name, $this->format_address( $email, $name ), true );
	}
	/**
	 * Adds To-header and recipient, $email can be an array, or a single string
	 * address
	 *
	 * @param string|array $email MANDATORY.
	 * @param string       $name NULL.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function addTo( $email, $name = '' ) {
		if ( ! is_array( $email ) ) {
			$email = array( $name => $email );
		}

		foreach ( $email as $n => $recipient ) {
			$this->add_recipient_and_header( 'To', $recipient, is_int( $n ) ? '' : $n );
			$this->_to[] = $recipient;
		}

		return $this;
	}
	/**
	 * Adds Cc-header and recipient, $email can be an array, or a single string
	 * address
	 *
	 * @param    string|array $email MANDATORY.
	 * @param    string       $name NULL.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function addCc( $email, $name = '' ) {
		if ( ! is_array( $email ) ) {
			$email = array( $name => $email );
		}

		foreach ( $email as $n => $recipient ) {
			$this->add_recipient_and_header( 'Cc', $recipient, is_int( $n ) ? '' : $n );
		}

		return $this;
	}
	/**
	 * Adds Bcc recipient, $email can be an array, or a single string address
	 *
	 * @param    string|array $email MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function addBcc( $email ) {
		if ( ! is_array( $email ) ) {
			$email = array( $email );
		}

		foreach ( $email as $recipient ) {
			$this->add_recipient_and_header( 'Bcc', $recipient, '' );
		}

		return $this;
	}
	/**
	 * Return list of recipient email addresses
	 *
	 * @return array (of strings)
	 */
	public function getRecipients() {
		return array_keys( $this->_recipients );
	}
	/**
	 * Clear header from the message
	 *
	 * @param string $header_name MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent inter
	 */
	public function clear_header( $header_name ) {
		if ( isset( $this->_headers[ $header_name ] ) ) {
			unset( $this->_headers[ $header_name ] );
		}
		return $this;
	}
	/**
	 * Clears list of recipient email addresses
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function clearRecipients() {
		$this->_recipients = array();
		$this->_to         = array();

		$this->clear_header( 'To' );
		$this->clear_header( 'Cc' );
		$this->clear_header( 'Bcc' );

		return $this;
	}
	/**
	 * Sets From-header and sender of the message
	 *
	 * @param    string $email MANDATORY.
	 * @param    string $name OPTIONAL.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws Mail_Bank_Zend_Mail_Exception If called subsequent times.
	 */
	public function setFrom( $email, $name = null ) {
		if ( null !== $this->_from ) {
			/** Includes Exception File.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'From Header set twice' );
		}

		$email       = $this->filter_email( $email );
		$name        = $this->filter_name( $name );
		$this->_from = $email;
		$this->store_header( 'From', $this->format_address( $email, $name ), true );

		return $this;
	}
	/**
	 * Set Reply-To Header
	 *
	 * @param string $email MANDATORY.
	 * @param string $name OPTIONAL.
	 * @return Mail_Bank_Zend_Mail
	 * @throws Mail_Bank_Zend_Mail_Exception If called more than one time.
	 */
	public function set_reply_to( $email, $name = null ) {
		if ( null !== $this->reply_to ) {
			/** Includes Exception File.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Reply-To Header set twice' );
		}

		$email          = $this->filter_email( $email );
		$name           = $this->filter_name( $name );
		$this->reply_to = $email;
		$this->store_header( 'Reply-To', $this->format_address( $email, $name ), true );

		return $this;
	}
	/**
	 * Returns the sender of the mail
	 *
	 * @return string
	 */
	public function getFrom() {
		return $this->_from;
	}
	/**
	 * Returns the current Reply-To address of the message
	 *
	 * @return string|null Reply-To address, null when not set
	 */
	public function getReplyTo() {
		return $this->reply_to;
	}
	/**
	 * Clears the sender from the mail
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function clearFrom() {
		$this->_from = null;
		$this->clear_header( 'From' );

		return $this;
	}
	/**
	 * Clears the current Reply-To address from the message
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function clearReplyTo() {
		$this->reply_to = null;
		$this->clear_header( 'Reply-To' );

		return $this;
	}
	/**
	 * Sets Default From-email and name of the message
	 *
	 * @param string $email MANDATORY.
	 * @param string $name optional.
	 * @return void
	 */
	public static function setDefaultFrom( $email, $name = null ) {
		self::$default_from = array(
			'email' => $email,
			'name'  => $name,
		);
	}
	/**
	 * Returns the default sender of the mail
	 *
	 * @return null|array     Null if none was set.
	 */
	public static function getDefaultFrom() {
		return self::$default_from;
	}
	/**
	 * Clears the default sender from the mail
	 *
	 * @return void
	 */
	public static function clearDefaultFrom() {
		self::$default_from = null;
	}
	/**
	 * Sets From-name and -email based on the defaults
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws Mail_Bank_Zend_Mail_Exception Throws Exception.
	 */
	public function setFromToDefaultFrom() {
		$from = self::getDefaultFrom();
		if ( null === $from ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception(
				'No default From Address set to use'
			);
		}

		$this->setFrom( $from['email'], $from['name'] );

		return $this;
	}
	/**
	 * Sets Default ReplyTo-address and -name of the message
	 *
	 * @param    string $email MANDATORY.
	 * @param    string $name optional.
	 * @return void
	 */
	public static function setDefaultReplyTo( $email, $name = null ) {
		self::$default_reply_to = array(
			'email' => $email,
			'name'  => $name,
		);
	}
	/**
	 * Returns the default Reply-To Address and Name of the mail
	 *
	 * @return null|array     Null if none was set.
	 */
	public static function getDefaultReplyTo() {
		return self::$default_reply_to;
	}
	/**
	 * Clears the default ReplyTo-address and -name from the mail
	 *
	 * @return void
	 */
	public static function clearDefaultReplyTo() {
		self::$default_reply_to = null;
	}
	/**
	 * Sets ReplyTo-name and -email based on the defaults
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws Mail_Bank_Zend_Mail_Exception Throws Exception.
	 */
	public function setReplyToFromDefault() {
		$reply_to = self::getDefaultReplyTo();
		if ( null === $reply_to ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception(
				'No default Reply-To Address set to use'
			);
		}

		$this->set_reply_to( $reply_to['email'], $reply_to['name'] );

		return $this;
	}
	/**
	 * Sets the Return-Path header of the message
	 *
	 * @param string $email MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws Mail_Bank_Zend_Mail_Exception If set multiple times.
	 */
	public function setReturnPath( $email ) {
		if ( null === $this->return_path ) {
			$email             = $this->filter_email( $email );
			$this->return_path = $email;
		} else {
			/** Includes Exception File

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Return-Path Header set twice' );
		}
		return $this;
	}
	/**
	 * Returns the current Return-Path address of the message
	 *
	 * If no Return-Path header is set, returns the value of {@link $_from}.
	 *
	 * @return string
	 */
	public function getReturnPath() {
		if ( null !== $this->return_path ) {
			return $this->return_path;
		}
		return $this->_from;
	}
	/**
	 * Clears the current Return-Path address from the message
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function clearReturnPath() {
		$this->return_path = null;
		$this->clear_header( 'Return-Path' );

		return $this;
	}
	/**
	 * Sets the subject of the message
	 *
	 * @param string $subject MANDATORY.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws Mail_Bank_Zend_Mail_Exception Throws Exception.
	 */
	public function setSubject( $subject ) {
		if ( null === $this->_subject ) {
			$subject        = $this->filter_other( $subject );
			$this->_subject = $this->encode_header( $subject );
			$this->store_header( 'Subject', $this->_subject );
		} else {
			/** Includes Exception File.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Subject set twice' );
		}
		return $this;
	}
	/**
	 * Returns the encoded subject of the message
	 *
	 * @return string
	 */
	public function getSubject() {
		return $this->_subject;
	}
	/**
	 * Clears the encoded subject from the message
	 *
	 * @return   Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function clearSubject() {
		$this->_subject = null;
		$this->clear_header( 'Subject' );

		return $this;
	}
	/**
	 * Sets Date-header
	 *
	 * @param    int|string|Mail_Bank_Zend_Date $date OPTIONAL.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws Mail_Bank_Zend_Mail_Exception If called subsequent times or wrong date.
	 * format.
	 */
	public function setDate( $date = null ) {
		if ( null === $this->_date ) {
			if ( null === $date ) {
				$date = date( 'r' );
			} elseif ( is_int( $date ) ) {
				$date = date( 'r', $date );
			} elseif ( is_string( $date ) ) {
				$date = strtotime( $date );
				if ( false === $date || $date < 0 ) {
					/** Includes Exception File.

				* @see Mail_Bank_Zend_Mail_Exception
				*/
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
						require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
					}

					throw new Mail_Bank_Zend_Mail_Exception(
						'String representations of Date Header must be ' .
						'strtotime()-compatible'
					);
				}
				$date = date( 'r', $date );
			} elseif ( $date instanceof Mail_Bank_Zend_Date ) {
				$date = $date->get( Mail_Bank_Zend_Date::RFC_2822 );
			} else {
				/** Includes Exception File.

			 * @see Mail_Bank_Zend_Mail_Exception
			 */
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
				}

				throw new Mail_Bank_Zend_Mail_Exception(
					__METHOD__ . ' only accepts UNIX timestamps, Zend_Date objects, ' .
					' and strtotime()-compatible strings'
				);
			}
			$this->_date = $date;
			$this->store_header( 'Date', $date );
		} else {
			/** Includes Exception File.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Date Header set twice' );
		}
		return $this;
	}
	/**
	 * Returns the formatted date of the message
	 *
	 * @return string
	 */
	public function getDate() {
		return $this->_date;
	}
	/**
	 * Clears the formatted date from the message
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function clearDate() {
		$this->_date = null;
		$this->clear_header( 'Date' );

		return $this;
	}
	/**
	 * Sets the Message-ID of the message.
	 *
	 * @param boolean|string $id OPTIONAL.
	 * true  :Auto
	 * false :No set
	 * null  :No set
	 * string:Sets given string (Angle brackets is not necessary).
	 * @return   Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws   Mail_Bank_Zend_Mail_Exception Throws Exception.
	 */
	public function setMessageId( $id = true ) {
		if ( null === $id || false === $id ) {
			return $this;
		} elseif ( true === $id ) {
			$id = $this->createMessageId();
		}

		if ( null === $this->message_id ) {
			$id               = $this->filter_other( $id );
			$this->message_id = $id;
			$this->store_header( 'Message-Id', '<' . $this->message_id . '>' );
		} else {
			/** Includes Exception File

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Message-ID set twice' );
		}

		return $this;
	}
	/**
	 * Returns the Message-ID of the message
	 *
	 * @return string
	 */
	public function getMessageId() {
		return $this->message_id;
	}
	/**
	 * Clears the Message-ID from the message
	 *
	 * @return Mail_Bank_Zend_Mail Provides fluent interface
	 */
	public function clearMessageId() {
		$this->message_id = null;
		$this->clear_header( 'Message-Id' );

		return $this;
	}
	/**
	 * Creates the Message-ID
	 *
	 * @return string
	 */
	public function createMessageId() {
		$time = time();

		if ( null !== $this->_from ) {
			$user = $this->_from;
		} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {// @codingStandardsIgnoreLine
			$user = $_SERVER['REMOTE_ADDR']; // @codingStandardsIgnoreLine
		} else {
			$user = getmypid();
		}

		$rand = mt_rand();

		if ( array() !== $this->_recipients ) {
			$recipient = array_rand( $this->_recipients );
		} else {
			$recipient = 'unknown';
		}

		if ( isset( $_SERVER['SERVER_NAME'] ) ) {// WPCS: input var ok.
			$host_name = $_SERVER['SERVER_NAME']; // @codingStandardsIgnoreLine
		} else {
			$host_name = php_uname( 'n' );
		}

		return sha1( $time . $user . $rand . $recipient ) . '@' . $host_name;
	}
	/**
	 * Add a custom header to the message
	 *
	 * @param string  $name MANDATORY.
	 * @param string  $value MANDATORY.
	 * @param boolean $append OPTIONAL.
	 * @return Mail_Bank_Zend_Mail Provides fluent interface.
	 * @throws Mail_Bank_Zend_Mail_Exception On attempts to create standard headers.
	 */
	public function addHeader( $name, $value, $append = false ) {
		$prohibit = array(
			'to',
			'cc',
			'bcc',
			'from',
			'subject',
			'reply-to',
			'return-path',
			'date',
			'message-id',
		);
		if ( in_array( strtolower( $name ), $prohibit, true ) ) {
			/** Includes Exception File.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'Cannot set standard header from addHeader()' );
		}

		$value = $this->filter_other( $value );
		$value = $this->encode_header( $value );
		$this->store_header( $name, $value, $append );

		return $this;
	}
	/**
	 * Return mail headers
	 *
	 * @return array
	 */
	public function get_headers() {
		return $this->_headers;
	}
	/**
	 * Sends this email using the given transport or a previously
	 * set DefaultTransport or the internal mail function if no
	 * default transport had been set.
	 *
	 * @param Zend_Mail_Transport_Abstract $transport OPTIONAL.
	 * @return Zend_Mail  Provides fluent interface
	 */
	public function send( $transport = null ) {
		if ( null === $transport ) {
			if ( ! self::$default_transport instanceof Mail_Bank_Zend_Mail_Transport_Abstract ) {
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-sendmail.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-sendmail.php';
				}

				$transport = new Mail_Bank_Zend_Mail_Transport_Sendmail();
			} else {
				$transport = self::$default_transport;
			}
		}

		if ( null === $this->_date ) {
			$this->setDate();
		}

		if ( null === $this->_from && null !== self::getDefaultFrom() ) {
			$this->setFromToDefaultFrom();
		}

		if ( null === $this->reply_to && null !== self::getDefaultReplyTo() ) {
			$this->setReplyToFromDefault();
		}

		$transport->send( $this );

		return $this;
	}
	/**
	 * Filter of email data
	 *
	 * @param string $email MANDATORY.
	 * @return string
	 */
	protected function filter_email( $email ) {
		$rule = array(
			"\r" => '',
			"\n" => '',
			"\t" => '',
			'"'  => '',
			','  => '',
			'<'  => '',
			'>'  => '',
		);

		return strtr( $email, $rule );
	}
	/**
	 * Filter of name data
	 *
	 * @param string $name MANDATORY.
	 * @return string
	 */
	protected function filter_name( $name ) {
		$rule = array(
			"\r" => '',
			"\n" => '',
			"\t" => '',
			'"'  => "'",
			'<'  => '[',
			'>'  => ']',
		);

		return trim( strtr( $name, $rule ) );
	}
	/**
	 * Filter of other data
	 *
	 * @param string $data MANDATORY.
	 * @return string
	 */
	protected function filter_other( $data ) {
		$rule = array(
			"\r" => '',
			"\n" => '',
			"\t" => '',
		);

		return strtr( $data, $rule );
	}
	/**
	 * Formats e-mail address
	 *
	 * @param string $email MANDATORY.
	 * @param string $name MANDATORY.
	 * @return string
	 */
	protected function format_address( $email, $name ) {
		if ( '' === $name || null === $name || $name === $email ) {
			return $email;
		} else {
			$encoded_name = $this->encode_header( $name );
			if ( $encoded_name === $name && strcspn( $name, '()<>[]:;@\\,.' ) != strlen( $name ) ) {// WPCS: loose comparison ok.
				$format = '"%s" <%s>';
			} else {
				$format = '%s <%s>';
			}
			return sprintf( $format, $encoded_name, $email );
		}
	}
}
