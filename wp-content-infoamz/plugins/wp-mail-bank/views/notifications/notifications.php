<?php
/**
 * This Template is used for notifications.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/views/notifications
 * @version 4.0.0
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
	} elseif ( NOTIFICATION_MAIL_BANK === '1' ) {
		?>
		<div class="row">
			<div class="col-md-9">
				<?php
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/dashboard.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/dashboard.php';
				}
				?>
				<div class="portlet box vivid-blue">
					<div class="portlet-title">
						<div class="caption">
							<i class="dashicons dashicons-microphone"></i>
							<?php echo esc_attr( $mb_notifications ); ?>
						</div>
					</div>
					<div class="portlet-body form mb-custom-form">
						<form id="ux_frm_notifications">
							<div class="form-body">
								<div class="form-group">
									<label class="control-label">
										<?php echo esc_attr( $mb_notifications ); ?> :
										<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
									</label>
									<select class="form-control" name="ux_ddl_notifications" id="ux_ddl_notifications" onchange="show_hide_delete_after_logs('#ux_ddl_notifications','#ux_div_notification_services');">
										<option value="enable"><?php echo esc_attr( $mb_enable ); ?></option>
										<option value="disable" selected="Selected"><?php echo esc_attr( $mb_disable ); ?></option>
									</select>
									<i class="controls-description"><?php echo esc_attr( $mb_notifications_service_tooltip ); ?>.</i>
								</div>
								<div id="ux_div_notification_services" style="display:none;">
									<div class="form-group">
										<label class="control-label">
											<?php echo esc_attr( $mb_notifications_service ); ?> :
											<span class="required" aria-required="true">*</span>
										</label>
										<select class="form-control" name="ux_ddl_notifications_service" id="ux_ddl_notifications_service" onchange="show_hide_notifications_service('#ux_ddl_notifications_service', '#ux_div_notification_email_address' ,'#ux_div_notifications_pushover_key', '#ux_div_slack_web_hook');">
											<option value="email"><?php echo esc_attr( $mb_notifications_service_email ); ?></option>
											<option value="pushover"><?php echo esc_attr( $mb_notifications_service_pushover ); ?></option>
											<option value="slack"><?php echo esc_attr( $mb_notifications_service_slack ); ?></option>
										</select>
										<i class="controls-description"><?php echo esc_attr( $mb_notifications_service_tooltip ); ?>.</i>
									</div>
									<div id="ux_div_notification_email_address" style="display:none;">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_email_configuration_email_address ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<input type="text" class="form-control" name="ux_txt_notification_email_address" id="ux_txt_notification_email_address" value="<?php echo isset( $notifications_data['notification_email_address'] ) ? esc_attr( $notifications_data['notification_email_address'] ) : esc_attr( get_option( 'admin_email' ) ); ?>">
											<i class="controls-description"><?php echo esc_attr( $mb_notifications_service_tooltip ); ?>.</i>
										</div>
									</div>
									<div id="ux_div_notifications_pushover_key" style="display:none;">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_notifications_service_pushover_key ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<input type="text" class="form-control" name="ux_txt_pushover_user_key" id="ux_txt_pushover_user_key" value="<?php echo isset( $notifications_data['pushover_user_key'] ) ? esc_attr( $notifications_data['pushover_user_key'] ) : ''; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_notifications_service_pushover_token ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<input type="text" class="form-control" name="ux_txt_pushover_user_token" id="ux_txt_pushover_user_token" value="<?php echo isset( $notifications_data['pushover_app_token'] ) ? esc_attr( $notifications_data['pushover_app_token'] ) : ''; ?>">
												</div>
											</div>
										</div>
									</div>
									<div id="ux_div_slack_web_hook" style="display:none;">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_notifications_service_slack_web_book ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<input type="text" class="form-control" name="ux_txt_slack_web_hook" id="ux_txt_slack_web_hook" value="<?php echo isset( $notifications_data['slack_web_hook'] ) ? esc_attr( $notifications_data['slack_web_hook'] ) : ''; ?>">
										</div>
									</div>
								</div>
								<div class="line-separator"></div>
								<div class="form-actions">
									<div class="pull-right">
										<input type="submit" class="btn vivid-blue" value="<?php echo esc_attr( $mb_save_changes ); ?>">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3 sidebar-menu-tech-banker">
				<?php
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/sidebar.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/sidebar.php';
				}
				?>
			</div>
		</div>
		<?php
	} else {
		?>
		<div class="row">
			<div class="col-md-9">
				<?php
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/dashboard.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/dashboard.php';
				}
				?>
				<div class="portlet box vivid-blue">
					<div class="portlet-title">
						<div class="caption">
							<i class="dashicons dashicons-microphone"></i>
							<?php echo esc_attr( $mb_notifications ); ?>
						</div>
					</div>
					<div class="portlet-body form">
						<div class="form-body">
						<strong><?php echo esc_attr( $mb_user_access_message ); ?>.</strong>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 sidebar-menu-tech-banker">
				<?php
				if ( file_exists( MAIL_BANK_DIR_PATH . 'includes/sidebar.php' ) ) {
					include MAIL_BANK_DIR_PATH . 'includes/sidebar.php';
				}
				?>
			</div>
		</div>
		<?php
	}
}
