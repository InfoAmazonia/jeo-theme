<?php
/**
 * This file is used for translation strings.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}// Exit if accessed directly
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
		// Disclaimer.
		$mb_pro_label               = 'Pro';
		$mb_message_premium_edition = __( 'This feature is available only in Pro Edition. Kindly Purchase to unlock it!', 'wp-mail-bank' );

			// Sidebar.
		$mb_learn_more             = __( 'Learn More »', 'wp-mail-bank' );
		$mb_advance_email_fields   = __( 'Advanced Email Fields', 'wp-mail-bank' );
		$mb_detailed_email_reports = __( 'Detailed Email Reports', 'wp-mail-bank' );
		$mb_reports_filtering      = __( 'Email Reports Filtering', 'wp-mail-bank' );
		$mb_technical_support      = __( '24/7 Technical Support', 'wp-mail-bank' );
		$mb_upgrade                = __( 'Upgrade To Premium »', 'wp-mail-bank' );
		$mb_join_group             = __( 'Join the Group', 'wp-mail-bank' );
		$mb_leave_review           = __( 'Leave my Review »', 'wp-mail-bank' );
		$mb_vip_community          = __( 'Become part of the Tech Banker VIP Community on Facebook. You will get access to the latest beta releases, get help with issues or simply meet like-minded people', 'wp-mail-bank' );
		$mb_greatful_message       = __( 'We are grateful that you’ve decided to join the Tech Banker Family and we are putting maximum efforts to provide you with the Best Product.', 'wp-mail-bank' );
		$mb_star_review            = __( 'Your 5 Star Review will Boost our Morale by 10x!', 'wp-mail-bank' );
		$mb_star_review_title      = __( 'Leave a 5 Star Review', 'wp-mail-bank' );

			// Dashboard.
		$mb_set_up_guide                   = __( 'Setup Guide', 'wp-mail-bank' );
		$mb_join_community                 = __( 'Join Our Community', 'wp-mail-bank' );
		$mb_set_up_auth_configuration      = __( 'How to setup Gmail/Google SMTP?', 'wp-mail-bank' );
		$mb_set_up_microsoft_configuration = __( 'How to setup Office 365 SMTP?', 'wp-mail-bank' );
		$mb_set_up_yahoo_configuration     = __( 'How to setup Yahoo SMTP?', 'wp-mail-bank' );
		$mb_send_grid_configuration        = __( 'How to setup SendGrid SMTP?', 'wp-mail-bank' );
		$mb_mailgun_configuration          = __( 'How to setup Mailgun SMTP?', 'wp-mail-bank' );
		$mb_follow_us_on_facebook          = __( 'Join Our Facebook VIP Group', 'wp-mail-bank' );
		$mb_follow_us_on_facebook_page     = __( 'Follow Us on Our Facebook Page', 'wp-mail-bank' );
		$mb_follow_us_on_twitter           = __( 'Follows Us on Twitter', 'wp-mail-bank' );
		$mb_support                        = __( 'Contact 24/7 Support', 'wp-mail-bank' );
		$mb_leave_a_five_star_rating       = __( 'Leave Us a 5 Star Review', 'wp-mail-bank' );

		// Wizard.
		$mb_wizard_welcome_message         = __( 'Hi!', 'wp-mail-bank' );
		$mb_wizard_opportunity             = __( 'Don\'t ever miss an opportunity to opt-in for Email Notifications / Announcements and Special Offers', 'wp-mail-bank' );
		$mb_wizard_diagnostic_info         = __( 'Contribute to making our plugin compatible with most plugins and themes by allowing to share non-sensitive diagnostic information about your website', 'wp-mail-bank' );
		$mb_wizard_email_address           = __( 'Name & Email to receive Notifications / Announcements / Special Offers', 'wp-mail-bank' );
		$mb_wizard_ready                   = __( 'If you\'re not ready to Opt-In, that\'s ok too', 'wp-mail-bank' );
		$mb_wizard_mail_bank               = __( 'Mail Bank will still work fine', 'wp-mail-bank' );
		$mb_wizard_permission_granted      = __( 'What permissions are being granted', 'wp-mail-bank' );
		$mb_wizard_current_plugin          = __( 'Current Plugin Events', 'wp-mail-bank' );
		$mb_wizard_activation_deactivation = __( 'Activation, Deactivation and Uninstall', 'wp-mail-bank' );
		$mb_wizard_website_overview        = __( 'Website Overview', 'wp-mail-bank' );
		$mb_wizard_updates_announcements   = __( 'Updates, Announcements, Marketing, No Spam', 'wp-mail-bank' );
		$mb_wizard_site_info               = __( 'Site URL, WP Version, PHP Info, Plugins &amp; Themes Info', 'wp-mail-bank' );
		$mb_wizard_newsletter              = __( 'Newsletter', 'wp-mail-bank' );
		$mb_wizard_skip                    = __( 'Skip', 'wp-mail-bank' );
		$mb_wizard_opt_in                  = __( 'Opt-In', 'wp-mail-bank' );
		$mb_wizard_continue                = __( 'Continue', 'wp-mail-bank' );
		$mb_wizard_terms                   = __( 'Terms', 'wp-mail-bank' );
		$mb_wizard_conditions              = __( 'Conditions', 'wp-mail-bank' );

		// Notifications.
		$mb_copied_successfully                  = __( 'Copied', 'wp-mail-bank' );
		$mb_more_options                         = __( 'More Options Available with Pro!', 'wp-mail-bank' );
		$mb_leave_review                         = __( 'Leave A Review For Mail Bank!', 'wp-mail-bank' );
		$mb_notifications_service                = __( 'Notification Services', 'wp-mail-bank' );
		$mb_notifications_service_tooltip        = __( 'Select the notification service you want to recieve alerts about failed emails', 'wp-mail-bank' );
		$mb_notifications_service_email          = __( 'Email', 'wp-mail-bank' );
		$mb_notifications_service_pushover       = __( 'Push Over', 'wp-mail-bank' );
		$mb_notifications_service_slack          = __( 'Slack', 'wp-mail-bank' );
		$mb_notifications_service_pushover_key   = __( 'Pushover User Key', 'wp-mail-bank' );
		$mb_notifications_service_pushover_token = __( 'Pushover App Token', 'wp-mail-bank' );
		$mb_notifications_service_slack_web_book = __( 'Slack WebHook', 'wp-mail-bank' );

		// fetch settings.
		$mb_fetch_settings         = __( 'Fetch Settings', 'wp-mail-bank' );
		$mb_fetch_settings_tooltip = __( 'Choose options for Fetch Settings', 'wp-mail-bank' );
		$mb_indivisual_site        = __( 'Individual Site', 'wp-mail-bank' );
		$mb_multiple_site          = __( 'Network Site', 'wp-mail-bank' );

		// wizard.
		$mb_wizard_first_name    = __( 'First Name', 'wp-mail-bank' );
		$mb_wizard_last_name     = __( 'Last Name', 'wp-mail-bank' );
		$mb_wizard_basic_info    = __( 'Basic Info', 'wp-mail-bank' );
		$mb_wizard_account_setup = __( 'Account Setup', 'wp-mail-bank' );
		$mb_wizard_confirm       = __( 'Confirm', 'wp-mail-bank' );

		// Menus.
		$wp_mail_bank              = 'WP Mail Bank';
		$mb_email_configuration    = __( 'Setup Wizard', 'wp-mail-bank' );
		$mb_email_logs             = __( 'Email Reports', 'wp-mail-bank' );
		$mb_test_email             = __( 'Send Test Email', 'wp-mail-bank' );
		$mb_settings               = __( 'General Settings', 'wp-mail-bank' );
		$mb_notifications          = __( 'Notifications', 'wp-mail-bank' );
		$mb_roles_and_capabilities = __( 'Roles & Capabilities', 'wp-mail-bank' );
		$mb_system_information     = __( 'System Information', 'wp-mail-bank' );
		$mb_upgrade_now            = __( 'Upgrade Now', 'wp-mail-bank' );

		// Footer.
		$mb_success                 = __( 'Success!', 'wp-mail-bank' );
		$mb_settings_saved          = __( 'Settings Saved!', 'wp-mail-bank' );
		$mb_test_email_sent         = __( 'Test Email was sent Successfully!', 'wp-mail-bank' );
		$mb_test_email_not_send     = __( 'Test Email was not sent!', 'wp-mail-bank' );
		$mb_choose_record_to_delete = __( 'Please choose to proceed!', 'wp-mail-bank' );
		$mb_confirm                 = __( 'Are You Sure?', 'wp-mail-bank' );
		$mb_delete_log              = __( 'Deleted Successfully!', 'wp-mail-bank' );
		$oauth_not_supported        = __( 'The OAuth is not supported by providing SMTP Host, kindly provide username and password', 'wp-mail-bank' );
		$mb_test_email_resent       = __( 'Resent Successfully!', 'wp-mail-bank' );
		$mb_resend_email_process    = __( 'Unfortunately, Your Email has not been Sent', 'wp-mail-bank' );

		// Common Variables.
		$mb_user_access_message = __( "You don't have Sufficient Access to this Page. Kindly contact the Administrator for more Privileges", 'wp-mail-bank' );
		$mb_enable              = __( 'Enable', 'wp-mail-bank' );
		$mb_disable             = __( 'Disable', 'wp-mail-bank' );
		$mb_override            = __( 'Yes', 'wp-mail-bank' );
		$mb_dont_override       = __( 'No', 'wp-mail-bank' );
		$mb_save_changes        = __( 'Save Settings', 'wp-mail-bank' );
		$mb_subject             = __( 'Subject', 'wp-mail-bank' );
		$mb_action              = __( 'Action', 'wp-mail-bank' );
		$mb_next_step           = __( 'Next Step', 'wp-mail-bank' );
		$mb_previous_step       = __( 'Previous Step', 'wp-mail-bank' );

		// Email Setup.
		$mb_email_configuration_cc_label                   = 'CC';
		$mb_mailgun_api_details                            = __( 'Get Mailgun API Key', 'wp-mail-bank' );
		$mb_mailgun_api_details_tooltip                    = __( 'In this field, you would need to provide Mailgun API Key', 'wp-mail-bank' );
		$mb_mailgun_domain_name                            = __( 'Domain Name', 'wp-mail-bank' );
		$mb_mailgun_domain_name_tooltip                    = __( 'In this field, you would need to provide Mailgun domain name', 'wp-mail-bank' );
		$mb_send_grid_api_details                          = __( 'SendGrid API', 'wp-mail-bank' );
		$mb_send_grid_api_details_tooltip                  = __( 'In this field, you need to provide SendGrid API Key', 'wp-mail-bank' );
		$mb_email_configuration_bcc_label                  = 'BCC';
		$mb_email_configuration_cc_email_address_tooltip   = __( 'A valid Email Address that will be used in the \'CC\' field of the email. Use Comma \',\' for including multiple email addresses in the \'CC\' field', 'wp-mail-bank' );
		$mb_email_configuration_bcc_email_address_tooltip  = __( 'A valid Email Address that will be used in the \'BCC\' field of the email. Use Comma \',\' for including multiple email addresses in the \'BCC\' field', 'wp-mail-bank' );
		$mb_email_configuration_from_name                  = __( 'From Name', 'wp-mail-bank' );
		$mb_email_configuration_from_email                 = __( 'From Email', 'wp-mail-bank' );
		$mb_email_configuration_mailer_type                = __( 'Mailer', 'wp-mail-bank' );
		$mb_email_configuration_mailer_type_tooltip        = __( 'A program that will be used to transmit all your emails', 'wp-mail-bank' );
		$mb_email_configuration_send_email_via_smtp        = __( 'Send Email via SMTP', 'wp-mail-bank' );
		$mb_email_configuration_send_email_via_mailgun_api = __( 'Mailgun API', 'wp-mail-bank' );
		$mb_get_sendgrid_api_key                           = __( 'Get SendGrid API Key', 'wp-mail-bank' );
		$mb_email_configuration_use_php_mail_function      = __( 'Use The PHP mail() Function', 'wp-mail-bank' );
		$mb_email_configuration_smtp_host_tooltip          = __( 'Server that will send the email', 'wp-mail-bank' );
		$mb_email_configuration_smtp_port                  = __( 'SMTP Port', 'wp-mail-bank' );
		$mb_email_configuration_smtp_port_tooltip          = __( 'Port to connect to the email server', 'wp-mail-bank' );
		$mb_email_configuration_encryption                 = __( 'Encryption', 'wp-mail-bank' );
		$mb_email_configuration_encryption_tooltip         = __( 'Encrypt the email using different methods when sent to the email server', 'wp-mail-bank' );
		$mb_email_configuration_no_encryption              = 'No Encryption';
		$mb_email_configuration_use_ssl_encryption         = 'SSL Encryption';
		$mb_email_configuration_use_tls_encryption         = 'TLS Encryption';
		$mb_email_configuration_authentication_tooltip     = __( 'Method for authentication (almost always Login)', 'wp-mail-bank' );
		$mb_email_configuration_test_email_address_tooltip = __( 'An Email Address to which you would like to send a Test Email', 'wp-mail-bank' );
		$mb_email_configuration_subject_test_tooltip       = __( 'Subject Line for your Test Email', 'wp-mail-bank' );
		$mb_email_configuration_content                    = __( 'Email Content', 'wp-mail-bank' );
		$mb_email_configuration_content_tooltip            = __( 'Email Content for your Test Email', 'wp-mail-bank' );
		$mb_email_configuration_send_test_email_textarea   = __( 'Checking your settings', 'wp-mail-bank' );
		$mb_email_configuration_result                     = __( 'Result', 'wp-mail-bank' );
		$mb_email_configuration_send_another_test_email    = __( 'Send Another Test Email', 'wp-mail-bank' );
		$mb_email_configuration_enable_from_name           = __( 'Override From Name Field', 'wp-mail-bank' );
		$mb_email_configuration_enable_from_name_tooltip   = __( 'Do you want to use this Option for all emails, ignoring values set by other plugins', 'wp-mail-bank' );
		$mb_email_configuration_enable_from_email          = __( 'Override From Email Field', 'wp-mail-bank' );
		$mb_email_configuration_username                   = __( 'Username', 'wp-mail-bank' );
		$mb_email_configuration_username_tooltip           = __( 'Login is typically the full email address (Example: mailbox@yourdomain.com)', 'wp-mail-bank' );
		$mb_email_configuration_password                   = __( 'Password', 'wp-mail-bank' );
		$mb_email_configuration_password_tooltip           = __( 'Password is typically the same as the password to retrieve the email', 'wp-mail-bank' );
		$mb_email_configuration_redirect_uri               = __( 'Redirect URI', 'wp-mail-bank' );
		$mb_email_configuration_redirect_uri_tooltip       = __( 'Please copy this Redirect URI and Paste into Redirect URI field when creating your app', 'wp-mail-bank' );
		$mb_email_configuration_use_oauth                  = 'OAuth (Client ID and Secret Key required)';
		$mb_email_configuration_none                       = 'None';
		$mb_email_configuration_use_plain_authentication   = 'Plain Authentication';
		$mb_email_configuration_login                      = 'Login';
		$mb_email_configuration_client_id                  = __( 'Client ID', 'wp-mail-bank' );
		$mb_email_configuration_client_secret              = __( 'Secret Key', 'wp-mail-bank' );
		$mb_email_configuration_client_id_tooltip          = __( 'Client ID issued by your SMTP Host', 'wp-mail-bank' );
		$mb_email_configuration_client_secret_tooltip      = __( 'Secret Key issued by your SMTP Host', 'wp-mail-bank' );
		$mb_email_configuration_tick_for_sent_mail         = __( 'Yes, send a Test Email upon clicking on the Next Step Button to verify Settings', 'wp-mail-bank' );
		$mb_email_configuration_email_address              = __( 'Email Address', 'wp-mail-bank' );
		$mb_email_configuration_email_address_tooltip      = __( 'The email address used for sending emails. If you are using an email provider (Gmail, Yahoo, Outlook, etc), this should be your email address for that account', 'wp-mail-bank' );
		$mb_email_configuration_reply_to                   = __( 'Reply To', 'wp-mail-bank' );
		$mb_email_configuration_reply_to_tooltip           = __( 'A valid Email Address that will be used in the \'Reply-To\' field of the email', 'wp-mail-bank' );
		$mb_email_installed_firewall_message               = __( 'Your host may have installed a firewall between you and the server. Ask them to open the ports.', 'wp-mail-bank' );
		$mb_email_incorrect_port_message                   = __( 'You may have tried to (incorrectly) use SSL over port 587. Check your encryption and port settings.', 'wp-mail-bank' );
		$mb_email_poor_connectivity_message                = __( 'Your host may have poor connectivity to the mail server. Try doubling the Read Timeout.', 'wp-mail-bank' );
		$mb_email_drop_packets_message                     = __( 'Your host may have installed a firewall (DROP packets) between you and the server. Ask them to open the ports.', 'wp-mail-bank' );
		$mb_email_encryption_message                       = __( 'Your host may have tried to (incorrectly) use TLS over port 465. Check your encryption and port settings.', 'wp-mail-bank' );
		$mb_email_open_port_message                        = __( 'Your host has likely installed a firewall (REJECT packets) between you and the server. Ask them to open the ports.', 'wp-mail-bank' );
		$mb_email_debug_output_firewall_message            = __( 'Your Web Host provider may have installed a firewall between you and the server.', 'wp-mail-bank' );
		$mb_email_debug_output_host_provider_message       = __( 'Contact the admin of the server and ask if they allow outgoing communication on port 25,465,587.', 'wp-mail-bank' );
		$mb_email_debug_output_contact_admin_message       = __( 'It seems like they are blocking certain traffic. Ask them to open the ports.', 'wp-mail-bank' );
		$mb_email_blocked_message                          = __( 'Your Web Host provider may have blocked the use of mail() function on your server.', 'wp-mail-bank' );
		$mb_enable_mail_message                            = __( 'Ask them to enable the mail() function to start sending emails.', 'wp-mail-bank' );
		$mb_email_configuration_get_credentials            = __( 'Get API Key', 'wp-mail-bank' );
		$mb_email_configuration_how_to_set_up              = __( 'How to setup?', 'wp-mail-bank' );

		// Email Reports.
		$mb_start_date_title         = __( 'Start Date', 'wp-mail-bank' );
		$mb_resend                   = __( 'Resend Email', 'wp-mail-bank' );
		$mb_start_date_tooltip       = __( 'Date from where you would like to see Email Reports', 'wp-mail-bank' );
		$mb_end_date_title           = __( 'End Date', 'wp-mail-bank' );
		$mb_limit_records_title      = __( 'Total Reports', 'wp-mail-bank' );
		$mb_limit_records_tooltip    = __( 'Number of Reports to view', 'wp-mail-bank' );
		$mb_status_sent              = __( 'Sent', 'wp-mail-bank' );
		$mb_status_not_sent          = __( 'Not Sent', 'wp-mail-bank' );
		$mb_status_tooltip           = __( 'Status of Reports to view', 'wp-mail-bank' );
		$mb_all_records              = 'All';
		$mb_end_date_tooltip         = __( 'Date till where you would like to see Email Reports', 'wp-mail-bank' );
		$mb_submit                   = __( 'Filter', 'wp-mail-bank' );
		$mb_email_logs_bulk_action   = __( 'Bulk Action', 'wp-mail-bank' );
		$mb_email_logs_delete        = __( 'Delete', 'wp-mail-bank' );
		$mb_email_logs_apply         = __( 'Apply', 'wp-mail-bank' );
		$mb_email_logs_email_to      = __( 'Email To', 'wp-mail-bank' );
		$mb_email_logs_email_details = __( 'Email Details', 'wp-mail-bank' );
		$mb_email_logs_show_outputs  = __( 'Debug Output', 'wp-mail-bank' );
		$mb_email_sent_to            = __( 'Email Sent To', 'wp-mail-bank' );
		$mb_date_time                = __( 'Date/Time', 'wp-mail-bank' );
		$mb_from                     = __( 'From', 'wp-mail-bank' );
		$mb_back_to_email_logs       = __( 'Back to Email Reports', 'wp-mail-bank' );

		// Settings.
		$mb_settings_auto_clear_logs                   = __( 'Auto Clear Email Reports', 'wp-mail-bank' );
		$mb_settings_auto_clear_logs_tooltips          = __( 'Do you want to Clear Email Reports Automatically?', 'wp-mail-bank' );
		$mb_settings_delete_logs_after                 = __( 'Delete Email Reports of', 'wp-mail-bank' );
		$mb_settings_delete_logs_after_tooltips        = __( 'Email Reports would be removed automatically after the above specified days', 'wp-mail-bank' );
		$mb_settings_delete_logs_after_one_day         = __( '1 Day', 'wp-mail-bank' );
		$mb_settings_delete_logs_after_seven_days      = __( '7 Days', 'wp-mail-bank' );
		$mb_settings_delete_logs_after_forteen_days    = __( '14 Days', 'wp-mail-bank' );
		$mb_settings_delete_logs_after_twentyone_days  = __( '21 Days', 'wp-mail-bank' );
		$mbsettings_delete_logs_after_twentyeight_days = __( '28 Days', 'wp-mail-bank' );
		$mb_settings_automatic_plugin_update           = __( 'Automatic Plugin Updates', 'wp-mail-bank' );
		$mb_settings_automatic_plugin_update_tooltip   = __( 'Do you wish to Automatically Update the Plugin whenever a New Version is available?', 'wp-mail-bank' );
		$mb_settings_debug_mode                        = __( 'Debug Mode', 'wp-mail-bank' );
		$mb_settings_debug_mode_tooltip                = __( 'Do you want to see Debugging Output for your emails?', 'wp-mail-bank' );
		$mb_remove_tables_title                        = __( 'Remove Database at Uninstall', 'wp-mail-bank' );
		$mb_remove_tables_tooltip                      = __( 'Do you wish to remove all Database Settings when the Plugin is Deleted?', 'wp-mail-bank' );
		$mb_monitoring_email_log_title                 = __( 'Monitoring Email Reports', 'wp-mail-bank' );
		$mb_monitoring_email_log_tooltip               = __( 'Do you want to monitor your all Outgoing Emails?', 'wp-mail-bank' );

		// Roles and Capabilities.
		$mb_roles_capabilities_show_menu                        = __( 'Show Mail Bank Menu', 'wp-mail-bank' );
		$mb_roles_capabilities_show_menu_tooltip                = __( 'Choose among the following roles who would be able to see the Mail Bank Menu?', 'wp-mail-bank' );
		$mb_roles_capabilities_administrator                    = __( 'Administrator', 'wp-mail-bank' );
		$mb_roles_capabilities_author                           = __( 'Author', 'wp-mail-bank' );
		$mb_roles_capabilities_editor                           = __( 'Editor', 'wp-mail-bank' );
		$mb_roles_capabilities_contributor                      = __( 'Contributor', 'wp-mail-bank' );
		$mb_roles_capabilities_subscriber                       = __( 'Subscriber', 'wp-mail-bank' );
		$mb_roles_capabilities_others                           = __( 'Others', 'wp-mail-bank' );
		$mb_roles_capabilities_topbar_menu                      = __( 'Show Mail Bank Top Bar Menu', 'wp-mail-bank' );
		$mb_roles_capabilities_topbar_menu_tooltip              = __( 'Do you want to show Mail Bank menu in Top Bar?', 'wp-mail-bank' );
		$mb_roles_capabilities_administrator_role               = __( 'An Administrator Role can do the following', 'wp-mail-bank' );
		$mb_roles_capabilities_administrator_role_tooltip       = __( 'Choose what pages would be visible to the users having Administrator Access', 'wp-mail-bank' );
		$mb_roles_capabilities_full_control                     = __( 'Full Control', 'wp-mail-bank' );
		$mb_roles_capabilities_author_role                      = __( 'An Author Role can do the following', 'wp-mail-bank' );
		$mb_roles_capabilities_author_role_tooltip              = __( 'Choose what pages would be visible to the users having Author Access', 'wp-mail-bank' );
		$mb_roles_capabilities_editor_role                      = __( 'An Editor Role can do the following', 'wp-mail-bank' );
		$mb_roles_capabilities_editor_role_tooltip              = __( 'Choose what pages would be visible to the users having Editor Access', 'wp-mail-bank' );
		$mb_roles_capabilities_contributor_role                 = __( 'A Contributor Role can do the following', 'wp-mail-bank' );
		$mb_roles_capabilities_contributor_role_tooltip         = __( 'Choose what pages would be visible to the users having Contributor Access', 'wp-mail-bank' );
		$mb_roles_capabilities_other_role                       = __( 'Other Roles can do the following', 'wp-mail-bank' );
		$mb_roles_capabilities_other_role_tooltip               = __( 'Choose what pages would be visible to the users having Others Role Access', 'wp-mail-bank' );
		$mb_roles_capabilities_other_roles_capabilities         = __( 'Please tick the appropriate capabilities for security purposes', 'wp-mail-bank' );
		$mb_roles_capabilities_other_roles_capabilities_tooltip = __( 'Only users with these capabilities can access Mail Bank', 'wp-mail-bank' );
		$mb_roles_capabilities_subscriber_role                  = __( 'A Subscriber Role can do the following', 'wp-mail-bank' );
		$mb_roles_capabilities_subscriber_role_tooltip          = __( 'Choose what pages would be visible to the users having Subscriber Access', 'wp-mail-bank' );

		// Test Email.
		$mb_test_email_sending_test_email = __( 'Sending Test Email to', 'wp-mail-bank' );
		$mb_test_email_status             = __( 'Email Status', 'wp-mail-bank' );

		// Connectivity Test.
		$mb_connectivity_test   = __( 'Connectivity Test', 'wp-mail-bank' );
		$mb_transport           = __( 'Transport', 'wp-mail-bank' );
		$mb_socket              = __( 'Socket', 'wp-mail-bank' );
		$mb_status              = __( 'Status', 'wp-mail-bank' );
		$mb_authentication      = __( 'Authentication', 'wp-mail-bank' );
		$mb_cram_md5            = 'CRAM-MD5';
		$mb_smtp                = __( 'SMTP', 'wp-mail-bank' );
		$mb_mail_server_host    = __( 'SMTP Host', 'wp-mail-bank' );
		$mb_begin_test          = __( 'Begin Test', 'wp-mail-bank' );
		$mb_mail_server_tooltip = __( 'SMTP Server that you would like to use for a Connectivity Test', 'wp-mail-bank' );

		// Email Setup.
		$mb_additional_header         = __( 'Additional Email Headers', 'wp-mail-bank' );
		$mb_additional_header_tooltip = __( 'You also can insert additional headers in this optional field in order to include in your email', 'wp-mail-bank' );
		$mb_licensing_api_key_label   = __( 'API KEY', 'wp-mail-bank' );
	}
}
