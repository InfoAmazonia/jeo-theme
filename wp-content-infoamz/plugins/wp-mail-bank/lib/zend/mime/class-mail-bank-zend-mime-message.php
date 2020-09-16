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
 * @package Mail_Bank_Zend_Mime
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/**
 * Mail_Bank_Zend_Mime
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php';
}

/**
 * Mail_Bank_Zend_Mime_Part
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-part.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-part.php';
}
/** Class Begins here.

 * @category Zend
 * @package Mail_Bank_Zend_Mime
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class Mail_Bank_Zend_Mime_Message {
	/**
	 * The Mail_Bank_Zend_Mime_Parts of the message
	 *
	 * @var array
	 */
	protected $_parts = array();
	/**
	 * The Mail_Bank_Zend_Mime object for the message
	 *
	 * @var Mail_Bank_Zend_Mime|null
	 */
	protected $_mime = null;
	/**
	 * Returns the list of all Mail_Bank_Zend_Mime_Parts in the message
	 *
	 * @return array of Mail_Bank_Zend_Mime_Part
	 */
	public function get_parts() {
		return $this->_parts;
	}
	/**
	 * Sets the given array of Mail_Bank_Zend_Mime_Parts as the array for the message
	 *
	 * @param array $parts MANDATORY.
	 */
	public function set_parts( $parts ) {
		$this->_parts = $parts;
	}
	/**
	 * Append a new Mail_Bank_Zend_Mime_Part to the current message
	 *
	 * @param Mail_Bank_Zend_Mime_Part $part MANDATORY.
	 */
	public function add_part( Mail_Bank_Zend_Mime_Part $part ) {

		$this->_parts[] = $part;
	}
	/**
	 * Check if message needs to be sent as multipart
	 * MIME message or if it has only one part.
	 *
	 * @return boolean
	 */
	public function is_multi_part() {
		return ( count( $this->_parts ) > 1 );
	}
	/**
	 * Set Mail_Bank_Zend_Mime object for the message
	 *
	 * This can be used to set the boundary specifically or to use a subclass of
	 * Mail_Bank_Zend_Mime for generating the boundary.
	 *
	 * @param Mail_Bank_Zend_Mime $mime MANDATORY.
	 */
	public function set_mime( Mail_Bank_Zend_Mime $mime ) {
		$this->_mime = $mime;
	}
	/**
	 * Returns the Mail_Bank_Zend_Mime object in use by the message
	 *
	 * If the object was not present, it is created and returned. Can be used to
	 * determine the boundary used in this message.
	 *
	 * @return Mail_Bank_Zend_Mime
	 */
	public function get_mime() {
		if ( null === $this->_mime ) {
			$this->_mime = new Mail_Bank_Zend_Mime();
		}

		return $this->_mime;
	}
	/**
	 * Generate MIME-compliant message from the current configuration
	 *
	 * This can be a multipart message if more than one MIME part was added. If
	 * only one part is present, the content of this part is returned. If no
	 * part had been added, an empty string is returned.
	 *
	 * Parts are seperated by the mime boundary as defined in Mail_Bank_Zend_Mime. If
	 * {@link set_mime()} has been called before this method, the Mail_Bank_Zend_Mime
	 * object set by this call will be used. Otherwise, a new Mail_Bank_Zend_Mime object
	 * is generated and used.
	 *
	 * @param string $eol eol string; defaults to {@link Mail_Bank_Zend_Mime::LINEEND}.
	 * @return string
	 */
	public function generate_message( $eol = Mail_Bank_Zend_Mime::LINEEND ) {
		if ( ! $this->is_multi_part() ) {
			$body = array_shift( $this->_parts );
			$body = $body->get_content( $eol );
		} else {
			$mime = $this->get_mime();

			$boundary_line = $mime->boundary_line( $eol );
			$body          = 'This is a message in Mime Format.	If you see this, '
			. 'your mail reader does not support this format.' . $eol;

			foreach ( array_keys( $this->_parts ) as $p ) {
				$body .= $boundary_line
				. $this->get_part_headers( $p, $eol )
				. $eol
				. $this->get_part_content( $p, $eol );
			}

			$body .= $mime->mime_end( $eol );
		}

		return trim( $body );
	}
	/**
	 * Get the headers of a given part as an array
	 *
	 * @param int $partnum MANDATORY.
	 * @return array
	 */
	public function get_part_headers_array( $partnum ) {
		return $this->_parts[ $partnum ]->get_headers_array();
	}
	/**
	 * Get the headers of a given part as a string
	 *
	 * @param    int    $partnum MANDATORY.
	 * @param    string $eol OPTIONAL.
	 * @return string
	 */
	public function get_part_headers( $partnum, $eol = Mail_Bank_Zend_Mime::LINEEND ) {
		return $this->_parts[ $partnum ]->get_headers( $eol );
	}
	/**
	 * Get the (encoded) content of a given part as a string
	 *
	 * @param    int    $partnum MANDATORY.
	 * @param    string $eol OPTIONAL.
	 * @return string
	 */
	public function get_part_content( $partnum, $eol = Mail_Bank_Zend_Mime::LINEEND ) {
		return $this->_parts[ $partnum ]->get_content( $eol );
	}
	/**
	 * Explode MIME multipart string into seperate parts
	 *
	 * Parts consist of the header and the body of each MIME part.
	 *
	 * @param    string $body MANDATORY.
	 * @param    string $boundary MANDATORY.
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 * @return array
	 */
	protected static function disassemble_mime( $body, $boundary ) {
		$start = 0;
		$res   = array();
		// find every mime part limiter and cut out the
		// string before it.
		// the part before the first boundary string is discarded.
		$p = strpos( $body, '--' . $boundary . "\n", $start );
		if ( false === $p ) {
			// no parts found!
			return array();
		}

		// Position after first boundary line.
		$start = $p + 3 + strlen( $boundary );
		$p     = strpos( $body, '--' . $boundary . "\n", $start );
		while ( false !== $p ) {
			$res[] = substr( $body, $start, $p - $start );
			$start = $p + 3 + strlen( $boundary );
		}

		// No more parts, find end boundary.
		$p = strpos( $body, '--' . $boundary . '--', $start );
		if ( false === $p ) {
			throw new Mail_Bank_Zend_Exception( 'Not a valid Mime Message: End Missing' );
		}

		// The remaining part also needs to be parsed.
		$res[] = substr( $body, $start, $p - $start );

		return $res;
	}
	/**
	 * Decodes a MIME encoded string and returns a Mail_Bank_Zend_Mime_Message object with
	 * all the MIME parts set according to the given string
	 *
	 * @param string $message MANDATORY.
	 * @param string $boundary MANDATORY.
	 * @param string $eol eol string; defaults to {@link Mail_Bank_Zend_Mime::LINEEND}.
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 * @return Mail_Bank_Zend_Mime_Message
	 */
	public static function create_from_message(
	$message, $boundary, $eol = Mail_Bank_Zend_Mime::LINEEND
	) {
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-decode.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-decode.php';
		}

		$parts = Mail_Bank_Zend_Mime_Decode::split_message_struct( $message, $boundary, $eol );

		$res = new self();
		foreach ( $parts as $part ) {
			// Now we build a new MimePart for the current Message Part.
			$new_part = new Mail_Bank_Zend_Mime_Part( $part['body'] );
			foreach ( $part['header'] as $key => $value ) {
				switch ( strtolower( $key ) ) {
					case 'content-type':
						$new_part->type = $value;
						break;
					case 'content-transfer-encoding':
						$new_part->encoding = $value;
						break;
					case 'content-id':
						$new_part->id = trim( $value, '<>' );
						break;
					case 'content-disposition':
						$new_part->disposition = $value;
						break;
					case 'content-description':
						$new_part->description = $value;
						break;
					case 'content-location':
						$new_part->location = $value;
						break;
					case 'content-language':
						$new_part->language = $value;
						break;
					default:
						throw new Mail_Bank_Zend_Exception(
							'Unknown header ignored for MimePart:' . $key
						);
				}
			}
			$res->add_part( $new_part );
		}

		return $res;
	}
}
