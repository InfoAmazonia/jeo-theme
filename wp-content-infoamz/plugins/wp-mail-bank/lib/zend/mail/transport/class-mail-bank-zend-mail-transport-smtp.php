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

/** Zend Protocol Mime File Included

 * @see Mail_Bank_Zend_Mail_Protocol_Smtp
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-smtp.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-smtp.php';
}

/** Zend Mail Transport Abstract File Included.

 * @see Mail_Bank_Zend_Mail_Transport_Abstract
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-abstract.php';
}
/**
 * SMTP connection object
 *
 * Loads an instance of Mail_Bank_Zend_Mail_Protocol_Smtp and forwards smtp transactions
 *
 * @category Zend
 * @package  Mail_Bank_Zend_Mail
 * @subpackage Transport
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */
class Mail_Bank_Zend_Mail_Transport_Smtp extends Mail_Bank_Zend_Mail_Transport_Abstract {
	/**
	 * Eol character string used by transport
	 *
	 * @var string
	 * @access public
	 */
	public $eol = "\n";
	/**
	 * Remote smtp hostname or i.p.
	 *
	 * @var string
	 */
	protected $_host;
	/**
	 * Port number
	 *
	 * @var integer|null
	 */
	protected $_port;
	/**
	 * Local client hostname or i.p.
	 *
	 * @var string
	 */
	protected $_name = 'localhost';
	/**
	 * Authentication type OPTIONAL
	 *
	 * @var string
	 */
	protected $_auth;
	/**
	 * Config options for authentication
	 *
	 * @var array
	 */
	protected $_config;
	/**
	 * Instance of Mail_Bank_Zend_Mail_Protocol_Smtp
	 *
	 * @var Mail_Bank_Zend_Mail_Protocol_Smtp
	 */
	protected $_connection;
	/**
	 * Constructor.
	 *
	 * @param  string     $host OPTIONAL (Default: 127.0.0.1).
	 * @param  array|null $config OPTIONAL (Default: null).
	 * @return void
	 *
	 * @todo Someone please make this compatible
	 * with the SendMail transport class.
	 */
	public function __construct( $host = '127.0.0.1', array $config = array() ) {
		if ( isset( $config['name'] ) ) {
			$this->_name = $config['name'];
		}
		if ( isset( $config['port'] ) ) {
			$this->_port = $config['port'];
		}
		if ( isset( $config['auth'] ) ) {
			$this->_auth = $config['auth'];
		}

		$this->_host   = $host;
		$this->_config = $config;
	}
	/**
	 * Class destructor to ensure all open connections are closed
	 *
	 * @return void
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws exception.
	 */
	public function __destruct() {
		if ( $this->_connection instanceof Mail_Bank_Zend_Mail_Protocol_Smtp ) {
			try {
				$this->_connection->quit();
			} catch ( Mail_Bank_Zend_Mail_Protocol_Exception $e ) {
				throw $e;

			}
			$this->_connection->disconnect();
		}
	}
	/** Function Declaration.
	 * Sets the connection protocol instance
	 *
	 * @param Mail_Bank_Zend_Mail_Protocol_Abstract $connection MANDATORY.
	 *
	 * @return void
	 */
	public function set_connection( Mail_Bank_Zend_Mail_Protocol_Abstract $connection ) {
		$this->_connection = $connection;
	}
	/**
	 * Gets the connection protocol instance
	 *
	 * @return Mail_Bank_Zend_Mail_Protocol|null
	 */
	public function get_connection() {
		return $this->_connection;
	}
	/**
	 * Send an email via the SMTP connection protocol
	 *
	 * The connection via the protocol adapter is made just-in-time to allow a
	 * developer to add a custom adapter if required before mail is sent.
	 *
	 * @return void
	 * @todo Rename this to sendMail, it's a public method...
	 */
	public function send_mail() {
		// If sending multiple messages per session use existing adapter.
		if ( ! ( $this->_connection instanceof Mail_Bank_Zend_Mail_Protocol_Smtp ) ) {
			// Check if authentication is required and determine required class.
			$connection_class = 'Mail_Bank_Zend_Mail_Protocol_Smtp';
			if ( 'none' !== $this->_auth ) {
				$connection_class .= '_Auth_' . ucwords( $this->_auth );
			}
			if ( ! class_exists( $connection_class ) ) {
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-plain.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-plain.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-crammd5.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-crammd5.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-login.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/smtp/auth/class-mail-bank-zend-mail-protocol-smtp-auth-login.php';
				}
				// require_once MAIL_BANK_DIR_PATH.'lib/zend/class-mail-bank-zend-loader.php'.
			}
			$this->set_connection( new $connection_class( $this->_host, $this->_port, $this->_config ) );
			$this->_connection->connect();
			$this->_connection->helo( $this->_name );
		} else {
			// Reset connection to ensure reliable transaction.
			$this->_connection->rset();
		}
		// Set sender email address.
		$this->_connection->mail( $this->_mail->getReturnPath() );
		// Set recipient forward paths.
		foreach ( $this->_mail->getRecipients() as $recipient ) {
			$this->_connection->rcpt( $recipient );
		}

		// Issue DATA command to client.
		$this->_connection->data( $this->header . Mail_Bank_Zend_Mime::LINEEND . $this->body );
	}
	/**
	 * Format and fix headers
	 *
	 * Some SMTP servers do not strip BCC headers. Most clients do it themselves as do we.
	 *
	 * @access  protected
	 * @param    array $headers MANDATORY.
	 * @return  void
	 * @throws  Mail_Bank_Zend_Mail_Transport_Exception Throws Exception.
	 */
	protected function prepare_headers( $headers ) {
		if ( ! $this->_mail ) {
			/** Zend Mail Transport Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Transport_Exception Throws Exception.
		 */

			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/transport/class-mail-bank-zend-mail-transport-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Transport_Exception( 'prepare_headers requires a registered Mail_Bank_Zend_Mail object' );
		}

		unset( $headers['Bcc'] );

		// Prepare headers.
		parent::prepare_headers( $headers );
	}
}
