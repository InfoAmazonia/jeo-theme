<?php
/**
 * This Template is used for displaying email logs.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/views/email-logs
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
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
	} elseif ( EMAIL_LOGS_MAIL_BANK === '1' ) {
		$mb_logs_resent_email_nonce   = wp_create_nonce( 'mb_logs_resent_email_nonce' );
		$mb_email_logs_delete_log     = wp_create_nonce( 'mb_email_logs_delete' );
		$mb_start_end_data_email_logs = wp_create_nonce( 'mb_start_end_data_email_logs' );
		$end_date                     = MAIL_BANK_LOCAL_TIME;
		$start_date                   = strtotime( '-7 days', $end_date );
		$array1                       = array_count_values( $sent_array_dates );
		$array2                       = array_count_values( $not_sent_array_dates );
		$array3                       = $email_logs_array_dates;
		$final_sent_data_array        = array();
		$final_not_sent_data_array    = array();
		foreach ( $array3 as $value ) {
			$sent_data     = array_key_exists( $value, $array1 ) ? $array1[ $value ] : 0;
			$not_sent_data = array_key_exists( $value, $array2 ) ? $array2[ $value ] : 0;
			array_push( $final_sent_data_array, $sent_data );
			array_push( $final_not_sent_data_array, $not_sent_data );
		}
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
							<i class="dashicons dashicons-welcome-write-blog"></i>
							<?php echo esc_attr( $mb_email_logs ); ?>
						</div>
					</div>
					<div class="portlet-body form mb-custom-form">
						<form id="ux_frm_email_logs">
							<div class="form-body">
								<div id="ux_div_chart">
									<canvas id="ux_mb_charts" width="200" height="100"></canvas>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_start_date_title ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<input type="text" class="form-control" name="ux_txt_mb_start_date" id="ux_txt_mb_start_date" value="<?php echo esc_attr( date( 'm/d/Y', $start_date ) ); ?>" onfocus="prevent_datepicker_mail_bank(this.id);">
											<i class="controls-description"><?php echo esc_attr( $mb_start_date_tooltip ); ?>.</i>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_end_date_title ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<input type="text" class="form-control" name="ux_txt_mb_end_date" id="ux_txt_mb_end_date" value="<?php echo esc_attr( date( 'm/d/Y', $end_date ) ); ?>" onfocus="prevent_datepicker_mail_bank(this.id);">
											<i class="controls-description"><?php echo esc_attr( $mb_end_date_tooltip ); ?>.</i>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_limit_records_title ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<input type="text" id="ux_txt_limit_email_logs" name="ux_txt_limit_email_logs" class="form-control" value="3000">
											<i class="controls-description"><?php echo esc_attr( $mb_limit_records_tooltip ); ?>.</i>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_status ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<select name="ux_ddl_email_status" id="ux_ddl_email_status" class="form-control">
												<option value="all" selected="selected"><?php echo esc_attr( $mb_all_records ); ?></option>
												<option value="Sent"><?php echo esc_attr( $mb_status_sent ); ?></option>
												<option value="Not Sent"><?php echo esc_attr( $mb_status_not_sent ); ?></option>
											</select>
											<i class="controls-description"><?php echo esc_attr( $mb_status_tooltip ); ?>.</i>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="pull-right">
										<input type="submit" class="btn vivid-blue" name="ux_btn_email_logs" id="ux_btn_email_logs" value="<?php echo esc_attr( $mb_submit ); ?>">
									</div>
								</div>
								<div class="line-separator"></div>
								<div class="table-top-margin">
									<select name="ux_ddl_email_logs" id="ux_ddl_email_logs" class="custom-bulk-width">
										<option value=""><?php echo esc_attr( $mb_email_logs_bulk_action ); ?></option>
										<option value="delete" style="color:red;"><?php echo esc_attr( $mb_email_logs_delete ) . ' ( ' . esc_attr( $mb_pro_label ) . ' )'; ?></option>
										<option value="resend_email" style="color:red;"><?php echo esc_attr( $mb_resend ) . ' ( ' . esc_attr( $mb_pro_label ) . ' )'; ?></option>
									</select>
									<input type="button" class="btn vivid-blue" name="ux_btn_apply" id="ux_btn_apply" value="<?php echo esc_attr( $mb_email_logs_apply ); ?>" onclick="premium_edition_notification_mail_bank()">
								</div>
								<table class="table table-striped table-bordered table-hover table-margin-top" id="ux_tbl_email_logs">
									<thead>
										<tr>
											<th style="text-align: center;" class="chk-action"style="width:5%">
												<input type="checkbox" name="ux_chk_all_email_logs" id="ux_chk_all_email_logs">
											</th>
											<th style="width:55%">
												<label>
													<?php echo esc_attr( $mb_email_logs_email_details ); ?>
												</label>
											</th>
											<th style="width:10%">
												<label>
													<?php echo esc_attr( $mb_status ); ?>
												</label>
											</th>
											<th style="width:30%">
												<label>
													<?php echo esc_attr( $mb_action ); ?>
												</label>
											</th>
										</tr>
									</thead>
									<tbody id="ux_dynamic_email_logs_table_filter">
										<?php
										foreach ( $email_reports_array as $value ) {
											?>
											<tr>
												<td style="text-align: center;">
													<input type="checkbox" name="ux_chk_email_logs_<?php echo intval( $value['id'] ); ?>" id="ux_chk_email_logs_<?php echo intval( $value['id'] ); ?>" onclick="check_email_logs(<?php echo intval( $value['id'] ); ?>)" value="<?php echo intval( $value['id'] ); ?>">
												</td>
												<td id="ux_email_sent_to_<?php echo intval( $value['id'] ); ?>">
													<p>
														<strong><?php echo esc_attr( $mb_email_logs_email_to ); ?> :
														</strong><?php echo esc_html( $value['email_to'] ); ?>
													</p>
													<p>
														<strong><?php echo esc_attr( $mb_subject ); ?> :
														</strong><?php echo isset( $value->subject ) !== '' ? esc_attr( $value['subject'] ) : 'N/A'; ?>
													</p>
													<p>
														<strong><?php echo esc_attr( $mb_date_time ); ?> :
														</strong><?php echo esc_attr( date_i18n( 'd M Y h:i A', $value['timestamp'] ) ); ?>
													</p>
												</td>
												<td>
													<p style="margin: 5px 0px;">
														<?php
														if ( 'Not Sent' === $value['status'] ) {
															?>
															<label class="mb-email-not-sent">
																<?php echo 'Sent' === $value['status'] ? esc_attr( $mb_status_sent ) : esc_attr( $mb_status_not_sent ); ?>
															</label>
															<?php
														} else {
															?>
															<label class="mb-email-sent">
																<?php echo 'Sent' === $value['status'] ? esc_attr( $mb_status_sent ) : esc_attr( $mb_status_not_sent ); ?>
															</label>
															<?php
														}
														?>
													</p>
												</td>
												<td id="ux_email_action_<?php echo intval( $value['id'] ); ?>">
													<a href="javascript:void(0);" class="btn mail-bank-buttons" onclick="premium_edition_notification_mail_bank();" ><?php echo esc_attr( $mb_resend ); ?>
													</a>
													<?php
													if ( isset( $value['debug_mode'] ) ) {
														?>
														<a class="btn mail-bank-buttons" onclick="premium_edition_notification_mail_bank();">
															<?php echo esc_attr( $mb_email_logs_show_outputs ); ?>
														</a>
														<?php
													}
													?>
													<a class="btn mail-bank-buttons" onclick="premium_edition_notification_mail_bank();">
														<?php echo esc_attr( $mb_email_configuration_content ); ?>
													</a>
													<a class="btn mail-bank-buttons" href="javascript:void(0);" onclick="delete_email_logs(<?php echo intval( $value['id'] ); ?>)" ><?php echo esc_attr( $mb_email_logs_delete ); ?>
													</a>
												</td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
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
							<i class="dashicons dashicons-welcome-write-blog"></i>
							<?php echo esc_attr( $mb_email_logs ); ?>
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
