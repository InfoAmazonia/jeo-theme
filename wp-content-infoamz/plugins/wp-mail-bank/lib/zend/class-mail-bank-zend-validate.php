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

if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-interface.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-interface.php';
}

/** Mail_Bank_Zend_Validate class starts from here.

 * @see Mail_Bank_Zend_Validate_Interface
 */
class Mail_Bank_Zend_Validate implements Mail_Bank_Zend_Validate_Interface {
	/**
	 * Validator chain
	 *
	 * @var array
	 */
	protected $_validators = array();
	/**
	 * Array of validation failure messages
	 *
	 * @var array
	 */
	protected $_messages = array();
	/**
	 * Default Namespaces
	 *
	 * @var array
	 */
	protected static $_default_namespaces = array();
	/**
	 * Array of validation failure message codes
	 *
	 * @var array
	 * @deprecated Since 1.5.0
	 */
	protected $_errors = array();

	/**
	 * Adds a validator to the end of the chain
	 *
	 * If $break_chain_on_failure is true, then if the validator fails, the next validator in the chain,
	 * if one exists, will not be executed.
	 * Variable declaration starts here.
	 *
	 * @param Mail_Bank_Zend_Validate_Interface $validator MANDATORY.
	 * @param boolean                           $break_chain_on_failure OPTIONAL.
	 * @return Mail_Bank_Zend_Validate Provides a fluent interface
	 */
	public function addValidator( Mail_Bank_Zend_Validate_Interface $validator, $break_chain_on_failure = false ) {
		$this->_validators[] = array(
			'instance'            => $validator,
			'breakChainOnFailure' => (boolean) $break_chain_on_failure,
		);
		return $this;
	}
	/**
	 * Returns true if and only if $value passes all validations in the chain
	 *
	 * Validators are run in the order in which they were added to the chain (FIFO).
	 *
	 * @param  mixed $value  MANDATORY.
	 * @return boolean
	 */
	public function is_valid( $value ) {
		$this->_messages = array();
		$this->_errors   = array();
		$result          = true;
		foreach ( $this->_validators as $element ) {
			$validator = $element['instance'];
			if ( $validator->is_valid( $value ) ) {
				continue;
			}
			$result          = false;
			$messages        = $validator->get_messages();
			$this->_messages = array_merge( $this->_messages, $messages );
			$this->_errors   = array_merge( $this->_errors, array_keys( $messages ) );
			if ( $element['breakChainOnFailure'] ) {
				break;
			}
		}
		return $result;
	}
	/**
	 * Defined by Mail_Bank_Zend_Validate_Interface
	 *
	 * Returns array of validation failure messages
	 *
	 * @return array
	 */
	public function get_messages() {
		return $this->_messages;
	}
	/**
	 * Defined by Mail_Bank_Zend_Validate_Interface
	 *
	 * Returns array of validation failure message codes
	 *
	 * @return array
	 * @deprecated Since 1.5.0
	 */
	public function getErrors() {
		return $this->_errors;
	}
	/**
	 * Returns the set default namespaces
	 *
	 * @return array
	 */
	public static function getDefaultNamespaces() {
		return self::$_default_namespaces;
	}
	/**
	 * Sets new default namespaces
	 *
	 * @param array|string $namespace MANDATORY.
	 */
	public static function setDefaultNamespaces( $namespace ) {
		if ( ! is_array( $namespace ) ) {
			$namespace = array( (string) $namespace );
		}

		self::$_default_namespaces = $namespace;
	}
	/**
	 * Adds a new default namespace
	 *
	 * @param array|string $namespace MANDATORY.
	 */
	public static function addDefaultNamespaces( $namespace ) {
		if ( ! is_array( $namespace ) ) {
			$namespace = array( (string) $namespace );
		}

		self::$_default_namespaces = array_unique( array_merge( self::$_default_namespaces, $namespace ) );
	}
	/**
	 * Returns true when defaultNamespaces are set
	 *
	 * @return boolean
	 */
	public static function hasDefaultNamespaces() {
		return ( ! empty( self::$_default_namespaces ) );
	}
	/** Is Function.

	 * @param  mixed $value MANDATORY.
	 * @param  mixed $class_base_name MANDATORY.
	 * @param  array $args OPTIONAL.
	 * @param  mixed $namespaces OPTIONAL.
	 * @return boolean
	 * @throws Mail_Bank_Zend_Validate_Exception Throws zend validate exception.
	 * @throws Exception Throws exception.
	 */
	public static function is( $value, $class_base_name, array $args = array(), $namespaces = array() ) {
		$namespaces = array_merge( (array) $namespaces, self::$_default_namespaces, array( 'Mail_Bank_Zend_Validate' ) );
		$class_name = ucfirst( $class_base_name );
		try {
			if ( ! class_exists( $class_name, false ) ) {
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php';
				}

				foreach ( $namespaces as $namespace ) {
					$class = $namespace . '_' . $class_name;
					$file  = str_replace( '_', DIRECTORY_SEPARATOR, $class ) . '.php';
					if ( Mail_Bank_Zend_Loader::is_file_readable( $file ) ) {
						Mail_Bank_Zend_Loader::load_class( $class );
						$class_name = $class;
						break;
					}
				}
			}

			$class = new ReflectionClass( $class_name );
			if ( $class->implementsInterface( 'Mail_Bank_Zend_Validate_Interface' ) ) {
				if ( $class->hasMethod( '__construct' ) ) {
					$keys    = array_keys( $args );
					$numeric = false;
					foreach ( $keys as $key ) {
						if ( is_numeric( $key ) ) {
							$numeric = true;
							break;
						}
					}

					if ( $numeric ) {
						$object = $class->newInstanceArgs( $args );
					} else {
						$object = $class->newInstance( $args );
					}
				} else {
					$object = $class->newInstance();
				}

				return $object->is_valid( $value );
			}
		} catch ( Mail_Bank_Zend_Validate_Exception $ze ) {
			// if there is an exception while validating throw it.
			throw $ze;
		} catch ( Exception $e ) {
			throw $e;
			// fallthrough and continue for missing validation classes.
		}
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php';
		}

		throw new Mail_Bank_Zend_Validate_Exception( "Validate class not found from basename '$class_base_name'" );
	}
	/**
	 * Returns the maximum allowed message length
	 *
	 * @return integer
	 */
	public static function getMessageLength() {
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php';
		}

		return Mail_Bank_Zend_Validate_Abstract::getMessageLength();
	}
	/**
	 * Sets the maximum allowed message length
	 *
	 * @param integer $length sets length.
	 */
	public static function setMessageLength( $length = -1 ) {
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php';
		}

		Mail_Bank_Zend_Validate_Abstract::setMessageLength( $length );
	}
	/**
	 * Gets a default translation object for all validation objects.
	 *
	 * @param Mail_Bank_Zend_Translate|Mail_Bank_Zend_Translate_Adapter|null $translator sets translator.
	 * @Returns the default translation object
	 *
	 * @return getDefaultTranslator
	 */
	public static function getDefaultTranslator( $translator = null ) {
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php';
		}

		return Mail_Bank_Zend_Validate_Abstract::getDefaultTranslator();
	}
	/**
	 * Sets a default translation object for all validation objects.
	 *
	 * @param Mail_Bank_Zend_Translate|Mail_Bank_Zend_Translate_Adapter|null $translator sets translator.
	 */
	public static function setDefaultTranslator( $translator = null ) {
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-abstract.php';
		}

		Mail_Bank_Zend_Validate_Abstract::setDefaultTranslator( $translator );
	}
}
