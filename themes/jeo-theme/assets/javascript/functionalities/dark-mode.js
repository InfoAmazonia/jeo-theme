window.addEventListener("DOMContentLoaded", function () {
    if(localStorage.getItem('theme')) {
        jQuery('html').css('font-size', localStorage.getItem('fontSizeAccessibility') + 'px');
    } else {
        const userPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const userPrefersLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;

        if(userPrefersDark){
            console.log("User prefers a dark interface");
        }
    }


    jQuery('button[action="dark-mode"]').click(function () {
        jQuery("body").toggleClass("dark-theme");
        jQuery(this.querySelector("i:last-child")).toggleClass(
            "fa-toggle-off fa-toggle-on"
        );
    });
});