import './font-size';

window.addEventListener("DOMContentLoaded", function () {
    jQuery('#mobile-sidebar-fallback').css('padding-left', jQuery('.bottom-header-contain.post-header .mobile-menu-toggle.left-menu-toggle').offset().left)

    jQuery('.more-menu--content').css('left', jQuery('aside#mobile-sidebar-fallback').offset().left + jQuery('aside#mobile-sidebar-fallback').width() + jQuery('.bottom-header-contain.post-header .mobile-menu-toggle.left-menu-toggle').offset().left);
    const inicialPos = jQuery('.more-menu--content').css('left');

    jQuery('button.mobile-menu-toggle').click(function() {
        if(parseInt(jQuery('.more-menu--content').css('left'), 10) > 0) {
            jQuery('.more-menu--content').css('left', inicialPos);
        } else {
            jQuery('.more-menu--content').css('left', jQuery('aside#mobile-sidebar-fallback').width() + jQuery('.bottom-header-contain.post-header .mobile-menu-toggle.left-menu-toggle').offset().left);
        }
    })

    // jQuery('.more-menu .more-title').hover(function() {
    //     jQuery('.more-menu--content').show();
    // }, function() {
    //     jQuery('.more-menu--content').hide();
    // })
    
});