window.addEventListener("DOMContentLoaded", function () {
    const isSingleStorymap = document.querySelector('.single-storymap');

    if(isSingleStorymap) {
        const notNavigatingMap = document.querySelector( '.not-navigating-map .mapboxgl-map' );
        const headerHeight = document.querySelector('header').offsetHeight;

        notNavigatingMap.style.top = `${ headerHeight }px`;

        window.addEventListener('scroll', function(e) {
            const scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

            if(window.scrollY > headerHeight) {
               notNavigatingMap.style.top = '50px'; 
            } else {
                let newTop = headerHeight - scrollTop;
                if(newTop < 50) {
                    newTop = 50;
                }

                notNavigatingMap.style.top = `${ newTop }px`;
            }
        });
    }

});
