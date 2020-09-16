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
 * @package Mail_Bank_Zend_Registry
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/**
 * Generic storage class helps to manage global data.
 *
 * @category Zend
 * @package Mail_Bank_Zend_Registry
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class Mail_Bank_Zend_Registry extends ArrayObject {
	/**
	 * Class name of the singleton registry object.
	 *
	 * @var string
	 */
	private static $_registry_class_name = 'Mail_Bank_Zend_Registry';
	/**
	 * Registry object provides storage for shared objects.
	 *
	 * @var Mail_Bank_Zend_Registry
	 */
	private static $_registry = null;
	/**
	 * Retrieves the default registry instance.
	 *
	 * @return Mail_Bank_Zend_Registry
	 */
	public static function getInstance() {
		if ( nul === self::$_registry ) {
			self::init();
		}

		return self::$_registry;
	}
	/**
	 * Set the default registry instance to a specified instance.
	 *
	 * @param Mail_Bank_Zend_Registry $registry An object instance of type Mail_Bank_Zend_Registry,
	 *    or a subclass.
	 * @return void
	 * @throws Mail_Bank_Zend_Exception If registry is already initialized.
	 */
	public static function setInstance( Mail_Bank_Zend_Registry $registry ) {
		if ( null !== self::$_registry ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			}

			throw new Mail_Bank_Zend_Exception( 'Registry is already initialized' );
		}

		self::setClassName( get_class( $registry ) );
		self::$_registry = $registry;
	}
	/**
	 * Initialize the default registry instance.
	 *
	 * @return void
	 */
	protected static function init() {
		self::setInstance( new self::$_registry_class_name() );
	}
	/**
	 * Set the class name to use for the default registry instance.
	 * Does not affect the currently initialized instance, it only applies
	 * for the next time you instantiate.
	 *
	 * @param string $_registry_class_name Name of the Registry Class.
	 * @return void
	 * @throws Mail_Bank_Zend_Exception If the registry is initialized or if the
	 *    class name is not valid.
	 */
	public static function setClassName( $_registry_class_name = 'Mail_Bank_Zend_Registry' ) {
		if ( null !== self::$_registry ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			}

			throw new Mail_Bank_Zend_Exception( 'Registry is already initialized' );
		}

		if ( ! is_string( $_registry_class_name ) ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			}

			throw new Mail_Bank_Zend_Exception( 'Argument is not a class name' );
		}

		/** Includes the Zend loader Class File.

		 * @see Mail_Bank_Zend_Loader
		 */
		if ( ! class_exists( $_registry_class_name ) ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php';
			}

			Mail_Bank_Zend_Loader::load_class( $_registry_class_name );
		}

		self::$_registry_class_name = $_registry_class_name;
	}
	/**
	 * Unset the default registry instance.
	 * Primarily used in tearDown() in unit tests.
	 *
	 * @returns void
	 */
	public static function unsetInstance() {
		self::$_registry = null;
	}
	/**
	 * Getter method, basically same as offsetGet().
	 *
	 * This method can be called from an object of type Mail_Bank_Zend_Registry, or it
	 * can be called statically. In the latter case, it uses the default
	 * static instance stored in the class.
	 *
	 * @param string $index - get the value associated with $index.
	 * @return mixed
	 * @throws Mail_Bank_Zend_Exception If no entry is registered for $index.
	 */
	public static function get( $index ) {
		$instance = self::getInstance();

		if ( ! $instance->offsetExists( $index ) ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			}

			throw new Mail_Bank_Zend_Exception( "No entry is registered for key '$index'" );
		}

		return $instance->offsetGet( $index );
	}
	/**
	 * Setter method, basically same as offsetSet().
	 *
	 * This method can be called from an object of type Mail_Bank_Zend_Registry, or it
	 * can be called statically. In the latter case, it uses the default
	 * static instance stored in the class.
	 *
	 * @param string $index The location in the ArrayObject in which to store
	 *    the value.
	 * @param mixed  $value The object to store in the ArrayObject.
	 * @return void
	 */
	public static function set( $index, $value ) {
		$instance = self::getInstance();
		$instance->offsetSet( $index, $value );
	}
	/**
	 * Returns TRUE if the $index is a named value in the registry,
	 * or FALSE if $index was not found in the registry.
	 *
	 * @param  string $index MANDATORY.
	 * @return boolean
	 */
	public static function isRegistered( $index ) {
		if ( null === self::$_registry ) {
			return false;
		}
		return self::$_registry->offsetExists( $index );
	}
	/**
	 * Constructs a parent ArrayObject with default
	 * ARRAY_AS_PROPS to allow acces as an object
	 *
	 * @param array   $array data array.
	 * @param integer $flags ArrayObject flags.
	 */
	public function __construct( $array = array(), $flags = parent::ARRAY_AS_PROPS ) {// @codingStandardsIgnoreLine.
		parent::__construct( $array, $flags );
	}
	/** Offset Exists Function.

	 * @param string $index MANDATORY.
	 * @returns mixed
	 *
	 * Workaround for http://bugs.php.net/bug.php?id=40442 (ZF-960).
	 */
	public function offsetExists( $index ) {
		return array_key_exists( $index, $this );
	}
}
