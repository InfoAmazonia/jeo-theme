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
 * @package Mail_Bank_Zend_Loader
 * @subpackage Autoloader
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @version $Id$
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/** Zend_Loader */
if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php' ) ) {
	require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-loader.php';
}
/** Class Begins here
 * Autoloader stack and namespace autoloader
 *
 * @uses Mail_Bank_Zend_Loader_Autoloader
 * @package Mail_Bank_Zend_Loader
 * @subpackage Autoloader
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */
class Mail_Bank_Zend_Loader_Autoloader {
	/** Variable Declaration

	 * @var Mail_Bank_Zend_Loader_Autoloader Singleton instance
	 */

	protected static $_instance;

	/** Variable Declaration

	 * @var array Concrete autoloader callback implementations
	 */

	protected $_autoloaders = array();

	/** Variable Declaration

	 * @var array Default autoloader callback
	 */

	protected $default_autoloader = array( 'Mail_Bank_Zend_Loader', 'load_class' );

	/** Variable Declaration

	 * @var bool Whether or not to act as a fallback autoloader
	 */
	protected $fallback_autoloader = false;
	/** Variable Declaration.

	 * @var array Callback for internal autoloader implementation
	 */

	protected $internal_autoloader;

	/** Variable Declaration.

	 * @var array Supported namespaces 'Zend' and 'ZendX' by default.
	 */

	protected $_namespaces = array(
		'Mail_Bank_Zend_' => true,
		'ZendX_'          => true,
	);

	/** Variable Declaration.

	 * @var array Namespace-specific autoloaders
	 */

	protected $namespace_autoloaders = array();

	/** Variable Declaration.

	 * @var bool Whether or not to suppress file not found warnings
	 */

	protected $suppress_not_found_warnings = false;

	/** Variable Declaration.
	 *
	 * @var null|string
	 */

	protected $zf_path;

	/** Function Declaration.

	 * Retrieve singleton instance
	 *
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public static function get_instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}
			return self::$_instance;
	}

	/** Function Declaration.
	 * Reset the singleton instance
	 *
	 * @return void
	 */
	public static function reset_instance() {
			self::$_instance = null;
	}
	/** Function Declaration.
	 * Autoload a class
	 *
	 * @param  string $class MANDATORY.
	 * @return bool
	 */
	public static function autoload( $class ) {
			$self = self::get_instance();

		foreach ( $self->get_class_autoloaders( $class ) as $autoloader ) {
			if ( $autoloader instanceof Mail_Bank_Zend_Loader_Autoloader_Interface ) {
				if ( $autoloader->autoload( $class ) ) {
					return true;
				}
			} elseif ( is_array( $autoloader ) ) {
				if ( call_user_func( $autoloader, $class ) ) {
					return true;
				}
			} elseif ( is_string( $autoloader ) || is_callable( $autoloader ) ) {
				if ( $autoloader( $class ) ) {
					return true;
				}
			}
		}
			return false;
	}

	/** Function Declaration.
	 * Set the default autoloader implementation
	 *
	 * @param  string|array $callback PHP callback.
	 * @return array|string
	 * @throws Mail_Bank_Zend_Loader_Exception Throws Exception.
	 */
	public function set_default_autoloader( $callback ) {
		if ( ! is_callable( $callback ) ) {
			throw new Mail_Bank_Zend_Loader_Exception( 'Invalid callback specified for default autoloader' );
		}

			$this->default_autoloader = $callback;
			return $this;
	}
	/** Function Declaration.
	 * Retrieve the default autoloader callback
	 *
	 * @return string|array PHP Callback
	 */
	public function get_default_autoloader() {
			return $this->default_autoloader;
	}

	/** Function Declaration.
	 * Set several autoloader callbacks at once.
	 *
	 * @param  array $autoloaders Array of PHP callbacks (or Mail_Bank_Zend_Loader_Autoloader_Interface implementations) to act as  autoloaders.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public function set_autoloaders( array $autoloaders ) {
			$this->_autoloaders = $autoloaders;
			return $this;
	}

	/** Function Declaration.
	 * Get attached autoloader implementations
	 *
	 * @return array
	 */
	public function get_autoloaders() {
			return $this->_autoloaders;
	}

