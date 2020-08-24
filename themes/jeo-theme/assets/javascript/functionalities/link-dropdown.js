window.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.link-dropdown .controls.saved-block').onclick = () => {
        const sections = document.querySelector('.link-dropdown .sections');
        const arrowIcon = document.querySelector('.link-dropdown .arrow-icon');
     
        sections.style.transition = 'all 0.2s ease-in';

        if(sections.style.opacity == 1) {
            console.log('a')
            arrowIcon.className = 'arrow-icon fas fa-angle-down';
            sections.style.opacity = 0;
            sections.style.height = 0;

        } else {
            console.log('b')
            arrowIcon.className = 'arrow-icon fas fa-angle-up';
            sections.style.opacity = 1;
            sections.style.height = 'auto';

        }

    }
});

