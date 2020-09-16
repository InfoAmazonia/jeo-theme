<?php
/**
 * This file is used for creating admin bar menu.
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
				'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key = %s', 'roles_and_capabilities'
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
				$flag = $capabilities[0];
				break;

			case 'author':
				$flag = $capabilities[1];
				break;

			case 'editor':
				$flag = $capabilities[2];
				break;

			case 'contributor':
				$flag = $capabilities[3];
				break;

			case 'subscriber':
				$flag = $capabilities[4];
				break;

			default:
				$flag = $capabilities[5];
				break;
		}

		if ( '1' === $flag ) {
			global $wp_version;
			$icon = '<img style="vertical-align:middle; margin-right:3px; display:inline-block;" src=' . plugins_url( 'assets/global/img/icon.png', dirname( __FILE__ ) ) . '>';
			$wp_admin_bar->add_menu(
				array(
					'id'    => 'wp_mail_bank',
					'title' => $icon . '<span class="ab-label">' . $wp_mail_bank . '</span>',
					'href'  => admin_url( 'admin.php?page=mb_email_configuration' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'email_configuration_mail_bank',
					'title'  => $mb_email_configuration,
					'href'   => admin_url( 'admin.php?page=mb_email_configuration' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'test_email_mail_bank',
					'title'  => $mb_test_email,
					'href'   => admin_url( 'admin.php?page=mb_test_email' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'connectivity_test_mail_bank',
					'title'  => $mb_connectivity_test,
					'href'   => admin_url( 'admin.php?page=mb_connectivity_test' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'email_logs_mail_bank',
					'title'  => $mb_email_logs,
					'href'   => admin_url( 'admin.php?page=mb_email_logs' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'notifications_mail_bank',
					'title'  => $mb_notifications,
					'href'   => admin_url( 'admin.php?page=mb_notifications' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'general_settings_mail_bank',
					'title'  => $mb_settings,
					'href'   => admin_url( 'admin.php?page=mb_settings' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'roles_and_capabilities_mail_bank',
					'title'  => $mb_roles_and_capabilities,
					'href'   => admin_url( 'admin.php?page=mb_roles_and_capabilities' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'recommended_mail_bank',
					'title'  => $mb_upgrade_now,
					'href'   => admin_url( 'admin.php?page=mb_upgrade_now' ),
				)
			);
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'wp_mail_bank',
					'id'     => 'system_information_mail_bank',
					'title'  => $mb_system_information,
					'href'   => admin_url( 'admin.php?page=mb_system_information' ),
				)
			);
		}
	}
}
