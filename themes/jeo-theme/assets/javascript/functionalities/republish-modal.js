window.addEventListener("DOMContentLoaded", function () {
    const isRepublishablePost = document.querySelector('.republish-post');

    if(isRepublishablePost) {
        const modal = document.querySelector('.republish-post-modal');
        const modalContainer = document.querySelector('.modal-container')
        modal.classList.add("hideModal");

        document.querySelector('.republish-post-label').onclick = () => {
            modal.classList.add("showModal");
            modalContainer.style.display = 'block';
        }

        document.querySelector('.close-button').onclick = () => {
            modal.classList.remove("showModal");
        }
    }
});

