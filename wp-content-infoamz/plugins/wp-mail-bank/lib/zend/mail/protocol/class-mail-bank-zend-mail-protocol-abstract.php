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
 * @subpackage Protocol
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/** Validate File Included

 * @see Mail_Bank_Zend_Validate
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-validate.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-validate.php';
}


/** Validate Hostname File Included

 * @see Mail_Bank_Zend_Validate_Hostname
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-hostname.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-hostname.php';
}
/**
 * Mail_Bank_Zend_Mail_Protocol_Abstract
 *
 * Provides low-level methods for concrete adapters to communicate with a remote mail server and track requests and responses.
 *
 * @category Zend
 * @package Mail_Bank_Zend_Mail
 * @subpackage Protocol
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 * @version $Id$
 * @todo Implement proxy settings
 */
abstract class Mail_Bank_Zend_Mail_Protocol_Abstract {
	/**
	* Mail default EOL string
	*/
	const EOL = "\r\n";
	/**
	* Default timeout in seconds for initiating session
	*/
	const TIMEOUT_CONNECTION = 90;
	/**
	 * Maximum of the transaction log
	 *
	 * @var integer
	 */
	protected $maximum_log = 64;
	/**
	 * Hostname or IP address of remote server
	 *
	 * @var string
	 */
	protected $_host;
	/**
	 * Port number of connection
	 *
	 * @var integer
	 */
	protected $_port;
	/**
	 * Instance of Mail_Bank_Zend_Validate to check hostnames
	 *
	 * @var Mail_Bank_Zend_Validate
	 */
	protected $valid_host;
	/**
	 * Socket connection resource
	 *
	 * @var resource
	 */
	protected $_socket;
	/**
	 * Last request sent to server
	 *
	 * @var string
	 */
	protected $_request;
	/**
	 * Array of server responses to last request
	 *
	 * @var array
	 */
	protected $_response;
	/**
	 * String template for parsing server responses using sscanf (default: 3 digit code and response string)
	 *
	 * @var resource
	 * @deprecated Since 1.10.3
	 */
	protected $_template = '%d%s';
	/**
	 * Log of mail requests and server responses for a session
	 *
	 * @var array
	 */
	private $_log = array();
	/**
	 * Constructor.
	 *
	 * @param  string  $host OPTIONAL Hostname of remote connection (default: 127.0.0.1).
	 * @param  integer $port OPTIONAL Port number (default: null).
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return void
	 */
	public function __construct( $host = '127.0.0.1', $port = null ) {
		$this->valid_host = new Mail_Bank_Zend_Validate();
		$this->valid_host->addValidator( new Mail_Bank_Zend_Validate_Hostname( Mail_Bank_Zend_Validate_Hostname::ALLOW_ALL ) );

		if ( ! $this->valid_host->is_valid( $host ) ) {
			/** Mail Protocol Exception Included.

		 * @see Mail_Bank_Zend_Mail_Protocol_Exception
		 */
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( join( ', ', $this->valid_host->get_messages() ) );
		}

		$this->_host = $host;
		$this->_port = $port;
	}
	/**
	 * Class destructor to cleanup open resources
	 *
	 * @return void
	 */
	public function __destruct() {
		$this->_disconnect();
	}
	/**
	 * Set the maximum log size
	 *
	 * @param integer $maximum_log Maximum log size.
	 * @return void
	 */
	public function set_maximum_log( $maximum_log ) {
		$this->maximum_log = (int) $maximum_log;
	}
	/**
	 * Get the maximum log size
	 *
	 * @return int the maximum log size
	 */
	public function get_maximum_log() {
		return $this->maximum_log;
	}
	/**
	 * Create a connection to the remote host
	 *
	 * Concrete adapters for this class will implement their own unique connect scripts, using the connect() method to create the socket resource.
	 */
	abstract public function connect();
	/**
	 * Retrieve the last client request
	 *
	 * @return string
	 */
	public function get_request() {
		return $this->_request;
	}
	/**
	 * Retrieve the last server response
	 *
	 * @return array
	 */
	public function get_response() {
		return $this->_response;
	}
	/**
	 * Retrieve the transaction log
	 *
	 * @return string
	 */
	public function get_log() {
		return implode( '', $this->_log );
	}
	/**
	 * Reset the transaction log
	 *
	 * @return void
	 */
	public function reset_log() {
		$this->_log = array();
	}
	/**
	 * Add the transaction log
	 *
	 * @param  string $value new transaction.
	 * @return void
	 */
	protected function add_log( $value ) {
		if ( $this->maximum_log >= 0 && count( $this->_log ) >= $this->maximum_log ) {
			array_shift( $this->_log );
		}

		$this->_log[] = $value;
	}
	/**
	 * Connect to the server using the supplied transport and target
	 *
	 * An example $remote string may be 'tcp://mail.example.com:25' or 'ssh://hostname.com:2222'
	 *
	 * @param  string $remote Remote.
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return boolean
	 */
	protected function _connect( $remote ) {// @codingStandardsIgnoreLine.
		$error_num = 0;
		$error_str = '';

		// open connection.
		$this->_socket = stream_socket_client( $remote, $error_num, $error_str, self::TIMEOUT_CONNECTION );

		if ( false === $this->_socket ) {
			if ( 0 == $error_num ) {// WPCS: loose comparison ok.
				$error_str = 'Could not open socket';
			}
			/** Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( $error_str );
		}
		$result = $this->set_stream_timeout( self::TIMEOUT_CONNECTION );
		if ( false === $result ) {
			/** Mail Protocol Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'Could not set stream timeout' );
		}

		return $result;
	}
	/**
	 * Disconnect from remote host and free resource
	 *
	 * @return void
	 */
	protected function _disconnect() {// @codingStandardsIgnoreLine
		if ( is_resource( $this->_socket ) ) {
			fclose( $this->_socket );// @codingStandardsIgnoreLine
		}
	}
	/**
	 * Send the given request followed by a LINEEND to the server.
	 *
	 * @param  string $request MANDATORY.
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return integer|boolean Number of bytes written to remote host
	 */
	protected function send( $request ) {
		if ( ! is_resource( $this->_socket ) ) {
			/** Mail Protocol Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'No connection has been established to ' . $this->_host );
		}

		$this->_request = $request;

		$result = fwrite( $this->_socket, $request . self::EOL );// @codingStandardsIgnoreLine.

		// Save request to internal log.
		$this->add_log( $request . self::EOL );

		if ( false === $result ) {
			/** Mail Protocol Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception.
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'Could not send request to ' . $this->_host );
		}

		return $result;
	}
	/** Function Declaration.
	 * Get a line from the stream.
	 *
	 * @param integer $timeout Per-request timeout value if applicable.
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception here.
	 * @return string
	 */
	protected function receive( $timeout = null ) {
		if ( ! is_resource( $this->_socket ) ) {
			/** Mail Protocol Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'No connection has been established to ' . $this->_host );
		}

		// Adapters may wish to supply per-commend timeouts according to appropriate RFC.
		if ( null !== $timeout ) {
			$this->set_stream_timeout( $timeout );
		}

		// Retrieve response.
		$reponse = fgets( $this->_socket, 1024 );

		// Save request to internal log.
		$this->add_log( $reponse );

		// Check meta data to ensure connection is still valid.
		$info = stream_get_meta_data( $this->_socket );

		if ( ! empty( $info['timed_out'] ) ) {
			/** Mail Protocol Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( $this->_host . ' has timed out' );
		}

		if ( false === $reponse ) {
			/** Mail Protocol Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( 'Could not read from ' . $this->_host );
		}

		return $reponse;
	}
	/** Function Declaration.
	 * Parse server response for successful codes
	 *
	 * Read the response from the stream and check for expected return code.
	 * Throws a Mail_Bank_Zend_Mail_Protocol_Exception if an unexpected code is returned.
	 *
	 * @param  string|array $code One or more codes that indicate a successful response.
	 * @param  string|array $timeout OPTIONAL.
	 * @throws Mail_Bank_Zend_Mail_Protocol_Exception Throws Exception.
	 * @return string Last line of response string.
	 */
	protected function expect( $code, $timeout = null ) {
		$this->_response = array();
		$cmd             = '';
		$more            = '';
		$msg             = '';
		$err_msg         = '';

		if ( ! is_array( $code ) ) {
			$code = array( $code );
		}

		do {
			$result                 = $this->receive( $timeout );
			$this->_response[]      = $result;
			list($cmd, $more, $msg) = preg_split( '/([\s-]+)/', $result, 2, PREG_SPLIT_DELIM_CAPTURE );

			if ( '' !== $err_msg ) {
				$err_msg .= ' ' . $msg;
			} elseif ( null === $cmd || ! in_array( $cmd, $code ) ) {// @codingStandardsIgnoreLine.
				$err_msg = $msg;
			}
		} while ( strpos( $more, '-' ) === 0 ); // The '-' message prefix indicates an information string instead of a response string.

		if ( '' !== $err_msg ) {
			/** Mail Protocol Exception File Included.

			* @see Mail_Bank_Zend_Mail_Protocol_Exception
			*/
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-exception.php';
			}

			throw new Mail_Bank_Zend_Mail_Protocol_Exception( $err_msg, $cmd );
		}

		return $msg;
	}
	/**
	 * Set stream timeout
	 *
	 * @param integer $timeout MANDATORY.
	 * @return boolean
	 */
	protected function set_stream_timeout( $timeout ) {
		return stream_set_timeout( $this->_socket, $timeout );
	}
}
