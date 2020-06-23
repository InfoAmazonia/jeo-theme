


( function( $ ) {
    $(document).ready( function() {
    $(window).scroll( function(){
        var headerHeight = $('.middle-header-contain').height();
        console.log(headerHeight);
        if ($(this).scrollTop() > headerHeight ){
            $('.bottom-header-contain').addClass("fixed-header");
        } else {
            $('.bottom-header-contain').removeClass("fixed-header");
        }
    });
});
} )( jQuery );
