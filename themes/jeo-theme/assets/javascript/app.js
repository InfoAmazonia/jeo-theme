// Functionalities
import "./functionalities/ajax-pv";
import "./functionalities/dark-mode";
import "./functionalities/hash-ajust";
import "./functionalities/audio-player";
import "./functionalities/video-repositioning";
import "./functionalities/header";
import "./functionalities/cover-block";
import "./functionalities/video-gallery";
// import "./functionalities/image-gallery";
// import "./functionalities/search-filters";
import "./functionalities/tooltip";
import "./functionalities/link-dropdown";
import "./functionalities/project-single";
import "./functionalities/republish-modal";
import "./functionalities/storymap";

// Other options
import "./cookies";

// Vendors
// import './../vendor/selectric/selectric.min';


window.addEventListener("DOMContentLoaded", function () {
    // External source post API magic <3
    const siteLinks = document
        .querySelectorAll("article .entry-title > a")
        .forEach((element) => {
            const targetLink = element.getAttribute("href");
            // console.log(element);


            try {
                try {
                    element.closest('article').querySelector('figure.post-thumbnail a').setAttribute("target", "_blank");
                } catch {
                    // console.log('post has no image')
                }

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
                        encodeURIComponent(targetLink);

                    jQuery.ajax({
                        type: "GET",
                        url: external_link_api,
                        success: function (data) {
                            // console.log(data);
                            externalSourceLink.innerHTML = `<i class="fas fa-external-link-alt"></i> <span class="target-title">${data}</span>`;
                        },
                    });

                    let metaarea = element.closest("article").querySelector(".entry-meta");
                    
                    if (!metaarea) {
                        metaarea = document.createElement("div");
                        metaarea.classList.add("entry-meta");

                        element.closest("article").querySelector(".entry-wrapper").appendChild(metaarea);
                    }

                    metaarea.insertBefore(externalSourceLink, metaarea.firstChild);
                }
            } catch (err) {
                console.log(err);
                // console.log("Invalid link: ", targetLink);
            }
        });
});

(function ($) {
    jQuery(document).ready(function () {
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

        if (jQuery(".single .featured-image-large").length) {
            jQuery(".featured-image-large .image-info i").click(function () {
                jQuery(".featured-image-large .image-info-container").toggleClass(
                    "active"
                );
                jQuery(".featured-image-large .image-info i").toggleClass(
                    "fa-info-circle fa-times"
                );
            });
        }

        if (jQuery(".single .featured-image-small").length) {
            jQuery(".featured-image-small .image-info i").click(function () {
                jQuery(".featured-image-small .image-info-container").toggleClass(
                    "active"
                );
                jQuery(".featured-image-small .image-info i").toggleClass(
                    "fa-info-circle fa-times"
                );
            });
        }

        // prevents comments from hiding when a direct comment hash is set
        if (!(document.location.hash.length && document.location.hash.slice(1, 8) == 'comment')) {
            jQuery(".toggable-comments-form").hide();
        }

        if (jQuery(".toggable-comments-area").length) {
            jQuery(".toggable-comments-area").click(function () {
                jQuery(".toggable-comments-form").toggle("fast");
            });
        }
    });
})(jQuery);
