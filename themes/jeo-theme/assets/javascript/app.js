import Vue from "vue";
import ImageBlock from "./components/imageBlock/ImageBlock";
import "./audio-player";
import "./video-repositioning";

Vue.component("image-block", ImageBlock);

window.addEventListener("DOMContentLoaded", function () {
    const siteLinks = document
        .querySelectorAll("article > .entry-wrapper > h2 > a")
        .forEach((element) => {
            const targetLink = element.getAttribute("href");

            try {
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
                    console.log(external_link_api);

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
        const app = new Vue({
            el: "#content",
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

        // jQuery(window).scroll(function () {
        //     var headerHeight = jQuery('.middle-header-contain').height();
        //     // console.log(headerHeight);
        //     if (jQuery(this).scrollTop() > headerHeight) {
        //         jQuery('.bottom-header-contain').addClass("fixed-header");
        //     } else {
        //         jQuery('.bottom-header-contain').removeClass("fixed-header");
        //     }
        // });

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

        jQuery(window).scroll(function () {
            var headerHeight = document.querySelector(
                ".bottom-header-contain.desktop-only"
            ).offsetTop;
            // console.log(headerHeight);
            if (jQuery(this).scrollTop() > headerHeight) {
                jQuery(".bottom-header-contain.post-header").addClass("active");

                if (!jQuery("header #header-search").hasClass("fixed")) {
                    jQuery("header #header-search").addClass("fixed");
                    jQuery("header #header-search").css("top", 50 + "px");
                    jQuery("header #header-search").css(
                        "height",
                        jQuery(window).height() - 50 + "px"
                    );
                }
            } else {
                jQuery(".bottom-header-contain.post-header").removeClass("active");

                if (jQuery("header #header-search").hasClass("fixed")) {
                    jQuery("header #header-search").removeClass("fixed");
                    jQuery("header #header-search").css(
                        "top",
                        document.querySelector(".bottom-header-contain.desktop-only")
                            .offsetTop +
                        50 +
                        "px"
                    );
                    jQuery("header #header-search").css(
                        "height",
                        jQuery(window).height() -
                        document.querySelector(".bottom-header-contain.desktop-only")
                            .offsetTop +
                        "px"
                    );
                }
            }
        });

        jQuery("button.search-toggle").click(function (e) {
            jQuery("header#masthead").toggleClass("hide-header-search");
        });

        jQuery("header #header-search").css(
            "top",
            document.querySelector(".bottom-header-contain.desktop-only").offsetTop +
            50 +
            "px"
        );
        jQuery("header #header-search").css(
            "height",
            jQuery(window).height() -
            document.querySelector(".bottom-header-contain.desktop-only")
                .offsetTop +
            "px"
        );

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

        if (jQuery(".no-comments-area").length) {
            jQuery(".no-comments-area").click(function () {
                jQuery(".no-comments-form").toggle("fast");
            });
        }
    });
})(jQuery);
