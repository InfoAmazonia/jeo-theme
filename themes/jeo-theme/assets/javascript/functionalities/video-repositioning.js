window.addEventListener("DOMContentLoaded", function () {
    const allYoutubeBlocks = document.querySelectorAll('.video .wp-block-embed-youtube, .video .wp-block-video');
    // console.log(allYoutubeBlocks);
    if(allYoutubeBlocks.length) {
        const target = document.querySelector('.entry-header');
        target.appendChild(allYoutubeBlocks[0]);
    }
})