import { __ } from '@wordpress/i18n';

window.addEventListener("DOMContentLoaded", function () {
    if ( typeof window.jeo_theme_config !== 'undefined' && ! window.jeo_theme_config.enable_dark_mode ) {
        return;
    }
    if(localStorage.getItem('theme')) {
        if(localStorage.getItem('theme') == "dark") {
            jQuery('body').addClass('dark-theme');
            jQuery('button[action="dark-mode"] i:last-child').toggleClass(
                "fa-toggle-off fa-toggle-on"
            );
        }

    } else {
        const userPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const userPrefersLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;

        if(userPrefersDark){
            jQuery('body').addClass('dark-theme');
            localStorage.setItem('theme', "dark");
        } 
        
        if(userPrefersLight || !userPrefersDark && !userPrefersLight){
            if(jQuery('body').hasClass('dark-theme')) {
                jQuery('body').removeClass('dark-theme');
            }

            localStorage.setItem('theme', "light");
        }
    }


    jQuery('button[action="dark-mode"]').click(function () {
        jQuery("body").toggleClass("dark-theme");
        jQuery(this.querySelector("i:last-child")).toggleClass(
            "fa-toggle-off fa-toggle-on"
        );

        localStorage.setItem('theme', localStorage.getItem('theme') == "dark"? "light" : "dark");

        const lightLabel = __( 'Light mode', 'jeo' );
        const darkLabel = __( 'Dark mode', 'jeo' );
        if(localStorage.getItem('theme') == "dark") {
            try {
                if(this.querySelector('.item--title').innerHTML) {
                    this.querySelector('.item--title').innerHTML = lightLabel;
                }
            } catch {};
        } else {
            try{
                if(this.querySelector('.item--title').innerHTML) {
                    this.querySelector('.item--title').innerHTML = darkLabel;
                }
            } catch {};
        }
    });
});