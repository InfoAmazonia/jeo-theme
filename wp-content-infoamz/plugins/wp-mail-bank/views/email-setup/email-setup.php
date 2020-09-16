<?php
/**
 * This Template is used for email setup.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/views/email-setup
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
	} elseif ( EMAIL_CONFIGURATION_MAIL_BANK === '1' ) {
		$oauth_redirect_url                     = admin_url( 'admin-ajax.php' );
		$mail_bank_set_hostname_port            = wp_create_nonce( 'mail_bank_set_hostname_port' );
		$mail_bank_email_configuration_settings = wp_create_nonce( 'mail_bank_email_configuration_settings' );
		$mail_bank_test_email_configuration     = wp_create_nonce( 'mail_bank_test_email_configuration' );
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
							<i class="dashicons dashicons-admin-tools "></i>
							<?php echo esc_attr( $mb_email_configuration ); ?>
						</div>
					</div>
					<div class="portlet-body form mb-custom-form">
						<div class="form-body">
							<div class="form-wizard" id="ux_div_frm_wizard">
								<ul class="mail-bank-setup-steps nav-justified steps">
									<li class="active">
										<a aria-expanded="true" href="javascript:void(0);" class="step">
											<span class="desc"> <?php echo esc_attr( $mb_wizard_basic_info ); ?> </span>
										</a>
									</li>
									<li class="">
										<a href="javascript:void(0);" class="step">
											<span class="desc"><?php echo esc_attr( $mb_wizard_account_setup ); ?> </span>
										</a>
									</li>
									<li class="">
										<a href="javascript:void(0);" class="step">
											<span class="desc"><?php echo esc_attr( $mb_wizard_confirm ); ?> </span>
										</a>
									</li>
								</ul>
							</div>
							<div class="line-separator"></div>
							<div class="tab-content" id="mailer_settings">
								<form id="ux_frm_email_configuration">
									<div id="ux_div_first_step">
										<div class="row">
											<div class="col-md-7">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_enable_from_name ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<select name="ux_ddl_from_name" id="ux_ddl_from_name" class="form-control" onchange="mail_bank_from_name_override()">
														<option value="override"><?php echo esc_attr( $mb_override ); ?></option>
														<option value="dont_override"><?php echo esc_attr( $mb_dont_override ); ?></option>
													</select>
													<i class="controls-description"> <?php echo esc_attr( $mb_email_configuration_enable_from_name_tooltip ); ?>?</i>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_from_name ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<input type="text" class="form-control" name="ux_txt_mb_from_name" id="ux_txt_mb_from_name" value="<?php echo isset( $email_configuration_array['sender_name'] ) ? esc_html( $email_configuration_array['sender_name'] ) : ''; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-7">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_enable_from_email ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<select name="ux_ddl_from_email" id="ux_ddl_from_email" class="form-control" onchange="mail_bank_from_email_override()">
														<option value="override"><?php echo esc_attr( $mb_override ); ?></option>
														<option value="dont_override"><?php echo esc_attr( $mb_dont_override ); ?></option>
													</select>
													<i class="controls-description"> <?php echo esc_attr( $mb_email_configuration_enable_from_name_tooltip ); ?>?</i>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_from_email ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<input type="text" class="form-control" name="ux_txt_mb_from_email_configuration" id="ux_txt_mb_from_email_configuration" value="<?php echo isset( $email_configuration_array['sender_email'] ) ? esc_html( $email_configuration_array['sender_email'] ) : ''; ?>">
												</div>
											</div>
										</div>
										<div class="line-separator"></div>
										<div class="form-actions">
											<div class="pull-right">
												<button class="btn vivid-blue" name="ux_btn_next_step_second" id="ux_btn_next_step_second" onclick="mail_bank_move_to_second_step();"><?php echo esc_attr( $mb_next_step ); ?> >> </button>
											</div>
										</div>
									</div>
									<div id="ux_div_second_step" style="display:none">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_email_address ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<input type="text" class="form-control" name="ux_txt_email_address" id="ux_txt_email_address" value="<?php echo isset( $email_configuration_array['email_address'] ) ? esc_html( $email_configuration_array['email_address'] ) : ''; ?>" onblur="mail_bank_get_host_port()">
													<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_email_address_tooltip ); ?>.</i>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_reply_to ); ?> :
														<span class="required" aria-required="true"> ( <?php echo esc_attr( $mb_pro_label ); ?> )</span>
													</label>
													<input type="text" class="form-control" disabled="disabled" name="ux_txt_reply_to" id="ux_txt_reply_to" value="<?php echo isset( $email_configuration_array['reply_to'] ) ? esc_html( $email_configuration_array['reply_to'] ) : ''; ?>">
													<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_reply_to_tooltip ); ?>.</i>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_cc_label ); ?> :
														<span class="required" aria-required="true"> ( <?php echo esc_attr( $mb_pro_label ); ?> )</span>
													</label>
													<input type="text" class="form-control" disabled="disabled" name="ux_txt_cc" id="ux_txt_cc" value="<?php echo isset( $email_configuration_array['cc'] ) ? esc_attr( $email_configuration_array['cc'] ) : ''; ?>">
													<i class="controls-description"> <?php echo esc_attr( $mb_email_configuration_cc_email_address_tooltip ); ?>.</i>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_bcc_label ); ?> :
														<span class="required" aria-required="true"> ( <?php echo esc_attr( $mb_pro_label ); ?> )</span>
													</label>
													<input type="text" class="form-control" disabled="disabled" name="ux_txt_bcc" id="ux_txt_bcc" value="<?php echo isset( $email_configuration_array['bcc'] ) ? esc_attr( $email_configuration_array['bcc'] ) : ''; ?>">
													<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_bcc_email_address_tooltip ); ?>.</i>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_additional_header ); ?> :
												<span class="required" aria-required="true"> ( <?php echo esc_attr( $mb_pro_label ); ?> )</span>
											</label>
											<textarea class="form-control" disabled="disabled" name="ux_txt_additional_header" id="ux_txt_additional_header" ><?php echo isset( $email_configuration_array['headers'] ) ? esc_attr( $email_configuration_array['headers'] ) : ''; ?></textarea>
											<i class="controls-description"><?php echo esc_attr( $mb_additional_header_tooltip ); ?>.</i>
										</div>
										<div class="form-group">
											<label class="control-label">
												<?php echo esc_attr( $mb_email_configuration_mailer_type ); ?> :
												<span class="required" aria-required="true">*</span>
											</label>
											<select name="ux_ddl_type" id="ux_ddl_type" class="form-control" onchange="change_settings_mail_bank()">
												<option value="php_mail_function" selected="selected"><?php echo esc_attr( $mb_email_configuration_use_php_mail_function ); ?></option>
												<option value="smtp"><?php echo esc_attr( $mb_email_configuration_send_email_via_smtp ); ?></option>
												<option value="sendgrid_api" style="color:red;"><?php echo esc_attr( $mb_send_grid_api_details . ' ( ' . esc_attr( $mb_pro_label ) . ' ) ' ); ?></option>
												<option value="mailgun_api" style="color:red;"><?php echo esc_attr( $mb_email_configuration_send_email_via_mailgun_api . ' ( ' . esc_attr( $mb_pro_label ) . ' ) ' ); ?></option>
											</select>
											<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_mailer_type_tooltip ); ?>.</i>
										</div>
										<div id="ux_div_smtp_mail_function">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															<?php echo esc_attr( $mb_mail_server_host ); ?> :
															<span class="required" aria-required="true">*</span>
														</label>
														<input type="text" class="form-control" name="ux_txt_host" id="ux_txt_host" value="<?php echo isset( $email_configuration_array['hostname'] ) ? esc_html( $email_configuration_array['hostname'] ) : ''; ?>" onblur="change_link_content_mail_bank();">
														<i class="controls-description"> <?php echo esc_attr( $mb_email_configuration_smtp_host_tooltip ); ?>.</i>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															<?php echo esc_attr( $mb_email_configuration_encryption ); ?> :
															<span class="required" aria-required="true">*</span>
														</label>
														<select name="ux_ddl_encryption" id="ux_ddl_encryption" class="form-control" onchange="mail_bank_select_port()">
															<option value="none"><?php echo esc_attr( $mb_email_configuration_no_encryption ); ?></option>
															<option value="tls"><?php echo esc_attr( $mb_email_configuration_use_tls_encryption ); ?></option>
															<option value="ssl"><?php echo esc_attr( $mb_email_configuration_use_ssl_encryption ); ?></option>
														</select>
														<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_encryption_tooltip ); ?>.</i>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															<?php echo esc_attr( $mb_email_configuration_smtp_port ); ?> :
															<span class="required" aria-required="true">*</span>
														</label>
														<input type="text" class="form-control" name="ux_txt_port" id="ux_txt_port" value="<?php echo isset( $email_configuration_array['port'] ) ? esc_html( $email_configuration_array['port'] ) : ''; ?>" onfocus="paste_only_digits_mail_bank(this.id);">
														<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_smtp_port_tooltip ); ?>.</i>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															<?php echo esc_attr( $mb_authentication ); ?> :
															<span class="required" aria-required="true">*</span>
														</label>
														<select name="ux_ddl_mb_authentication" id="ux_ddl_mb_authentication" class="form-control" onchange="select_credentials_mail_bank()">
															<option value="none"><?php echo esc_attr( $mb_email_configuration_none ); ?></option>
															<option value="oauth2"><?php echo esc_attr( $mb_email_configuration_use_oauth ); ?></option>
															<option value="crammd5"><?php echo esc_attr( $mb_cram_md5 ); ?></option>
															<option value="login"><?php echo esc_attr( $mb_email_configuration_login ); ?></option>
															<option value="plain"><?php echo esc_attr( $mb_email_configuration_use_plain_authentication ); ?></option>
														</select>
														<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_authentication_tooltip ); ?>.</i>
													</div>
												</div>
											</div>
											<div id="ux_div_oauth_authentication">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																<?php echo esc_attr( $mb_email_configuration_client_id ); ?><a href="https://console.developers.google.com" target="_blank" id="ux_link_reference_google" ><span id="ux_link_content_google">( <?php echo esc_attr( $mb_email_configuration_get_credentials ); ?> / </span></a><a id="ux_link_reference" href="<?php echo esc_url( TECH_BANKER_URL ); ?>/tutorials/how-to-setup-gmail-google-smtp-with-wp-mail-bank/" target="_blank"> <span id="ux_link_content"><?php echo esc_attr( $mb_email_configuration_how_to_set_up ); ?> )</a></span>:
																<span class="required" aria-required="true">*</span>
															</label>
															<input type="text" class="form-control" name="ux_txt_client_id" id="ux_txt_client_id" value="<?php echo isset( $email_configuration_array['client_id'] ) ? esc_html( $email_configuration_array['client_id'] ) : ''; ?>" onclick="this.select()">
															<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_client_id_tooltip ); ?>.</i>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																<?php echo esc_attr( $mb_email_configuration_client_secret ); ?> :
																<span class="required" aria-required="true">*</span>
															</label>
															<input type="text" class="form-control" name="ux_txt_client_secret" id="ux_txt_client_secret" value="<?php echo isset( $email_configuration_array['client_secret'] ) ? esc_html( $email_configuration_array['client_secret'] ) : ''; ?>" onclick="this.select()">
															<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_client_secret_tooltip ); ?>.</i>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_redirect_uri ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<div class="dashicons dashicons-book pull-right" style="font-size:18px;" data-original-title="<?php echo esc_attr( $mb_copied_successfully ); ?>" data-placement="left" data-clipboard-action="copy" data-clipboard-target="#ux_txt_redirect_uri"></div>
													<input type="text" name="ux_txt_redirect_uri" id="ux_txt_redirect_uri" class="form-control" readonly='readonly' value="<?php echo esc_attr( $oauth_redirect_url ); ?>">
													<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_redirect_uri_tooltip ); ?>.</i>
												</div>
											</div>
											<div id="ux_div_username_password_authentication">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																<?php echo esc_attr( $mb_email_configuration_username ); ?> :
																<span class="required" aria-required="true">*</span>
															</label>
															<input type="text" class="form-control" name="ux_txt_username" id="ux_txt_username" value="<?php echo isset( $email_configuration_array['username'] ) ? esc_html( $email_configuration_array['username'] ) : ''; ?>">
															<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_username_tooltip ); ?>.</i>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																<?php echo esc_attr( $mb_email_configuration_password ); ?> :
																<span class="required" aria-required="true">*</span>
															</label>
															<input type="password" class="form-control" name="ux_txt_password" id="ux_txt_password" value="<?php echo isset( $email_configuration_array['password'] ) ? esc_attr( str_repeat( '*', strlen( base64_decode( esc_html( $email_configuration_array['password'] ) ) ) ) ) : ''; ?>">
															<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_password_tooltip ); ?>.</i>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="ux_div_sendgrid_api">
											<div class="form-group">
												<label class="control-label">
													<?php echo esc_attr( $mb_send_grid_api_details ); ?> ( <a href="https://app.sendgrid.com/settings/api_keys" target="_blank"><?php echo esc_attr( $mb_get_sendgrid_api_key ); ?></a> ):
												</label>
												<input type="text" class="form-control" name="ux_txt_sendgrid_api_key" id="ux_txt_sendgrid_api_key" value="<?php echo isset( $email_configuration_array['sendgrid_api_key'] ) ? esc_attr( $email_configuration_array['sendgrid_api_key'] ) : ''; ?>">
												<i class="controls-description"><?php echo esc_attr( $mb_send_grid_api_details_tooltip ); ?>.</i>
											</div>
										</div>
										<div id="ux_div_mailgun_api">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															<?php echo esc_attr( $mb_licensing_api_key_label ); ?> ( <a href="https://app.mailgun.com/app/domains" target="_blank"><?php echo esc_attr( $mb_mailgun_api_details ); ?></a> ) :
														</label>
														<input type="text" class="form-control" name="ux_txt_mailgun_api_key" id="ux_txt_mailgun_api_key" value="<?php echo isset( $email_configuration_array['mailgun_api_key'] ) ? esc_attr( $email_configuration_array['mailgun_api_key'] ) : ''; ?>">
														<i class="controls-description"><?php echo esc_attr( $mb_mailgun_api_details_tooltip ); ?>.</i>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															<?php echo esc_attr( $mb_mailgun_domain_name ); ?> :
														</label>
														<input type="text" class="form-control" name="ux_txt_mailgun_domain_name" id="ux_txt_mailgun_domain_name" value="<?php echo isset( $email_configuration_array['mailgun_domain_name'] ) ? esc_attr( $email_configuration_array['mailgun_domain_name'] ) : ''; ?>">
														<i class="controls-description"><?php echo esc_attr( $mb_mailgun_domain_name_tooltip ); ?>.</i>
													</div>
												</div>
											</div>
										</div>
										<div id="ux_div_automatic_mail">
											<div class="form-group">
												<label class="control-label">
													<input type="checkbox"  name="ux_chk_automatic_sent_mail" id="ux_chk_automatic_sent_mail" value="1" checked="checked">
													<strong><?php echo esc_attr( $mb_email_configuration_tick_for_sent_mail ); ?></strong>
												</label>
											</div>
										</div>
										<div class="line-separator"></div>
										<div class="form-actions">
											<div class="pull-left">
												<button type="button" class="btn vivid-blue" name="ux_btn_previsious_step_first" id="ux_btn_previsious_step_first" onclick="mail_bank_move_to_first_step()"> << <?php echo esc_attr( $mb_previous_step ); ?></button>
											</div>
											<div class="pull-right">
												<button  class="btn vivid-blue" name="ux_btn_next_step_third" id="ux_btn_next_step_third" onclick="mail_bank_move_to_third_step();"><?php echo esc_attr( $mb_next_step ); ?> >></button>
											</div>
										</div>
									</div>
								</form>
								<div id="test_email" style="display:none">
									<form id="ux_frm_test_email_configuration">
										<div id="ux_div_test_mail">
											<div class="form-group">
												<label class="control-label">
													<?php echo esc_attr( $mb_email_configuration_email_address ); ?> :
													<span class="required" aria-required="true">*</span>
												</label>
												<?php
													$admin_email = get_option( 'admin_email' );
													?>
													<input type="text" class="form-control" name="ux_txt_email" id="ux_txt_email" value="<?php echo esc_attr( $admin_email ); ?>">
													<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_test_email_address_tooltip ); ?>.</i>
												</div>
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_subject ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<input type="text" class="form-control" name="ux_txt_subject" id="ux_txt_subject" value="Test Email - Mail Bank">
													<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_subject_test_tooltip ); ?>.</i>
												</div>
												<div class="form-group">
													<label class="control-label">
														<?php echo esc_attr( $mb_email_configuration_content ); ?> :
														<span class="required" aria-required="true">*</span>
													</label>
													<?php
														$email_configuration = 'This is a demo Email for Email Setup - Mail Bank';
														wp_editor(
															$email_configuration, 'ux_content', array(
																'teeny' => true,
																'textarea_name' => 'description',
																'media_buttons' => false,
																'textarea_rows' => 5,
															)
														);
														?>
													<textarea id="ux_email_configuration_text_area" name="ux_email_configuration_text_area" style="display: none;"></textarea>
													<i class="controls-description"><?php echo esc_attr( $mb_email_configuration_content_tooltip ); ?>.</i>
												</div>
												<div class="line-separator"></div>
												<div class="form-actions">
													<div class="pull-left">
														<button type="button" class="btn vivid-blue" name="ux_btn_previous_step_second" id="ux_btn_previous_step_second" onclick="mail_bank_second_step_settings()"> << <?php echo esc_attr( $mb_previous_step ); ?></button>
													</div>
													<div class="pull-right">
														<button class="btn vivid-blue" name="ux_btn_save_test_email"  id="ux_btn_save_test_email" onclick="mail_bank_send_test_mail()"><?php echo esc_attr( $mb_test_email ); ?></button>
														<button type="button" class="btn vivid-blue" name="ux_btn_save_changes" id="ux_btn_save_changes" onclick="mail_bank_save_changes()"> <?php echo esc_attr( $mb_save_changes ); ?></button>
													</div>
												</div>
											</div>
											<div id="console_log_div" style="display: none;">
												<div class="form-group">
													<label class="control-label"><?php echo esc_attr( $mb_email_configuration_result ); ?> :</label>
													<textarea name="ux_txtarea_console_log" class="form-control" id="ux_txtarea_console_log" rows="15" readonly="readonly"><?php echo esc_attr( $mb_email_configuration_send_test_email_textarea ); ?></textarea>
												</div>
											</div>
											<div id="ux_div_mail_console" style="display: none;">
												<div id="result_div">
													<div class="form-group">
														<label class="control-label"><?php echo esc_attr( $mb_email_configuration_result ); ?>:</label>
														<textarea name="ux_txtarea_result_log" id="ux_txtarea_result_log" class="mb-email-setup-wizard form-control" rows="16"  readonly="readonly" ></textarea>
													</div>
												</div>
											<div class="line-separator"></div>
											<div class="form-actions">
												<div class="pull-left">
													<button type="button" class="btn vivid-blue" name="ux_btn_previous_step_third" id="ux_btn_previous_step_third" onclick="mail_bank_second_step_settings()">  << <?php echo esc_attr( $mb_previous_step ); ?></button>
												</div>
												<div class="pull-right">
													<input type="button" class="btn vivid-blue" name="ux_btn_another_test_email" onclick="another_test_email_mail_bank();" id="ux_btn_another_test_email" value="<?php echo esc_attr( $mb_email_configuration_send_another_test_email ); ?>">
													<button type="button" class="btn vivid-blue" name="ux_btn_save_changes_on_another_mail" id="ux_btn_save_changes_on_another_mail" onclick="mail_bank_save_changes()"> <?php echo esc_attr( $mb_save_changes ); ?></button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
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
							<i class="dashicons dashicons-admin-tools "></i>
							<?php echo esc_attr( $mb_email_configuration ); ?>
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
