<?php
/**
 * This Template is used for managing roles and capabilities.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/views/roles-and-capabilities
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
	} elseif ( ROLES_AND_CAPABILITIES_MAIL_BANK === '1' ) {
		$mail_bank_roles_capabilities = wp_create_nonce( 'mail_bank_roles_capabilities' );
		$roles_and_capabilities       = explode( ',', isset( $details_roles_capabilities['roles_and_capabilities'] ) ? $details_roles_capabilities['roles_and_capabilities'] : '' );
		$author                       = explode( ',', isset( $details_roles_capabilities['author_privileges'] ) ? $details_roles_capabilities['author_privileges'] : '' );
		$editor                       = explode( ',', isset( $details_roles_capabilities['editor_privileges'] ) ? $details_roles_capabilities['editor_privileges'] : '' );
		$contributor                  = explode( ',', isset( $details_roles_capabilities['contributor_privileges'] ) ? $details_roles_capabilities['contributor_privileges'] : '' );
		$subscriber                   = explode( ',', isset( $details_roles_capabilities['subscriber_privileges'] ) ? $details_roles_capabilities['subscriber_privileges'] : '' );
		$other_privileges             = explode( ',', isset( $details_roles_capabilities['other_roles_privileges'] ) ? $details_roles_capabilities['other_roles_privileges'] : '' );
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
							<i class="dashicons dashicons-admin-users"></i>
							<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
						</div>
					</div>
					<div class="portlet-body form mb-custom-form">
						<form id="ux_frm_roles_and_capabilities">
							<div class="form-body">
								<div class="form-group">
									<label class="control-label">
										<?php echo esc_attr( $mb_roles_capabilities_show_menu ); ?> :
										<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
									</label>
									<table class="table table-striped table-bordered table-margin-top" id="ux_tbl_mail_bank_roles">
										<thead>
											<tr>
												<th>
													<input type="checkbox"  name="ux_chk_administrator" id="ux_chk_administrator" value="1" checked="checked" disabled="disabled" <?php echo '1' === $roles_and_capabilities[0] ? 'checked = checked' : ''; ?>>
													<?php echo esc_attr( $mb_roles_capabilities_administrator ); ?>
												</th>
												<th>
													<input type="checkbox"  name="ux_chk_author" id="ux_chk_author"  value="1" onclick="show_roles_capabilities_mail_bank(this, 'ux_div_author_roles');" <?php echo '1' === $roles_and_capabilities[1] ? 'checked = checked' : ''; ?>>
													<?php echo esc_attr( $mb_roles_capabilities_author ); ?>
												</th>
												<th>
													<input type="checkbox"  name="ux_chk_editor" id="ux_chk_editor" value="1" onclick="show_roles_capabilities_mail_bank(this, 'ux_div_editor_roles');" <?php echo '1' === $roles_and_capabilities[2] ? 'checked = checked' : ''; ?>>
													<?php echo esc_attr( $mb_roles_capabilities_editor ); ?>
												</th>
												<th>
													<input type="checkbox"  name="ux_chk_contributor" id="ux_chk_contributor"  value="1" onclick="show_roles_capabilities_mail_bank(this, 'ux_div_contributor_roles');" <?php echo '1' === $roles_and_capabilities[3] ? 'checked = checked' : ''; ?>>
													<?php echo esc_attr( $mb_roles_capabilities_contributor ); ?>
												</th>
												<th>
													<input type="checkbox"  name="ux_chk_subscriber" id="ux_chk_subscriber" value="1" onclick="show_roles_capabilities_mail_bank(this, 'ux_div_subscriber_roles');" <?php echo '1' === $roles_and_capabilities[4] ? 'checked = checked' : ''; ?>>
													<?php echo esc_attr( $mb_roles_capabilities_subscriber ); ?>
												</th>
												<th>
													<input type="checkbox"  name="ux_chk_others_privileges" id="ux_chk_others_privileges" value="1" onclick="show_roles_capabilities_mail_bank(this, 'ux_div_other_privileges_roles');" <?php echo '1' === $roles_and_capabilities[5] ? 'checked = checked' : ''; ?>>
													<?php echo esc_attr( $mb_roles_capabilities_others ); ?>
												</th>
											</tr>
										</thead>
									</table>
									<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_show_menu_tooltip ); ?></i>
								</div>
								<div class="form-group">
									<label class="control-label">
										<?php echo esc_attr( $mb_roles_capabilities_topbar_menu ); ?> :
										<span class="required" aria-required="true">*</span>
									</label>
									<select name="ux_ddl_mail_bank_menu" id="ux_ddl_mail_bank_menu" class="form-control">
										<option value="enable"><?php echo esc_attr( $mb_enable ); ?></option>
										<option value="disable"><?php echo esc_attr( $mb_disable ); ?></option>
									</select>
									<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_topbar_menu_tooltip ); ?></i>
								</div>
								<div class="line-separator"></div>
								<div class="form-group">
									<div id="ux_div_administrator_roles">
										<label class="control-label">
											<?php echo esc_attr( $mb_roles_capabilities_administrator_role ); ?> :
											<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
										</label>
										<div class="table-margin-top">
											<table class="table table-striped table-bordered table-hover" id="ux_tbl_administrator">
												<thead>
													<tr>
														<th style="width: 40% !important;">
															<input type="checkbox" name="ux_chk_full_control_administrator" id="ux_chk_full_control_administrator" checked="checked" disabled="disabled" value="1">
															<?php echo esc_attr( $mb_roles_capabilities_full_control ); ?>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_configuration_admin" disabled="disabled" checked="checked" id="ux_chk_email_configuration_admin" value="1">
															<?php echo esc_attr( $mb_email_configuration ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_test_email_admin" disabled="disabled" checked="checked" id="ux_chk_test_email_admin" value="1">
															<?php echo esc_attr( $mb_test_email ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_connectivity_test_email_admin" disabled="disabled" checked="checked" id="ux_chk_connectivity_test_email_admin" value="1">
															<?php echo esc_attr( $mb_connectivity_test ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_logs_admin" disabled="disabled" checked="checked" id="ux_chk_email_logs_admin" value="1">
															<?php echo esc_attr( $mb_email_logs ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_notification_admin" disabled="disabled" checked="checked" id="ux_chk_notification_admin" value="1">
															<?php echo esc_attr( $mb_notifications ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_settings_admin" disabled="disabled" checked="checked" id="ux_chk_settings_admin" value="1">
															<?php echo esc_attr( $mb_settings ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_roles_and_capabilities_admin" disabled="disabled" checked="checked" id="ux_chk_roles_and_capabilities_admin" value="1">
															<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_system_information_admin" disabled="disabled" checked="checked" id="ux_chk_system_information_admin" value="1">
															<?php echo esc_attr( $mb_system_information ); ?>
														</td>
														<td>
														</td>
													</tr>
												</tbody>
											</table>
											<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_administrator_role_tooltip ); ?>.</i>
										</div>
										<div class="line-separator"></div>
									</div>
								</div>
								<div class="form-group">
									<div id="ux_div_author_roles">
										<label class="control-label">
											<?php echo esc_attr( $mb_roles_capabilities_author_role ); ?> :
											<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
										</label>
										<div class="table-margin-top">
											<table class="table table-striped table-bordered table-hover" id="ux_tbl_author">
												<thead>
													<tr>
														<th style="width: 40% !important;">
															<input type="checkbox" name="ux_chk_full_control_author" id="ux_chk_full_control_author" value="1" onclick="full_control_function_mail_bank(this, 'ux_div_author_roles');" <?php echo isset( $author ) && '1' === $author[0] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_capabilities_full_control ); ?>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_configuration_author" id="ux_chk_email_configuration_author" value="1" <?php echo isset( $author ) && '1' === $author[1] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_configuration ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_test_email_author" id="ux_chk_test_email_author" value="1" <?php echo isset( $author ) && '1' === $author[2] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_test_email ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_connectivity_test_email_author" id="ux_chk_connectivity_test_email_author" value="1" <?php echo isset( $author ) && '1' === $author[3] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_connectivity_test ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_logs_author" id="ux_chk_email_logs_author" value="1" <?php echo isset( $author ) && '1' === $author[4] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_logs ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_notification_author" id="ux_chk_notification_author" value="1" <?php echo isset( $author ) && '1' === $author[5] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_notifications ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_settings_author" id="ux_chk_settings_author" value="1" <?php echo isset( $author ) && '1' === $author[6] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_settings ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_roles_and_capabilities_author" id="ux_chk_roles_and_capabilities_author" value="1" <?php echo isset( $author ) && '1' === $author[7] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_system_information_author" id="ux_chk_system_information_author" value="1" <?php echo isset( $author ) && '1' === $author[8] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_system_information ); ?>
														</td>
														<td>
														</td>
													</tr>
												</tbody>
											</table>
											<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_author_role_tooltip ); ?>.</i>
										</div>
										<div class="line-separator"></div>
									</div>
								</div>
								<div class="form-group">
									<div id="ux_div_editor_roles">
										<label class="control-label">
											<?php echo esc_attr( $mb_roles_capabilities_editor_role ); ?> :
											<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
										</label>
										<div class="table-margin-top">
											<table class="table table-striped table-bordered table-hover" id="ux_tbl_editor">
												<thead>
													<tr>
														<th style="width: 40% !important;">
															<input type="checkbox" name="ux_chk_full_control_editor" id="ux_chk_full_control_editor" value="1" onclick="full_control_function_mail_bank(this, 'ux_div_editor_roles');" <?php echo isset( $editor ) && '1' === $editor[0] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_capabilities_full_control ); ?>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_configuration_editor" id="ux_chk_email_configuration_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[1] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_configuration ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_test_email_editor" id="ux_chk_test_email_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[2] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_test_email ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_connectivity_test_email_editor" id="ux_chk_connectivity_test_email_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[3] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_connectivity_test ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_logs_editor" id="ux_chk_email_logs_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[4] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_logs ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_notification_editor" id="ux_chk_notification_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[5] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_notifications ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_settings_editor" id="ux_chk_settings_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[6] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_settings ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_roles_and_capabilities_editor" id="ux_chk_roles_and_capabilities_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[7] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_system_information_editor" id="ux_chk_system_information_editor" value="1" <?php echo isset( $editor ) && '1' === $editor[8] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_system_information ); ?>
														</td>
														<td>
														</td>
													</tr>
												</tbody>
											</table>
											<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_editor_role_tooltip ); ?>.</i>
										</div>
										<div class="line-separator"></div>
									</div>
								</div>
								<div class="form-group">
									<div id="ux_div_contributor_roles">
										<label class="control-label">
											<?php echo esc_attr( $mb_roles_capabilities_contributor_role ); ?> :
											<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
										</label>
										<div class="table-margin-top">
											<table class="table table-striped table-bordered table-hover" id="ux_tbl_contributor">
												<thead>
													<tr>
														<th style="width: 40% !important;">
															<input type="checkbox" name="ux_chk_full_control_contributor" id="ux_chk_full_control_contributor" value="1" onclick="full_control_function_mail_bank(this, 'ux_div_contributor_roles');" <?php echo isset( $contributor ) && '1' === $contributor[0] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_capabilities_full_control ); ?>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_configuration_contributor" id="ux_chk_email_configuration_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[1] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_configuration ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_test_email_contributor" id="ux_chk_test_email_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[2] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_test_email ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_connectivity_test_email_contributor" id="ux_chk_connectivity_test_email_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[3] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_connectivity_test ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_logs_contributor" id="ux_chk_email_logs_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[4] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_logs ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_notification_contributor" id="ux_chk_notification_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[5] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_notifications ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_settings_contributor" id="ux_chk_settings_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[6] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_settings ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_roles_and_capabilities_contributor" id="ux_chk_roles_and_capabilities_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[7] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_system_information_contributor" id="ux_chk_system_information_contributor" value="1" <?php echo isset( $contributor ) && '1' === $contributor[8] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_system_information ); ?>
														</td>
														<td>
														</td>
													</tr>
												</tbody>
											</table>
											<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_contributor_role_tooltip ); ?>.</i>
										</div>
										<div class="line-separator"></div>
									</div>
								</div>
								<div class="form-group">
									<div id="ux_div_subscriber_roles">
										<label class="control-label">
											<?php echo esc_attr( $mb_roles_capabilities_subscriber_role ); ?> :
											<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
										</label>
										<div class="table-margin-top">
											<table class="table table-striped table-bordered table-hover" id="ux_tbl_subscriber">
												<thead>
													<tr>
														<th style="width: 40% !important;">
															<input type="checkbox" name="ux_chk_full_control_subscriber" id="ux_chk_full_control_subscriber" value="1" onclick="full_control_function_mail_bank(this, 'ux_div_subscriber_roles');" <?php echo isset( $subscriber ) && '1' === $subscriber[0] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_capabilities_full_control ); ?>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_configuration_subscriber" id="ux_chk_email_configuration_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[1] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_configuration ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_test_email_subscriber" id="ux_chk_test_email_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[2] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_test_email ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_connectivity_test_email_subscriber" id="ux_chk_connectivity_test_email_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[3] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_connectivity_test ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_logs_subscriber" id="ux_chk_email_logs_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[4] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_logs ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_notifications_subscriber" id="ux_chk_notifications_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[5] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_notifications ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_settings_subscriber" id="ux_chk_settings_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[6] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_settings ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_roles_and_capabilities_subscriber" id="ux_chk_roles_and_capabilities_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[7] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_system_information_subscriber" id="ux_chk_system_information_subscriber" value="1" <?php echo isset( $subscriber ) && '1' === $subscriber[8] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_system_information ); ?>
														</td>
														<td>
														</td>
													</tr>
												</tbody>
											</table>
											<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_subscriber_role_tooltip ); ?>.</i>
										</div>
										<div class="line-separator"></div>
									</div>
								</div>
								<div class="form-group">
									<div id="ux_div_other_privileges_roles">
										<label class="control-label">
											<?php echo esc_attr( $mb_roles_capabilities_other_role ); ?> :
											<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
										</label>
										<div class="table-margin-top">
											<table class="table table-striped table-bordered table-hover" id="ux_tbl_other_roles_privileges">
												<thead>
													<tr>
														<th style="width: 40% !important;">
															<input type="checkbox" name="ux_chk_full_control_other_privileges_roles" id="ux_chk_full_control_other_privileges_roles" value="1" onclick="full_control_function_mail_bank(this, 'ux_div_other_privileges_roles');" <?php echo isset( $other_privileges ) && '1' === $other_privileges[0] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_capabilities_full_control ); ?>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_configuration_others" id="ux_chk_email_configuration_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[1] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_configuration ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_test_email_others" id="ux_chk_test_email_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[2] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_test_email ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_connectivity_test_email_others" id="ux_chk_connectivity_test_email_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[3] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_connectivity_test ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_email_logs_others" id="ux_chk_email_logs_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[4] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_email_logs ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_notifications_others" id="ux_chk_notifications_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[5] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_notifications ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_settings_others" id="ux_chk_settings_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[6] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_settings ); ?>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="ux_chk_roles_and_capabilities_others" id="ux_chk_roles_and_capabilities_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[7] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
														</td>
														<td>
															<input type="checkbox" name="ux_chk_system_information_others" id="ux_chk_system_information_others" value="1" <?php echo isset( $other_privileges ) && '1' === $other_privileges[8] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_system_information ); ?>
														</td>
														<td>
														</td>
													</tr>
												</tbody>
											</table>
											<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_other_role_tooltip ); ?>.</i>
										</div>
										<div class="line-separator"></div>
									</div>
								</div>
								<div class="form-group">
									<div id="ux_div_other_roles">
										<label class="control-label">
											<?php echo esc_attr( $mb_roles_capabilities_other_roles_capabilities ); ?> :
											<span class="required" aria-required="true">* <?php echo '( ' . esc_attr( $mb_pro_label ) . ' )'; ?></span>
										</label>
										<div class="table-margin-top">
											<table class="table table-striped table-bordered table-hover" id="ux_tbl_other_roles">
												<thead>
													<tr>
														<th style="width: 40% !important;">
															<input type="checkbox" name="ux_chk_full_control_other_roles" id="ux_chk_full_control_other_roles" value="1" onclick="full_control_function_mail_bank(this, 'ux_div_other_roles');" <?php echo '1' === $details_roles_capabilities['others_full_control_capability'] ? 'checked = checked' : ''; ?>>
															<?php echo esc_attr( $mb_roles_capabilities_full_control ); ?>
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$flag              = 0;
													$user_capabilities = get_others_capabilities_mail_bank();
													foreach ( $user_capabilities as $key => $value ) {
														$other_roles = in_array( $value, $other_roles_array, true ) ? 'checked=checked' : '';
														$flag++;
														if ( 0 === $key % 3 ) {
															?>
															<tr>
																<?php
														}
														?>
														<td>
															<input type="checkbox" name="ux_chk_other_capabilities_<?php echo esc_attr( $value ); ?>" id="ux_chk_other_capabilities_<?php echo esc_attr( $value ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $other_roles ); ?>>
															<?php echo esc_attr( $value ); ?>
														</td>
														<?php
														if ( count( $user_capabilities ) === $flag && 1 === $flag % 3 ) {
															?>
																<td>
																</td>
																<td>
																</td>
															<?php
														}
														?>
														<?php
														if ( count( $user_capabilities ) === $flag && 2 === $flag % 3 ) {
															?>
															<td>
															</td>
															<?php
														}
														?>
														<?php
														if ( 0 === $flag % 3 ) {
															?>
															</tr>
															<?php
														}
													}
													?>
												</tbody>
											</table>
											<i class="controls-description"><?php echo esc_attr( $mb_roles_capabilities_other_roles_capabilities_tooltip ); ?>.</i>
										</div>
										<div class="line-separator"></div>
									</div>
								</div>
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
							<i class="dashicons dashicons-admin-users"></i>
							<?php echo esc_attr( $mb_roles_and_capabilities ); ?>
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
