<?php // @codingStandardsIgnoreLine.
/**
 * Plugin Name: WP Mail SMTP Plugin by Mail Bank
 * Plugin URI: https://tech-banker.com/wp-mail-bank/
 * Description: WP Mail Bank is a WordPress smtp plugin that solves email deliverability issue. Configures Gmail Smtp Settings, OAuth, and any SMTP server.
 * Author: Tech Banker
 * Author URI: https://tech-banker.com/wp-mail-bank/
 * Version: 4.0.12
 * License: GPLv3
 * Text Domain: wp-mail-bank
 * Domain Path: /languages
 *
 * @package wp-mail-bank
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/* Constant Declaration */
if ( ! defined( 'MAIL_BANK_DIR_PATH' ) ) {
	define( 'MAIL_BANK_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'MAIL_BANK_PLUGIN_DIRNAME' ) ) {
	define( 'MAIL_BANK_PLUGIN_DIRNAME', plugin_basename( dirname( __FILE__ ) ) );
}
if ( ! defined( 'MAIL_BANK_LOCAL_TIME' ) ) {
	define( 'MAIL_BANK_LOCAL_TIME', strtotime( date_i18n( 'Y-m-d H:i:s' ) ) );
}
if ( ! defined( 'TECH_BANKER_URL' ) ) {
	define( 'TECH_BANKER_URL', 'https://tech-banker.com' );
}
if ( ! defined( 'TECH_BANKER_STATS_URL' ) ) {
	define( 'TECH_BANKER_STATS_URL', 'http://stats.tech-banker-services.org' );
}
if ( ! defined( 'MAIL_BANK_VERSION_NUMBER' ) ) {
	define( 'MAIL_BANK_VERSION_NUMBER', '4.0.10' );
}
$memory_limit_mail_bank = intval( ini_get( 'memory_limit' ) );
if ( ! extension_loaded( 'suhosin' ) && $memory_limit_mail_bank < 512 ) {
	ini_set( 'memory_limit', '512M' );// @codingStandardsIgnoreLine.
}
ini_set( 'max_execution_time', 6000 );// @codingStandardsIgnoreLine.
ini_set( 'max_input_vars', 10000 );// @codingStandardsIgnoreLine.

if ( ! function_exists( 'install_script_for_mail_bank' ) ) {
	/**
	 * Function Name: install_script_for_mail_bank
	 * Parameters: No
	 * Description: This function is used to create Tables in Database.
	 * Created On: 15-06-2016 09:52
	 * Created By: Tech Banker Team
	 */
	function install_script_for_mail_bank() {
		global $wpdb;
		if ( is_multisite() ) {
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );// WPCS: db call ok; no-cache ok.
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );// @codingStandardsIgnoreLine.
				$version = get_option( 'mail-bank-version-number' );
				if ( $version < '3.0.6' ) {
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/class-dbhelper-install-script-mail-bank.php' ) ) {
						include MAIL_BANK_DIR_PATH . 'lib/class-dbhelper-install-script-mail-bank.php';
					}
				}
				restore_current_blog();
			}
		} else {
			$version = get_option( 'mail-bank-version-number' );
			if ( $version < '3.0.6' ) {
				if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/class-dbhelper-install-script-mail-bank.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'lib/class-dbhelper-install-script-mail-bank.php';
				}
			}
		}
	}
}

if ( ! function_exists( 'check_user_roles_mail_bank' ) ) {
	/**
	 * Function Name: check_user_roles_mail_bank
	 * Parameters: Yes($user)
	 * Description: This function is used for checking roles of different users.
	 * Created On: 19-10-2016 03:40
	 * Created By: Tech Banker Team
	 */
	function check_user_roles_mail_bank() {
		global $current_user;
		$user = $current_user ? new WP_User( $current_user ) : wp_get_current_user();
		return $user->roles ? $user->roles[0] : false;
	}
}

if ( ! function_exists( 'mail_bank' ) ) {
	/**
	 * Function Name: mail_bank
	 * Parameters: No
	 * Description: This function is used to return Parent Table name with prefix.
	 * Created On: 15-06-2016 10:44
	 * Created By: Tech Banker Team
	 */
	function mail_bank() {
		global $wpdb;
		return $wpdb->prefix . 'mail_bank';
	}
}

if ( ! function_exists( 'mail_bank_meta' ) ) {
	/**
	 * Function Name: mail_bank_meta
	 * Parameters: No
	 * Description: This function is used to return Meta Table name with prefix.
	 * Created On: 15-06-2016 10:44
	 * Created By: Tech Banker Team
	 */
	function mail_bank_meta() {
		global $wpdb;
		return $wpdb->prefix . 'mail_bank_meta';
	}
}
if ( ! function_exists( 'mail_bank_logs' ) ) {
	/**
	 * Function Name: mail_bank_logs
	 * Parameters: No
	 * Description: This function is used to return Email Logs Table name with prefix.
	 * Created On: 18-07-2018 11:48
	 * Created By: Tech Banker Team
	 */
	function mail_bank_logs() {
		global $wpdb;
		return $wpdb->prefix . 'mail_bank_logs';
	}
}

if ( ! function_exists( 'get_others_capabilities_mail_bank' ) ) {
	/**
	 * Function Name: get_others_capabilities_mail_bank
	 * Parameters: No
	 * Description: This function is used to get all the roles available in WordPress
	 * Created On: 21-10-2016 12:06
	 * Created By: Tech Banker Team
	 */
	function get_others_capabilities_mail_bank() {
		$user_capabilities = array();
		if ( function_exists( 'get_editable_roles' ) ) {
			foreach ( get_editable_roles() as $role_name => $role_info ) {
				foreach ( $role_info['capabilities'] as $capability => $_ ) {
					if ( ! in_array( $capability, $user_capabilities, true ) ) {
						array_push( $user_capabilities, $capability );
					}
				}
			}
		} else {
			$user_capabilities = array(
				'manage_options',
				'edit_plugins',
				'edit_posts',
				'publish_posts',
				'publish_pages',
				'edit_pages',
				'read',
			);
		}
		return $user_capabilities;
	}
}

/**
 * Function Name: mail_bank_action_links
 * Parameters: Yes
 * Description: This function is used to create link for Pro Editions.
 * Created On: 24-04-2017 12:20
 * Created By: Tech Banker Team
 *
 * @param string $plugin_link .
 */
function mail_bank_action_links( $plugin_link ) {
	$plugin_link[] = '<a href="https://tech-banker.com/wp-mail-bank/pricing/" style="color: red; font-weight: bold;" target="_blank">Go Pro!</a>';
	return $plugin_link;
}

if ( ! function_exists( 'mail_bank_settings_link' ) ) {
	/**
	 * This function is used to add settings link.
	 *
	 * @param string $action .
	 */
	function mail_bank_settings_link( $action ) {
		global $wpdb, $user_role_permission;
		$settings_link = '<a href = "' . admin_url( 'admin.php?page=mb_email_configuration' ) . '">Settings</a>';
		array_unshift( $action, $settings_link );
		return $action;
	}
}

