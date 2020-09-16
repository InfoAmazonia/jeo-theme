<?php
/**
 * This Template is used for managing settings.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/views/settings
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
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
	} elseif ( SETTINGS_MAIL_BANK === '1' ) {
		$mail_bank_settings = wp_create_nonce( 'mail_bank_settings' );
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
							<i class="dashicons dashicons-admin-generic"></i>
							<?php echo esc_attr( $mb_settings ); ?>
						</div>
					</div>
					<div class="portlet-body form mb-custom-form">
						<form id="ux_frm_settings">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_settings_debug_mode ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<select name="ux_ddl_debug_mode" id="ux_ddl_debug_mode" class="form-control" >
												<option value="enable"><?php echo esc_attr( $mb_enable ); ?></option>
												<option value="disable"><?php echo esc_attr( $mb_disable ); ?></option>
											</select>
											<i class="controls-description"><?php echo esc_attr( $mb_settings_debug_mode_tooltip ); ?></i>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_remove_tables_title ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<select name="ux_ddl_remove_tables" id="ux_ddl_remove_tables" class="form-control" >
												<option value="enable"><?php echo esc_attr( $mb_enable ); ?></option>
												<option value="disable"><?php echo esc_attr( $mb_disable ); ?></option>
											</select>
											<i class="controls-description"><?php echo esc_attr( $mb_remove_tables_tooltip ); ?></i>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_monitoring_email_log_title ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<select name="ux_ddl_monitor_email_logs" id="ux_ddl_monitor_email_logs" class="form-control">
												<option value="enable"><?php echo esc_attr( $mb_enable ); ?></option>
												<option value="disable"><?php echo esc_attr( $mb_disable ); ?></option>
											</select>
											<i class="controls-description"><?php echo esc_attr( $mb_monitoring_email_log_tooltip ); ?></i>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">
										<?php echo esc_attr( $mb_settings_auto_clear_logs ); ?> :
										<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
									</label>
									<select class="form-control" name="ux_ddl_auto_clear_logs" id="ux_ddl_auto_clear_logs" onchange="show_hide_delete_after_logs('#ux_ddl_auto_clear_logs','#ux_div_delete_logs_after');">
										<option value="enable"><?php echo esc_attr( $mb_enable ); ?></option>
										<option value="disable"><?php echo esc_attr( $mb_disable ); ?></option>
									</select>
									<i class="controls-description"><?php echo esc_attr( $mb_settings_auto_clear_logs_tooltips ); ?></i>
								</div>
								<div class="form-group" id="ux_div_delete_logs_after">
									<label class="control-label">
										<?php echo esc_attr( $mb_settings_delete_logs_after ); ?> :
										<span class="required" aria-required="true">*</span>
									</label>
									<select class="form-control" name="ux_ddl_delete_logs_after" id="ux_ddl_delete_logs_after" >
										<option value="1day"><?php echo esc_attr( $mb_settings_delete_logs_after_one_day ); ?></option>
										<option value="7days"><?php echo esc_attr( $mb_settings_delete_logs_after_seven_days ); ?></option>
										<option value="14days"><?php echo esc_attr( $mb_settings_delete_logs_after_forteen_days ); ?></option>
										<option value="21days"><?php echo esc_attr( $mb_settings_delete_logs_after_twentyone_days ); ?></option>
										<option value="28days"><?php echo esc_attr( $mbsettings_delete_logs_after_twentyeight_days ); ?></option>
									</select>
									<i class="controls-description"><?php echo esc_attr( $mb_settings_delete_logs_after_tooltips ); ?>.</i>
								</div>
								<?php
								if ( is_multisite() && is_main_site() ) {
									?>
									<div class="form-group">
										<label class="control-label">
											<?php echo esc_attr( $mb_fetch_settings ); ?> :
											<span class="required" aria-required="true">*</span>
										</label>
										<select name="ux_ddl_fetch_settings" id="ux_ddl_fetch_settings" class="form-control">
											<option value="individual_site"><?php echo esc_attr( $mb_indivisual_site ); ?></option>
											<option value="network_site"><?php echo esc_attr( $mb_multiple_site ); ?></option>
										</select>
										<i class="controls-description"><?php echo esc_attr( $mb_fetch_settings_tooltip ); ?></i>
									</div>
									<?php
								}
								?>
								<div class="line-separator"></div>
								<div class="form-actions">
									<div class="pull-right">
										<input type="submit" class="btn vivid-blue" name="ux_btn_save_changes" id="ux_btn_save_changes" value="<?php echo esc_attr( $mb_save_changes ); ?>">
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
							<i class="dashicons dashicons-admin-generic"></i>
							<?php echo esc_attr( $mb_settings ); ?>
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
