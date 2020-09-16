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
 * @package  Mail_Bank_Zend_Mail
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/** Zend Mail Mime Decode File Included

 * @see Mail_Bank_Zend_Mime_Decode
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-decode.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mime/class-mail-bank-zend-mime-decode.php';
}

/** Zend Mail Mime Part File Included

 * @see Mail_Bank_Zend_Mail_Part
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mime-part.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mime-part.php';
}

/** Class Begins here

 * @category Zend
 * @package  Mail_Bank_Zend_Mail
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license  http://framework.zend.com/license/new-bsd New BSD License
 */
class Mail_Bank_Zend_Mail_Part_File extends Mail_Bank_Zend_Mail_Part {

	/** Variable Declaration

	 * @var array $content_pos
	 */
	protected $content_pos = array();

	/** Variable Declaration

	 * @var array $part_pos
	 */

	protected $part_pos = array();

	/** Variable Declaration

	 * @var array $fh
	 */
	protected $fh;
	/**
	 * Public constructor
	 *
	 * This handler supports the following params:
	 * - file      filename or open file handler with message content (required)
	 * - start_pos start position of message or part in file (default: current position)
	 * - end_pos  end position of message or part in file (default: end of file)
	 *
	 * @param array $params  full message with or without headers.
	 * @throws  Mail_Bank_Zend_Mail_Exception Throws exception.
	 */
	public function __construct( array $params ) {
		if ( empty( $params['file'] ) ) {

			/** Zend Mail Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */

			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'no file given in params' );
		}

		if ( ! is_resource( $params['file'] ) ) {
			$this->fh = fopen( $params['file'], 'r' );// @codingStandardsIgnoreLine.
		} else {
			$this->fh = $params['file'];
		}
		if ( ! $this->fh ) {

			/** Zend Mail Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */

			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'could not open file' );
		}
		if ( isset( $params['start_pos'] ) ) {
			fseek( $this->fh, $params['start_pos'] );
		}
		$header  = '';
		$end_pos = isset( $params['end_pos'] ) ? $params['end_pos'] : null;
		$line    = fgets( $this->fh );
		while ( ( null === $end_pos || ftell( $this->fh ) < $end_pos ) && trim( $line ) ) {
			$header .= $line;
		}

		Mail_Bank_Zend_Mime_Decode::split_message( $header, $this->_headers, $null );

		$this->content_pos[0] = ftell( $this->fh );
		if ( null !== $end_pos ) {
			$this->content_pos[1] = $end_pos;
		} else {
			fseek( $this->fh, 0, SEEK_END );
			$this->content_pos[1] = ftell( $this->fh );
		}
		if ( ! $this->isMultipart() ) {
			return;
		}

		$boundary = $this->getHeaderField( 'content-type', 'boundary' );
		if ( ! $boundary ) {

			/** Zend Mail Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'no boundary found in content type to split message' );
		}

		$part = array();
		$pos  = $this->content_pos[0];
		fseek( $this->fh, $pos );
		while ( ! feof( $this->fh ) && ( null === $end_pos || $pos < $end_pos ) ) {
			$line = fgets( $this->fh );
			if ( false === $line ) {
				if ( feof( $this->fh ) ) {
					break;
				}

				/** Zend Mail Exception File Included

			 * @see Mail_Bank_Zend_Mail_Exception
			 */
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
				}

				throw new Mail_Bank_Zend_Mail_Exception( 'error reading file' );
			}

			$last_pos = $pos;
			$pos      = ftell( $this->fh );
			$line     = trim( $line );

			if ( ( '--' . $boundary ) === $line ) {
				if ( $part ) {
					// not first part.
					$part[1]          = $last_pos;
					$this->part_pos[] = $part;
				}
				$part = array( $pos );
			} elseif ( ( '--' . $boundary . '--' ) === $line ) {
				$part[1]          = $last_pos;
				$this->part_pos[] = $part;
				break;
			}
		}
		$this->count_parts = count( $this->part_pos );
	}
	/** Function Declaration
	 * Body of part
	 *
	 * If part is multipart the raw content of this part with all sub parts is returned

	 * @param string $stream OPTIONAL.
	 * @return string body
	 * @throws Mail_Bank_Zend_Mail_Exception Throws Exception.
	 */
	public function get_content( $stream = null ) {
		fseek( $this->fh, $this->content_pos[0] );
		if ( null !== $stream ) {
			return stream_copy_to_stream( $this->fh, $stream, $this->content_pos[1] - $this->content_pos[0] );
		}
		$length = $this->content_pos[1] - $this->content_pos[0];
		return $length < 1 ? '' : fread( $this->fh, $length );// @codingStandardsIgnoreLine 
	}
	/**
	 * Return size of part
	 *
	 * Quite simple implemented currently (not decoding). Handle with care.
	 *
	 * @return int size
	 */
	public function getSize() {
		return $this->content_pos[1] - $this->content_pos[0];
	}
	/**
	 * Get part of multipart message
	 *
	 * @param  int $num number of part starting with 1 for first part.
	 * @return Mail_Bank_Zend_Mail_Part wanted part.
	 * @throws Mail_Bank_Zend_Mail_Exception Throws Exception.
	 */
	public function getPart( $num ) {
		--$num;
		if ( ! isset( $this->part_pos[ $num ] ) ) {

			/** Zend Mail Exception File Included

		 * @see Mail_Bank_Zend_Mail_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/class-mail-bank-zend-mail-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Exception( 'part not found' );
		}

		return new self(
			array(
				'file'      => $this->fh,
				'start_pos' => $this->part_pos[ $num ][0],
				'end_pos'   => $this->part_pos[ $num ][1],
			)
		);
	}
}
