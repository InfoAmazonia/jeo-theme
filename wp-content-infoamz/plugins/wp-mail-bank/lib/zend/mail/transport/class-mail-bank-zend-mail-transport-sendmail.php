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

/** Abstract File Included.

 * @see Mail_Bank_Zend_Mail_Transport_Abstract
 */

if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php';
}
/**
 * Class for sending eMails via the PHP internal mail() function
 *
 * @category    Zend
 * @package  Mail_Bank_Zend_Mail
 * @subpackage Transport
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license  http://framework.zend.com/license/new-bsd    New BSD License
 */
class Mail_Bank_Zend_Mail_Transport_Sendmail extends Mail_Bank_Zend_Mail_Transport_Abstract {
	/**
	 * Subject
	 *
	 * @var string
	 * @access public
	 */
	public $subject = null;
	/**
	 * Config options for sendmail parameters
	 *
	 * @var string
	 */
	public $parameters;
	/**
	 * Eol character string
	 *
	 * @var string
	 * @access public
	 */
	public $eol = PHP_EOL;
	/**
	 * Error information.
	 *
	 * @var string
	 */
	protected $_errstr;
	/**
	 * Constructor.
	 *
	 * @param  string|array|Mail_Bank_Zend_Config $parameters OPTIONAL (Default: null).
	 * @return void
	 */
	public function __construct( $parameters = null ) {
		if ( $parameters instanceof Mail_Bank_Zend_Config ) {
			$parameters = $parameters->toArray();
		}

		if ( is_array( $parameters ) ) {
			$parameters = implode( ' ', $parameters );
		}

		$this->parameters = $parameters;
	}
	/**
	 * Send mail using PHP native mail()
	 *
	 * @access public
	 * @return void
	 * @throws Mail_Bank_Zend_Mail_Transport_Exception If parameters is set but not a string.
	 * @throws Mail_Bank_Zend_Mail_Transport_Exception On mail() failure.
	 */
	public function send_mail() {
		if ( null === $this->parameters ) {
			set_error_handler( array( $this, 'handle_mail_errors' ) );// @codingStandardsIgnoreLine.
			$result = mail(
				$this->recipients, $this->_mail->getSubject(), $this->body, $this->header
			);
			restore_error_handler();
		} else {
			if ( ! is_string( $this->parameters ) ) {
				/** Exception File Included.

			 * @see Mail_Bank_Zend_Mail_Transport_Exception
			 *
			 * Exception is thrown here because
			 * $parameters is a public property
			 */
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
				}

				throw new Mail_Bank_Zend_Mail_Transport_Exception(
					'Parameters were set but are not a string'
				);
			}

			set_error_handler( array( $this, 'handle_mail_errors' ) );// @codingStandardsIgnoreLine.
			$result = mail(
				$this->recipients, $this->_mail->getSubject(), $this->body, $this->header, $this->parameters
			);
			restore_error_handler();
		}

		if ( null !== $this->_errstr || ! $result ) {
			/** Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Transport_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Transport_Exception( 'Unable to send mail. ' . $this->_errstr );
		}
	}
	/**
	 * Format and fix headers
	 *
	 * Mail() uses its $to and $subject arguments to set the To: and Subject:
	 * headers, respectively. This method strips those out as a sanity check to
	 * prevent duplicate header entries.
	 *
	 * @access  protected
	 * @param    array $headers MANDATORY.
	 * @return  void
	 * @throws  Mail_Bank_Zend_Mail_Transport_Exception Throws Exception.
	 */
	protected function prepare_headers( $headers ) {
		if ( ! $this->_mail ) {
			/** Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Transport_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Transport_Exception( 'prepare_headers requires a registered Zend_Mail object' );
		}

		// mail() uses its $to parameter to set the To: header, and the $subject
		// parameter to set the Subject: header. We need to strip them out.
		if ( 0 === strpos( PHP_OS, 'WIN' ) ) {
			// If the current recipients list is empty, throw an error.
			if ( empty( $this->recipients ) ) {
				/** Exception File Included.

			 * @see Mail_Bank_Zend_Mail_Transport_Exception
			 */
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
				}

				throw new Mail_Bank_Zend_Mail_Transport_Exception( 'Missing To addresses' );
			}
		} else {
			// All others, simply grab the recipients and unset the To: header.
			if ( ! isset( $headers['To'] ) ) {
				/** Exception File Included.

			 * @see Mail_Bank_Zend_Mail_Transport_Exception
			 */
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
				}

				throw new Mail_Bank_Zend_Mail_Transport_Exception( 'Missing To header' );
			}

			unset( $headers['To']['append'] );
			$this->recipients = implode( ',', $headers['To'] );
		}

		// Remove recipient header.
		unset( $headers['To'] );

		// Remove subject header, if present.
		if ( isset( $headers['Subject'] ) ) {
			unset( $headers['Subject'] );
		}

		// Prepare headers.
		parent::prepare_headers( $headers );

		// Fix issue with empty blank line ontop when using Sendmail Trnasport.
		$this->header = rtrim( $this->header );
	}
	/**
	 * Temporary error handler for PHP native mail().
	 *
	 * @param int    $errno MANDATORY.
	 * @param string $errstr MANDATORY.
	 * @param string $errfile MANDATORY.
	 * @param string $errline OPTIONAL.
	 * @param array  $errcontext OPTIONAL.
	 * @return true
	 */
	public function handle_mail_errors( $errno, $errstr, $errfile = null, $errline = null, array $errcontext = null ) {
		$this->_errstr = $errstr;
		return true;
	}
}
