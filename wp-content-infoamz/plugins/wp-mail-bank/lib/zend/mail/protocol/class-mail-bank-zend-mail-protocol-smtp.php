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
 * @category     end
 * @package  Mail_Bank_Zend_Mail
 * @subpackage Protocol
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license  http://framework.zend.com/license/new-bsd    New BSD License
 * @version  $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

/** Zend Mime File Included

 * @see Mail_Bank_Zend_Mime
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-mime.php';
}

/** Protocol Abstract File Included

 * @see Mail_Bank_Zend_Mail_Protocol_Abstract
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-abstract.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-abstract.php';
}

/** Class Begins here
 * Smtp implementation of Mail_Bank_Zend_Mail_Protocol_Abstract
 *
 * Minimum implementation according to RFC2821: EHLO, MAIL FROM, RCPT TO, DATA, RSET, NOOP, QUIT
 *
 * @category Zend
 * @package Mail_Bank_Zend_Mail
 * @subpackage Protocol
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */
class Mail_Bank_Zend_Mail_Protocol_Smtp extends Mail_Bank_Zend_Mail_Protocol_Abstract {
	/**
	 * The transport method for the socket
	 *
	 * @var string
	 */
	protected $_transport = 'tcp';
	/**
	 * Indicates that a session is requested to be secure
	 *
	 * @var string
	 */
	protected $_secure;
	/**
	 * Indicates an smtp session has been started by the HELO command
	 *
	 * @var boolean
	 */
	protected $_sess = false;
	/**
	 * Indicates the HELO command has been issues
	 *
	 * @var unknown_type
	 */
	protected $_helo = false;
	/**
	 * Indicates an smtp AUTH has been issued and authenticated
	 *
	 * @var unknown_type
	 */
	protected $_auth = false;
	/**
	 * Indicates a MAIL command has been issued
	 *
	 * @var unknown_type
	 */
	protected $_mail = false;
	/**
	 * Indicates one or more RCTP commands have been issued
	 *
	 * @var unknown_type
	 */
	protected $_rcpt = false;
	/**
	 * Indicates that DATA has been issued and sent
	 *
	 * @var unknown_type
	 */
	protected $_data = null;
	/**
	 * Constructor.
	 *
	 * @param  string  $host OPTIONAL.
	 * @param  integer $port OPTIONAL.
	 * @param  array   $config OPTIONAL.
	 * @return void
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 */
	public function __construct( $host = '127.0.0.1', $port = null, array $config = array() ) {
		if ( isset( $config['ssl'] ) ) {
			switch ( strtolower( $config['ssl'] ) ) {
				case 'tls':
					$this->_secure = 'tls';
					break;

				case 'ssl':
					$this->_transport = 'ssl';
					$this->_secure    = 'ssl';
					if ( null === $port ) {
						$port = 465;
					}
					break;

				default:
					/** Protocol Exception File Included.

				* @see Mail_Bank_Zend_Mail_Protocol_Exception
				*/
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
						require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
					}

					throw new Mail_Bank_Zend_Mail_Protocol_Exception( $config['ssl'] . ' is unsupported SSL type' );
			}
		}

		// If no port has been specified then check the bank PHP ini file. Defaults to 25 if the ini setting is null.
		if ( null === $port ) {
			$port = ini_get( 'smtp_port' );
			if ( '' === $port ) {
				$port = 25;
			}
		}

