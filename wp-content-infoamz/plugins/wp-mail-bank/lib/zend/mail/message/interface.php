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
 * @subpackage Storage
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 * @version $Id$
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
interface Mail_Bank_Zend_Mail_Message_Interface {
	/**
	 * Return toplines as found after headers.
	 *
	 * @return string toplines
	 */
	public function get_top_lines();
	/**
	 * Checks if flag is set
	 *
	 * @param mixed $flag a flag name, use constants defined in Mail_Bank_Zend_Mail_Storage.
	 * @return bool true if set, otherwise false.
	 */
	public function has_flag( $flag);
	/**
	 * Get all set flags.
	 *
	 * @return array array with flags, key and value are the same for easy lookup.
	 */
	public function get_flags();
}