$version = get_option( 'mail-bank-version-number' );
if ( $version >= '3.0.6' ) {

	/**
	 * Function Name: get_users_capabilities_mail_bank
	 * Parameters: No
	 * Description: This function is used to get users capabilities.
	 * Created On: 21-10-2016 15:21
	 * Created By: Tech Banker Team
	*/

	if ( ! function_exists( 'get_users_capabilities_mail_bank' ) ) {
		/**
		 * Function Name: get_users_capabilities_mail_bank
		 * Parameters: No
		 * Description: This function is used to get users capabilities.
		 * Created On: 21-10-2016 15:21
		 * Created By: Tech Banker Team
		 */
		function get_users_capabilities_mail_bank() {
			global $wpdb, $user_role_permission;
			$user_role_permission      = array();
			$capabilities              = $wpdb->get_var(
				$wpdb->prepare( 'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key = %s', 'roles_and_capabilities' )
			);// WPCS: db call ok; no-cache ok.
			$core_roles                = array(
				'manage_options',
				'edit_plugins',
				'edit_posts',
				'publish_posts',
				'publish_pages',
				'edit_pages',
				'read',
			);
			$unserialized_capabilities = maybe_unserialize( $capabilities );
			$user_role_permission      = isset( $unserialized_capabilities['capabilities'] ) ? $unserialized_capabilities['capabilities'] : $core_roles;
			return $user_role_permission;
		}
	}
	if ( is_admin() ) {
		if ( ! function_exists( 'backend_js_css_for_mail_bank' ) ) {
			/**
			 * This function is used for calling css and js files for backend
			 */
			function backend_js_css_for_mail_bank() {
				$pages_mail_bank = array(
					'wp_mail_bank_wizard',
					'mb_email_configuration',
					'mb_test_email',
					'mb_connectivity_test',
					'mb_email_logs',
					'mb_notifications',
					'mb_settings',
					'mb_roles_and_capabilities',
					'mb_system_information',
					'mb_upgrade_now',
				);
				if ( in_array( isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '', $pages_mail_bank, true ) ) { // WPCS: CSRF ok, WPCS: input var ok.
					wp_enqueue_script( 'jquery' );
					wp_enqueue_script( 'jquery-ui-datepicker' );
					wp_enqueue_script( 'mail-bank-jquery.validate.js', plugins_url( 'assets/global/plugins/validation/jquery.validate.js', __FILE__ ) );
					wp_enqueue_script( 'mail-bank-jquery.datatables.js', plugins_url( 'assets/global/plugins/datatables/media/js/jquery.datatables.js', __FILE__ ) );
					wp_enqueue_script( 'mail-bank-jquery.fngetfilterednodes.js', plugins_url( 'assets/global/plugins/datatables/media/js/fngetfilterednodes.js', __FILE__ ) );
					wp_enqueue_script( 'mail-bank-toastr.js', plugins_url( 'assets/global/plugins/toastr/toastr.js', __FILE__ ) );
					wp_enqueue_script( 'jquery.clipboard.js', plugins_url( 'assets/global/plugins/clipboard/clipboard.js', __FILE__ ) );
					wp_enqueue_script( 'jquery.chart.js', plugins_url( 'assets/global/plugins/chart/chart.js', __FILE__ ) );

					wp_enqueue_style( 'mail-bank-components.css', plugins_url( 'assets/global/css/components.css', __FILE__ ) );
					wp_enqueue_style( 'mail-bank-custom.css', plugins_url( 'assets/admin/layout/css/mail-bank-custom.css', __FILE__ ) );
					if ( is_rtl() ) {
						wp_enqueue_style( 'mail-bank-bootstrap.css', plugins_url( 'assets/global/plugins/custom/css/custom-rtl.css', __FILE__ ) );
						wp_enqueue_style( 'mail-bank-layout.css', plugins_url( 'assets/admin/layout/css/layout-rtl.css', __FILE__ ) );
						wp_enqueue_style( 'mail-bank-tech-banker-custom.css', plugins_url( 'assets/admin/layout/css/tech-banker-custom-rtl.css', __FILE__ ) );
					} else {
						wp_enqueue_style( 'mail-bank-bootstrap.css', plugins_url( 'assets/global/plugins/custom/css/custom.css', __FILE__ ) );
						wp_enqueue_style( 'mail-bank-layout.css', plugins_url( 'assets/admin/layout/css/layout.css', __FILE__ ) );
						wp_enqueue_style( 'mail-bank-tech-banker-custom.css', plugins_url( 'assets/admin/layout/css/tech-banker-custom.css', __FILE__ ) );
					}
					wp_enqueue_style( 'mail-bank-toastr.min.css', plugins_url( 'assets/global/plugins/toastr/toastr.css', __FILE__ ) );
					wp_enqueue_style( 'mail-bank-jquery-ui.css', plugins_url( 'assets/global/plugins/datepicker/jquery-ui.css', __FILE__ ), false, '2.0', false );
					wp_enqueue_style( 'mail-bank-datatables.foundation.css', plugins_url( 'assets/global/plugins/datatables/media/css/datatables.foundation.css', __FILE__ ) );
				}
				$database_update_option = get_option( 'mail_bank_update_database' );
				if ( false == $database_update_option ) { // WPCS: Loose comparison ok.
					wp_enqueue_script( 'jquery' );
					wp_enqueue_script( 'mail-bank-toastr.js', plugins_url( 'assets/global/plugins/toastr/toastr.js', __FILE__ ) );
					wp_enqueue_style( 'mail-bank-toastr.min.css', plugins_url( 'assets/global/plugins/toastr/toastr.css', __FILE__ ) );
					wp_enqueue_script( 'mail-bank-database-upgrade.js', plugins_url( 'assets/global/plugins/database-upgrade/database-upgrade.js', __FILE__ ) );
				}
			}
		}
		add_action( 'admin_enqueue_scripts', 'backend_js_css_for_mail_bank' );
	}

	if ( ! function_exists( 'helper_file_for_mail_bank' ) ) {
		/**
		 * Function Name: helper_file_for_mail_bank
		 * Parameters: No
		 * Description: This function is used to create Class and Function to perform operations.
		 * Created On: 15-06-2016 09:52
		 * Created By: Tech Banker Team
		 */
		function helper_file_for_mail_bank() {
			global $wpdb, $user_role_permission;
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/class-dbhelper-mail-bank.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'lib/class-dbhelper-mail-bank.php';
			}
		}
	}

	if ( ! function_exists( 'sidebar_menu_for_mail_bank' ) ) {
		/**
		 * This function is used to create Admin sidebar menus.
		 */
		function sidebar_menu_for_mail_bank() {
			global $wpdb, $current_user, $user_role_permission;
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
				include MAIL_BANK_DIR_PATH . 'includes/translations.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/sidebar-menu.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'lib/sidebar-menu.php';
			}
		}
	}

	if ( ! function_exists( 'topbar_menu_for_mail_bank' ) ) {
		/**
		 * Function Name: topbar_menu_for_mail_bank
		 * Parameters: No
		 * Description: This function is used for creating Top bar menu.
		 * Created On: 15-06-2016 10:44
		 * Created By: Tech Banker Team
		 */
		function topbar_menu_for_mail_bank() {
			global $wpdb, $current_user, $wp_admin_bar, $user_role_permission;
			$role_capabilities                        = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key = %s', 'roles_and_capabilities'
				)
			);// WPCS: db call ok; no-cache ok.
			$roles_and_capabilities_unserialized_data = maybe_unserialize( $role_capabilities );
			$top_bar_menu                             = $roles_and_capabilities_unserialized_data['show_mail_bank_top_bar_menu'];

			if ( 'enable' === $top_bar_menu ) {
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( get_option( 'mail-bank-welcome-page' ) ) {
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/admin-bar-menu.php' ) ) {
						include_once MAIL_BANK_DIR_PATH . 'lib/admin-bar-menu.php';
					}
				}
			}
		}
	}

	if ( ! function_exists( 'ajax_register_for_mail_bank' ) ) {
		/**
		 * Function Name: ajax_register_for_mail_bank
		 * Parameters: No
		 * Description: This function is used for register ajax.
		 * Created On: 15-06-2016 10:44
		 * Created By: Tech Banker Team
		 */
		function ajax_register_for_mail_bank() {
			global $wpdb, $user_role_permission;
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
				include MAIL_BANK_DIR_PATH . 'includes/translations.php';
			}
			if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/action-library.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'lib/action-library.php';
			}
		}
	}

	if ( ! function_exists( 'plugin_load_textdomain_mail_bank' ) ) {
		/**
		 * Function Name: plugin_load_textdomain_mail_bank
		 * Parameters: No
		 * Description: This function is used to load the plugin's translated strings.
		 * Created On: 16-06-2016 09:47
		 * Created By: Tech Banker Team
		 */
		function plugin_load_textdomain_mail_bank() {
			if ( function_exists( 'load_plugin_textdomain' ) ) {
				load_plugin_textdomain( 'wp-mail-bank', false, MAIL_BANK_PLUGIN_DIRNAME . '/languages' );
			}
		}
	}

	if ( ! function_exists( 'oauth_handling_mail_bank' ) ) {
		/**
		 * Function Name: oauth_handling_mail_bank
		 * Parameters: No
		 * Description: This function is used to Manage Redirect.
		 * Created On: 11-08-2016 11:53
		 * Created By: Tech Banker Team
		 */
		function oauth_handling_mail_bank() {
			if ( is_admin() && is_user_logged_in() && ! isset( $_REQUEST['action'] ) && isset( $_REQUEST['state'] ) && 'wp-mail-bank' == $_REQUEST['state'] ) {  // WPCS: CSRF ok, WPCS: input var ok.
				if ( ( count( $_REQUEST ) <= 3 ) && isset( $_REQUEST['code'] ) ) { // WPCS: CSRF ok, WPCS: input var ok.
					if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/callback.php' ) ) {
						include_once MAIL_BANK_DIR_PATH . 'lib/callback.php';
					}
				} elseif ( ( count( $_REQUEST ) <= 3 ) && isset( $_REQUEST['error'] ) ) { // WPCS: CSRF ok, WPCS: input var ok.
					$url = admin_url( 'admin.php?page=mb_email_configuration' );
					header( "location: $url" );
				}
			}
		}
	}

	if ( ! function_exists( 'email_configuration_mail_bank' ) ) {
		/**
		 * This function is used for checking test email.
		 *
		 * @param string $phpmailer .
		 */
		function email_configuration_mail_bank( $phpmailer ) {
			global $wpdb;
			$email_configuration_data       = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key = %s', 'email_configuration'
				)
			);// WPCS: db call ok; no-cache ok.
			$email_configuration_data_array = maybe_unserialize( $email_configuration_data );

			$phpmailer->Mailer = 'mail';// @codingStandardsIgnoreLine
			if ( 'override' === $email_configuration_data_array['sender_name_configuration'] ) {
				$phpmailer->FromName = stripcslashes( htmlspecialchars_decode( $email_configuration_data_array['sender_name'], ENT_QUOTES ) );// @codingStandardsIgnoreLine
			}
			if ( 'override' === $email_configuration_data_array['from_email_configuration'] ) {
				$phpmailer->From = $email_configuration_data_array['sender_email'];// @codingStandardsIgnoreLine
			}
			if ( '' !== $email_configuration_data_array['reply_to'] ) {
				$phpmailer->clearReplyTos();
				$phpmailer->AddReplyTo( $email_configuration_data_array['reply_to'] );
			}
			if ( '' !== $email_configuration_data_array['cc'] ) {
				$phpmailer->clearCCs();
				$cc_address_array = explode( ',', $email_configuration_data_array['cc'] );
				foreach ( $cc_address_array as $cc_address ) {
					$phpmailer->AddCc( $cc_address );
				}
			}
			if ( '' !== $email_configuration_data_array['bcc'] ) {
				$phpmailer->clearBCCs();
				$bcc_address_array = explode( ',', $email_configuration_data_array['bcc'] );
				foreach ( $bcc_address_array as $bcc_address ) {
					$phpmailer->AddBcc( $bcc_address );
				}
			}
			if ( isset( $email_configuration_data_array['headers'] ) && '' !== $email_configuration_data_array['headers'] ) {
				$phpmailer->addCustomHeader( $email_configuration_data_array['headers'] );
			}
			$phpmailer->Sender = $email_configuration_data_array['email_address'];// @codingStandardsIgnoreLine.
		}
	}

	if ( ! function_exists( 'mail_bank_compatibility_warning' ) ) {
			/**
			 * This Function is used to include CSS File.
			 */
		function mail_bank_compatibility_warning() {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'mail-bank-jquery.validate.js', plugins_url( 'assets/global/plugins/validation/jquery.validate.js', __FILE__ ) );
			if ( is_rtl() ) {
				wp_enqueue_style( 'tech-banker-compatibility-rtl.css', plugins_url( 'assets/admin/layout/css/tech-banker-compatibility-rtl.css', __FILE__ ) );
			}
			wp_enqueue_style( 'tech-banker-compatibility.css', plugins_url( 'assets/admin/layout/css/tech-banker-compatibility.css', __FILE__ ) );
		}
	}

	if ( ! function_exists( 'admin_functions_for_mail_bank' ) ) {
		/**
		 * Function Name: admin_functions_for_mail_bank
		 * Parameters: No
		 * Description: This function is used for calling admin_init functions.
		 * Created On: 15-06-2016 10:44
		 * Created By: Tech Banker Team
		 */
		function admin_functions_for_mail_bank() {
			global $user_role_permission;
			install_script_for_mail_bank();
			helper_file_for_mail_bank();
			mail_bank_compatibility_warning();
		}
	}

	if ( ! function_exists( 'mailer_file_for_mail_bank' ) ) {
		/**
		 * Function Name: mailer_file_for_mail_bank
		 * Parameters: No
		 * Description: This function is used for including Mailer File.
		 * Created On: 30-06-2016 02:13
		 * Created By: Tech Banker Team
		 */
		function mailer_file_for_mail_bank() {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-auth-host.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-auth-host.php';
			}
		}
	}
	if ( ! function_exists( 'user_functions_for_mail_bank' ) ) {
		/**
		 * Function Name: user_functions_for_mail_bank
		 * Parameters: No
		 * Description: This function is used to call on init hook.
		 * Created On: 16-06-2016 11:08
		 * Created By: Tech Banker Team
		 */
		function user_functions_for_mail_bank() {
			global $wpdb;
			$meta_values = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key IN(%s,%s)', 'settings', 'email_configuration'
				)
			);// WPCS: db call ok; no-cache ok.

			$meta_data_array = array();
			foreach ( $meta_values as $value ) {
				$unserialize_data = maybe_unserialize( $value->meta_value );
				array_push( $meta_data_array, $unserialize_data );
			}
			mailer_file_for_mail_bank();
			if ( 'php_mail_function' === $meta_data_array[0]['mailer_type'] ) {
				add_action( 'phpmailer_init', 'email_configuration_mail_bank' );
			} else {
				apply_filters( 'wp_mail', 'wp_mail' );
			}
			oauth_handling_mail_bank();
		}
	}

	/**
	 * Description: Override Mail Function here.
	 * Created On: 30-06-2016 02:13
	 * Created By: Tech Banker Team
	 */

	mailer_file_for_mail_bank();
	Mail_Bank_Auth_Host::override_wp_mail_function();

	if ( ! function_exists( 'deactivation_function_for_wp_mail_bank' ) ) {
		/**
		 * Function Name: deactivation_function_for_wp_mail_bank
		 * Parameters: No
		 * Description: This function is used for executing the code on deactivation.
		 * Created On: 21-04-2017 09:22
		 * Created by: Tech Banker Team
		 */
		function deactivation_function_for_wp_mail_bank() {
			delete_option( 'mail-bank-welcome-page' );
		}
	}

	/**
	 * This function is used to log email in case of phpmailer.
	 */
	function generate_logs_mail_bank() {
		global $wpdb;
		$email_configuration_data_array = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key=%s', 'email_configuration'
			)
		);// WPCS: db call ok; no-cache ok.
		$email_configuration_data       = maybe_unserialize( $email_configuration_data_array );

		if ( 'php_mail_function' === $email_configuration_data['mailer_type'] ) {
			if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-email-logger.php' ) ) {
				include_once MAIL_BANK_DIR_PATH . 'includes/class-mail-bank-email-logger.php';
			}
			$email_logger = new Mail_Bank_Email_Logger();
			$email_logger->load_emails_mail_bank();
		}
	}

	/**
	 * Function Name: add_dashboard_widgets_mail_bank
	 * Parameters: No
	 * Description: This function is used to add a widget to the dashboard.
	 * Created On: 24-08-2017 15:20
	 * Created By: Tech Banker Team
	 */
	function add_dashboard_widgets_mail_bank() {
		wp_add_dashboard_widget(
			'mb_dashboard_widget', // Widget slug.
			'Mail Bank Statistics', // Title.
			'dashboard_widget_function_mail_bank'// Display function.
		);
	}
	/**
	 * Function Name: dashboard_widget_function_mail_bank
	 * Parameters: No
	 * Description: This function is used to to output the contents of our Dashboard Widget.
	 * Created On: 29-08-2017 15:20
	 * Created By: Tech Banker Team
	 */
	function dashboard_widget_function_mail_bank() {

		global $wpdb;
		if ( file_exists( MAIL_BANK_DIR_PATH . 'lib/dashboard-widget.php' ) ) {
			include_once MAIL_BANK_DIR_PATH . 'lib/dashboard-widget.php';
		}
	}

	/* hooks */

	/**
	 * Description: This hook is used for calling the function of get_users_capabilities_mail_bank.
	 * Created On: 15-06-2016 09:46
	 * Created By: Tech Banker Team
	 */
	add_action( 'plugins_loaded', 'get_users_capabilities_mail_bank' );

	/**
	 * This hook is used for calling the function of install script.
	 */

	register_activation_hook( __FILE__, 'install_script_for_mail_bank' );

	/**
	 * This hook is used for create link for premium Editions.
	 */
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mail_bank_action_links' );

	/**
	 * This hook contains all admin_init functions.
	 */

	add_action( 'admin_init', 'admin_functions_for_mail_bank' );

	/**
	 * This hook is used for calling the function of user functions.
	 */

	add_action( 'init', 'user_functions_for_mail_bank' );

	/**
	 * This hook is used for calling the function of sidebar menu.
	 */

	add_action( 'admin_menu', 'sidebar_menu_for_mail_bank' );

	/**
	* This hook is used for calling the function of sidebar menu in multisite case.
	*/

	add_action( 'network_admin_menu', 'sidebar_menu_for_mail_bank' );

	/**
	 * This hook is used for calling the function of topbar menu.
	 */

	add_action( 'admin_bar_menu', 'topbar_menu_for_mail_bank', 100 );

	/**
	 * This hook is used for calling the function of languages.
	 */

	add_action( 'init', 'plugin_load_textdomain_mail_bank' );

	/*
	 * This hook is used to register ajax.
	 */
	add_action( 'wp_ajax_mail_bank_action', 'ajax_register_for_mail_bank' );

	/*
	 * This hook is used to add widget on dashboard.
	 */
		add_action( 'wp_dashboard_setup', 'add_dashboard_widgets_mail_bank' );

	/*
	 * This hook is used for calling the function of settings link.
	 */

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mail_bank_settings_link', 10, 2 );

	/**
	 * This hook is used to sets the deactivation hook for a plugin.
	 */

	register_deactivation_hook( __FILE__, 'deactivation_function_for_wp_mail_bank' );

	/**
	 * This hook is used to generate logs.
	 */
	add_action( 'plugins_loaded', 'generate_logs_mail_bank', 101 );

}