	/**
	 * Return all autoloaders for a given namespace
	 *
	 * @param  string $namespace MANDATORY.
	 * @return array
	 */
	public function get_namespace_autoloaders( $namespace ) {
			$namespace = (string) $namespace;
		if ( ! array_key_exists( $namespace, $this->namespace_autoloaders ) ) {
			return array();
		}
			return $this->namespace_autoloaders[ $namespace ];
	}
	/**
	 * Register a namespace to autoload
	 *
	 * @param  string|array $namespace MANDATORY.
	 * @throws Mail_Bank_Zend_Loader_Exception Throws Exception.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public function register_namespace( $namespace ) {
		if ( is_string( $namespace ) ) {
			$namespace = (array) $namespace;
		} elseif ( ! is_array( $namespace ) ) {
			throw new Mail_Bank_Zend_Loader_Exception( 'Invalid namespace provided' );
		}

		foreach ( $namespace as $ns ) {
			if ( ! isset( $this->_namespaces[ $ns ] ) ) {
					$this->_namespaces[ $ns ] = true;
			}
		}
			return $this;
	}
	/**
	 * Unload a registered autoload namespace
	 *
	 * @param  string|array $namespace MANDATORY.
	 * @throws Mail_Bank_Zend_Loader_Exception Throws Exception.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public function unregister_namespace( $namespace ) {
		if ( is_string( $namespace ) ) {
			$namespace = (array) $namespace;
		} elseif ( ! is_array( $namespace ) ) {
			throw new Mail_Bank_Zend_Loader_Exception( 'Invalid namespace provided' );
		}

		foreach ( $namespace as $ns ) {
			if ( isset( $this->_namespaces[ $ns ] ) ) {
					unset( $this->_namespaces[ $ns ] );
			}
		}
			return $this;
	}

	/**
	 * Get a list of registered autoload namespaces
	 *
	 * @throws Mail_Bank_Zend_Loader_Exception Throws Exception.
	 * @return array
	 */
	public function get_registered_namespaces() {
			return array_keys( $this->_namespaces );
	}

	/**
	 * Get a list of registered autoload namespaces
	 *
	 * @param  string|array $spec MANDATORY.
	 * @param  string       $version OPTIONAL.
	 * @throws Mail_Bank_Zend_Loader_Exception Throws Exception.
	 * @return array
	 */
	public function set_zf_path( $spec, $version = 'latest' ) {
			$path = $spec;
		if ( is_array( $spec ) ) {
			if ( ! isset( $spec['path'] ) ) {
					throw new Mail_Bank_Zend_Loader_Exception( 'No path specified for ZF' );
			}
				$path = $spec['path'];
			if ( isset( $spec['version'] ) ) {
					$version = $spec['version'];
			}
		}

			$this->zf_path = $this->get_version_path( $path, $version );
			set_include_path(// @codingStandardsIgnoreLine.
				implode(
					PATH_SEPARATOR, array(
						$this->zf_path,
						get_include_path(),
					)
				)
			);
			return $this;
	}

	/**
	 * Get a list of registered autoload namespaces
	 *
	 * @return array
	 */
	public function get_zf_path() {
			return $this->zf_path;
	}

	/**
	 * Get or set the value of the "suppress not found warnings" flag
	 *
	 * @param  null|bool $flag OPTIONAL.
	 * @return bool|Mail_Bank_Zend_Loader_Autoloader Returns boolean if no argument is passed, object instance otherwise
	 */
	public function suppress_not_found_warnings( $flag = null ) {
		if ( null === $flag ) {
			return $this->suppress_not_found_warnings;
		}
			$this->suppress_not_found_warnings = (bool) $flag;
			return $this;
	}

	/**
	 * Indicate whether or not this autoloader should be a fallback autoloader
	 *
	 * @param  bool $flag MANDATORY.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public function set_fallback_autoloader( $flag ) {
			$this->fallback_autoloader = (bool) $flag;
			return $this;
	}

	/**
	 * Is this instance acting as a fallback autoloader?
	 *
	 * @return bool
	 */
	public function is_fallback_autoloader() {
			return $this->fallback_autoloader;
	}

