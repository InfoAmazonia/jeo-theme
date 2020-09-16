<?php
/**
 * This file is used for widget.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/lib
 * @version 2.0.0
 */

	/**
	 * This file is used for displaying dashboard widget.
	 *
	 * @param string $type .
	 */
function get_mail_configuration_data_mail_bank( $type ) {
	global $wpdb;
	$meta_value = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key=%s', $type
		)
	);// WPCS: db call ok; no-cache ok.
	return maybe_unserialize( $meta_value );
}
$unserialized_mail_configuration_data = get_mail_configuration_data_mail_bank( 'email_configuration' );
/**
 * This is used for displaying today's data.
 *
 * @param string $current_date .
 * @param string $status .
 */
function get_mail_bank_today_logs_data( $current_date, $status ) {
	global $wpdb;
	// Get current week data.
	$current_date          = strtotime( date( 'y-m-d' ) );
	$email_logs_today_data = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT count( status ) FROM ' . $wpdb->prefix . 'mail_bank_logs WHERE timestamp >= %d AND status = %s', $current_date, $status
		)
	);// WPCS: db call ok; no-cache ok.
	return $email_logs_today_data;
}
$email_logs_today_sent_data     = get_mail_bank_today_logs_data( strtotime( date( 'y-m-d' ) ), 'Sent' );
$email_logs_today_not_sent_data = get_mail_bank_today_logs_data( strtotime( date( 'y-m-d' ) ), 'Not Sent' );

/**
 * This is used for displaying current week data.
 *
 * @param string $start_date .
 * @param string $end_date .
 * @param string $status .
 */
function get_mail_bank_logs_data( $start_date, $end_date, $status ) {
	global $wpdb;
	// Get current week data.
	$end_date        = MAIL_BANK_LOCAL_TIME;
	$start_date      = strtotime( 'monday this week', $end_date );
	$email_logs_data = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT count( status ) FROM ' . $wpdb->prefix . 'mail_bank_logs WHERE timestamp BETWEEN %d AND %d AND status = %s', $start_date, $end_date, $status
		)
	);// WPCS: db call ok; no-cache ok.
	return $email_logs_data;
}
$email_logs_sent_data     = get_mail_bank_logs_data( strtotime( 'last monday', MAIL_BANK_LOCAL_TIME ), MAIL_BANK_LOCAL_TIME, 'Sent' );
$email_logs_not_sent_data = get_mail_bank_logs_data( strtotime( 'last monday', MAIL_BANK_LOCAL_TIME ), MAIL_BANK_LOCAL_TIME, 'Not Sent' );

/**
 * This is used for displaying last week data.
 *
 * @param string $start_week .
 * @param string $end_week .
 * @param string $status .
 */
function get_mail_bank_last_week_logs_data( $start_week, $end_week, $status ) {
	global $wpdb;
	// Get last week data.
	$previous_week = strtotime( '-1 week +1 day' );
	$start_week    = strtotime( 'last monday', $previous_week );
	$end_week      = strtotime( 'next sunday', $start_week );

	$email_logs_last_week_data = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT count( status ) FROM ' . $wpdb->prefix . 'mail_bank_logs WHERE timestamp BETWEEN %d AND %d AND status = %s', $start_week, $end_week, $status
		)
	);// WPCS: db call ok; no-cache ok.
	return $email_logs_last_week_data;
}
$email_logs_last_week_sent_data     = get_mail_bank_last_week_logs_data( strtotime( 'last sunday midnight', strtotime( '-1 week +1 day' ) ), strtotime( 'next saturday', strtotime( 'last sunday midnight', strtotime( '-1 week +1 day' ) ) ), 'Sent' );
$email_logs_last_week_not_sent_data = get_mail_bank_last_week_logs_data( strtotime( 'last sunday midnight', strtotime( '-1 week +1 day' ) ), strtotime( 'next saturday', strtotime( 'last sunday midnight', strtotime( '-1 week +1 day' ) ) ), 'Not Sent' );

/**
 * This is used for displaying current month data.
 *
 * @param string $first_day_this_month .
 * @param string $end_date .
 * @param string $status .
 */