/**
* This hook is used for calling the function of install script.
*/

register_activation_hook( __FILE__, 'install_script_for_mail_bank' );

/**
 * This hook used for calling the function of install script.
 */

add_action( 'admin_init', 'install_script_for_mail_bank' );

if ( ! function_exists( 'plugin_activate_wp_mail_bank' ) ) {
	/**
	 * This function is used to add option on plugin activation.
	 */
	function plugin_activate_wp_mail_bank() {
		add_option( 'wp_mail_bank_do_activation_redirect', true );
	}
}

if ( ! function_exists( 'wp_mail_bank_redirect' ) ) {
	/**
	 * This function is used to redirect to email setup.
	 */
	function wp_mail_bank_redirect() {
		if ( get_option( 'wp_mail_bank_do_activation_redirect', false ) ) {
			delete_option( 'wp_mail_bank_do_activation_redirect' );
			wp_safe_redirect( admin_url( 'admin.php?page=mb_email_configuration' ) );
			exit;
		}
	}
}
register_activation_hook( __FILE__, 'plugin_activate_wp_mail_bank' );
add_action( 'admin_init', 'wp_mail_bank_redirect' );

/**
 * Function Name:mail_bank_admin_notice_class
 * Parameter: No
 * Description: This function is used to create the object of admin notices.
 * Created On: 08-29-2017 15:06
 * Created By: Tech Banker Team
 */
