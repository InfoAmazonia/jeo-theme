import './font-size';

window.addEventListener("DOMContentLoaded", function () {
    document.getElementById('mobile-sidebar-fallback').style.setProperty('--padding-left', jQuery('.bottom-header-contain.post-header .mobile-menu-toggle.left-menu-toggle').offset().left + 'px');

    jQuery('.more-menu--content').css('left', jQuery('aside#mobile-sidebar-fallback').offset().left + jQuery('aside#mobile-sidebar-fallback').width() + jQuery('.bottom-header-contain.post-header .mobile-menu-toggle.left-menu-toggle').offset().left);
    const inicialPos = jQuery('.more-menu--content').css('left');

    jQuery('button.mobile-menu-toggle').click(function() {
        if(parseInt(jQuery('.more-menu--content').css('left'), 10) > 0) {
            jQuery('.more-menu--content').css('left', inicialPos);
        } else {
            jQuery('.more-menu--content').css('left', jQuery('aside#mobile-sidebar-fallback').width());
        }
    })

    jQuery('button[action="dark-mode"]').click(function() {
        jQuery('body').toggleClass('dark-mode');
        jQuery(this.querySelector('i:last-child')).toggleClass('fa-toggle-off fa-toggle-on');
    });


});