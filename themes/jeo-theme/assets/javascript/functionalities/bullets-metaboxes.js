window.addEventListener("DOMContentLoaded", function () {
    const hasRepublishPostSetting = document.querySelector('input[id="republish_post"]');
    const republishPostsBullets = document.querySelector('.republish-posts-bullets');
    const republishPostsLabel = document.querySelector('label[for="republish_post"]');
    const bulletsMetaboxesTitle = document.querySelector('.bullets-metaboxes-title');

    if(hasRepublishPostSetting) {
        const isRepublishablePost = hasRepublishPostSetting.checked;

        if(!isRepublishablePost) {
            republishPostsBullets.style.display = 'none';
            bulletsMetaboxesTitle.style.display = 'none';
        }

        republishPostsLabel.onclick = () => {
            if(document.querySelector('input[id="republish_post"]').checked) {
                republishPostsBullets.style.display = 'block';
                bulletsMetaboxesTitle.style.display = 'block';
            } else {
                republishPostsBullets.style.display = 'none';
                bulletsMetaboxesTitle.style.display = 'none';
            }
        }
    }
})