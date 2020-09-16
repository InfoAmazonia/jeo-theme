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
 * @package Mail_Bank_Zend_Validate
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/** Include Abstract File

 * @see Mail_Bank_Zend_Validate_Abstract
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php';
}
/** Class Begins here

 * @category Zend
 * @package Mail_Bank_Zend_Validate
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class Mail_Bank_Zend_Validate_Ip extends Mail_Bank_Zend_Validate_Abstract {
	const INVALID        = 'ipInvalid';
	const NOT_IP_ADDRESS = 'notIpAddress';
	/** Variable Declaration here.

	 * @var array
	 */
	protected $message_templates = array(
		self::INVALID        => 'Invalid type given. String expected',
		self::NOT_IP_ADDRESS => "'%value%' does not appear to be a valid IP address",
	);
	/**
	 * Internal options.
	 *
	 * @var array
	 */
	protected $_options = array(
		'allowipv6' => true,
		'allowipv4' => true,
	);
	/**
	 * Sets validator options
	 *
	 * @param array $options OPTIONAL Options to set, see the manual for all available options.
	 */
	public function __construct( $options = array() ) {
		if ( $options instanceof Mail_Bank_Zend_Config ) {
			$options = $options->toArray();
		} elseif ( ! is_array( $options ) ) {
			$options           = func_get_args();
			$temp['allowipv6'] = array_shift( $options );
			if ( ! empty( $options ) ) {
				$temp['allowipv4'] = array_shift( $options );
			}

			$options = $temp;
		}

		$options += $this->_options;
		$this->setOptions( $options );
	}
	/**
	 * Returns all set options
	 *
	 * @return array
	 */
	public function getOptions() {
		return $this->_options;
	}
	/**
	 * Sets the options for this validator
	 *
	 * @param array $options MANDATORY.
	 * @throws Mail_Bank_Zend_Validate_Exception Throws Exception.
	 * @return Mail_Bank_Zend_Validate_Ip
	 */
	public function setOptions( $options ) {
		if ( array_key_exists( 'allowipv6', $options ) ) {
			$this->_options['allowipv6'] = (boolean) $options['allowipv6'];
		}

		if ( array_key_exists( 'allowipv4', $options ) ) {
			$this->_options['allowipv4'] = (boolean) $options['allowipv4'];
		}

		if ( ! $this->_options['allowipv4'] && ! $this->_options['allowipv6'] ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php';
			}

			throw new Mail_Bank_Zend_Validate_Exception( 'Nothing to validate. Check your options' );
		}

		return $this;
	}
	/**
	 * Defined by Mail_Bank_Zend_Validate_Interface
	 *
	 * Returns true if and only if $value is a valid IP address
	 *
	 * @param    mixed $value MANDATORY.
	 * @return boolean
	 */
	public function is_valid( $value ) {
		if ( ! is_string( $value ) ) {
			$this->_error( self::INVALID );
			return false;
		}

		$this->set_value( $value );
		if ( ( $this->_options['allowipv4'] && ! $this->_options['allowipv6'] && ! $this->validate_ipv4( $value ) ) ||
		( ! $this->_options['allowipv4'] && $this->_options['allowipv6'] && ! $this->validate_ipv6( $value ) ) ||
		( $this->_options['allowipv4'] && $this->_options['allowipv6'] && ! $this->validate_ipv4( $value ) && ! $this->validate_ipv6( $value ) ) ) {
			$this->_error( self::NOT_IP_ADDRESS );
			return false;
		}

		return true;
	}
	/**
	 * Validates an IPv4 address
	 *
	 * @param string $value MANDATORY.
	 * @return bool
	 */
	protected function validate_ipv4( $value ) {
		$ip2long = ip2long( $value );
		if ( false === $ip2long ) {
			return false;
		}

		return long2ip( $ip2long ) === $value;
	}
	/**
	 * Validates an IPv6 address
	 *
	 * @param    string $value Value to check against.
	 * @return boolean True when $value is a valid ipv6 address.
	 *  False otherwise
	 */
	protected function validate_ipv6( $value ) {
		if ( strlen( $value ) < 3 ) {
			return '::' === $value;
		}

		if ( strpos( $value, '.' ) ) {
			$lastcolon = strrpos( $value, ':' );
			if ( ! ( $lastcolon && $this->validate_ipv4( substr( $value, $lastcolon + 1 ) ) ) ) {
				return false;
			}
			$value = substr( $value, 0, $lastcolon ) . ':0:0';
		}

		if ( strpos( $value, '::' ) === false ) {
			return preg_match( '/\A(?:[a-f0-9]{1,4}:){7}[a-f0-9]{1,4}\z/i', $value );
		}

		$colon_count = substr_count( $value, ':' );
		if ( $colon_count < 8 ) {
			return preg_match( '/\A(?::|(?:[a-f0-9]{1,4}:)+):(?:(?:[a-f0-9]{1,4}:)*[a-f0-9]{1,4})?\z/i', $value );
		}

		// Special case with ending or starting double colon.
		if ( 8 === $colon_count ) {
			return preg_match( '/\A(?:::)?(?:[a-f0-9]{1,4}:){6}[a-f0-9]{1,4}(?:::)?\z/i', $value );
		}

		return false;
	}
}