function get_mail_bank_this_month_logs_data( $first_day_this_month, $end_date, $status ) {
	global $wpdb;
	// Get this month data.
	$end_date                   = MAIL_BANK_LOCAL_TIME;
	$first_day_this_month       = strtotime( date( '01-m-Y' ) );
	$email_logs_this_month_data = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT count( status ) FROM ' . $wpdb->prefix . 'mail_bank_logs WHERE timestamp BETWEEN %d AND %d AND status = %s', $first_day_this_month, $end_date, $status
		)
	);// WPCS: db call ok; no-cache ok.
	return $email_logs_this_month_data;
}
$email_logs_this_month_sent_data     = get_mail_bank_this_month_logs_data( strtotime( date( 'm-01-Y' ) ), MAIL_BANK_LOCAL_TIME, 'Sent' );
$email_logs_this_month_not_sent_data = get_mail_bank_this_month_logs_data( strtotime( date( 'm-01-Y' ) ), MAIL_BANK_LOCAL_TIME, 'Not Sent' );

/**
 * This is used for displaying last month data.
 *
 * @param string $last_month_start_date .
 * @param string $last_month_end_date .
 * @param string $status .
 */
function get_mail_bank_last_month_logs_data( $last_month_start_date, $last_month_end_date, $status ) {
	global $wpdb;
	// Get last month data.
	$last_month_start_date      = strtotime( 'first day of previous month' );
	$end_date                   = strtotime( 'first day of this month' );
	$last_month_end_date        = strtotime( '-1 day', $end_date );
	$email_logs_last_month_data = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT count( status ) FROM ' . $wpdb->prefix . 'mail_bank_logs WHERE timestamp BETWEEN %d AND %d AND status = %s', $last_month_start_date, $last_month_end_date, $status
		)
	);// WPCS: db call ok; no-cache ok.
	return $email_logs_last_month_data;
}
$email_logs_last_month_sent_data     = get_mail_bank_last_month_logs_data( strtotime( 'first day of previous month' ), strtotime( 'last day of previous month' ), 'Sent' );
$email_logs_last_month_not_sent_data = get_mail_bank_last_month_logs_data( strtotime( 'first day of previous month' ), strtotime( 'last day of previous month' ), 'Not Sent' );

/**
 * This is used for displaying last month data.
 *
 * @param string $start_date_year .
 * @param string $end_date_year .
 * @param string $status .
 */
function get_mail_bank_this_year_logs_data( $start_date_year, $end_date_year, $status ) {
	global $wpdb;
	// Get this month data.
	$start_date_year           = strtotime( 'first day of january ' . date( 'Y' ) );
	$end_date_year             = strtotime( 'last day of december ' . date( 'Y' ) );
	$email_logs_this_year_data = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT count( status ) FROM ' . $wpdb->prefix . 'mail_bank_logs WHERE timestamp BETWEEN %d AND %d AND status = %s', $start_date_year, $end_date_year, $status
		)
	);// WPCS: db call ok; no-cache ok.
	return $email_logs_this_year_data;
}
$email_logs_this_year_sent_data     = get_mail_bank_this_year_logs_data( strtotime( 'first day of january ' . date( 'Y' ) ), strtotime( 'last day of december ' . date( 'Y' ) ), 'Sent' );
$email_logs_this_year_not_sent_data = get_mail_bank_this_year_logs_data( strtotime( 'first day of january ' . date( 'Y' ) ), strtotime( 'last day of december ' . date( 'Y' ) ), 'Not Sent' );

$mb_encryption = '';
switch ( $unserialized_mail_configuration_data['enc_type'] ) {
	case 'tls':
		$mb_encryption = 'TLS Encryption';
		break;
	case 'ssl':
		$mb_encryption = 'SSL Encryption';
		break;
	default:
		$mb_encryption = 'No Encryption';
		break;
}
$mb_authentication = '';
switch ( esc_attr( $unserialized_mail_configuration_data['auth_type'] ) ) {
	case 'crammd5':
		$mb_authentication = 'Crammd5';
		break;
	case 'oauth2':
		$mb_authentication = 'Oauth2';
		break;
	case 'login':
		$mb_authentication = 'Login';
		break;
	case 'plain':
		$mb_authentication = 'Plain';
		break;
	default:
		$mb_authentication = 'No';
		break;
}
switch ( esc_attr( $unserialized_mail_configuration_data['mailer_type'] ) ) {
	case 'smtp':
		$mb_mailer_type = 'SMTP';
		break;
	default:
		$mb_mailer_type = 'PHP Mailer';
		break;
}
$mb_encryption_type      = esc_attr( $unserialized_mail_configuration_data['mailer_type'] ) === 'smtp' ? ' - ' . $mb_encryption : '';
$mb_host_name            = esc_attr( $unserialized_mail_configuration_data['hostname'] );
$mb_port_number          = esc_attr( $unserialized_mail_configuration_data['port'] );
$mb_hostname_port        = esc_attr( $unserialized_mail_configuration_data['mailer_type'] ) === 'smtp' ? ' ' . $mb_host_name . ':' . $mb_port_number : '';
$password_authentication = esc_attr( $unserialized_mail_configuration_data['mailer_type'] ) === 'smtp' ? ' Password ( ' . $mb_authentication . ' ) ' : '';
$mb_authentication       = esc_attr( $unserialized_mail_configuration_data['mailer_type'] ) === 'smtp' ? ' authentication' : '';
$mb_smtp_to              = esc_attr( $unserialized_mail_configuration_data['mailer_type'] ) === 'smtp' ? ' ' . __( 'to', 'wp-mail-bank' ) : '';
$mb_smtp_using           = esc_attr( $unserialized_mail_configuration_data['mailer_type'] ) === 'smtp' ? ' ' . __( 'using', 'wp-mail-bank' ) : '';
?>
<style>
	.mb-stats-table{
		border: 1px solid #ececec;
		width: 100%;
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
	}
	.mb-stats-table th {
		padding: 12px 0px 0px 10px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #4CAF50;
		color: white;
	}
	.mb-stats-table td, .mb-stats-table th {
		border: 1px solid #ddd;
		padding: 8px;
	}
	.mb-stats-table tr:nth-child(even) {
		background-color: #f2f2f2;
	}
	.mb-stats-table tr:hover {
		background-color: #ddd;
	}
