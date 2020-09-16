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
 * Class representing a MIME part.
 *
 * @category Zend
 * @package Mail_Bank_Zend_Mime
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class Mail_Bank_Zend_Mime_Part {
	/**
	 * Type
	 *
	 * @var string
	 */
	public $type = Mail_Bank_Zend_Mime::TYPE_OCTETSTREAM;
	/**
	 * Encoding
	 *
	 * @var string
	 */
	public $encoding = Mail_Bank_Zend_Mime::ENCODING_8BIT;
	/**
	 * ID
	 *
	 * @var string
	 */
	public $id;
	/**
	 * Disposition
	 *
	 * @var string
	 */
	public $disposition;
	/**
	 * Filename
	 *
	 * @var string
	 */
	public $filename;
	/**
	 * Description
	 *
	 * @var string
	 */
	public $description;
	/**
	 * Character set
	 *
	 * @var string
	 */
	public $charset;
	/**
	 * Boundary
	 *
	 * @var string
	 */
	public $boundary;
	/**
	 * Location
	 *
	 * @var string
	 */
	public $location;
	/**
	 * Language
	 *
	 * @var string
	 */
	public $language;
	/**
	 * Content
	 *
	 * @var mixed
	 */
	protected $_content;
	/** Variable Declaration.

	 * @var bool
	 */
	protected $is_stream = false;
	/**
	 * Create a new Mime Part.
	 * The (unencoded) content of the Part as passed
	 * as a string or stream
	 *
	 * @param mixed $content String or Stream containing the content.
	 */
	public function __construct( $content ) {
		$this->_content = $content;
		if ( is_resource( $content ) ) {
			$this->is_stream = true;
		}
	}
	/** Function Declaration.

	 * @todo setters/getters
	 * @todo error checking for setting $type
	 * @todo error checking for setting $encoding
	 */
	/**
	 * Check if this part can be read as a stream.
	 * if true, get_encoded_stream can be called, otherwise
	 * only get_content can be used to fetch the encoded
	 * content of the part
	 *
	 * @return bool
	 */
	public function is_stream() {
		return $this->is_stream;
	}
	/**
	 * If this was created with a stream, return a filtered stream for
	 * reading the content. very useful for large file attachments.
	 *
	 * @return mixed Stream
	 * @throws Mail_Bank_Zend_Mime_Exception If not a stream or unable to append filter.
	 */
	public function get_encoded_stream() {
		if ( ! $this->is_stream ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-exception.php';
			}

			throw new Mail_Bank_Zend_Mime_Exception(
				'Attempt to get a stream from a string part'
			);
		}

		switch ( $this->encoding ) {
			case Mail_Bank_Zend_Mime::ENCODING_QUOTEDPRINTABLE:
				$filter = stream_filter_append(
					$this->_content, 'convert.quoted-printable-encode', STREAM_FILTER_READ, array(
						'line-length'      => 76,
						'line-break-chars' => Mail_Bank_Zend_Mime::LINEEND,
					)
				);
				if ( ! is_resource( $filter ) ) {
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-exception.php' ) ) {
						require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-exception.php';
					}

					throw new Mail_Bank_Zend_Mime_Exception(
						'Failed to append quoted-printable filter'
					);
				}
				break;

			case Mail_Bank_Zend_Mime::ENCODING_BASE64:
				$filter = stream_filter_append(
					$this->_content, 'convert.base64-encode', STREAM_FILTER_READ, array(
						'line-length'      => 76,
						'line-break-chars' => Mail_Bank_Zend_Mime::LINEEND,
					)
				);
				if ( ! is_resource( $filter ) ) {
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-exception.php' ) ) {
						require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-exception.php';
					}

					throw new Mail_Bank_Zend_Mime_Exception(
						'Failed to append base64 filter'
					);
				}
				break;

			default:
		}

		return $this->_content;
	}
	/**
	 * Get the Content of the current Mime Part in the given encoding.
	 *
	 * @param    string $eol Line end; defaults to {@link Mail_Bank_Zend_Mime::LINEEND}.
	 * @throws Mail_Bank_Zend_Mime_Exception Throws Exception.
	 * @return string
	 */
	public function get_content( $eol = Mail_Bank_Zend_Mime::LINEEND ) {
		if ( $this->is_stream ) {
			return stream_get_contents( $this->get_encoded_stream() );
		} else {
			return Mail_Bank_Zend_Mime::encode( $this->_content, $this->encoding, $eol );
		}
	}
	/**
	 * Get the RAW unencoded content from this part
	 *
	 * @return string
	 */
	public function get_raw_content() {
		if ( $this->is_stream ) {
			return stream_get_contents( $this->_content );
		} else {
			return $this->_content;
		}
	}
	/**
	 * Create and return the array of headers for this MIME part
	 *
	 * @param    string $eol Line end; defaults to {@link Mail_Bank_Zend_Mime::LINEEND}.
	 * @return array
	 */
	public function get_headers_array( $eol = Mail_Bank_Zend_Mime::LINEEND ) {
		$headers = array();

		$content_type = $this->type;
		if ( $this->charset ) {
			$content_type .= '; charset=' . $this->charset;
		}

		if ( $this->boundary ) {
			$content_type .= ';' . $eol
			. ' boundary="' . $this->boundary . '"';
		}

		$headers[] = array(
			'Content-Type',
			$content_type,
		);

		if ( $this->encoding ) {
			$headers[] = array(
				'Content-Transfer-Encoding',
				$this->encoding,
			);
		}

		if ( $this->id ) {
			$headers[] = array(
				'Content-ID',
				'<' . $this->id . '>',
			);
		}

		if ( $this->disposition ) {
			$disposition = $this->disposition;
			if ( $this->filename ) {
				$disposition .= '; filename="' . $this->filename . '"';
			}
			$headers[] = array(
				'Content-Disposition',
				$disposition,
			);
		}

		if ( $this->description ) {
			$headers[] = array(
				'Content-Description',
				$this->description,
			);
		}

		if ( $this->location ) {
			$headers[] = array(
				'Content-Location',
				$this->location,
			);
		}

		if ( $this->language ) {
			$headers[] = array(
				'Content-Language',
				$this->language,
			);
		}

		return $headers;
	}
	/**
	 * Return the headers for this part as a string
	 *
	 * @param    string $eol Line end; defaults to {@link Mail_Bank_Zend_Mime::LINEEND}.
	 * @return string
	 */
	public function get_headers( $eol = Mail_Bank_Zend_Mime::LINEEND ) {
		$res = '';
		foreach ( $this->get_headers_array( $eol ) as $header ) {
			$res .= $header[0] . ': ' . $header[1] . $eol;
		}

		return $res;
	}
}
