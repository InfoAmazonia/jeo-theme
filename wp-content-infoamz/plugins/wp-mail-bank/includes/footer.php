<?php
/**
 * This file contains javascript code.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
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
		?>
	</div>
	<script type="text/javascript">
		function show_hide_notifications_service(id, email_div, div, div_id) {
			var email_service = jQuery(id).val();
			switch (email_service) {
				case "email":
					jQuery(email_div).css("display", "block");
					jQuery(div_id).css("display", "none");
					jQuery(div).css("display", "none");
					break;
				case "pushover":
					jQuery(div).css("display", "block");
					jQuery(div_id).css("display", "none");
					jQuery(email_div).css("display", "none");
					break;
				case "slack":
					jQuery(div_id).css("display", "block");
					jQuery(div).css("display", "none");
					jQuery(email_div).css("display", "none");
					break;
				default:
					jQuery(div).css("display", "none");
					jQuery(div_id).css("display", "none");
					jQuery(email_div).css("display", "none");
					break;
			}
		}
		function show_hide_delete_after_logs(id, div_id) {
			var type = jQuery(id).val();
			switch (type) {
				case "enable":
					jQuery(div_id).css("display", "block");
					break;
				case "disable":
					jQuery(div_id).css("display", "none");
					break;
				default:
					jQuery(div_id).css("display", "none");
					break;
			}
		}
		if (typeof (paste_only_digits_mail_bank) !== "function")
		{
			function paste_only_digits_mail_bank(control_id)
			{
				jQuery("#" + control_id).on("paste keypress", function (e)
				{
					var $this = jQuery("#" + control_id);
					setTimeout(function ()
					{
						$this.val($this.val().replace(/[^0-9]/g, ""));
					}, 5);
				});
			}
		}
		function premium_edition_notification_mail_bank()
		{
			var premium_edition = <?php echo wp_json_encode( $mb_message_premium_edition ); ?>;
			var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
			toastr[shortCutFunction](premium_edition);
		}
		if (typeof (overlay_loading_mail_bank) !== "function")
		{
			function overlay_loading_mail_bank(control_id)
			{
				var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
				jQuery("body").append(overlay_opacity);
				var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
				jQuery("body").append(overlay);
				if (control_id !== undefined)
				{
					var message = control_id;
					var success = <?php echo wp_json_encode( $mb_success ); ?>;
					var issuccessmessage = jQuery("#toast-container").exists();
					if (issuccessmessage !== true)
					{
						var shortCutFunction = jQuery("#manage_messages input:checked").val();
						toastr[shortCutFunction](message, success);
					}
				}
			}
		}
		var clipboard = new Clipboard(".dashicons-book");
		clipboard.on("success", function (e)
		{
			var shortCutFunction = jQuery("#manage_messages input:checked").val();
			toastr[shortCutFunction](<?php echo wp_json_encode( $mb_copied_successfully ); ?>);
		});
		if (typeof (remove_overlay_mail_bank) !== "function"){
			function remove_overlay_mail_bank()
			{
				jQuery(".loader_opacity").remove();
				jQuery(".opacity_overlay").remove();
			}
		}
		if (typeof (base64_encode) !== "function"){
			function base64_encode(data)
			{
				var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
				var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
				ac = 0,
				enc = '',
				tmp_arr = [];
				if (!data){
					return data;
				}
				do
				{
					o1 = data.charCodeAt(i++);
					o2 = data.charCodeAt(i++);
					o3 = data.charCodeAt(i++);
					bits = o1 << 16 | o2 << 8 | o3;
					h1 = bits >> 18 & 0x3f;
					h2 = bits >> 12 & 0x3f;
					h3 = bits >> 6 & 0x3f;
					h4 = bits & 0x3f;
					tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
				} while (i < data.length);
				enc = tmp_arr.join('');
				var r = data.length % 3;
				return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
			}
		}
		if (typeof (another_test_email_mail_bank) !== "function") {
			function another_test_email_mail_bank()
			{
				jQuery("#ux_div_mail_console").css("display", "none");
				jQuery("#console_log_div").css("display", "none");
				jQuery("#ux_div_help_support").css("display", "none");
				jQuery("#ux_div_test_mail").css("display", "block");
			}
		}
		if (typeof (check_links_oauth_mail_bank) !== "function")
		{
			function check_links_oauth_mail_bank()
			{
				var smtp_host = jQuery("#ux_txt_host").val();
				var indexof = smtp_host.indexOf("yahoo");
				var hostname = smtp_host.substr(indexof, 5);
				if (smtp_host === "smtp.gmail.com")
				{
					jQuery("#ux_link_content_google").text("(" +<?php echo wp_json_encode( $mb_email_configuration_get_credentials ); ?>);
					jQuery("#ux_link_content").text(" / "+<?php echo wp_json_encode( $mb_email_configuration_how_to_set_up ); ?>+" )");
					jQuery("#ux_link_reference_google").attr("href", "https://console.developers.google.com");
					jQuery("#ux_link_reference").attr("href", "https://tech-banker.com/blog/how-to-setup-gmail-google-smtp-with-wp-mail-bank/");
				} else if (smtp_host === "smtp.live.com")
				{
					jQuery("#ux_link_content_google").text("(" +<?php echo wp_json_encode( $mb_email_configuration_get_credentials ); ?>);
					jQuery("#ux_link_content").text(" / "+<?php echo wp_json_encode( $mb_email_configuration_how_to_set_up ); ?>+" )");
					jQuery("#ux_link_reference_google").attr("href", "https://account.live.com/developers/applications/create");
					jQuery("#ux_link_reference").attr("href", "https://tech-banker.com/blog/how-to-setup-office-365-smtp-with-wp-mail-bank/");
				} else if (hostname === "yahoo")
				{
					jQuery("#ux_link_content_google").text("(" +<?php echo wp_json_encode( $mb_email_configuration_get_credentials ); ?>);
					jQuery("#ux_link_content").text(" / "+<?php echo wp_json_encode( $mb_email_configuration_how_to_set_up ); ?>+" )");
					jQuery("#ux_link_reference_google").attr("href", "https://developer.yahoo.com/apps/");
					jQuery("#ux_link_reference").attr("href", "https://tech-banker.com/blog/how-to-setup-yahoo-smtp-with-wp-mail-bank/");
				} else
				{
					jQuery("#ux_link_content_google").text("");
					jQuery("#ux_link_content").text("");
				}
			}
		}
		if (typeof (mail_bank_mail_sender) !== "function")
		{
			function mail_bank_mail_sender(to_email_address)
			{
				jQuery.post(ajaxurl,
				{
					data: base64_encode(jQuery("#ux_frm_test_email_configuration").serialize()),
					param: "mail_bank_test_email_configuration_module",
					action: "mail_bank_action",
					_wp_nonce: "<?php echo isset( $mail_bank_test_email_configuration ) ? esc_attr( $mail_bank_test_email_configuration ) : ''; ?>"
				},
				function (data)
				{
					jQuery("#ux_txtarea_result_log").html("<?php echo esc_attr( $mb_email_configuration_send_test_email_textarea ); ?>\n");
					jQuery("#ux_txtarea_result_log").append(<?php echo wp_json_encode( $mb_test_email_sending_test_email ); ?> + "&nbsp;" + to_email_address + "\n");
					jQuery("#ux_div_help_support").css("display", "block");
					if (jQuery.trim(data) === "true" || jQuery.trim(data) === "1")
					{
						jQuery("#ux_div_mail_console").css("display", "block");
						jQuery("#console_log_div").css("display", "none");
						jQuery("#ux_txtarea_result_log").append(<?php echo wp_json_encode( $mb_test_email_sent ); ?>);
					} else
					{
						jQuery("#console_log_div").css("display", "none");
						jQuery("#ux_div_mail_console").css("display", "block");
						if (jQuery.trim(data) !== "")
						{
							jQuery("#ux_txtarea_result_log").html(data);
						} else
						{
							jQuery("#ux_txtarea_result_log").append(<?php echo wp_json_encode( $mb_test_email_not_send ); ?>);
						}
					}
				});
			}
		}
		if (typeof (mail_bank_send_test_mail) !== "function")
		{
			function mail_bank_send_test_mail()
			{
				jQuery("#ux_frm_test_email_configuration").validate
				({
					rules:
					{
						ux_txt_email:
						{
							required: true,
							email: true
						},
						ux_txt_subject:
						{
							required: true
						},
						ux_content:
						{
							required: true
						}
					},
					errorPlacement: function ()
					{
					},
					highlight: function (element)
					{
						jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
					},
					success: function (label, element)
					{
						var icon = jQuery(element).parent(".input-icon").children("i");
						jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
						icon.removeClass("fa-warning").addClass("fa-check");
					},
					submitHandler: function ()
					{
						var to_email_address = jQuery("#ux_txt_email").val();
						if (window.CKEDITOR)
						{
							jQuery("#ux_email_configuration_text_area").val(CKEDITOR.instances["ux_content"].getData());
						} else if (jQuery("#wp-ux_content-wrap").hasClass("tmce-active"))
						{
							jQuery("#ux_email_configuration_text_area").val(tinyMCE.get("ux_content").getContent());
						} else {
							jQuery("#ux_email_configuration_text_area").val(jQuery("#ux_content").val());
						}
						mail_bank_mail_sender(to_email_address);
						jQuery("#console_log_div").css("display", "block");
						jQuery("#ux_div_help_support").css("display", "block");
						jQuery("#ux_div_test_mail").css("display", "none");
					}
				});
			}
		}
		<?php
		$check_wp_mail_bank_wizard = get_option( 'mail-bank-welcome-page' );
		if ( isset( $_GET['page'] ) ) {
			$page = sanitize_text_field( wp_unslash( $_GET['page'] ) );// WPCS: CSRF ok,WPCS: input var ok.
		}
		$page_url = false === $check_wp_mail_bank_wizard ? 'wp_mail_bank_wizard' : $page;
		if ( isset( $_GET['page'] ) ) { // WPCS: CSRF ok,WPCS: input var ok.
			switch ( $page_url ) {
				case 'wp_mail_bank_wizard':
					?>
					if (typeof (show_hide_details_wp_mail_bank) !== "function")
					{
						function show_hide_details_wp_mail_bank()
						{
							if (jQuery("#ux_div_wizard_set_up").hasClass("wizard-set-up"))
							{
								jQuery("#ux_div_wizard_set_up").css("display", "none");
								jQuery("#ux_div_wizard_set_up").removeClass("wizard-set-up");
							} else
							{
								jQuery("#ux_div_wizard_set_up").css("display", "block");
								jQuery("#ux_div_wizard_set_up").addClass("wizard-set-up");
							}
						}
					}
					if (typeof (plugin_stats_wp_mail_bank) !== "function")
					{
						function plugin_stats_wp_mail_bank(type)
						{
							var validate_form = '';
							var email_pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
							var wizard_notification_array = [ 'ux_txt_email_address_notifications', 'ux_txt_first_name' ];
							wizard_notification_array.forEach( function( element ) {
								if( ( jQuery('#'+ element).val() === '' || false == email_pattern.test(jQuery("#ux_txt_email_address_notifications").val()) ) && type !== 'skip' )
									{
										validate_form = 1;
										jQuery('#'+ element).css("border-color","red");
										jQuery('#'+ element+'_validate').css({"display":'','color':'red'});
										jQuery('#'+ element+'_wizard_firstname').css({"display":'','color':'red'});
									} else {
										jQuery('#'+ element).css("border-color","#ddd");
										jQuery('#'+ element+'_validate').css( 'display','none' );
										jQuery('#'+ element+'_wizard_firstname').css( 'display','none' );
									}
							});
							if( validate_form == "" ) {
								overlay_loading_mail_bank();
								jQuery.post(ajaxurl,
								{
									first_name: jQuery("#ux_txt_first_name").val(),
									last_name: jQuery("#ux_txt_last_name").val(),
									id: jQuery("#ux_txt_email_address_notifications").val(),
									type: type,
									param: "wizard_wp_mail_bank",
									action: "mail_bank_action",
									_wp_nonce: "<?php echo esc_attr( $wp_mail_bank_check_status ); ?>"
								},
								function ()
								{
									remove_overlay_mail_bank();
									window.location.href = "admin.php?page=mb_email_configuration";
								});
							}
						}
					}
					<?php
					break;
				case 'mb_email_configuration':
					if ( '1' === EMAIL_CONFIGURATION_MAIL_BANK ) {
						?>
					if (typeof (select_credentials_mail_bank) !== "function")
					{
						function select_credentials_mail_bank()
						{
							var selected_credential = jQuery("#ux_ddl_mb_authentication").val();
							var type = jQuery("#ux_ddl_type").val();
							if (selected_credential === "oauth2" && type === "smtp")
							{
								jQuery("#ux_div_username_password_authentication").css("display", "none");
								jQuery("#ux_div_oauth_authentication").css("display", "block");
								check_links_oauth_mail_bank();
							} else
							{
								if (selected_credential === "none")
								{
									jQuery("#ux_div_username_password_authentication").css("display", "none");
									jQuery("#ux_div_oauth_authentication").css("display", "none");
								} else
								{
									jQuery("#ux_div_username_password_authentication").css("display", "block");
									jQuery("#ux_div_oauth_authentication").css("display", "none");
								}
							}
						}
					}
					if (typeof (mail_bank_second_step_settings) !== "function")
					{
						function mail_bank_second_step_settings()
						{
							jQuery("#ux_div_first_step").css("display", "none");
							jQuery("#test_email").css("display", "none");
							jQuery("#ux_div_second_step").css("display", "block");
							jQuery("#ux_div_step_progres_bar_width").css("width", "66%");
							jQuery("#ux_div_frm_wizard li:eq(1)").addClass("active");
							jQuery("#ux_div_frm_wizard li:eq(2)").removeClass("active");
						}
					}
					if (typeof (mail_bank_third_step_settings) !== "function")
					{
						function mail_bank_third_step_settings()
						{
							jQuery("#ux_div_first_step").removeClass("first-step-helper");
							jQuery("#test_email").css("display", "block");
							jQuery("#ux_div_first_step").css("display", "none");
							jQuery("#ux_div_second_step").css("display", "none");
							jQuery("#ux_div_step_progres_bar_width").css("width", "100%");
							jQuery("#ux_div_frm_wizard li:eq(1)").addClass("active");
							jQuery("#ux_div_frm_wizard li:eq(2)").addClass("active");
						}
					}
					if (typeof (mail_bank_from_name_override) !== "function")
					{
						function mail_bank_from_name_override()
						{
							var from_name = jQuery("#ux_ddl_from_name").val();
							if (jQuery.trim(from_name) === "dont_override")
							{
								jQuery("#ux_txt_mb_from_name").attr("disabled", true);
							} else
							{
								jQuery("#ux_txt_mb_from_name").attr("disabled", false);
							}
						}
					}
					if (typeof (mail_bank_from_email_override) !== "function")
					{
						function mail_bank_from_email_override()
						{
							var from_email = jQuery("#ux_ddl_from_email").val();
							if (jQuery.trim(from_email) === "dont_override")
							{
								jQuery("#ux_txt_mb_from_email_configuration").attr("disabled", true);
							} else
							{
								jQuery("#ux_txt_mb_from_email_configuration").attr("disabled", false);
							}
						}
					}
					if (typeof (mail_bank_validate_settings) !== "function")
					{
						function mail_bank_validate_settings()
						{
							jQuery("#ux_frm_email_configuration").validate
							({
								rules:
								{
									ux_txt_mb_from_name:
									{
										required: true
									},
									ux_txt_mb_from_email_configuration:
									{
										required: true,
										email: true
									},
									ux_txt_email_address:
									{
										required: true,
										email: true
									},
									ux_txt_host:
									{
										required: true
									},
									ux_txt_port:
									{
										required: true
									},
									ux_txt_client_id:
									{
										required: true
									},
									ux_txt_client_secret:
									{
										required: true
									},
									ux_txt_username:
									{
										required: true
									},
									ux_txt_password:
									{
										required: true
									}
								},
								errorPlacement: function ()
								{
								},
								highlight: function (element)
								{
									jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
								},
								success: function (label, element)
								{
									var icon = jQuery(element).parent(".input-icon").children("i");
									jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
									icon.removeClass("fa-warning").addClass("fa-check");
								},
								submitHandler: function ()
								{
									if (jQuery("#ux_div_first_step").hasClass("first-step-helper"))
									{
										mail_bank_second_step_settings();
									} else if (jQuery("#test_email").hasClass("second-step-helper"))
									{
										jQuery.post(ajaxurl,
										{
											data: base64_encode(jQuery("#ux_frm_email_configuration").serialize()),
											action: "mail_bank_action",
											param: "mail_bank_email_configuration_settings_module",
											_wp_nonce: "<?php echo esc_attr( $mail_bank_email_configuration_settings ); ?>"
										},
										function (data)
										{
											var automatic_mail = jQuery("#ux_chk_automatic_sent_mail").is(":checked");
											var mailer_type = jQuery("#ux_ddl_type").val();
											if (jQuery.trim(data) === "100" && mailer_type === "smtp")
											{
												var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
												toastr[shortCutFunction](<?php echo wp_json_encode( $oauth_not_supported ); ?>);
											} else if (jQuery.trim(data) !== "" && mailer_type === "smtp")
											{
												window.location.href = data;
											} else
											{
												var send_mail = false;
												if (jQuery.trim(automatic_mail) === "true")
												{
													var send_mail = true;
												}
												window.location.href = "admin.php?page=mb_email_configuration&auto_mail=" + send_mail;
											}
										});
									}
								}
							});
						}
					}
					if (typeof (change_settings_mail_bank) !== "function")
					{
						function change_settings_mail_bank()
						{
							var type = jQuery("#ux_ddl_type").val();
							switch (type)
							{
								case "php_mail_function":
									jQuery("#ux_div_smtp_mail_function").css("display", "none");
									jQuery("#ux_div_sendgrid_api").css("display", "none");
									jQuery("#ux_div_mailgun_api").css("display", "none");
									break;
								case "smtp":
									jQuery("#ux_div_smtp_mail_function").css("display", "block");
									jQuery("#ux_div_sendgrid_api").css("display", "none");
									jQuery("#ux_div_mailgun_api").css("display", "none");
									break;
								case "sendgrid_api":
									jQuery("#ux_div_smtp_mail_function").css("display", "none");
									jQuery("#ux_div_sendgrid_api").css("display", "block");
									jQuery("#ux_div_mailgun_api").css("display", "none");
									break;
								case "mailgun_api":
									jQuery("#ux_div_smtp_mail_function").css("display", "none");
									jQuery("#ux_div_mailgun_api").css("display", "block");
									jQuery("#ux_div_sendgrid_api").css("display", "none");
									break;
							}
							select_credentials_mail_bank();
						}
					}
					if (typeof (mail_bank_get_host_port) !== "function")
					{
						function mail_bank_get_host_port()
						{
							change_settings_mail_bank();
							var smtp_user = jQuery("#ux_txt_email_address").val();
							jQuery.post(ajaxurl,
							{
								smtp_user: smtp_user,
								param: "mail_bank_set_hostname_port_module",
								action: "mail_bank_action",
								_wp_nonce: "<?php echo esc_attr( $mail_bank_set_hostname_port ); ?>"
							},
							function (data)
							{
								if (jQuery.trim(data) !== "")
								{
									jQuery("#ux_txt_host").val(data);
									check_links_oauth_mail_bank();
								} else
								{
									jQuery("#ux_txt_host").val("");
									jQuery("#ux_link_content").text("");
								}
								change_settings_mail_bank();
							});
						}
					}
					if (typeof (change_link_content_mail_bank) !== "function")
					{
						function change_link_content_mail_bank()
						{
							var host_type = jQuery("#ux_txt_host").val();
							var indexof = host_type.indexOf("yahoo");
							var hostname = host_type.substr(indexof, 5);
							if (host_type === "smtp.gmail.com")
							{
								check_links_oauth_mail_bank();
								jQuery("#ux_ddl_mb_authentication").val("oauth2");
								select_credentials_mail_bank();
							} else if (host_type === "smtp.live.com")
							{
								check_links_oauth_mail_bank();
								jQuery("#ux_ddl_mb_authentication").val("oauth2");
								select_credentials_mail_bank();
							} else if (hostname === "yahoo")
							{
								check_links_oauth_mail_bank();
								jQuery("#ux_ddl_mb_authentication").val("oauth2");
								select_credentials_mail_bank();
							} else
							{
								check_links_oauth_mail_bank();
								jQuery("#ux_ddl_mb_authentication").val("login");
								select_credentials_mail_bank();
							}
						}
					}
					jQuery(document).ready(function ()
					{
						if (window.CKEDITOR)
						{
							CKEDITOR.replace("ux_content");
						}
						jQuery("#ux_ddl_type").val("<?php echo isset( $email_configuration_array['mailer_type'] ) ? esc_attr( $email_configuration_array['mailer_type'] ) : ''; ?>");
						jQuery("#ux_ddl_mb_authentication").val("<?php echo isset( $email_configuration_array['auth_type'] ) ? esc_attr( $email_configuration_array['auth_type'] ) : 'login'; ?>");
						jQuery("#ux_ddl_from_name").val("<?php echo isset( $email_configuration_array['sender_name_configuration'] ) ? esc_attr( $email_configuration_array['sender_name_configuration'] ) : ''; ?>");
						jQuery("#ux_ddl_from_email").val("<?php echo isset( $email_configuration_array['from_email_configuration'] ) ? esc_attr( $email_configuration_array['from_email_configuration'] ) : ''; ?>");
						jQuery("#ux_ddl_encryption").val("<?php echo isset( $email_configuration_array['enc_type'] ) ? esc_attr( $email_configuration_array['enc_type'] ) : ''; ?>");
						<?php
						if ( isset( $test_secret_key_error ) ) {
							?>
							var shortCutFunction = jQuery("#toastTypeGroup_error input:checked").val();
							toastr[shortCutFunction](<?php echo wp_json_encode( $test_secret_key_error ); ?>);
							mail_bank_second_step_settings();
							<?php
						}
						if ( isset( $automatically_send_mail ) ) {
							?>
							window.location.href = "admin.php?page=mb_email_configuration&auto_mail=true";
							<?php
						} elseif ( isset( $automatically_not_send_mail ) ) {
							?>
							window.location.href = "admin.php?page=mb_email_configuration&auto_mail=false";
							<?php
						}
						?>
						select_credentials_mail_bank();
						change_settings_mail_bank();
						mail_bank_from_name_override();
						mail_bank_from_email_override();
						<?php
						if ( isset( $_REQUEST['auto_mail'] ) && sanitize_text_field( wp_unslash( $_REQUEST['auto_mail'] ) ) === 'true' ) { // WPCS: CSRF ok, WPCS: input var ok.
							?>
							mail_bank_mail_sender("<?php echo esc_attr( get_option( 'admin_email' ) ); ?>");
							jQuery("#console_log_div").css("display", "block");
							jQuery("#ux_div_help_support").css("display", "block");
							jQuery("#ux_div_mail_console").css("display", "none");
							jQuery("#ux_div_test_mail").css("display", "none");
							mail_bank_third_step_settings();
							<?php
						} elseif ( isset( $_REQUEST['auto_mail'] ) && 'false' === sanitize_text_field( wp_unslash( $_REQUEST['auto_mail'] ) ) ) { // WPCS: CSRF ok, WPCS: input var ok.
							?>
							jQuery("#ux_div_mail_console").css("display", "none");
							jQuery("#ux_div_help_support").css("display", "none");
							jQuery("#ux_div_test_mail").css("display", "block");
							mail_bank_third_step_settings();
							<?php
						}
						if ( '' !== $email_configuration_array['hostname'] ) {
							?>
							jQuery("#ux_txt_host").val("<?php echo esc_attr( $email_configuration_array['hostname'] ); ?>");
							<?php
						} else {
							?>
							mail_bank_get_host_port();
							<?php
						}
						?>
					});
					if (typeof (mail_bank_move_to_second_step) !== "function")
					{
						function mail_bank_move_to_second_step()
						{
							jQuery("#ux_div_first_step").addClass("first-step-helper");
							mail_bank_validate_settings();
						}
					}
					if (typeof (mail_bank_move_to_first_step) !== "function")
					{
						function mail_bank_move_to_first_step()
						{
							jQuery("#ux_div_first_step").removeClass("first-step-helper");
							jQuery("#test_email").removeClass("second-step-helper");
							jQuery("#ux_div_first_step").css("display", "block");
							jQuery("#test_email").css("display", "none");
							jQuery("#ux_div_second_step").css("display", "none");
							jQuery("#ux_div_step_progres_bar_width").css("width", "33%");
							jQuery("#ux_div_frm_wizard li:eq(1)").removeClass("active");
						}
					}
					if (typeof (mail_bank_save_changes) !== "function")
					{
						function mail_bank_save_changes()
						{
							overlay_loading_mail_bank(<?php echo wp_json_encode( $mb_settings_saved ); ?>);
							setTimeout(function ()
							{
								remove_overlay_mail_bank();
								window.location.href = "admin.php?page=mb_email_configuration";
							}, 3000);
						}
					}
					if (typeof (mail_bank_move_to_third_step) !== "function")
					{
						function mail_bank_move_to_third_step()
						{
							var mailer_type = jQuery("#ux_ddl_type").val();
							if( mailer_type === "sendgrid_api" || mailer_type === "mailgun_api" ) {
								premium_edition_notification_mail_bank();

							} else if( mailer_type === "php_mail_function" || mailer_type === "smtp" ) {
								jQuery("#ux_div_first_step").removeClass("first-step-helper");
								jQuery("#test_email").addClass("second-step-helper");
								mail_bank_validate_settings();
							}
						}
					}
					if (typeof (mail_bank_select_port) !== "function")
					{
						function mail_bank_select_port()
						{
							var encryption = jQuery("#ux_ddl_encryption").val();
							switch (encryption)
							{
								case "none":
								case "tls":
								jQuery("#ux_txt_port").val(587);
								break;
								case "ssl":
								jQuery("#ux_txt_port").val(465);
								break;
							}
						}
					}
						<?php
					}
					break;
				case 'mb_test_email':
					?>
				jQuery(document).ready(function ()
				{
					if (window.CKEDITOR)
					{
						CKEDITOR.replace("ux_content");
					}
				});
					<?php
					break;
				case 'mb_connectivity_test':
					?>
					<?php
					if ( '1' === CONNECTIVITY_TEST_EMAIL_MAIL_BANK ) {
						?>
					jQuery("#ux_frm_settings").validate
					({
						rules:
						{
							ux_txt_conn_search:
							{
								required: true
							}
						},
						errorPlacement: function ()
						{
						},
						highlight: function (element)
						{
							jQuery(element).closest(".form-group").removeClass("has-success").addClass("has-error");
						},
						success: function (label, element)
						{
							var icon = jQuery(element).parent(".input-icon").children("i");
							jQuery(element).closest(".form-group").removeClass("has-error").addClass("has-success");
							icon.removeClass("fa-warning").addClass("fa-check");
						},
						submitHandler: function ()
						{
							jQuery("#ux_div_connectivity_test").css("display", "block");
							overlay_loading_mail_bank();
							jQuery.post(ajaxurl,
							{
								smtp_host: jQuery("#ux_txt_conn_search").val(),
								param: "mail_bank_connectivity_test",
								action: "mail_bank_action",
								_wp_nonce: "<?php echo esc_attr( $connectivity_test_nonce ); ?>"
							},
							function (data)
							{
								jQuery("#ux_tbody_smtp").html(data);
								setTimeout(function ()
								{
									remove_overlay_mail_bank();
								}, 1000);
							});
						}
					});
						<?php
					}
					break;
				case 'mb_email_logs':
					?>
					<?php
					if ( '1' === EMAIL_LOGS_MAIL_BANK ) {
						?>
						var jQuery_date_array = <?php echo isset( $array3 ) ? wp_json_encode( $array3 ) : 0; ?>;
						var jQuery_sent_array = <?php echo isset( $final_sent_data_array ) ? wp_json_encode( $final_sent_data_array ) : 0; ?>;
						var jQuery_not_sent_array = <?php echo isset( $final_not_sent_data_array ) ? wp_json_encode( $final_not_sent_data_array ) : 0; ?>;
						var mb_charts = document.getElementById("ux_mb_charts").getContext('2d');
						var mail_bank_chart = new Chart(mb_charts, {
								type: 'line',
								data: {
										labels: jQuery_date_array,
										datasets: [{
												label: 'Sent',
												data: jQuery_sent_array,
												backgroundColor: [
														'rgba(12,169,74,0.2)'
												],
												borderColor: [
														'rgba(12,169,74,1)'
												],
												borderWidth: 2,
												fill: false,
										},{
											label: 'Not Sent',
											data: jQuery_not_sent_array,
											backgroundColor: [
													'rgb(227,15,28, 0.2)',
											],
											borderColor: [
													'rgb(227,15,28)',
											],
											borderWidth: 2,
											fill: false,
										}]
								},
								options: {
									responsive: true,
									title: {
										display: true,
										text: 'Legend'
									},
									tooltips: {
										displayColors: false,
										backgroundColor: [
												'rgb(227,15,28, 0.2)',
										],
										mode: 'index',
										intersect: false,
									},
									hover: {
										mode: 'nearest',
										intersect: true,
									},
									scales: {
											yAxes: [{
													ticks: {
															beginAtZero:true
													}
											}]
									}
								}
						});
					jQuery(document).ready(function ()
					{
						jQuery("#ux_txt_mb_start_date").datepicker
						({
							dateFormat: 'mm/dd/yy',
							numberOfMonths: 1,
							changeMonth: true,
							changeYear: true,
							yearRange: "1970:2039",
							onSelect: function (selected)
							{
								jQuery("#ux_txt_mb_end_date").datepicker("option", "minDate", selected)
							}
						});
						jQuery("#ux_txt_mb_end_date").datepicker
						({
							dateFormat: 'mm/dd/yy',
							numberOfMonths: 1,
							changeMonth: true,
							changeYear: true,
							yearRange: "1970:2039",
							onSelect: function (selected)
							{
								jQuery("#ux_txt_mb_start_date").datepicker("option", "maxDate", selected)
							}
						});
					});
					if (typeof (prevent_datepicker_mail_bank) !== "function")
					{
						function prevent_datepicker_mail_bank(id)
						{
							jQuery("#" + id).on("keypress", function (e)
							{
								e.preventDefault();
							});
						}
					}
					var oTable = jQuery("#ux_tbl_email_logs").dataTable
					({
							"pagingType": "full_numbers",
							"language":
								{
									"emptyTable": "No data available in table",
									"info": "Showing _START_ to _END_ of _TOTAL_ entries",
									"infoEmpty": "No entries found",
									"infoFiltered": "(filtered1 from _MAX_ total entries)",
									"lengthMenu": "Show _MENU_ entries",
									"search": "Search:",
									"zeroRecords": "No matching records found"
								},
							"bSort": true,
							"pageLength": 10,
							"aoColumnDefs": [{"bSortable": false, "aTargets": [0]}]
						});
						jQuery("#ux_chk_all_email_logs").click(function ()
						{
							jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).attr("checked", this.checked);
						});
					if (typeof (delete_email_logs) !== "function")
					{
						function delete_email_logs(id)
						{
							var confirm_delete = confirm(<?php echo wp_json_encode( $mb_confirm ); ?>);
							if (confirm_delete === true)
							{
								overlay_loading_mail_bank(<?php echo wp_json_encode( $mb_delete_log ); ?>);
								jQuery.post(ajaxurl,
								{
									id: id,
									param: "mail_bank_email_logs_delete_module",
									action: "mail_bank_action",
									_wp_nonce: "<?php echo esc_attr( $mb_email_logs_delete_log ); ?>"
								},
								function ()
								{
									setTimeout(function ()
									{
										remove_overlay_mail_bank();
										window.location.href = "admin.php?page=mb_email_logs";
									}, 3000);
								});
							}
						}
					}
					if (typeof (check_email_logs) !== "function")
					{
						function check_email_logs(id)
						{
							if (jQuery("input:checked", oTable.fnGetFilteredNodes()).length === jQuery("input[type=checkbox]", oTable.fnGetFilteredNodes()).length)
							{
								jQuery("#ux_chk_all_email_logs").attr("checked", "checked");
							} else
							{
								jQuery("#ux_chk_all_email_logs").removeAttr("checked");
							}
						}
					}
					var ux_frm_email_logs = jQuery("#ux_frm_email_logs").validate
					({
						submitHandler: function ()
						{
							premium_edition_notification_mail_bank();
						}
					});
						<?php
					}
					break;

				case 'mb_settings':
					?>
					<?php
					if ( '1' === SETTINGS_MAIL_BANK ) {
						?>
					jQuery(document).ready(function ()
					{
						jQuery("#ux_ddl_debug_mode").val("<?php echo isset( $settings_data_array['debug_mode'] ) ? esc_attr( $settings_data_array['debug_mode'] ) : 'enable'; ?>");
						jQuery("#ux_ddl_remove_tables").val("<?php echo isset( $settings_data_array['remove_tables_at_uninstall'] ) ? esc_attr( $settings_data_array['remove_tables_at_uninstall'] ) : 'disable'; ?>");
						jQuery("#ux_ddl_monitor_email_logs").val("<?php echo isset( $settings_data_array['monitor_email_logs'] ) ? esc_attr( $settings_data_array['monitor_email_logs'] ) : 'enable'; ?>");
						jQuery("#ux_ddl_fetch_settings").val("<?php echo isset( $settings_data_array['fetch_settings'] ) ? esc_attr( $settings_data_array['fetch_settings'] ) : 'individual_site'; ?>");
						jQuery("#ux_ddl_delete_logs_after").val("<?php echo isset( $settings_data_array['delete_logs_after'] ) ? esc_attr( $settings_data_array['delete_logs_after'] ) : '1day'; ?>");
						jQuery("#ux_ddl_auto_clear_logs").val("<?php echo isset( $settings_data_array['auto_clear_logs'] ) ? esc_attr( $settings_data_array['auto_clear_logs'] ) : 'disable'; ?>");
						show_hide_delete_after_logs('#ux_ddl_auto_clear_logs','#ux_div_delete_logs_after');
					});
					jQuery("#ux_frm_settings").validate
					({
							submitHandler: function ()
							{
								overlay_loading_mail_bank(<?php echo wp_json_encode( $mb_settings_saved ); ?>);
								jQuery.post(ajaxurl,
								{
									data: base64_encode(jQuery("#ux_frm_settings").serialize()),
									action: "mail_bank_action",
									param: "mail_bank_settings_module",
									_wp_nonce: "<?php echo esc_attr( $mail_bank_settings ); ?>"
								},
								function ()
								{
									setTimeout(function ()
									{
										remove_overlay_mail_bank();
										window.location.href = "admin.php?page=mb_settings";
									}, 3000);
								});
							}
						});
						<?php
					}
					break;
				case 'mb_notifications':
					if ( '1' === NOTIFICATION_MAIL_BANK ) {
						?>
					jQuery(document).ready(function ()
					{
						jQuery("#ux_ddl_notifications_service").val('<?php echo isset( $notifications_data['notification_service'] ) ? esc_attr( $notifications_data['notification_service'] ) : 'email'; ?>');
						jQuery("#ux_ddl_notifications").val('<?php echo isset( $notifications_data['notification'] ) ? esc_attr( $notifications_data['notification'] ) : 'disable'; ?>');
						show_hide_delete_after_logs('#ux_ddl_notifications','#ux_div_notification_services');
						show_hide_notifications_service('#ux_ddl_notifications_service', '#ux_div_notification_email_address' ,'#ux_div_notifications_pushover_key', '#ux_div_slack_web_hook');
					});
					jQuery("#ux_frm_notifications").validate
					({
						submitHandler: function()
						{
							premium_edition_notification_mail_bank();
						}
					});
						<?php
					}
					break;
				case 'mb_roles_and_capabilities':
					?>
					<?php
					if ( '1' === ROLES_AND_CAPABILITIES_MAIL_BANK ) {
						?>
					if (typeof (full_control_function_mail_bank) !== "function")
					{
						function full_control_function_mail_bank(id, div_id)
						{
							var checkbox_id = jQuery(id).prop("checked");
							jQuery("#" + div_id + " input[type=checkbox]").each(function ()
							{
								if (checkbox_id)
								{
									jQuery(this).attr("checked", "checked");
									if (jQuery(id).attr("id") !== jQuery(this).attr("id"))
									{
										jQuery(this).attr("disabled", "disabled");
									}
								} else
								{
								if (jQuery(id).attr("id") !== jQuery(this).attr("id"))
								{
									jQuery(this).removeAttr("disabled");
									jQuery("#ux_chk_other_capabilities_manage_options").attr("disabled", "disabled");
									jQuery("#ux_chk_other_capabilities_read").attr("checked", "checked").attr("disabled", "disabled");
								}
								}
							});
						}
					}
					if (typeof (show_roles_capabilities_mail_bank) !== "function")
					{
						function show_roles_capabilities_mail_bank(id, div_id)
						{
							if (jQuery(id).prop("checked"))
							{
								jQuery("#" + div_id).css("display", "block");
							} else
							{
								jQuery("#" + div_id).css("display", "none");
							}
						}
					}
					jQuery(document).ready(function ()
					{
						jQuery("#ux_ddl_mail_bank_menu").val("<?php echo isset( $details_roles_capabilities['show_mail_bank_top_bar_menu'] ) ? esc_attr( $details_roles_capabilities['show_mail_bank_top_bar_menu'] ) : 'enable'; ?>");
						show_roles_capabilities_mail_bank("#ux_chk_author", "ux_div_author_roles");
						full_control_function_mail_bank("#ux_chk_full_control_author", "ux_div_author_roles");
						show_roles_capabilities_mail_bank("#ux_chk_editor", "ux_div_editor_roles");
						full_control_function_mail_bank("#ux_chk_full_control_editor", "ux_div_editor_roles");
						show_roles_capabilities_mail_bank("#ux_chk_contributor", "ux_div_contributor_roles");
						full_control_function_mail_bank("#ux_chk_full_control_contributor", "ux_div_contributor_roles");
						show_roles_capabilities_mail_bank("#ux_chk_subscriber", "ux_div_subscriber_roles");
						full_control_function_mail_bank("#ux_chk_full_control_subscriber", "ux_div_subscriber_roles");
						show_roles_capabilities_mail_bank("#ux_chk_others_privileges", "ux_div_other_privileges_roles");
						full_control_function_mail_bank("#ux_chk_full_control_other_privileges_roles", "ux_div_other_privileges_roles");
						full_control_function_mail_bank("#ux_chk_full_control_other_roles", "ux_div_other_roles");
					});
					jQuery("#ux_frm_roles_and_capabilities").validate
					({
						submitHandler: function ()
						{
							overlay_loading_mail_bank(<?php echo wp_json_encode( $mb_settings_saved ); ?>);
							jQuery.post(ajaxurl,
							{
								data: base64_encode(jQuery("#ux_frm_roles_and_capabilities").serialize()),
								param: "mail_bank_roles_and_capabilities_module",
								action: "mail_bank_action",
								_wp_nonce: "<?php echo esc_attr( $mail_bank_roles_capabilities ); ?>"
							},
							function ()
							{
								setTimeout(function ()
								{
									remove_overlay_mail_bank();
									window.location.href = "admin.php?page=mb_roles_and_capabilities";
								}, 3000);
							});
						}
					});
						<?php
					}
					break;
				case 'mb_system_information':
					?>
					<?php
					if ( '1' === SYSTEM_INFORMATION_MAIL_BANK ) {
						?>
					jQuery.getSystemReport = function (strDefault, stringCount, string, location)
					{
						var o = strDefault.toString();
						if (!string)
						{
							string = "0";
						}
						while (o.length < stringCount)
						{
							if (location === "undefined")
							{
								o = string + o;
							} else
							{
								o = o + string;
							}
						}
						return o;
					};
					jQuery(".system-report").click(function ()
					{
						var report = "";
						jQuery(".custom-form-body").each(function ()
						{
							jQuery("h3.form-section", jQuery(this)).each(function ()
							{
								report = report + "\n### " + jQuery.trim(jQuery(this).text()) + " ###\n\n";
							});
							jQuery("tbody > tr", jQuery(this)).each(function ()
							{
								var the_name = jQuery.getSystemReport(jQuery.trim(jQuery(this).find("strong").text()), 25, " ");
								var the_value = jQuery.trim(jQuery(this).find("span").text());
								var value_array = the_value.split(", ");
								if (value_array.length > 1)
								{
									var temp_line = "";
									jQuery.each(value_array, function (key, line)
									{
										var tab = (key === 0) ? 0 : 25;
										temp_line = temp_line + jQuery.getSystemReport("", tab, " ", "f") + line + "\n";
									});
									the_value = temp_line;
								}
								report = report + "" + the_name + the_value + "\n";
							});
						});
						try
						{
							jQuery("#ux_system_information").slideDown();
							jQuery("#ux_system_information textarea").val(report).focus().select();
							return false;
						} catch (e)
						{
						}
						return false;
					});
					jQuery("#ux_btn_system_information").click(function ()
					{
						if (jQuery("#ux_btn_system_information").text() === "Close System Information!")
						{
							jQuery("#ux_system_information").slideUp();
							jQuery("#ux_btn_system_information").html("Get System Information!");
						} else
						{
							jQuery("#ux_btn_system_information").html("Close System Information!");
							jQuery("#ux_btn_system_information").removeClass("system-information");
							jQuery("#ux_btn_system_information").addClass("close-information");
						}
					});
						<?php
					}
					break;
			}
		}
		?>
	</script>
		<?php
	}
}
