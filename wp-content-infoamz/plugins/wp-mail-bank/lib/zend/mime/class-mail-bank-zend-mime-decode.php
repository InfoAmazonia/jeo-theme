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
/** Mime File Included

 * @see Mail_Bank_Zend_Mime
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php';
}
/** Class Begins here.

 * @category Zend
 * @package Mail_Bank_Zend_Mime
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class Mail_Bank_Zend_Mime_Decode {
	/**
	 * Explode MIME multipart string into seperate parts
	 *
	 * Parts consist of the header and the body of each MIME part.
	 *
	 * @param string $body raw body of message.
	 * @param string $boundary boundary as found in content-type.
	 * @return array parts with content of each part, empty if no parts found.
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 */
	public static function split_mime( $body, $boundary ) {
		// TODO: we're ignoring \r for now - is this function fast enough and is it safe to asume noone needs \r?
		$body = str_replace( "\r", '', $body );

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

		// position after first boundary line.
		$start = $p + 3 + strlen( $boundary );
		$p     = strpos( $body, '--' . $boundary . "\n", $start );
		while ( false !== $p ) {
			$res[] = substr( $body, $start, $p - $start );
			$start = $p + 3 + strlen( $boundary );
		}

		// no more parts, find end boundary.
		$p = strpos( $body, '--' . $boundary . '--', $start );
		if ( false === $p ) {
			throw new Mail_Bank_Zend_Exception( 'Not a valid Mime Message: End Missing' );
		}

		// the remaining part also needs to be parsed.
		$res[] = substr( $body, $start, $p - $start );

		return $res;
	}
	/**
	 * Decodes a mime encoded String and returns a struct of parts with header and body.
	 *
	 * @param string $message    raw message content.
	 * @param string $boundary boundary as found in content-type.
	 * @param string $eol eol string; defaults to {@link Mail_Bank_Zend_Mime::LINEEND}.
	 * @return array|null parts as array('header' => array(name => value), 'body' => content), null if no parts found.
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 */
	public static function split_message_struct(
	$message, $boundary, $eol = Mail_Bank_Zend_Mime::LINEEND
	) {
		$parts = self::split_mime( $message, $boundary );
		if ( count( $parts ) <= 0 ) {
			return null;
		}
		$result = array();
		foreach ( $parts as $part ) {
			self::split_message( $part, $headers, $body, $eol );
			$result[] = array(
				'header' => $headers,
				'body'   => $body,
			);
		}

		return $result;
	}
	/**
	 * Split a message in header and body part, if no header or an
	 * invalid header is found $headers is empty.
	 *
	 * The charset of the returned headers depend on your iconv settings.
	 *
	 * @param string $message raw message with header and optional content.
	 * @param array  $headers output param, array with headers as array(name => value).
	 * @param string $body output param, content of message.
	 * @param string $eol eol string; defaults to {@link Mail_Bank_Zend_Mime::LINEEND}.
	 * @return null
	 */
	public static function split_message(
	$message, &$headers, &$body, $eol = Mail_Bank_Zend_Mime::LINEEND
	) {
		// check for valid header at first line.
		$firstline = strtok( $message, "\n" );
		if ( ! preg_match( '%^[^\s]+[^:]*:%', $firstline ) ) {
			$headers = array();
			// TODO: we're ignoring \r for now - is this function fast enough and is it safe to asume noone needs \r?
			$body = str_replace(
				array(
					"\r",
					"\n",
				), array(
					'',
					$eol,
				), $message
			);

			return;
		}

		// find an empty line between headers and body.
		// default is set new line.
		if ( strpos( $message, $eol . $eol ) ) {
			list($headers, $body) = explode( $eol . $eol, $message, 2 );
			// next is the standard new line.
		} else {
			if ( "\r\n" !== $eol && strpos( $message, "\r\n\r\n" ) ) {
				list($headers, $body) = explode( "\r\n\r\n", $message, 2 );
				// next is the other "standard" new line.
			} else {
				if ( "\n" !== $eol && strpos( $message, "\n\n" ) ) {
					list($headers, $body) = explode( "\n\n", $message, 2 );
					// at last resort find anything that looks like a new line.
				} else {
					list($headers, $body) = preg_split( "%([\r\n]+)\\1%U", $message, 2 );
				}
			}
		}

		$headers = iconv_mime_decode_headers(
			$headers, ICONV_MIME_DECODE_CONTINUE_ON_ERROR
		);

		if ( false === $headers ) {
			// an error occurs during the decoding.
			return;
		}

		// normalize header names.
		foreach ( $headers as $name => $header ) {
			$lower = strtolower( $name );
			if ( $lower === $name ) {
				continue;
			}
			unset( $headers[ $name ] );
			if ( ! isset( $headers[ $lower ] ) ) {
				$headers[ $lower ] = $header;
				continue;
			}
			if ( is_array( $headers[ $lower ] ) ) {
				$headers[ $lower ][] = $header;
				continue;
			}
			$headers[ $lower ] = array(
				$headers[ $lower ],
				$header,
			);
		}
	}
	/**
	 * Split a content type in its different parts.
	 *
	 * @param string $type content-type.
	 * @param string $wanted_part the wanted part, else an array with all parts is returned.
	 * @return string|array wanted part or all parts as array('type' => content-type, partname => value).
	 */
	public static function split_content_type( $type, $wanted_part = null ) {
		return self::split_header_field( $type, $wanted_part, 'type' );
	}
	/**
	 * Split a header field like content type in its different parts.
	 *
	 * @param string     $field MANDATORY.
	 * @param string     $wanted_part the wanted part, else an array with all parts is returned.
	 * @param    int|string $first_name   key name for the first part.
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 * @return string|array wanted part or all parts as array($first_name => firstPart, partname => value).
	 */
	public static function split_header_field( $field, $wanted_part = null, $first_name = 0 ) {
		$wanted_part = strtolower( $wanted_part );
		$first_name  = strtolower( $first_name );

		// Special case - a bit optimized.
		if ( $first_name === $wanted_part ) {
			$field = strtok( $field, ';' );

			return '"' === $field[0] ? substr( $field, 1, -1 ) : $field;
		}

		$field = $first_name . '=' . $field;
		if ( ! preg_match_all( '%([^=\s]+)\s*=\s*("[^"]+"|[^;]+)(;\s*|$)%', $field, $matches ) ) {
			throw new Mail_Bank_Zend_Exception( 'not a valid header field' );
		}

		if ( $wanted_part ) {
			foreach ( $matches[1] as $key => $name ) {
				if ( strcasecmp( $name, $wanted_part ) ) {
					continue;
				}
				if ( '"' === $matches[2][ $key ][0] ) {
					return $matches[2][ $key ];
				}

				return substr( $matches[2][ $key ], 1, -1 );
			}

			return null;
		}

		$split = array();
		foreach ( $matches[1] as $key => $name ) {
			$name = strtolower( $name );
			if ( '"' === $matches[2][ $key ][0] ) {
				$split[ $name ] = substr( $matches[2][ $key ], 1, -1 );
			} else {
				$split[ $name ] = $matches[2][ $key ];
			}
		}

		return $split;
	}
	/**
	 * Decode a quoted printable encoded string.
	 *
	 * The charset of the returned string depends on your iconv settings.
	 *
	 * @param string $string Encoded string MANDATORY.
	 * @return string Decoded string.
	 */
	public static function decode_quoted_printable( $string ) {
		return quoted_printable_decode( $string );
	}
}