function mail_bank_admin_notice_class() {
	global $wpdb;
	/**
	 * This Class is used to add admin notice.
	 */
	class Mail_Bank_Admin_Notices {
		/**
		 * The version of this plugin.
		 *
		 * @access   public
		 * @var      string    $config  .
		 */
		public $config;
		/**
		 * The version of this plugin.
		 *
		 * @access   public
		 * @var      integer    $notice_spam .
		 */
		public $notice_spam = 0;
		/**
		 * The version of this plugin.
		 *
		 * @access   public
		 * @var      integer    $notice_spam_max .
		 */
		public $notice_spam_max = 2;
		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param array $config .
		 */
		public function __construct( $config = array() ) {
			// Runs the admin notice ignore function incase a dismiss button has been clicked.
			add_action( 'admin_init', array( $this, 'mb_admin_notice_ignore' ) );
			// Runs the admin notice temp ignore function incase a temp dismiss link has been clicked.
			add_action( 'admin_init', array( $this, 'mb_admin_notice_temp_ignore' ) );
			add_action( 'admin_notices', array( $this, 'mb_display_admin_notices' ) );
		}
		/**
		 * Checks to ensure notices aren't disabled and the user has the correct permissions.
		 */
		public function mb_admin_notices() {
			$settings = get_option( 'mb_admin_notice' );
			if ( ! isset( $settings['disable_admin_notices'] ) || ( isset( $settings['disable_admin_notices'] ) && 0 === $settings['disable_admin_notices'] ) ) {
				if ( current_user_can( 'manage_options' ) ) {
					return true;
				}
			}
			return false;
		}
		/**
		 * Primary notice function that can be called from an outside function sending necessary variables.
		 *
		 * @param string $admin_notices .
		 */
		public function change_admin_notice_mail_bank( $admin_notices ) {
			// Check options.
			if ( ! $this->mb_admin_notices() ) {
				return false;
			}
			foreach ( $admin_notices as $slug => $admin_notice ) {
				// Call for spam protection.
				if ( $this->mb_anti_notice_spam() ) {
					return false;
				}

				// Check for proper page to display on.
				if ( isset( $admin_notices[ $slug ]['pages'] ) && is_array( $admin_notices[ $slug ]['pages'] ) ) {
					if ( ! $this->mb_admin_notice_pages( $admin_notices[ $slug ]['pages'] ) ) {
						return false;
					}
				}

				// Check for required fields.
				if ( ! $this->mb_required_fields( $admin_notices[ $slug ] ) ) {

					// Get the current date then set start date to either passed value or current date value and add interval.
					$current_date = current_time( 'm/d/Y' );
					$start        = ( isset( $admin_notices[ $slug ]['start'] ) ? $admin_notices[ $slug ]['start'] : $current_date );
					$start        = date( 'm/d/Y' );
					$interval     = ( isset( $admin_notices[ $slug ]['int'] ) ? $admin_notices[ $slug ]['int'] : 0 );
					$date         = strtotime( '+' . $interval . ' days', strtotime( $start ) );
					$start        = date( 'm/d/Y', $date );

					// This is the main notices storage option.
					$admin_notices_option = get_option( 'mb_admin_notice', array() );
					// Check if the message is already stored and if so just grab the key otherwise store the message and its associated date information.
					if ( ! array_key_exists( $slug, $admin_notices_option ) ) {
						$admin_notices_option[ $slug ]['start'] = date( 'm/d/Y' );
						$admin_notices_option[ $slug ]['int']   = $interval;
						update_option( 'mb_admin_notice', $admin_notices_option );
					}

					// Sanity check to ensure we have accurate information.
					// New date information will not overwrite old date information.
					$admin_display_check    = ( isset( $admin_notices_option[ $slug ]['dismissed'] ) ? $admin_notices_option[ $slug ]['dismissed'] : 0 );
					$admin_display_start    = ( isset( $admin_notices_option[ $slug ]['start'] ) ? $admin_notices_option[ $slug ]['start'] : $start );
					$admin_display_interval = ( isset( $admin_notices_option[ $slug ]['int'] ) ? $admin_notices_option[ $slug ]['int'] : $interval );
					$admin_display_msg      = ( isset( $admin_notices[ $slug ]['msg'] ) ? $admin_notices[ $slug ]['msg'] : '' );
					$admin_display_title    = ( isset( $admin_notices[ $slug ]['title'] ) ? $admin_notices[ $slug ]['title'] : '' );
					$admin_display_link     = ( isset( $admin_notices[ $slug ]['link'] ) ? $admin_notices[ $slug ]['link'] : '' );
					$output_css             = false;

					// Ensure the notice hasn't been hidden and that the current date is after the start date.
					if ( 0 === $admin_display_check && strtotime( $admin_display_start ) <= strtotime( $current_date ) ) {

						// Get remaining query string.
						$query_str = ( isset( $admin_notices[ $slug ]['later_link'] ) ? $admin_notices[ $slug ]['later_link'] : esc_url( add_query_arg( 'mb_admin_notice_ignore', $slug ) ) );
						if ( strpos( $slug, 'promo' ) === false ) {
							// Admin notice display output.
							echo '<div class="update-nag mb-admin-notice">
															 <div></div>
																<strong><p>' . $admin_display_title . '</p></strong>
																<p class="tech-banker-display-notice">' . $admin_display_msg . '</p>
																<strong><ul>' . $admin_display_link . '</ul></strong>
														</div>';// WPCS: XSS ok.
						} else {
							echo '<div class="admin-notice-promo">';
							echo $admin_display_msg;// WPCS: XSS ok.
							echo '<ul class="notice-body-promo blue">
																		' . $admin_display_link . '
																	</ul>';// WPCS: XSS ok.
							echo '</div>';
						}
						$this->notice_spam += 1;
						$output_css         = true;
					}
				}
			}
		}
		/**
		 * Spam protection check.
		 */
		public function mb_anti_notice_spam() {
			if ( $this->notice_spam >= $this->notice_spam_max ) {
				return true;
			}
			return false;
		}
		/**
		 * Ignore function that gets ran at admin init to ensure any messages that were dismissed get marked.
		 */
		public function mb_admin_notice_ignore() {
			// If user clicks to ignore the notice, update the option to not show it again.
			if ( isset( $_GET['mb_admin_notice_ignore'] ) ) { // WPCS: CSRF ok, WPCS: input var ok.
				$admin_notices_option = get_option( 'mb_admin_notice', array() );
				$admin_notices_option[ wp_unslash( $_GET['mb_admin_notice_ignore'] ) ]['dismissed'] = 1; // @codingStandardsIgnoreLine.
				update_option( 'mb_admin_notice', $admin_notices_option );
				$query_str = remove_query_arg( 'mb_admin_notice_ignore' );
				wp_safe_redirect( $query_str );
				exit;
			}
		}
		/**
		 * Temp Ignore function that gets ran at admin init to ensure any messages that were temp dismissed get their start date changed.
		 */
		public function mb_admin_notice_temp_ignore() {
			// If user clicks to temp ignore the notice, update the option to change the start date - default interval of 7 days.
			if ( isset( $_GET['mb_admin_notice_temp_ignore'] ) ) { // WPCS: CSRF ok, WPCS: input var ok.
				$admin_notices_option = get_option( 'mb_admin_notice', array() );
				$current_date         = current_time( 'm/d/Y' );
				$interval             = ( isset( $_GET['int'] ) ? wp_unslash( $_GET['int'] ) : 7 ); // @codingStandardsIgnoreLine.
				$date                 = strtotime( '+' . $interval . ' days', strtotime( $current_date ) );
				$new_start            = date( 'm/d/Y', $date );

				$admin_notices_option[ wp_unslash( $_GET['mb_admin_notice_temp_ignore'] ) ]['start']     = $new_start; // @codingStandardsIgnoreLine.
				$admin_notices_option[ wp_unslash( $_GET['mb_admin_notice_temp_ignore'] ) ]['dismissed'] = 0; // @codingStandardsIgnoreLine.
				update_option( 'mb_admin_notice', $admin_notices_option );
				$query_str = remove_query_arg( array( 'mb_admin_notice_temp_ignore', 'int' ) );
				wp_safe_redirect( $query_str );
				exit;
			}
		}
		/**
		 * This function is used to add admin notices on pages of backend.
		 *
		 * @param string $pages .
		 */
		public function mb_admin_notice_pages( $pages ) {
			foreach ( $pages as $key => $page ) {
				if ( is_array( $page ) ) {
					if ( isset( $_GET['page'] ) && $page[0] === $_GET['page'] && isset( $_GET['tab'] ) && $page[1] === $_GET['tab'] ) { // WPCS: CSRF ok, WPCS: input var ok.
						return true;
					}
				} else {
					if ( 'all' === $page ) {
						return true;
					}
					if ( get_current_screen()->id === $page ) {
						return true;
					}
					if ( isset( $_GET['page'] ) && $page === $_GET['page'] ) { // WPCS: CSRF ok, WPCS: input var ok.
						return true;
					}
				}
				return false;
			}
		}
		/**
		 * Required fields check.
		 *
		 * @param string $fields .
		 */
		public function mb_required_fields( $fields ) {
			if ( ! isset( $fields['msg'] ) || ( isset( $fields['msg'] ) && empty( $fields['msg'] ) ) ) {
				return true;
			}
			if ( ! isset( $fields['title'] ) || ( isset( $fields['title'] ) && empty( $fields['title'] ) ) ) {
				return true;
			}
			return false;
		}
		/**
		 * This function is used to display message on admin notice.
		 */
		public function mb_display_admin_notices() {
			$two_week_review_ignore = add_query_arg( array( 'mb_admin_notice_ignore' => 'two_week_review' ) );
			$two_week_review_temp   = add_query_arg(
				array(
					'mb_admin_notice_temp_ignore' => 'two_week_review',
					'int'                         => 14,
				)
			);

			$mb_sure_love_to            = __( "Sure! I'd love to!", 'wp-mail-bank' );
			$mb_leave_review            = __( "I've already left a review", 'wp-mail-bank' );
			$mb_may_be_later            = __( 'Maybe Later', 'wp-mail-bank' );
			$mb_greatful_message        = __( 'We are grateful that you’ve decided to join the Tech Banker Family and we are putting maximum efforts to provide you with the Best Product.', 'wp-mail-bank' );
			$mb_star_review             = __( 'Your 5 Star Review will Boost our Morale by 10x!', 'wp-mail-bank' );
			$notices['two_week_review'] = array(
				'title'      => __( 'Leave a 5 Star Review', 'wp-mail-bank' ),
				'msg'        => $mb_greatful_message . '</br>' . $mb_star_review,
				'link'       => '<span class="dashicons dashicons-external"></span><span class="tech-banker-admin-notice"><a href="https://wordpress.org/support/plugin/wp-mail-bank/reviews/?filter=5" target="_blank" class="tech-banker-admin-notice-link"> ' . $mb_sure_love_to . ' </a></span>
												<span class="dashicons dashicons-smiley tech-banker-admin-notice"></span><span class="tech-banker-admin-notice"><a href="' . $two_week_review_ignore . '" class="tech-banker-admin-notice-link">' . $mb_leave_review . '</a></span>
												<span class="dashicons dashicons-calendar-alt tech-banker-admin-notice"></span><span class="tech-banker-admin-notice"><a href="' . $two_week_review_temp . '" class="tech-banker-admin-notice-link"> ' . $mb_may_be_later . ' </a></span>',
				'later_link' => $two_week_review_temp,
				'int'        => 14,
			);

			$this->change_admin_notice_mail_bank( $notices );
		}
	}
	$plugin_info_mail_bank = new Mail_Bank_Admin_Notices();
}
add_action( 'init', 'mail_bank_admin_notice_class' );
/**
 * This function is used to add popup on deactivation.
 */