	/**
	 * Get autoloaders to use when matching class
	 *
	 * Determines if the class matches a registered namespace, and, if so,
	 * returns only the autoloaders for that namespace. Otherwise, it returns
	 * all non-namespaced autoloaders.
	 *
	 * @param  string $class MANDATORY.
	 * @return array Array of autoloaders to use
	 */
	public function get_class_autoloaders( $class ) {
			$namespace   = false;
			$autoloaders = array();

			// Add concrete namespaced autoloaders.
		foreach ( array_keys( $this->namespace_autoloaders ) as $ns ) {
			if ( '' === $ns ) {
					continue;
			}
			if ( 0 === strpos( $class, $ns ) ) {
				if ( ( false === $namespace ) || ( strlen( $ns ) > strlen( $namespace ) ) ) {
					$namespace   = $ns;
					$autoloaders = $this->get_namespace_autoloaders( $ns );
				}
			}
		}

			// Add internal namespaced autoloader.
		foreach ( $this->get_registered_namespaces() as $ns ) {
			if ( 0 === strpos( $class, $ns ) ) {
					$namespace     = $ns;
					$autoloaders[] = $this->internal_autoloader;
					break;
			}
		}

			// Add non-namespaced autoloaders.
			$autoloaders_non_namespace = $this->get_namespace_autoloaders( '' );
		if ( count( $autoloaders_non_namespace ) ) {
			foreach ( $autoloaders_non_namespace as $ns ) {
					$autoloaders[] = $ns;
			}
			unset( $autoloaders_non_namespace );
		}

			// Add fallback autoloader.
		if ( ! $namespace && $this->is_fallback_autoloader() ) {
			$autoloaders[] = $this->internal_autoloader;
		}

			return $autoloaders;
	}
	/**
	 * Add an autoloader to the beginning of the stack.
	 *
	 * @param  object|array|string $callback PHP callback or Mail_Bank_Zend_Loader_Autoloader_Interface implementation.
	 * @param  string|array        $namespace Specific namespace(s) under which to register callback.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public function unshift_autoloader( $callback, $namespace = '' ) {
			$autoloaders = $this->get_autoloaders();
			array_unshift( $autoloaders, $callback );
			$this->set_autoloaders( $autoloaders );

			$namespace = (array) $namespace;
		foreach ( $namespace as $ns ) {
			$autoloaders = $this->get_namespace_autoloaders( $ns );
			array_unshift( $autoloaders, $callback );
			$this->set_namespace_autoloaders( $autoloaders, $ns );
		}

			return $this;
	}
	/**
	 * Append an autoloader to the autoloader stack.
	 *
	 * @param  object|array|string $callback PHP callback or Mail_Bank_Zend_Loader_Autoloader_Interface implementation.
	 * @param  string|array        $namespace Specific namespace(s) under which to register callback.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public function push_autoloader( $callback, $namespace = '' ) {
			$autoloaders = $this->get_autoloaders();
			array_push( $autoloaders, $callback );
			$this->set_autoloaders( $autoloaders );

			$namespace = (array) $namespace;
		foreach ( $namespace as $ns ) {
			$autoloaders = $this->get_namespace_autoloaders( $ns );
			array_push( $autoloaders, $callback );
			$this->set_namespace_autoloaders( $autoloaders, $ns );
		}

			return $this;
	}
	/**
	 * Remove an autoloader from the autoloader stack.
	 *
	 * @param  object|array|string $callback PHP callback or Mail_Bank_Zend_Loader_Autoloader_Interface implementation.
	 * @param  null|string|array   $namespace Specific namespace(s) from which to remove autoloader.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	public function remove_autoloader( $callback, $namespace = null ) {
		if ( null === $namespace ) {
			$autoloaders = $this->get_autoloaders();
			$index       = array_search( $callback, $autoloaders, true );
			if ( false !== $index ) {
					unset( $autoloaders[ $index ] );
					$this->set_autoloaders( $autoloaders );
			}

			foreach ( $this->namespace_autoloaders as $ns => $autoloaders ) {
				$index = array_search( $callback, $autoloaders, true );
				if ( false !== $index ) {
					unset( $autoloaders[ $index ] );
					$this->set_namespace_autoloaders( $autoloaders, $ns );
				}
			}
		} else {
			$namespace = (array) $namespace;
			foreach ( $namespace as $ns ) {
					$autoloaders = $this->get_namespace_autoloaders( $ns );
					$index       = array_search( $callback, $autoloaders, true );
				if ( false !== $index ) {
					unset( $autoloaders[ $index ] );
					$this->set_namespace_autoloaders( $autoloaders, $ns );
				}
			}
		}

			return $this;
	}
	/**
	 * Constructor
	 *
	 * Registers instance with spl_autoload stack
	 *
	 * @return void
	 */
	protected function __construct() {
			spl_autoload_register( array( __CLASS__, 'autoload' ) );
			$this->internal_autoloader = array( $this, '_autoload' );
	}

