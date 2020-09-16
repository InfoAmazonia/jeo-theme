<?php
/**
 * This Template is used for connectivity test.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/views/connectivity-test
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
	} elseif ( CONNECTIVITY_TEST_EMAIL_MAIL_BANK === '1' ) {
		$connectivity_test_nonce = wp_create_nonce( 'connectivity_test_nonce' );
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
							<i class="dashicons dashicons-backup"></i>
							<?php echo esc_attr( $mb_connectivity_test ); ?>
						</div>
					</div>
					<div class="portlet-body form mb-custom-form">
						<form id="ux_frm_settings">
							<div class="form-body">
								<div class="form-group">
									<label class="control-label">
										<?php echo esc_attr( $mb_mail_server_host ); ?> :
										<span class="required" aria-required="true">*</span>
									</label>
									<input type="text" class="form-control" name="ux_txt_conn_search" id="ux_txt_conn_search" value="">
									<i class="controls-description"><?php echo esc_attr( $mb_mail_server_tooltip ); ?>.</i>
								</div>
								<div class="form-actions">
									<div class="pull-right">
										<input type="submit" class="btn vivid-blue" name="ux_btn_begin_test" id="ux_btn_begin_test" value="<?php echo esc_attr( $mb_begin_test ); ?>">
									</div>
								</div>
								<div class="line-separator"></div>
								<div id="ux_div_connectivity_test" style="display:none;">
									<table class="table table-striped table-bordered table-hover table-margin-top">
										<thead>
											<tr>
												<th rowspan="2"><?php echo esc_attr( $mb_transport ); ?></th>
												<th rowspan="2"><?php echo esc_attr( $mb_socket ); ?></th>
												<th rowspan="2"><?php echo esc_attr( $mb_status ); ?></th>
											</tr>
										</thead>
										<tbody id="ux_tbody_smtp">
										</tbody>
									</table>
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
						<i class="dashicons dashicons-backup"></i>
							<?php echo esc_attr( $mb_connectivity_test ); ?>
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
