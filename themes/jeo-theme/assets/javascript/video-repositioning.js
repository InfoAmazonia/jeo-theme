window.addEventListener("DOMContentLoaded", function () {
    const allYoutubeBlocks = document.querySelectorAll('.wp-block-embed-youtube');
    if(allYoutubeBlocks.length) {
        const target = document.querySelector('.entry-header');
        target.appendChild(allYoutubeBlocks[0]);
    }
})