</style>
<p class="dashicons-before mb-dashicons-email"> <span style="color:green">Mail Bank <?php echo esc_attr( __( 'is configured', 'wp-mail-bank' ) ); ?></span></p>
<p>Mail Bank <?php echo esc_attr( __( 'will send mail through ', 'wp-mail-bank' ) ); ?><b><?php echo esc_attr( $mb_mailer_type ) . esc_attr( $mb_encryption_type ); ?></b><?php echo esc_attr( $mb_smtp_to ); ?><b><?php echo esc_attr( $mb_hostname_port ); ?></b><?php echo esc_attr( $mb_smtp_using ); ?><b><?php echo esc_attr( $password_authentication ); ?></b><?php echo esc_attr( $mb_authentication ); ?>.</p>
<p><a href="admin.php?page=mb_email_logs"><?php echo esc_attr( __( 'Email Logs', 'wp-mail-bank' ) ); ?></a> | <a href="admin.php?page=mb_email_configuration"><?php echo esc_attr( __( 'Email Configuration', 'wp-mail-bank' ) ); ?></a></p>
<table class="mb-stats-table">
	<tr>
		<th></th>
		<th><?php echo esc_attr( __( 'Sent', 'wp-mail-bank' ) ); ?></th>
		<th><?php echo esc_attr( __( 'Not Sent', 'wp-mail-bank' ) ); ?></th>
	</tr>
	<tr>
		<td><?php echo esc_attr( __( 'Today', 'wp-mail-bank' ) ); ?></td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_today_sent_data ); ?></strong>
			</a>
		</td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_today_not_sent_data ); ?></strong>
			</a>
		</td>
	</tr>
	<tr>
		<td><?php echo esc_attr( __( 'This Week', 'wp-mail-bank' ) ); ?></td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_sent_data ); ?></strong>
			</a>
		</td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_not_sent_data ); ?></strong>
			</a>
		</td>
	</tr>
	<tr>
		<td><?php echo esc_attr( __( 'Last Week', 'wp-mail-bank' ) ); ?></td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_last_week_sent_data ); ?></strong>
			</a>
		</td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_last_week_not_sent_data ); ?></strong>
			</a>
		</td>
	</tr>
	<tr>
		<td><?php echo esc_attr( __( 'This Month', 'wp-mail-bank' ) ); ?></td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_this_month_sent_data ); ?></strong>
			</a>
		</td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_this_month_not_sent_data ); ?></strong>
			</a>
		</td>
	</tr>
	<tr>
		<td><?php echo esc_attr( __( 'Last Month', 'wp-mail-bank' ) ); ?></td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_last_month_sent_data ); ?></strong>
			</a>
		</td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_last_month_not_sent_data ); ?></strong>
			</a>
		</td>
	</tr>
	<tr>
		<td><?php echo esc_attr( __( 'This Year', 'wp-mail-bank' ) ); ?></td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_this_year_sent_data ); ?></strong>
			</a></td>
		<td>
			<a href="admin.php?page=mb_email_logs">
				<strong><?php echo esc_attr( $email_logs_this_year_not_sent_data ); ?></strong>
			</a>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center;">
			<a href="https://tech-banker.com/wp-mail-bank/">
				<strong><?php echo esc_attr( __( 'Upgrade Now to Premium Editions', 'wp-mail-bank'  ) ); ?></strong>
			</a>
		</td>
	</tr>
</table>
