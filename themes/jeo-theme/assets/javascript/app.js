import "./functionalities/ajax-pv";
import Vue from "vue";
import ImageBlock from "./components/imageBlock/ImageBlock";
import "./functionalities/audio-player";
import "./functionalities/video-repositioning";
import "./functionalities/header";
import "./cookies";

Vue.component("image-block", ImageBlock);

window.addEventListener("DOMContentLoaded", function () {
    // External source post API magic <3
    const siteLinks = document
        .querySelectorAll("article > .entry-wrapper > h2 > a")
        .forEach((element) => {
            const targetLink = element.getAttribute("href");

            try {
                element.parentElement.parentElement.parentElement.querySelector('figure.post-thumbnail a').setAttribute("target", "_blank");

                const targetLinkSource = new URL(targetLink).origin;
                if (document.location.origin !== targetLinkSource) {
                    element.setAttribute("target", "_blank");

                    const externalSourceLink = document.createElement("a");
                    externalSourceLink.classList.add("external-link");
                    externalSourceLink.setAttribute("href", targetLink);
                    externalSourceLink.setAttribute("target", "_blank");
                    externalSourceLink.setAttribute("href", targetLink);

                    const external_link_api =
                        document.location.origin +
                        "/wp-json/api/external-link/?target_link=" +
                        targetLink;
                    //console.log(external_link_api);

                    jQuery.ajax({
                        type: "GET",
                        url: external_link_api,
                        success: function (data) {
                            console.log(data);
                            externalSourceLink.innerHTML = `<i class="fas fa-external-link-alt"></i> <span class="target-title">${data}</span>`;
                        },
                    });

                    const metaarea = element.parentElement.parentElement.querySelector(
                        ".entry-meta"
                    );
                    metaarea.insertBefore(externalSourceLink, metaarea.firstChild);
                }
            } catch (err) {
                //console.log("Invalid link: ", targetLink);
            }
        });
});

(function ($) {
    jQuery(document).ready(function () {
        // Fix JEO-plugin and Vue conflit.
        document.querySelectorAll('.vue-component').forEach(function(element) {
            new Vue({
                el: element,
            });
        });

        if (jQuery(".single .featured-image-behind").length) {
            jQuery(".featured-image-behind .image-info i").click(function () {
                jQuery(".featured-image-behind .image-info-container").toggleClass(
                    "active"
                );
                jQuery(".featured-image-behind .image-info i").toggleClass(
                    "fa-info-circle fa-times-circle "
                );
            });
        }


        jQuery(".filters select").change(function () {
            jQuery(this).closest("form").submit();
        });

        jQuery('input[name="daterange"]').daterangepicker({
            minDate: "01/01/2010",
            maxDate: new Date(),
            autoUpdateInput: false,
            locale: {
                cancelLabel: "Clear",
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

        if (jQuery(".toggable-comments-area").length) {
            jQuery(".toggable-comments-area").click(function () {
                jQuery(".toggable-comments-form").toggle("fast");
            });
        }
    });
})(jQuery);
