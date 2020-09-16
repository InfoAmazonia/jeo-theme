if (typeof (remove_overlay_mail_bank) !== "function"){
	function remove_overlay_mail_bank()
	{
		jQuery(".loader_opacity").remove();
		jQuery(".opacity_overlay").remove();
	}
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
      var success = "Success";
      var issuccessmessage = jQuery("#toast-container").exists();
      if (issuccessmessage !== true)
      {
        var shortCutFunction = jQuery("#manage_messages input:checked").val();
        toastr[shortCutFunction](message, success);
      }
    }
  }
}

if(typeof(database_update_mail_bank) != "function"){
  function database_update_mail_bank(offset, nonce){
    // overlay_loading_mail_bank();
    jQuery.post(ajaxurl,
    {
      param: "update_database_entries_mail_bank",
      action: "mail_bank_action",
      _wp_nonce: nonce,
      offset: offset
    },
    function (data)
    {
    });
  }
}
function setIntervalX(callback, delay, repetitions, nonce) {
  var x = 0;
  var intervalID = window.setInterval(function () {
    database_update_mail_bank(x, nonce );
    if (++x === repetitions) {
        window.clearInterval(intervalID);
				setTimeout(function ()
				{
					remove_overlay_mail_bank();
					window.location.href = "admin.php?page=mb_email_logs";
				}, 3000);
    }
  }, delay);
}
function update_database_interval( rows_count, nonce ) {
  overlay_loading_mail_bank();
  setIntervalX(function () {
  }, 2000, rows_count, nonce);
}
