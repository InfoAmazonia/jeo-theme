window.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.credited-image-block').forEach(imageBlock => {
        imageBlock.querySelector('.image-description-toggle').addEventListener('click', function() {
            imageBlock.classList.toggle('active');
        })
    })
})