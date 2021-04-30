import { __ } from '@wordpress/i18n';

window.addEventListener("DOMContentLoaded", function () {
    const topicsLabel = __( 'Topics', 'jeo' );
    const regionsLabel = __( 'Regions', 'jeo' );
    const clearLabel = __( 'Clear', 'jeo' );
    const applyLabel = __( 'Apply', 'jeo' );


    if (document.querySelector('body').classList.contains('search')) {
        jQuery('.filters select#topics').select2({
            placeholder: topicsLabel,
        });

        jQuery('.filters select#regions').select2({
            placeholder: regionsLabel,
        });

        jQuery('input[name="daterange"]').daterangepicker({
            minDate: "01/01/2010",
            maxDate: new Date(),
            autoUpdateInput: false,
            locale: {
                cancelLabel: clearLabel,
                applyLabel,
            },
        });

        // Search fields
        jQuery('input[name="daterange"]').on("apply.daterangepicker", function (
            ev,
            picker
        ) {
            jQuery(this).val(
                picker.startDate.format("MM/DD/YYYY") +
                " - " +
                picker.endDate.format("MM/DD/YYYY")
            );

            jQuery(this).closest('form').submit();
        });

        jQuery('input[name="daterange"]').on("cancel.daterangepicker", function (
            ev,
            picker
        ) {
            jQuery(this).val("");
        });

        if (jQuery('input[name="daterange"]').attr("replace-empty") === "true") {
            jQuery('input[name="daterange"]').val("");
        }

        if (jQuery(".sorting-method").length) {
            jQuery(".sorting-method .current").click(function () {
                jQuery(".sorting-method .options").toggleClass("active");
                jQuery("#sorting").attr(
                    "value",
                    jQuery(".sorting-method .options button").attr("value")
                );
            });

            jQuery(".sorting-option").click(function () {
                jQuery("#sorting").attr("value", jQuery(this).attr("value"));
                jQuery(this).closest("form").submit();
            });
        }
    }
})