	/**
	 * Internal autoloader implementation
	 *
	 * @param  string $class MANDATORY.
	 * @return bool
	 */
	protected function _autoload( $class ) {// @codingStandardsIgnoreLine.
			$callback = $this->get_default_autoloader();
		try {
			if ( $this->suppress_not_found_warnings() ) {
					call_user_func( $callback, $class );
			} else {
					call_user_func( $callback, $class );
			}
				return $class;
		} catch ( Mail_Bank_Zend_Exception $e ) {
			return false;
		}
	}
	/**
	 * Set autoloaders for a specific namespace
	 *
	 * @param  array  $autoloaders MANDATORY.
	 * @param  string $namespace OPTIONAL.
	 * @return Mail_Bank_Zend_Loader_Autoloader
	 */
	protected function set_namespace_autoloaders( array $autoloaders, $namespace = '' ) {
			$namespace                                 = (string) $namespace;
			$this->namespace_autoloaders[ $namespace ] = $autoloaders;
			return $this;
	}

	/**
	 * Retrieve the filesystem path for the requested ZF version
	 *
	 * @param  string $path MANDATORY.
	 * @param  string $version MANDATORY.
	 * @throws Mail_Bank_Zend_Loader_Exception Throws Exception.
	 * @return string|array
	 */
	protected function get_version_path( $path, $version ) {
			$type = $this->get_version_type( $version );

		if ( 'latest' === $type ) {
			$version = 'latest';
		}

			$available_versions = $this->get_available_versions( $path, $version );
		if ( empty( $available_versions ) ) {
			throw new Mail_Bank_Zend_Loader_Exception( 'No valid ZF installations discovered' );
		}

			$matched_version = array_pop( $available_versions );
			return $matched_version;
	}

	/**
	 * Retrieve the ZF version type
	 *
	 * @param  string $version MANDATORY.
	 * @return string "latest", "major", "minor", or "specific".
	 * @throws Mail_Bank_Zend_Loader_Exception If version string contains too many dots.
	 */
	protected function get_version_type( $version ) {
		if ( 'latest' === strtolower( $version ) ) {
			return 'latest';
		}

			$parts = explode( '.', $version );
			$count = count( $parts );
		if ( 1 === $count ) {
			return 'major';
		}
		if ( 2 === $count ) {
			return 'minor';
		}
		if ( 3 < $count ) {
			throw new Mail_Bank_Zend_Loader_Exception( 'Invalid version string provided' );
		}
			return 'specific';
	}

	/**
	 * Get available versions for the version type requested
	 *
	 * @param  string $path MANDATORY.
	 * @param  string $version MANDATORY.
	 * @throws Mail_Bank_Zend_Loader_Exception Throws Exception.
	 * @return array
	 */
	protected function get_available_versions( $path, $version ) {
		if ( ! is_dir( $path ) ) {
			throw new Mail_Bank_Zend_Loader_Exception( 'Invalid ZF path provided' );
		}

			$path        = rtrim( $path, '/' );
			$path        = rtrim( $path, '\\' );
			$version_len = strlen( $version );
			$versions    = array();
			$dirs        = glob( "$path/*", GLOB_ONLYDIR );
		foreach ( (array) $dirs as $dir ) {
			$dir_name = substr( $dir, strlen( $path ) + 1 );
			if ( ! preg_match( '/^(?:ZendFramework-)?(\d+\.\d+\.\d+((a|b|pl|pr|p|rc)\d+)?)(?:-minimal)?$/i', $dir_name, $matches ) ) {
					continue;
			}

			$matched_version = $matches[1];

			if ( ( 'latest' === $version ) || ( ( strlen( $matched_version ) >= $version_len ) && ( 0 === strpos( $matched_version, $version ) ) ) ) {
					$versions[ $matched_version ] = $dir . '/library';
			}
		}

			uksort( $versions, 'version_compare' );
			return $versions;
	}
}
