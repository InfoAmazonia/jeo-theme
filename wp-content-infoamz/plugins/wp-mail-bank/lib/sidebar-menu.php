<?php
/**
 * This file is used for creating sidebar menu.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/lib
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
if ( ! is_user_logged_in() ) {
	return;
} else {
	$access_granted = false;
	foreach ( $user_role_permission as $permission ) {
		if ( current_user_can( $permission ) ) {
			$access_granted = true;
			break;
		}
	}
	if ( ! $access_granted ) {
		return;
	} else {
		$flag = 0;

		$role_capabilities = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT meta_value from ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key = %s', 'roles_and_capabilities'
			)
		); // WPCS: db call ok; no-cache ok.

		$roles_and_capabilities_unserialized_data = maybe_unserialize( $role_capabilities );
		$capabilities                             = explode( ',', $roles_and_capabilities_unserialized_data['roles_and_capabilities'] );

		if ( is_super_admin() ) {
			$mb_role = 'administrator';
		} else {
			$mb_role = check_user_roles_mail_bank();
		}
		switch ( $mb_role ) {
			case 'administrator':
				$privileges = 'administrator_privileges';
				$flag       = $capabilities[0];
				break;

			case 'author':
				$privileges = 'author_privileges';
				$flag       = $capabilities[1];
				break;

			case 'editor':
				$privileges = 'editor_privileges';
				$flag       = $capabilities[2];
				break;

			case 'contributor':
				$privileges = 'contributor_privileges';
				$flag       = $capabilities[3];
				break;

			case 'subscriber':
				$privileges = 'subscriber_privileges';
				$flag       = $capabilities[4];
				break;

			default:
				$privileges = 'other_roles_privileges';
				$flag       = $capabilities[5];
				break;
		}

		foreach ( $roles_and_capabilities_unserialized_data as $key => $value ) {
			if ( $privileges === $key ) {
				$privileges_value = $value;
				break;
			}
		}

		$full_control = explode( ',', $privileges_value );
		if ( ! defined( 'FULL_CONTROL' ) ) {
			define( 'FULL_CONTROL', "$full_control[0]" );
		}
		if ( ! defined( 'EMAIL_CONFIGURATION_MAIL_BANK' ) ) {
			define( 'EMAIL_CONFIGURATION_MAIL_BANK', "$full_control[1]" );
		}
		if ( ! defined( 'TEST_EMAIL_MAIL_BANK' ) ) {
			define( 'TEST_EMAIL_MAIL_BANK', "$full_control[2]" );
		}
		if ( ! defined( 'CONNECTIVITY_TEST_EMAIL_MAIL_BANK' ) ) {
			define( 'CONNECTIVITY_TEST_EMAIL_MAIL_BANK', "$full_control[3]" );
		}
		if ( ! defined( 'EMAIL_LOGS_MAIL_BANK' ) ) {
			define( 'EMAIL_LOGS_MAIL_BANK', "$full_control[4]" );
		}
		if ( ! defined( 'NOTIFICATION_MAIL_BANK' ) ) {
			define( 'NOTIFICATION_MAIL_BANK', "$full_control[5]" );
		}
		if ( ! defined( 'SETTINGS_MAIL_BANK' ) ) {
			define( 'SETTINGS_MAIL_BANK', "$full_control[6]" );
		}
		if ( ! defined( 'ROLES_AND_CAPABILITIES_MAIL_BANK' ) ) {
			define( 'ROLES_AND_CAPABILITIES_MAIL_BANK', "$full_control[7]" );
		}
		if ( ! defined( 'SYSTEM_INFORMATION_MAIL_BANK' ) ) {
			define( 'SYSTEM_INFORMATION_MAIL_BANK', "$full_control[8]" );
		}
		$check_wp_mail_bank_wizard = get_option( 'mail-bank-welcome-page' );
		$mb_pro                    = '<strong style="color:#f25454;"> ( Pro )</strong>';
		if ( '1' === $flag ) {
			global $wp_version;

			$icon = plugins_url( 'assets/global/img/icon.png', dirname( __FILE__ ) );
			if ( $check_wp_mail_bank_wizard ) {
				add_menu_page( $wp_mail_bank, $wp_mail_bank, 'read', 'mb_email_configuration', '', $icon );
			} else {
				add_menu_page( $wp_mail_bank, $wp_mail_bank, 'read', 'wp_mail_bank_wizard', '', plugins_url( 'assets/global/img/icon.png', dirname( __FILE__ ) ) );
				add_submenu_page( $wp_mail_bank, $wp_mail_bank, '', 'read', 'wp_mail_bank_wizard', 'wp_mail_bank_wizard' );
			}

			add_submenu_page( 'mb_email_configuration', $mb_email_configuration, $mb_email_configuration, 'read', 'mb_email_configuration', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_email_configuration' );
			add_submenu_page( 'mb_email_configuration', $mb_test_email, $mb_test_email, 'read', 'mb_test_email', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_test_email' );
			add_submenu_page( 'mb_email_configuration', $mb_connectivity_test, $mb_connectivity_test, 'read', 'mb_connectivity_test', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_connectivity_test' );
			add_submenu_page( 'mb_email_configuration', $mb_email_logs, $mb_email_logs . $mb_pro, 'read', 'mb_email_logs', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_email_logs' );
			add_submenu_page( 'mb_email_configuration', $mb_notifications, $mb_notifications . $mb_pro, 'read', 'mb_notifications', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_notifications' );
			add_submenu_page( 'mb_email_configuration', $mb_settings, $mb_settings, 'read', 'mb_settings', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_settings' );
			add_submenu_page( 'mb_email_configuration', $mb_roles_and_capabilities, $mb_roles_and_capabilities, 'read', 'mb_roles_and_capabilities', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_roles_and_capabilities' );
			add_submenu_page( 'mb_email_configuration', $mb_upgrade_now, $mb_upgrade_now, 'read', 'mb_upgrade_now', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_upgrade_now' );
			add_submenu_page( 'mb_email_configuration', $mb_system_information, $mb_system_information, 'read', 'mb_system_information', false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : 'mb_system_information' );
		}

		if ( ! function_exists( 'wp_mail_bank_wizard' ) ) {
			/**
			 * This function is used for creating wp_mail_bank_wizard.
			 */
			function wp_mail_bank_wizard() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/wizard/wizard.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/wizard/wizard.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}

		if ( ! function_exists( 'mb_email_configuration' ) ) {
			/**
			 * This function is used for email configuration.
			 */
			function mb_email_configuration() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/email-setup/email-setup.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/email-setup/email-setup.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_test_email' ) ) {
			/**
			 * This function is used to create mb_test_email menu.
			 */
			function mb_test_email() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/test-email/test-email.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/test-email/test-email.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_connectivity_test' ) ) {
			/**
			 * This function is used to create mb_connectivity_test menu.
			 */
			function mb_connectivity_test() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/connectivity-test/connectivity-test.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/connectivity-test/connectivity-test.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_email_logs' ) ) {
			/**
			 * This function is used to create mb_email_logs menu.
			 */
			function mb_email_logs() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/email-logs/email-logs.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/email-logs/email-logs.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_notifications' ) ) {
			/**
			 * This function is used for dashboard.
			 */
			function mb_notifications() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/notifications/notifications.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/notifications/notifications.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_settings' ) ) {
			/**
			 * This function is used for plugin settings.
			 */
			function mb_settings() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/settings/settings.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/settings/settings.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_roles_and_capabilities' ) ) {
			/**
			 * This function is used to create mb_roles_and_capabilities menu.
			 */
			function mb_roles_and_capabilities() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/roles-and-capabilities/roles-and-capabilities.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/roles-and-capabilities/roles-and-capabilities.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_upgrade_now' ) ) {
			/**
			 * This function is used for dashboard.
			 */
			function mb_upgrade_now() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/pricing-plans/pricing-plans.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/pricing-plans/pricing-plans.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
		if ( ! function_exists( 'mb_system_information' ) ) {
			/**
			 * This function is used to create mb_system_information menu.
			 */
			function mb_system_information() {
				global $wpdb, $user_role_permission;
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/translations.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/translations.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/header.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/header.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/queries.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/queries.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'views/system-information/system-information.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'views/system-information/system-information.php';
				}
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/footer.php' ) ) {
					include_once MAIL_BANK_DIR_PATH . 'includes/footer.php';
				}
			}
		}
	}
}