function add_popup_on_deactivation_mail_bank() {
	global $wpdb;
	/**
	 * This class is used to add deactivation form.
	 */
	class Mail_Bank_Deactivation_Form {// @codingStandardsIgnoreLine
		/**
		 * Initialize the class and set its properties.
		 */
		function __construct() {
			add_action( 'wp_ajax_post_user_feedback_mail_bank', array( $this, 'post_user_feedback_mail_bank' ) );
			global $pagenow;
			if ( 'plugins.php' === $pagenow ) {
					add_action( 'admin_enqueue_scripts', array( $this, 'feedback_form_js_mail_bank' ) );
					add_action( 'admin_head', array( $this, 'add_form_layout_mail_bank' ) );
					add_action( 'admin_footer', array( $this, 'add_deactivation_dialog_form_mail_bank' ) );
			}
		}
		/**
		 * Enqueue js files.
		 */
		function feedback_form_js_mail_bank() {
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_register_script( 'mail-bank-feedback', plugins_url( 'assets/global/plugins/deactivation/deactivate-popup.js', __FILE__ ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-dialog' ), false, true );
			wp_localize_script( 'mail-bank-feedback', 'post_feedback', array( 'admin_ajax' => admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_script( 'mail-bank-feedback' );
		}
		/**
		 * This function is used to post user feedback.
		 */
		function post_user_feedback_mail_bank() {
			$mail_bank_deactivation_reason = isset( $_POST['reason'] ) ? wp_unslash( $_POST['reason'] ) : ''; // // @codingStandardsIgnoreLine.
			$plugin_info_wp_mail_bank      = new Plugin_Info_Wp_Mail_Bank();
			global $wp_version, $wpdb;
			$url              = TECH_BANKER_STATS_URL . '/wp-admin/admin-ajax.php';
			$type             = get_option( 'mail-bank-welcome-page' );
			$user_admin_email = get_option( 'mail-bank-admin-email' );
			$theme_details    = array();
			if ( $wp_version >= 3.4 ) {
				$active_theme                   = wp_get_theme();
				$theme_details['theme_name']    = strip_tags( $active_theme->Name );// @codingStandardsIgnoreLine
				$theme_details['theme_version'] = strip_tags( $active_theme->Version );// @codingStandardsIgnoreLine
				$theme_details['author_url']    = strip_tags( $active_theme->{'Author URI'} );
			}
			$plugin_stat_data                   = array();
			$plugin_stat_data['plugin_slug']    = 'wp-mail-bank';
			$plugin_stat_data['reason']         = $mail_bank_deactivation_reason;
			$plugin_stat_data['type']           = 'standard_edition';
			$plugin_stat_data['version_number'] = MAIL_BANK_VERSION_NUMBER;
			$plugin_stat_data['status']         = $type;
			if ( '3' === $mail_bank_deactivation_reason ) {
				$feedback_array               = array();
				$feedback_array['name']       = isset( $_POST['ux_txt_your_name_mail_bank'] ) ? wp_unslash( $_POST['ux_txt_your_name_mail_bank'] ) : ''; //@codingStandardsIgnoreLine.
				$feedback_array['email']      = isset( $_POST['ux_txt_email_address_mail_bank'] ) ? wp_unslash( $_POST['ux_txt_email_address_mail_bank'] ) : '';//@codingStandardsIgnoreLine.
				$feedback_array['request']    = isset( $_POST['ux_txtarea_feedbacks_mail_bank'] ) ? wp_unslash( $_POST['ux_txtarea_feedbacks_mail_bank'] ) : '';//@codingStandardsIgnoreLine.
				$plugin_stat_data['feedback'] = maybe_serialize( $feedback_array );
			}
			$plugin_stat_data['event']            = 'de-activate';
			$plugin_stat_data['domain_url']       = site_url();
			$plugin_stat_data['wp_language']      = defined( 'WPLANG' ) && WPLANG ? WPLANG : get_locale();
			$plugin_stat_data['email']            = false !== $user_admin_email ? $user_admin_email : get_option( 'admin_email' );
			$plugin_stat_data['wp_version']       = $wp_version;
			$plugin_stat_data['php_version']      = esc_html( phpversion() );
			$plugin_stat_data['mysql_version']    = $wpdb->db_version();
			$plugin_stat_data['max_input_vars']   = ini_get( 'max_input_vars' );
			$plugin_stat_data['operating_system'] = PHP_OS . '  (' . PHP_INT_SIZE * 8 . ') BIT';
			$plugin_stat_data['php_memory_limit'] = ini_get( 'memory_limit' ) ? ini_get( 'memory_limit' ) : 'N/A';
			$plugin_stat_data['extensions']       = get_loaded_extensions();
			$plugin_stat_data['plugins']          = $plugin_info_wp_mail_bank->get_plugin_info_wp_mail_bank();
			$plugin_stat_data['themes']           = $theme_details;

			$response = wp_safe_remote_post(
				$url, array(
					'method'      => 'POST',
					'timeout'     => 45,
					'redirection' => 5,
					'httpversion' => '1.0',
					'blocking'    => true,
					'headers'     => array(),
					'body'        => array(
						'data'    => maybe_serialize( $plugin_stat_data ),
						'site_id' => false !== get_option( 'mb_tech_banker_site_id' ) ? get_option( 'mb_tech_banker_site_id' ) : '',
						'action'  => 'plugin_analysis_data',
					),
				)
			);

			if ( ! is_wp_error( $response ) ) {
				false !== $response['body'] ? update_option( 'mb_tech_banker_site_id', $response['body'] ) : '';
			}
				die( 'success' );
		}
		/**
		 * Add layout for deactivation form.
		 */
		function add_form_layout_mail_bank() {
			?>
			<style type="text/css">
					.mail-bank-feedback-form {
						height: auto;
						width: 40% !important;
						top: 406px;
						left: 30% !important;
						right: 30% !important;
						overflow: hidden;
						display: block;
					}
					.feedback-form-submit {
						padding-left: 0px !important;
						padding-right: 0px !important;
						position: relative;
						min-height: 1px;
						float: left;
						width: 100%;
					}
					.feedback-form-submit-col-md-6{
						padding-left: 0px !important;
						padding-right: 0px !important;
						position: relative;
						min-height: 1px;
						width: 50%;
						float: left;
					}
					.mail-bank-feedback-form .ui-dialog-title {
						color : red !important;
					}
					.mail-bank-feedback-form .ui-dialog-titlebar {
						background : #f7f7f7 !important;
					}
					.mail-bank-feedback-form .ui-dialog-buttonpane {
						background : #f7f7f7 !important;
					}
					.mail-bank-feedback-form .ui-dialog-buttonset {
						float: none !important;
					}
					#mail-bank-feedback-dialog-continue,#mail-bank-feedback-dialog-skip {
						float: right;
					}
					#mail-bank-feedback-cancel{
						float: left;
					}
					#mail-bank-feedback-content p {
						font-size: 1.1em;
					}
					.mail-bank-feedback-form .ui-icon {
						display: none;
					}
					#mail-bank-feedback-dialog-continue.mail-bank-ajax-progress .ui-icon {
						text-indent: inherit;
						display: inline-block !important;
						vertical-align: middle;
						animation: rotate 2s infinite linear;
					}
					#mail-bank-feedback-dialog-continue.mail-bank-ajax-progress .ui-button-text {
						vertical-align: middle;
					}
					@keyframes rotate {
					0%    { transform: rotate(0deg); }
					100%  { transform: rotate(360deg); }
					}
			</style>
			<?php
		}
		/**
		 * Add deactivation form Layout.
		 */
		function add_deactivation_dialog_form_mail_bank() {
			?>
			<div id="mail-bank-feedback-content" style="display: none; padding: 16px 16px 0px 16px;">
			<p style="margin-top:-5px"><?php echo esc_attr( __( 'Were you expecting something else or Did it fail to work for you?', 'wp-mail-bank' ) ); ?></p>
						<p><?php echo esc_attr( __( 'If you write about your expectations or experience, we can guarantee a Solution for it would be provided 100% free of cost.', 'wp-mail-bank' ) ); ?></p>
			<form id="ux_frm_deactivation_popup_mail_bank">
				<?php wp_nonce_field(); ?>
				<ul id="mail-bank-deactivate-reasons">
					<li class="mail-bank-reason mail-bank-custom-input">
						<label>
							<span><input value="0" type="radio" name="reason"/></span>
							<span><?php echo esc_attr( __( 'It didn\'t work as expected.', 'wp-mail-bank' ) ); ?></span>
						</label>
					</li>
					<li class="mail-bank-reason mail-bank-custom-input">
						<label>
							<span><input value="1" type="radio" name="reason" /></span>
							<span><?php echo esc_attr( __( 'I found a Better Plugin.', 'wp-mail-bank' ) ); ?></span>
						</label>
					</li>
					<li class="mail-bank-reason mail-bank-custom-input">
						<label>
							<span><input value="2" type="radio" name="reason"></span>
							<span><?php echo esc_attr( __( 'It\'s a temporary deactivation. I\'m just debugging an issue.', 'wp-mail-bank' ) ); ?></span>
						</label>
					</li>
					<li class="mail-bank-reason mail-bank-support">
						<label>
							<span><input value="3" type="radio" id="ux_rdl_reason" name="reason" checked/></span>
							<span><?php echo esc_attr( __( 'Submit a Ticket', 'wp-mail-bank' ) ); ?></span>
						</label>
						<div class="mail-bank-submit-feedback" style="padding: 10px 10px 0px 10px;">
							<div class="feedback-form-submit">
								<div class="feedback-form-submit-col-md-6">
									<strong><?php echo esc_attr( __( 'Name', 'wp-mail-bank' ) ); ?> : </strong>
									<div class="form-group">
										<input type="text" class="form-control" name="ux_txt_your_name_mail_bank" id="ux_txt_your_name_mail_bank" value="">
									</div>
								</div>
								<div class="feedback-form-submit-col-md-6">
									<strong><?php echo esc_attr( __( 'Email', 'wp-mail-bank' ) ); ?> : </strong>
									<div class="form-group">
										<input type="email" class="form-control" id="ux_txt_email_address_mail_bank" name="ux_txt_email_address_mail_bank"/>
									</div>
								</div>
							</div>
							<strong><?php echo esc_attr( __( 'Feedback', 'wp-mail-bank' ) ); ?> : </strong>
							<div class="form-group">
								<textarea class="form-control" style="width: 100%;" name="ux_txtarea_feedbacks_mail_bank" id="ux_txtarea_feedbacks_mail_bank" rows="2" ></textarea>
							</div>
						</div>
					</li>
				</ul>
			</form>
		</div>
			<?php
		}
	}
	$plugin_deactivation_details = new Mail_Bank_Deactivation_Form();
}
add_action( 'plugins_loaded', 'add_popup_on_deactivation_mail_bank' );
/**
 * This function is used to insert decativate link on deactivate link.
 *
 * @param string $links .
 */
