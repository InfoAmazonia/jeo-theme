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
/** Interface File Included

 * @see Mail_Bank_Zend_Validate_Interface
 */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-interface.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-interface.php';
}

/** Class Begins here.

 * @category Zend
 * @package Mail_Bank_Zend_Validate
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
abstract class Mail_Bank_Zend_Validate_Abstract implements Mail_Bank_Zend_Validate_Interface {
	/**
	 * The value to be validated
	 *
	 * @var mixed
	 */
	protected $_value;
	/**
	 * Additional variables available for validation failure messages
	 *
	 * @var array
	 */
	protected $message_variables = array();
	/**
	 * Validation failure message template definitions
	 *
	 * @var array
	 */
	protected $message_templates = array();
	/**
	 * Array of validation failure messages
	 *
	 * @var array
	 */
	protected $_messages = array();
	/**
	 * Flag indidcating whether or not value should be obfuscated in error
	 * messages
	 *
	 * @var bool
	 */
	protected $obscure_value = false;
	/**
	 * Array of validation failure message codes
	 *
	 * @var array
	 * @deprecated Since 1.5.0
	 */
	protected $_errors = array();
	/**
	 * Translation object
	 *
	 * @var Mail_Bank_Zend_Translate
	 */
	protected $_translator;
	/**
	 * Default translation object for all validate objects
	 *
	 * @var Mail_Bank_Zend_Translate
	 */
	protected static $default_translator;
	/**
	 * Is translation disabled?
	 *
	 * @var Boolean
	 */
	protected $translator_disabled = false;
	/**
	 * Limits the maximum returned length of a error message
	 *
	 * @var Integer
	 */
	protected static $message_length = -1;
	/**
	 * Returns array of validation failure messages
	 *
	 * @return array
	 */
	public function get_messages() {
		return $this->_messages;
	}
	/**
	 * Returns an array of the names of variables that are used in constructing validation failure messages
	 *
	 * @return array
	 */
	public function getMessageVariables() {
		return array_keys( $this->message_variables );
	}
	/**
	 * Returns the message templates from the validator
	 *
	 * @return array
	 */
	public function getMessageTemplates() {
		return $this->message_templates;
	}
	/**
	 * Sets the validation failure message template for a particular key.
	 *
	 * @param    string $message_string MANDATORY.
	 * @param    string $message_key  OPTIONAL.
	 * @return Mail_Bank_Zend_Validate_Abstract Provides a fluent interface.
	 * @throws Mail_Bank_Zend_Validate_Exception Throws Exception.
	 */
	public function setMessage( $message_string, $message_key = null ) {
		if ( null === $message_key ) {
			$keys = array_keys( $this->message_templates );
			foreach ( $keys as $key ) {
				$this->setMessage( $message_string, $key );
			}
			return $this;
		}

		if ( ! isset( $this->message_templates[ $message_key ] ) ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php';
			}

			throw new Mail_Bank_Zend_Validate_Exception( "No message template exists for key '$message_key'" );
		}

		$this->message_templates[ $message_key ] = $message_string;
		return $this;
	}
	/**
	 * Sets validation failure message templates given as an array, where the array keys are the message keys,
	 * and the array values are the message template strings.
	 *
	 * @param    array $messages MANDATORY.
	 * @return Mail_Bank_Zend_Validate_Abstract
	 */
	public function setMessages( array $messages ) {
		foreach ( $messages as $key => $message ) {
			$this->setMessage( $message, $key );
		}
		return $this;
	}
	/**
	 * Magic function returns the value of the requested property, if and only if it is the value or a
	 * message variable.
	 *
	 * @param    string $property MANDATORY.
	 * @return mixed
	 * @throws Mail_Bank_Zend_Validate_Exception Throws Exception.
	 */
	public function __get( $property ) {
		if ( 'value' === $property ) {
			return $this->_value;
		}
		if ( array_key_exists( $property, $this->message_variables ) ) {
			return $this->{$this->message_variables[ $property ]};
		}
		/** File Included

		* @see Mail_Bank_Zend_Validate_Exception
		*/
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php';
		}

		throw new Mail_Bank_Zend_Validate_Exception( "No property exists by the name '$property'" );
	}
	/**
	 * Constructs and returns a validation failure message with the given message key and value.
	 *
	 * Returns null if and only if $message_key does not correspond to an existing template.
	 *
	 * If a translator is available and a translation exists for $message_key,
	 * the translation will be used.
	 *
	 * @param    string $message_key MANDATORY.
	 * @param    string $value MANDATORY.
	 * @return string
	 */
	protected function create_message( $message_key, $value ) {
		if ( ! isset( $this->message_templates[ $message_key ] ) ) {
			return null;
		}

		$message    = $this->message_templates[ $message_key ];
		$translator = $this->getTranslator();
		if ( null !== $translator ) {
			if ( $translator->isTranslated( $message_key ) ) {
				$message = $translator->translate( $message_key );// @codingStandardsIgnoreLine.
			} else {
				$message = $translator->translate( $message );// @codingStandardsIgnoreLine.
			}
		}

		if ( is_object( $value ) ) {
			if ( ! in_array( '__toString', get_class_methods( $value ), true ) ) {
				$value = get_class( $value ) . ' object';
			} else {
				$value = $value->__toString();
			}
		} elseif ( is_array( $value ) ) {
			$value = $this->implode_recursive( $value );
		} else {
			$value = implode( (array) $value );
		}

		if ( $this->getObscureValue() ) {
			$value = str_repeat( '*', strlen( $value ) );
		}

		$message = str_replace( '%value%', $value, $message );
		foreach ( $this->message_variables as $ident => $property ) {
			$message = str_replace(
				"%$ident%", implode( ' ', (array) $this->$property ), $message
			);
		}

		$length = self::getMessageLength();
		if ( ( $length > -1 ) && ( strlen( $message ) > $length ) ) {
			$message = substr( $message, 0, ( self::getMessageLength() - 3 ) ) . '...';
		}

		return $message;
	}
	/**
	 * Joins elements of a multidimensional array
	 *
	 * @param array $pieces MANDATORY.
	 * @return string
	 */
	protected function implode_recursive( array $pieces ) {
		$values = array();
		foreach ( $pieces as $item ) {
			if ( is_array( $item ) ) {
				$values[] = $this->implode_recursive( $item );
			} else {
				$values[] = $item;
			}
		}

		return implode( ', ', $values );
	}
	/** Function Declaration

	 * @param    string $message_key MANDATORY.
	 * @param    string $value  OPTIONAL.
	 * @return void
	 */
	protected function _error( $message_key, $value = null ) {// @codingStandardsIgnoreLine.
		if ( null === $message_key ) {
			$keys        = array_keys( $this->message_templates );
			$message_key = current( $keys );
		}
		if ( null === $value ) {
			$value = $this->_value;
		}
		$this->_errors[]                 = $message_key;
		$this->_messages[ $message_key ] = $this->create_message( $message_key, $value );
	}
	/**
	 * Sets the value to be validated and clears the messages and errors arrays
	 *
	 * @param    mixed $value MANDATORY.
	 * @return void
	 */
	protected function set_value( $value ) {
		$this->_value    = $value;
		$this->_messages = array();
		$this->_errors   = array();
	}
	/**
	 * Returns array of validation failure message codes
	 *
	 * @return array
	 * @deprecated Since 1.5.0
	 */
	public function getErrors() {
		return $this->_errors;
	}
	/**
	 * Set flag indicating whether or not value should be obfuscated in messages
	 *
	 * @param bool $flag MANDATORY.
	 * @return Mail_Bank_Zend_Validate_Abstract
	 */
	public function setObscureValue( $flag ) {
		$this->obscure_value = (bool) $flag;
		return $this;
	}
	/**
	 * Retrieve flag indicating whether or not value should be obfuscated in
	 * messages
	 *
	 * @return bool
	 */
	public function getObscureValue() {
		return $this->obscure_value;
	}
	/**
	 * Set translation object
	 *
	 * @param Mail_Bank_Zend_Translate|Mail_Bank_Zend_Translate_Adapter|null $translator OPTIONAL.
	 * @throws Mail_Bank_Zend_Validate_Exception Throws Exception.
	 * @return Mail_Bank_Zend_Validate_Abstract
	 */
	public function setTranslator( $translator = null ) {
		if ( ( null === $translator ) || ( $translator instanceof Mail_Bank_Zend_Translate_Adapter ) ) {
			$this->_translator = $translator;
		} elseif ( $translator instanceof Mail_Bank_Zend_Translate ) {
			$this->_translator = $translator->getAdapter();
		} else {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php';
			}

			throw new Mail_Bank_Zend_Validate_Exception( 'Invalid translator specified' );
		}
		return $this;
	}
	/**
	 * Return translation object
	 *
	 * @return Mail_Bank_Zend_Translate_Adapter|null
	 */
	public function getTranslator() {
		if ( $this->translatorIsDisabled() ) {
			return null;
		}

		if ( null === $this->_translator ) {
			return self::getDefaultTranslator();
		}

		return $this->_translator;
	}
	/**
	 * Does this validator have its own specific translator?
	 *
	 * @return bool
	 */
	public function hasTranslator() {
		return (bool) $this->_translator;
	}
	/**
	 * Set default translation object for all validate objects
	 *
	 * @param    Mail_Bank_Zend_Translate|Mail_Bank_Zend_Translate_Adapter|null $translator OPTIONAL.
	 * @throws Mail_Bank_Zend_Validate_Exception Throws Exception.
	 */
	public static function setDefaultTranslator( $translator = null ) {
		if ( ( null === $translator ) || ( $translator instanceof Mail_Bank_Zend_Translate_Adapter ) ) {
			self::$default_translator = $translator;
		} elseif ( $translator instanceof Mail_Bank_Zend_Translate ) {
			self::$default_translator = $translator->getAdapter();
		} else {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/validate/class-mail-bank-zend-validate-exception.php';
			}

			throw new Mail_Bank_Zend_Validate_Exception( 'Invalid translator specified' );
		}
	}
	/**
	 * Get default translation object for all validate objects
	 *
	 * @return Mail_Bank_Zend_Translate_Adapter|null
	 */
	public static function getDefaultTranslator() {
		if ( null === self::$default_translator ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-registry.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-registry.php';
			}

			if ( Mail_Bank_Zend_Registry::isRegistered( 'Mail_Bank_Zend_Translate' ) ) {
				$translator = Mail_Bank_Zend_Registry::get( 'Mail_Bank_Zend_Translate' );
				if ( $translator instanceof Mail_Bank_Zend_Translate_Adapter ) {
					return $translator;
				} elseif ( $translator instanceof Mail_Bank_Zend_Translate ) {
					return $translator->getAdapter();
				}
			}
		}

		return self::$default_translator;
	}
	/**
	 * Is there a default translation object set?
	 *
	 * @return boolean
	 */
	public static function hasDefaultTranslator() {
		return (bool) self::$default_translator;
	}
	/**
	 * Indicate whether or not translation should be disabled
	 *
	 * @param    bool $flag MANDATORY.
	 * @return Mail_Bank_Zend_Validate_Abstract
	 */
	public function setDisableTranslator( $flag ) {
		$this->translator_disabled = (bool) $flag;
		return $this;
	}
	/**
	 * Is translation disabled?
	 *
	 * @return bool
	 */
	public function translatorIsDisabled() {
		return $this->translator_disabled;
	}
	/**
	 * Returns the maximum allowed message length
	 *
	 * @return integer
	 */
	public static function getMessageLength() {
		return self::$message_length;
	}
	/**
	 * Sets the maximum allowed message length
	 *
	 * @param integer $length MANDATORY.
	 */
	public static function setMessageLength( $length = -1 ) {
		self::$message_length = $length;
	}
}
