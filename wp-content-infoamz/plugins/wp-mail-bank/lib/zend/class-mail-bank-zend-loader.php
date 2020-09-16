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
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/**
 * Static methods for loading classes and files.
 *
 * @category Zend
 * @package Mail_Bank_Zend_Loader
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
class Mail_Bank_Zend_Loader {
	/**
	 * Loads a class from a PHP file.    The filename must be formatted
	 * as "$class.php".
	 *
	 * If $dirs is a string or an array, it will search the directories
	 * in the order supplied, and attempt to load the first matching file.
	 *
	 * If $dirs is null, it will split the class name at underscores to
	 * generate a path hierarchy (e.g., "Mail_Bank_Zend_Example_Class" will map
	 * to "zend/example/class.php").
	 *
	 * If the file was not found in the $dirs, or if no $dirs were specified,
	 * it will attempt to load it from PHP's include_path.
	 *
	 * @param string       $class - The full class name of a Zend component.
	 * @param string|array $dirs - OPTIONAL Either a path or an array of paths
	 * to search.
	 * @return void
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 */
	public static function load_class( $class, $dirs = null ) {
		if ( class_exists( $class, false ) || interface_exists( $class, false ) ) {
			return;
		}

		if ( ( null !== $dirs ) && ! is_string( $dirs ) && ! is_array( $dirs ) ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			}

			throw new Mail_Bank_Zend_Exception( 'Directory argument must be a string or an array' );
		}

		$file = self::standardise_file( $class );
		if ( ! empty( $dirs ) ) {
			// use the autodiscovered path.
			$dir_path = dirname( $file );
			if ( is_string( $dirs ) ) {
				$dirs = explode( PATH_SEPARATOR, $dirs );
			}
			foreach ( $dirs as $key => $dir ) {
				if ( '.' == $dir ) {// WPCS: loose comparison ok.
					$dirs[ $key ] = $dir_path;
				} else {
					$dir          = rtrim( $dir, '\\/' );
					$dirs[ $key ] = $dir . DIRECTORY_SEPARATOR . $dir_path;
				}
			}
			$file = basename( $file );
			self::load_file( $file, $dirs, true );
		} else {
			self::load_file( $file, null, true );
		}
		if ( ! class_exists( $class, false ) && ! interface_exists( $class, false ) ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			}

			throw new Mail_Bank_Zend_Exception( "File \"$file\" does not exist or class \"$class\" was not found in the file" );
		}
	}
	/**
	 * Loads a PHP file. This is a wrapper for PHP's include() function.
	 *
	 * $filename must be the complete filename, including any
	 * extension such as ".php". Note that a security check is performed that
	 * does not permit extended characters in the filename.  This method is
	 * intended for loading Zend Framework files.
	 *
	 * If $dirs is a string or an array, it will search the directories
	 * in the order supplied, and attempt to load the first matching file.
	 *
	 * If the file was not found in the $dirs, or if no $dirs were specified,
	 * it will attempt to load it from PHP's include_path.
	 *
	 * If $once is TRUE, it will use include_once() instead of include().
	 *
	 * @param    string       $filename MANDATORY.
	 * @param    string|array $dirs - OPTIONAL either a path or array of paths OPTIONAL.
	 * to search.
	 * @param    boolean      $once OPTIONAL.
	 * @return boolean
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 */
	public static function load_file( $filename, $dirs = null, $once = false ) {
		self::security_check( $filename );

		/**
	 * Search in provided directories, as well as include_path.
	 */
		$inc_path = false;
		if ( ! empty( $dirs ) && ( is_array( $dirs ) || is_string( $dirs ) ) ) {
			if ( is_array( $dirs ) ) {
				$dirs = implode( PATH_SEPARATOR, $dirs );
			}
			$inc_path = get_include_path();
			set_include_path( $dirs . PATH_SEPARATOR . $inc_path );// @codingStandardsIgnoreLine.
		}

		/**
	 * Try finding for the plain filename in the include_path.
	 */
		if ( $once ) {
			if ( file_exists( $filename ) ) {
				include_once $filename;
			}
		} else {
			if ( file_exists( $filename ) ) {
				include $filename;
			}
		}

		/**
	 * If searching in directories, reset include_path
	 */
		if ( $inc_path ) {
			set_include_path( $inc_path );// @codingStandardsIgnoreLine.
		}

		return true;
	}
	/**
	 * Returns TRUE if the $filename is readable, or FALSE otherwise.
	 * This function uses the PHP include_path, where PHP's is_file_readable()
	 * does not.
	 *
	 * Note from ZF-2900:
	 * If you use custom error handler, please check whether return value
	 *   from error_reporting() is zero or not.
	 * At mark of fopen() can not suppress warning if the handler is used.
	 *
	 * @param string $filename MANDATORY.
	 * @return boolean
	 */
	public static function is_file_readable( $filename ) {
		if ( is_readable( $filename ) ) {
			// Return early if the filename is readable without needing the include_path.
			return true;
		}

		if ( 'WIN' == strtoupper( substr( PHP_OS, 0, 3 ) ) && preg_match( '/^[a-z]:/i', $filename )// WPCS: loose comparison ok.
		) {
			// If on windows, and path provided is clearly an absolute path, return false immediately.
			return false;
		}

		foreach ( self::explode_include_path() as $path ) {
			if ( '.' == $path ) {// WPCS: loose comparison ok.
				if ( is_readable( $filename ) ) {
					return true;
				}
				continue;
			}
			$file = $path . '/' . $filename;
			if ( is_readable( $file ) ) {
				return true;
			}
		}
		return false;
	}
	/**
	 * Explode an include path into an array
	 *
	 * If no path provided, uses current include_path. Works around issues that
	 * occur when the path includes stream schemas.
	 *
	 * @param    string|null $path OPTIONAL.
	 * @return array
	 */
	public static function explode_include_path( $path = null ) {
		if ( null === $path ) {
			$path = get_include_path();
		}

		if ( PATH_SEPARATOR == ':' ) {// WPCS: loose comparison ok.
			// On *nix systems, include_paths which include paths with a stream
			// schema cannot be safely explode'd, so we have to be a bit more
			// intelligent in the approach.
			$paths = preg_split( '#:(?!//)#', $path );
		} else {
			$paths = explode( PATH_SEPARATOR, $path );
		}
		return $paths;
	}
	/**
	 * Spl_autoload() suitable implementation for supporting class autoloading.
	 *
	 * Attach to spl_autoload() using the following:
	 * <code>
	 * spl_autoload_register(array('Mail_Bank_Zend_Loader', 'autoload'));
	 * </code>
	 *
	 * @deprecated Since 1.8.0
	 * @param    string $class MANDATORY.
	 * @return string|false Class name on success; false on failure
	 */
	public static function autoload( $class ) {
		trigger_error( __CLASS__ . '::' . __METHOD__ . ' is deprecated as of 1.8.0 and will be removed with 2.0.0; use Zend_Loader_Autoloader instead', E_USER_NOTICE );// @codingStandardsIgnoreLine.
		try {
			self::load_class( $class );
			return $class;
		} catch ( Exception $e ) {
			return false;
		}
	}
	/**
	 * Register {@link autoload()} with spl_autoload()
	 *
	 * @deprecated Since 1.8.0
	 * @param string  $class (optional).
	 * @param boolean $enabled (optional).
	 * @return void
	 * @throws Mail_Bank_Zend_Exception If spl_autoload() is not found
	 * or if the specified class does not have an autoload() method.
	 */
	public static function register_auto_load( $class = 'Mail_Bank_Zend_Loader', $enabled = true ) {
		trigger_error( __CLASS__ . '::' . __METHOD__ . ' is deprecated as of 1.8.0 and will be removed with 2.0.0; use Mail_Bank_Zend_Loader_Autoloader instead', E_USER_NOTICE );// @codingStandardsIgnoreLine.
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/loader/class-mail-bank-zend-loader-autoloader.php' ) ) {
			require_once MAIL_BANK_DIR_PATH . 'lib/zend/loader/class-mail-bank-zend-loader-autoloader.php';
		}

		$autoloader = Mail_Bank_Zend_Loader_Autoloader::getInstance();
		$autoloader->setFallbackAutoloader( true );

		if ( 'Mail_Bank_Zend_Loader' != $class ) {// WPCS: loose comparison ok.
			self::load_class( $class );
			$methods = get_class_methods( $class );
			if ( ! in_array( 'autoload', (array) $methods, true ) ) {
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
					require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
				}

				throw new Mail_Bank_Zend_Exception( "The class \"$class\" does not have an autoload() method" );
			}

			$callback = array( $class, 'autoload' );

			if ( $enabled ) {
				$autoloader->pushAutoloader( $callback );
			} else {
				$autoloader->removeAutoloader( $callback );
			}
		}
	}
	/**
	 * Ensure that filename does not contain exploits
	 *
	 * @param    string $filename MANDATORY.
	 * @return void
	 * @throws Mail_Bank_Zend_Exception Throws Exception.
	 */
	protected static function security_check( $filename ) {
		/**
	 * Security check
	 */
		if ( preg_match( '/[^a-z0-9\\/\\\\_.:-]/i', $filename ) ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php' ) ) {
				require_once MAIL_BANK_DIR_PATH . 'lib/zend/class-mail-bank-zend-exception.php';
			}

			throw new Mail_Bank_Zend_Exception( 'Security check: Illegal character in filename' );
		}
	}
	/**
	 * Attempt to include() the file.
	 *
	 * Include() is not prefixed with the @ operator because if
	 * the file is loaded and contains a parse error, execution
	 * will halt silently and this is difficult to debug.
	 *
	 * Always set display_errors = Off on production servers!
	 *
	 * @param    string  $filespec MANDATORY.
	 * @param    boolean $once OPTIONAL.
	 * @return boolean
	 * @deprecated Since 1.5.0; use load_file() instead
	 */
	protected static function include_file( $filespec, $once = false ) {
		if ( $once ) {
			if ( file_exists( $filespec ) ) {
				return include_once $filespec;
			}
		} else {
			if ( file_exists( $filespec ) ) {
				return include $filespec;
			}
		}
	}
	/**
	 * Standardise the filename.
	 *
	 * Convert the supplied filename into the namespace-aware standard,
	 * based on the Framework Interop Group reference implementation:
	 * http://groups.google.com/group/php-standards/web/psr-0-final-proposal
	 *
	 * The filename must be formatted as "$file.php".
	 *
	 * @param string $file - The file name to be loaded.
	 * @return string
	 */
	public static function standardise_file( $file ) {
		$file_name = ltrim( $file, '\\' );
		$file      = '';
		$namespace = '';
		if ( $last_ns_pos = strripos( $file_name, '\\' ) ) {// @codingStandardsIgnoreLine.
			$namespace = substr( $file_name, 0, $last_ns_pos );
			$file_name = substr( $file_name, $last_ns_pos + 1 );
			$file      = str_replace( '\\', DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR;
		}
		$file .= str_replace( '_', DIRECTORY_SEPARATOR, $file_name ) . '.php';
		return $file;
	}
}