function insert_deactivate_link_id_mail_bank( $links ) {
	if ( ! is_multisite() ) {
		$links['deactivate'] = str_replace( '<a', '<a id="mail-bank-plugin-disable-link"', $links['deactivate'] );
	}
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'insert_deactivate_link_id_mail_bank', 10, 2 );
/**
 * This function is used to deactivate plugins.
 */
function deactivate_plugin_mail_bank() {
	if ( wp_verify_nonce( isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '', 'mb_deactivate_plugin_nonce' ) ) {
		deactivate_plugins( isset( $_GET['plugin'] ) ? wp_unslash( $_GET['plugin'] ) : '' );// WPCS: Input var ok, sanitization ok.
		wp_safe_redirect( wp_get_referer() );
		die();
	}
}
add_action( 'admin_post_mail_bank_deactivate_plugin', 'deactivate_plugin_mail_bank' );
/**
 * This function is used to display admin notice.
 */
function display_admin_notice_mail_bank() {
	$conflict_plugins_list = array(
		'WP Mail SMTP by WPForms'    => 'wp-mail-smtp/wp_mail_smtp.php',
		'Post SMTP Mailer/Email Log' => 'post-smtp/postman-smtp.php',
		'Easy WP SMTP'               => 'easy-wp-smtp/easy-wp-smtp.php',
		'Gmail SMTP'                 => 'gmail-smtp/main.php',
		'SMTP Mailer'                => 'smtp-mailer/main.php',
		'WP Email SMTP'              => 'wp-email-smtp/wp_email_smtp.php',
		'SMTP by BestWebSoft'        => 'bws-smtp/bws-smtp.php',
		'WP SendGrid SMTP'           => 'wp-sendgrid-smtp/wp-sendgrid-smtp.php',
		'Cimy Swift SMTP'            => 'cimy-swift-smtp/cimy_swift_smtp.php',
		'SAR Friendly SMTP'          => 'sar-friendly-smtp/sar-friendly-smtp.php',
		'WP Easy SMTP'               => 'wp-easy-smtp/wp-easy-smtp.php',
		'WP Gmail SMTP'              => 'wp-gmail-smtp/wp-gmail-smtp.php',
		'Email Log'                  => 'email-log/email-log.php',
		'SendGrid'                   => 'sendgrid-email-delivery-simplified/wpsendgrid.php',
		'Mailgun for WordPress'      => 'mailgun/mailgun.php',
	);
	$found                 = array();
	foreach ( $conflict_plugins_list as $name => $path ) {
		if ( is_plugin_active( $path ) ) {
				$found[] = array(
					'name' => $name,
					'path' => $path,
				);
		}
	}
	if ( count( $found ) ) {
		?>
		<div class="notice notice-error notice-warning tech-banker-compatiblity-warning">
			<p class="mail-bank-deactivation-message"><?php echo esc_attr( 'WP Mail Bank has detected the following plugins are activated. Please deactivate them to prevent conflicts.', 'wp-mail-bank' ); ?></p>
			<ul>
			<?php
			foreach ( $found as $plugin ) {
				?>
					<li class="tech-banker-deactivation"><strong><?php echo $plugin['name']; // WPCS: XSS ok. ?></strong>
						<a href='<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=mail_bank_deactivate_plugin&plugin=' . urlencode( $plugin['path'] ) ), 'mb_deactivate_plugin_nonce' ); // @codingStandardsIgnoreLine. ?>'class='button button-primary tech-banker-deactivation-button'><?php echo esc_attr( _e( 'Deactivate', 'wp-mail-bank' ) ); ?></a>
					</li>
					<?php
			}
			?>
			</ul>
		</div>
		<?php
	}
}
/**
 * This hook is used to display admin notice.
 */
