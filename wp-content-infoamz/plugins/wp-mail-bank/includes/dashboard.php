<?php
/**
 * This file is used for dashboard.
 *
 * @author  Tech Banker
 * @package wp-mail-bank/includes
 * @version 4.0.0
 */

?>
<div class="portlet box vivid-blue">
	<div class="portlet-body form">
		<div class="form-body custom-dashboard">
			<div class="row">
				<div class="col-md-12">
					<div id="ux_div_mail_bank_logo">
						<img width="300px" src="<?php echo esc_url( plugins_url( 'assets/global/img/wp-mail-bank-logo.png', dirname( __FILE__ ) ) ); ?>" alt="WP Mail Bank">
					</div>
					<div class="col-md-6 tech-banker-column">
						<h4 class="tech-banker-dashboard-heading"><?php echo esc_attr( $mb_set_up_guide ); ?></h4>
						<ul class="tech-banker-dashboard-listing">
							<li><a target="_blank" href="<?php echo esc_url( TECH_BANKER_URL ); ?>/blog/how-to-setup-gmail-google-smtp-with-wp-mail-bank/" class="mb-dashboard-links"><i class="dashicons dashicons-cloud mb-dashboard-icons"></i><?php echo ( $mb_set_up_auth_configuration ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( TECH_BANKER_URL ); ?>/blog/how-to-setup-office-365-smtp-with-wp-mail-bank/" class="mb-dashboard-links"><i class="dashicons dashicons-screenoptions mb-dashboard-icons"></i><?php echo ( $mb_set_up_microsoft_configuration ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( TECH_BANKER_URL ); ?>/blog/how-to-setup-yahoo-smtp-with-wp-mail-bank/" class="mb-dashboard-links"><i class=" dashicons dashicons-sos mb-dashboard-icons"></i><?php echo ( $mb_set_up_yahoo_configuration ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( TECH_BANKER_URL ); ?>/blog/how-to-setup-sendgrid-smtp-with-wp-mail-bank/" class="mb-dashboard-links"><i class="dashicons dashicons-external mb-dashboard-icons"></i><?php echo ( $mb_send_grid_configuration ); ?></a><strong><span style="color:#E65454;"><?php echo ' ( ' . esc_attr( $mb_pro_label ) . ' )'; ?></strong></span></li>
							<li><a target="_blank" href="<?php echo esc_url( TECH_BANKER_URL ); ?>/blog/how-to-setup-mailgun-smtp-with-wp-mail-bank/" class="mb-dashboard-links"><i class="dashicons dashicons-share-alt2 mb-dashboard-icons"></i><?php echo ( $mb_mailgun_configuration ); ?></a><strong><span style="color:#E65454;"><?php echo ' ( ' . esc_attr( $mb_pro_label ) . ' )'; ?></strong></span></li>
						</ul>
						</ul>
					</div>
					<div class="col-md-6 tech-banker-column">
						<h4 class="tech-banker-dashboard-heading"><?php echo esc_attr( $mb_join_community ); ?></h4>
						<ul class="tech-banker-dashboard-listing">
							<li><a target="_blank" href="https://www.facebook.com/techbanker" class="mb-dashboard-links"><i class="dashicons dashicons-facebook  mb-dashboard-icons"></i><?php echo ( $mb_follow_us_on_facebook_page ); ?></a></li>
							<li><a target="_blank" href="https://www.facebook.com/groups/152567505440114/" class="mb-dashboard-links"><i class="dashicons dashicons-universal-access-alt  mb-dashboard-icons" ></i><?php echo ( $mb_follow_us_on_facebook ); ?></a></li>
							<li><a target="_blank" href="https://twitter.com/techno_banker" class="mb-dashboard-links"><i class="dashicons dashicons-twitter mb-dashboard-icons"></i><?php echo ( $mb_follow_us_on_twitter ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( TECH_BANKER_URL ); ?>/contact-us/" class="mb-dashboard-links"><i class="dashicons dashicons-admin-users mb-dashboard-icons"></i><?php echo ( $mb_support ); ?></a></li>
							<li><a target="_blank" href="https://wordpress.org/support/plugin/wp-mail-bank/reviews/?filter=5" class="mb-dashboard-links"><i class="dashicons dashicons-star-filled mb-dashboard-icons"></i><?php echo ( $mb_leave_a_five_star_rating ); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
