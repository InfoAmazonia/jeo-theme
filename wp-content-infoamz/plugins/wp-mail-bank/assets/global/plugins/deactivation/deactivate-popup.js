jQuery(document).ready(function($) {
	$( '#the-list #mail-bank-plugin-disable-link' ).click(function(e) {
		e.preventDefault();

		var reason = $( '#mail-bank-feedback-content .mail-bank-reason' ),
			deactivateLink = $( this ).attr( 'href' );

	    $( "#mail-bank-feedback-content" ).dialog({
				title: 'Feedback Form',
	    	dialogClass: 'mail-bank-feedback-form',
	      	resizable: false,
	      	minWidth: 430,
	      	minHeight: 300,
	      	modal: true,
	      	buttons: {
	      		'go' : {
		        	text: 'Submit',
        			icons: { primary: "dashicons dashicons-update" },
		        	id: 'mail-bank-feedback-dialog-continue',
					class: 'button deactivation-skip-popup-button',
		        	click: function() {
		        		var dialog = $(this),
		        			go = $('#mail-bank-feedback-dialog-continue'),
		          			form = dialog.find('form').serializeArray(),
							result = {};
						$.each( form, function() {
							if ( '' !== this.value ){
								result[ this.name ] = this.value;
								jQuery('input[name='+ this.name+ ']').css('border-color','#ddd');
								jQuery('textarea[name='+ this.name+ ']').css('border-color','#ddd');
							} else {
									if( jQuery('#ux_rdl_reason').attr('checked') == 'checked' ){
										jQuery('input[name='+ this.name+ ']').css('border-color','#D43F3F');
										jQuery('textarea[name='+ this.name+ ']').css('border-color','#D43F3F');
										result = {};
									}
								}
						});
						jQuery("#ux_frm_deactivation_popup_mail_bank").validate({
							rules:{
								ux_txt_email_address_mail_bank:
								{
									email: true
								}
							}
						});
						if( jQuery('#ux_rdl_reason').attr('checked') == 'checked' ){
							if ( jQuery("#ux_txt_email_address_mail_bank").hasClass('error') ) {
								jQuery('input[name=ux_txt_email_address_mail_bank]').css('border-color','#D43F3F');
								result = {};
							}
						}
							if ( ! jQuery.isEmptyObject( result ) ) {
								result.action = 'post_user_feedback_mail_bank';
									$.ajax({
											url: post_feedback.admin_ajax,
											type: 'POST',
											data: result,
											error: function(){},
											success: function(msg){},
											beforeSend: function() {
												go.addClass('mail-bank-ajax-progress');
											},
											complete: function() {
												go.removeClass('mail-bank-ajax-progress');
													dialog.dialog( "close" );
													location.href = deactivateLink;
											}
									});
							}
		        	},
	      		},
	      		'cancel' : {
		        	text: 'Cancel',
		        	id: 'mail-bank-feedback-cancel',
		        	class: 'button deactivation-cancel-popup-button',
		        	click: function() {
		          		$( this ).dialog( "close" );
		        	}
	      		},
	      		'skip' : {
		        	text: 'Skip',
		        	id: 'mail-bank-feedback-dialog-skip',
							class: 'button deactivation-skip-popup-button',
		        	click: function() {
		          		$( this ).dialog( "close" );
		          		location.href = deactivateLink;
		        	}
	      		},
	      	}
	    });
			reason.change(function() {
						$( '.mail-bank-submit-feedback' ).hide();
						if ( $( this ).hasClass( 'mail-bank-support' ) ) {
							$( this ).find( '.mail-bank-submit-feedback' ).show();
						}
					});
	});
	$('.ui-dialog-titlebar').append('<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>');
});