add_action( 'admin_notices', 'display_admin_notice_mail_bank' );

/**
 * This hook is used to display admin notice.
 */
function upgrade_database_admin_notice() {
	global $wpdb;
	if ( $wpdb->query( "SHOW TABLES LIKE '" . $wpdb->prefix . 'mail_bank_email_logs' . "'" ) != 0 ) { // @codingStandardsIgnoreLine.
		$mb_email_logs_count = $wpdb->get_var(
			'SELECT COUNT(id) FROM ' . $wpdb->prefix . 'mail_bank_email_logs'
		);// WPCS: db call ok; no-cache ok.
		if ( 0 != $mb_email_logs_count ) {// WPCS: Loose comparison ok.
			$batches                    = ceil( $mb_email_logs_count / 3000 );
			$upgrade_database_mail_bank = wp_create_nonce( 'upgrade_database_mail_bank' );
			?>
			<div class="update-nag">
				<strong><?php echo esc_attr( __( 'Important Announcement - Mail Bank?', 'wp-mail-bank' ) ); ?></strong>
				<p><?php echo esc_attr( __( 'We have made imminent changes to our Database to improve the Performance. You would need to update the Database to view prior Email Reports.', 'wp-mail-bank' ) ); ?></p>
				<p><?php echo esc_attr( __( 'All of your Past Email Reports are safely backed up. Contact Us', 'wp-mail-bank' ) ); ?><a href="<?php echo esc_url( TECH_BANKER_URL ); ?>/contact-us/" target="_blank"> <?php echo esc_attr( __( 'here', 'wp-mail-bank' ) ); ?></a> <?php echo esc_attr( __( 'if you face any issues updating your database.', 'wp-mail-bank' ) ); ?></p>
				<a class="btn tech-banker-pro-options" onclick="update_database_interval(<?php echo intval( $batches ); ?>, '<?php echo esc_attr( $upgrade_database_mail_bank ); ?>' );"><?php echo esc_attr( __( 'Update Database!', 'wp-mail-bank' ) ); ?></a>
			</div>
			<?php
		}
	}
}
$database_update_option = get_option( 'mail_bank_update_database' );
if ( false == $database_update_option ) {// WP: loose comparison ok.
	add_action( 'admin_notices', 'upgrade_database_admin_notice' );
}