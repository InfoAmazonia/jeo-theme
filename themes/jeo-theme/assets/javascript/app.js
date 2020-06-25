


(function ($) {
    $(document).ready(function () {
        if($('.single .featured-image-behind').length) {
            $('.featured-image-behind .image-info i').click(function() {
                $('.featured-image-behind .image-info-container').toggleClass('active');
                $('.featured-image-behind .image-info i').toggleClass('fa-info-circle fa-times-circle ');
            });
        }

        $(window).scroll(function () {
            var headerHeight = $('.middle-header-contain').height();
            // console.log(headerHeight);
            if ($(this).scrollTop() > headerHeight) {
                $('.bottom-header-contain').addClass("fixed-header");
            } else {
                $('.bottom-header-contain').removeClass("fixed-header");
            }
        });
    });
})(jQuery);