		parent::__construct( $host, $port );
	}
	/**
	 * Connect to the server with the parameters given in the constructor.
	 *
	 * @return boolean
	 */
	public function connect() {
		return $this->_connect( $this->_transport . '://' . $this->_host . ':' . $this->_port );
	}
	/**
	 * Initiate HELO/EHLO sequence and set flag to indicate valid smtp session
	 *
	 * @param  string $host The client hostname or IP address (default: 127.0.0.1).
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return void
	 */
	public function helo( $host = '127.0.0.1' ) {
		// Respect RFC 2821 and disallow HELO attempts if session is already initiated.
		if ( true === $this->_sess ) {
			/** Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Protocol_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'Cannot issue HELO to existing session' );
		}

		// Validate client hostname.
		if ( ! $this->valid_host->is_valid( $host ) ) {
			/** Exception File Included

		 * @see Mail_Bank_Zend_Mail_Protocol_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( join( ', ', $this->valid_host->get_messages() ) );
		}

		// Initiate helo sequence.
		$this->expect( 220, 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2.
		$this->ehlo( $host );

		// If a TLS session is required, commence negotiation.
		if ( 'tls' === $this->_secure ) {
			$this->send( 'STARTTLS' );
			$this->expect( 220, 180 );
			stream_context_set_option( $this->_socket, 'ssl', 'verify_peer', false );
			stream_context_set_option( $this->_socket, 'ssl', 'verify_peer_name', false );
			if ( extension_loaded( 'openssl' ) ) {
				if ( ! stream_socket_enable_crypto( $this->_socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT ) ) {
					/** Exception File Included.

				* @see Mail_Bank_Zend_Mail_Protocol_Exception
				*/
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
						require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
					}

					throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'Unable to connect via TLS' );
				}
			}
			$this->ehlo( $host );
		}

		$this->start_session();
		$this->auth();
	}
	/**
	 * Send EHLO or HELO depending on capabilities of smtp host
	 *
	 * @param  string $host The client hostname or IP address (default: 127.0.0.1).
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return void
	 */
	protected function ehlo( $host ) {
		// Support for older, less-compliant remote servers. Tries multiple attempts of EHLO or HELO.
		try {
			$this->send( 'EHLO ' . $host );
			$this->expect( 250, 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2.
		} catch ( Mail_Bank_Zend_Mail_Protocol_Exception $e ) {
			$this->send( 'HELO ' . $host );
			$this->expect( 250, 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2.
		} catch ( Mail_Bank_Zend_Mail_Protocol_Exception $e ) {
			throw $e;
		}
	}
	/**
	 * Issues MAIL command
	 *
	 * @param  string $from Sender mailbox MANDATORY.
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return void
	 */
	public function mail( $from ) {
		if ( true !== $this->_sess ) {
			/** Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Protocol_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'A valid session has not been started' );
		}

		$this->send( 'MAIL FROM:<' . $from . '>' );
		$this->expect( 250, 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2
		// Set mail to true, clear recipients and any existing data flags as per 4.1.1.2 of RFC 2821.
		$this->_mail = true;
		$this->_rcpt = false;
		$this->_data = false;
	}
	/**
	 * Issues RCPT command
	 *
	 * @param  string $to Receiver(s) mailbox.
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return void
	 */
	public function rcpt( $to ) {
		if ( true !== $this->_mail ) {
			/** Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Protocol_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'No sender reverse path has been supplied' );
		}

		// Set rcpt to true, as per 4.1.1.3 of RFC 2821.
		$this->send( 'RCPT TO:<' . $to . '>' );
		$this->expect( array( 250, 251 ), 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2.
		$this->_rcpt = true;
	}
	/**
	 * Issues DATA command
	 *
	 * @param  string $data MANDATORY.
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return void
	 */
	public function data( $data ) {
		// Ensure recipients have been set.
		if ( true !== $this->_rcpt ) {
			/** Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Protocol_Exception.
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'No recipient forward path has been supplied' );
		}

		$this->send( 'DATA' );
		$this->expect( 354, 120 ); // Timeout set for 2 minutes as per RFC 2821 4.5.3.2.

		foreach ( explode( Mail_Bank_Zend_Mime::LINEEND, $data ) as $line ) {
			if ( strpos( $line, '.' ) === 0 ) {
				// Escape lines prefixed with a '.'.
				$line = '.' . $line;
			}
			$this->send( $line );
		}

		$this->send( '.' );
		$this->expect( 250, 600 ); // Timeout set for 10 minutes as per RFC 2821 4.5.3.2.
		$this->_data = true;
	}
	/**
	 * Issues the RSET command and validates answer
	 *
	 * Can be used to restore a clean smtp communication state when a transaction has been cancelled or commencing a new transaction.
	 *
	 * @return void
	 */
	public function rset() {
		$this->send( 'RSET' );
		// MS ESMTP doesn't follow RFC, see [ZF-1377].
		$this->expect( array( 250, 220 ) );

		$this->_mail = false;
		$this->_rcpt = false;
		$this->_data = false;
	}
	/**
	 * Issues the NOOP command and validates answer
	 *
	 * Not used by Mail_Bank_Zend_Mail, could be used to keep a connection alive or check if it is still open.
	 *
	 * @return void
	 */
	public function noop() {
		$this->send( 'NOOP' );
		$this->expect( 250, 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2.
	}
	/**
	 * Issues the VRFY command and validates answer
	 *
	 * Not used by Mail_Bank_Zend_Mail.
	 *
	 * @param  string $user User Name or eMail to verify.
	 * @return void
	 */
	public function vrfy( $user ) {
		$this->send( 'VRFY ' . $user );
		$this->expect( array( 250, 251, 252 ), 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2.
	}
	/**
	 * Issues the QUIT command and clears the current session.
	 *
	 * @return void
	 */
	public function quit() {
		if ( $this->_sess ) {
			$this->send( 'QUIT' );
			$this->expect( 221, 300 ); // Timeout set for 5 minutes as per RFC 2821 4.5.3.2.
			$this->stop_session();
		}
	}
	/**
	 * Default authentication method
	 *
	 * This default method is implemented by AUTH adapters to properly authenticate to a remote host.
	 *
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return void
	 */
	public function auth() {
		if ( true === $this->_auth ) {
			/** Exception File Included.

		 * @see Mail_Bank_Zend_Mail_Protocol_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'Already authenticated for this session' );
		}
	}
	/**
	 * Closes connection
	 *
	 * @return void
	 */
	public function disconnect() {
		$this->_disconnect();
	}
	/**
	 * Start mail session
	 *
	 * @return void
	 */
	protected function start_session() {
		$this->_sess = true;
	}
	/**
	 * Stop mail session
	 *
	 * @return void
	 */
	protected function stop_session() {
		$this->_sess = false;
	}
}
