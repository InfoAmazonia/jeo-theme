window.addEventListener("DOMContentLoaded", function () {
    const allYoutubeBlocks = document.querySelectorAll('.wp-block-embed-youtube, .wp-block-video');
    console.log(allYoutubeBlocks);
    if(allYoutubeBlocks.length) {
        const target = document.querySelector('.entry-header');
        target.appendChild(allYoutubeBlocks[0]);
    }
})