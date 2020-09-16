<?php // @codingStandardsIgnoreLine
/**
 * This file is used to Log emails sent through `wp_mail`.
 *
 * @package wp-mail-bank/includes
 */

/**
 * This class is used to log emails.
 */
class Mail_Bank_Email_Logger {

	/**
	 * Load the logger.
	 */
	public function load_emails_mail_bank() {
		add_filter( 'wp_mail', array( $this, 'log_email' ) );
		add_action( 'wp_mail_failed', array( $this, 'log_email_failed' ) );
	}

	/**
	 * Logs email to database.
	 *
	 * @param WP_Error $wp_error .
	 */
	public function log_email_failed( $wp_error ) {
		global $mb_insert_id, $wpdb;
		$settings_array_serialized   = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key=%s', 'settings'
			)
		);// db call ok; no-cache ok.
		$settings_array_unserialized = maybe_unserialize( $settings_array_serialized );
		if ( 'enable' === $settings_array_unserialized['monitor_email_logs'] ) {
			if ( isset( $mb_insert_id ) ) {
				$email_logs_data_array           = array();
				$email_logs_data_array['status'] = 'Not Sent';

				if ( 'enable' === $settings_array_unserialized['debug_mode'] ) {
					$email_logs_data_array['debug_mode']       = $settings_array_unserialized['debug_mode'];
					$email_logs_data_array['debugging_output'] = $wp_error->get_error_message();
				}
				$where       = array();
				$where['id'] = $mb_insert_id;
				$wpdb->update( mail_bank_logs(), $email_logs_data_array, $where );// db call ok; no-cache ok.
			}
		}
	}
	/**
	 * Logs email to database.
	 *
	 * @param array $mail_info Information about email.
	 *
	 * @return array Information about email.
	 */
	public function log_email( $mail_info ) {
		global $mb_insert_id, $wpdb;
		$email_configuration_data  = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key=%s', 'email_configuration'
			)
		);// db call ok; no-cache ok.
		$email_configuration_array = maybe_unserialize( $email_configuration_data );

		$settings_array_serialized   = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT meta_value FROM ' . $wpdb->prefix . 'mail_bank_meta WHERE meta_key=%s', 'settings'
			)
		);// db call ok; no-cache ok.
		$settings_array_unserialized = maybe_unserialize( $settings_array_serialized );
		$mail_info                   = wp_parse_args( $mail_info, array(
			'attachments' => array(),
			'to'          => '',
			'subject'     => '',
			'headers'     => '',
		) );

		$data = array(
			'attachments' => ( count( $mail_info['attachments'] ) > 0 ) ? 'true' : 'false',
			'to_email'    => is_array( $mail_info['to'] ) ? implode( ',', $mail_info['to'] ) : $mail_info['to'],
			'subject'     => $mail_info['subject'],
			'headers'     => is_array( $mail_info['headers'] ) ? implode( "\n", $mail_info['headers'] ) : $mail_info['headers'],
			'sent_date'   => current_time( 'mysql' ),
		);

		$cc         = array();
		$bcc        = array();
		$reply_to   = array();
		$from_email = '';
		$from_name  = '';
		if ( empty( $mail_info['headers'] ) ) {
			$headers = array();
		} else {
			if ( ! is_array( $mail_info['headers'] ) ) {
				$tempheaders = explode( "\n", str_replace( "\r\n", "\n", $mail_info['headers'] ) );
			} else {
				$tempheaders = $mail_info['headers'];
			}
			$headers = array();
			if ( ! empty( $tempheaders ) ) {
				foreach ( (array) $tempheaders as $header ) {
					if ( strpos( $header, ':' ) === false ) {
						if ( false !== stripos( $header, 'boundary=' ) ) {
							$parts    = preg_split( '/boundary=/i', trim( $header ) );
							$boundary = trim( str_replace( array( "'", '"' ), '', $parts[1] ) );
						}
						continue;
					}
					list( $name, $content ) = explode( ':', trim( $header ), 2 );

					$name    = trim( $name );
					$content = trim( $content );
					switch ( strtolower( $name ) ) {
						case 'from':
							$bracket_pos = strpos( $content, '<' );
							if ( false !== $bracket_pos ) {
								if ( $bracket_pos > 0 ) {
									$from_name = substr( $content, 0, $bracket_pos - 1 );
									$from_name = str_replace( '"', '', $from_name );
									$from_name = trim( $from_name );
								}
								$from_email = substr( $content, $bracket_pos + 1 );
								$from_email = str_replace( '>', '', $from_email );
								$from_email = trim( $from_email );
							} elseif ( '' !== trim( $content ) ) {
								$from_email = trim( $content );
							}
							break;
						case 'content-type':
							if ( strpos( $content, ';' ) !== false ) {
								list( $type, $charset_content ) = explode( ';', $content );
								$content_type                   = trim( $type );
								if ( false !== stripos( $charset_content, 'charset=' ) ) {
									$charset = trim( str_replace( array( 'charset=', '"' ), '', $charset_content ) );
								} elseif ( false !== stripos( $charset_content, 'boundary=' ) ) {
									$boundary = trim( str_replace( array( 'BOUNDARY=', 'boundary=', '"' ), '', $charset_content ) );
									$charset  = '';
								}
							} elseif ( '' !== trim( $content ) ) {
								$content_type = trim( $content );
							}
							break;
						case 'cc':
							$cc = array_merge( (array) $cc, explode( ',', $content ) );
							break;
						case 'bcc':
							$bcc = array_merge( (array) $bcc, explode( ',', $content ) );
							break;
						case 'reply-to':
							$reply_to = array_merge( (array) $reply_to, explode( ',', $content ) );
							break;
						default:
							$headers[ trim( $name ) ] = trim( $content );
							break;
					}
				}
			}
		}

		$message = '';

		if ( isset( $mail_info['message'] ) ) {
			$message = $mail_info['message'];
		} else {
			if ( isset( $mail_info['html'] ) ) {
				$message = $mail_info['html'];
			}
		}

		$data['message'] = $message;

		$sender_email = 'override' === $email_configuration_array['from_email_configuration'] ? $email_configuration_array['sender_email'] : $from_email;
		$sender_name  = 'override' === $email_configuration_array['sender_name_configuration'] ? $email_configuration_array['sender_name'] : $from_name;
		if ( 'enable' === $settings_array_unserialized['monitor_email_logs'] ) {
			$email_logs_data_array                 = array();
			$email_logs_data_array['email_to']     = $data['to_email'];
			$email_logs_data_array['cc']           = '' === $email_configuration_array['cc'] ? implode( ',', $cc ) : $email_configuration_array['cc'];
			$email_logs_data_array['bcc']          = '' === $email_configuration_array['bcc'] ? implode( ',', $bcc ) : $email_configuration_array['bcc'];
			$email_logs_data_array['subject']      = $data['subject'];
			$email_logs_data_array['content']      = $data['message'];
			$email_logs_data_array['sender_name']  = $sender_name;
			$email_logs_data_array['sender_email'] = $sender_email;
			$email_logs_data_array['timestamp']    = MAIL_BANK_LOCAL_TIME;
			$email_logs_data_array['status']       = 'Sent';
			$wpdb->insert( mail_bank_logs(), $email_logs_data_array );// db call ok; no-cache ok.
			$mb_insert_id = $wpdb->insert_id;
		}

		return $mail_info;
	}
}
