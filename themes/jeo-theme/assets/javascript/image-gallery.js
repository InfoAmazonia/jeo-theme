window.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.image-gallery .gallery-grid').forEach(function(slider, index) {
        // jQuery(slider).slick({
        //     dots: true,
        //     infinite: true,
        //     speed: 300,
        // });

        jQuery(slider).sss({
            slideShow : false, // Set to false to prevent SSS from automatically animating.
            startOn : 0, // Slide to display first. Uses array notation (0 = first slide).
            transition : 0, // Length (in milliseconds) of the fade 
            speed : 0, // Slideshow speed in milliseconds.
            showNav : true // Set to false to hide navigation arrows.
        });

        slider.parentNode.querySelector('button[action="fullsreen"]').onclick = function() {
            slider.parentNode.classList.toggle('fullscreen');
        }

        slider.parentNode.querySelector('button[action="display-grid"]').onclick = function() {
            slider.parentNode.classList.toggle('grid-display');
        }

        slider.querySelectorAll('.gallery-item-container img').forEach(element => {
            element.onclick = function() {
                if(slider.parentNode.classList.contains('grid-display')) {
                    slider.parentNode.classList.toggle('grid-display');
                    slider.querySelectorAll('.gallery-item-container').forEach(element => element.style.display = "none");
                    this.parentNode.style.display = "block";
                }
            }
        })
    })
})