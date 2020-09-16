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
/** Class Begins here

 * @category Zend
 * @package Mail_Bank_Zend_Validate
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
interface Mail_Bank_Zend_Validate_Interface {
	/**
	 * Returns true if and only if $value meets the validation requirements
	 *
	 * If $value fails validation, then this method returns false, and
	 * get_messages() will return an array of messages that explain why the
	 * validation failed.
	 *
	 * @param mixed $value MANDATORY.
	 * @return boolean
	 * @throws Mail_Bank_Zend_Validate_Exception If validation of $value is impossible.
	 */
	public function is_valid( $value);
	/**
	 * Returns an array of messages that explain why the most recent is_valid()
	 * call returned false. The array keys are validation failure message identifiers,
	 * and the array values are the corresponding human-readable message strings.
	 *
	 * If is_valid() was never called or if the most recent is_valid() call
	 * returned true, then this method returns an empty array.
	 *
	 * @return array
	 */
	public function get_messages();
}
