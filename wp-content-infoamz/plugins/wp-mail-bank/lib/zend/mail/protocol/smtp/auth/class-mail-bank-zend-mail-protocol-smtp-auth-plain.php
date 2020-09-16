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

/** Zend Mail Protocol SMTP File Included.

 * @see Mail_Bank_Zend_Mail_Protocol_Smtp
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-smtp.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/mail/protocol/class-mail-bank-zend-mail-protocol-smtp.php';
}
/**
 * Performs PLAIN authentication
 *
 * @category    Zend
 * @package  Mail_Bank_Zend_Mail
 * @subpackage Protocol
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license  http://framework.zend.com/license/new-bsd    New BSD License
 */
class Mail_Bank_Zend_Mail_Protocol_Smtp_Auth_Plain extends Mail_Bank_Zend_Mail_Protocol_Smtp {
	/**
	 * PLAIN username
	 *
	 * @var string
	 */
	protected $_username;
	/**
	 * PLAIN password
	 *
	 * @var string
	 */
	protected $_password;
	/**
	 * Constructor.
	 *
	 * @param  string $host  (Default: 127.0.0.1).
	 * @param  int    $port  (Default: null).
	 * @param  array  $config Auth-specific parameters.
	 * @return void
	 */
	public function __construct( $host = '127.0.0.1', $port = null, $config = null ) {
		if ( is_array( $config ) ) {
			if ( isset( $config['username'] ) ) {
				$this->_username = $config['username'];
			}
			if ( isset( $config['password'] ) ) {
				$this->_password = $config['password'];
			}
		}

		parent::__construct( $host, $port, $config );
	}
	/**
	 * Perform PLAIN authentication with supplied credentials
	 *
	 * @return void
	 */
	public function auth() {
		// Ensure AUTH has not already been initiated.
		parent::auth();

		$this->send( 'AUTH PLAIN' );
		$this->expect( 334 );
		$this->send( base64_encode( "\0" . $this->_username . "\0" . $this->_password ) );
		$this->expect( 235 );
		$this->_auth = true;
	}
}
