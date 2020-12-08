window.addEventListener("DOMContentLoaded", function () {
    const parent = document.querySelector('.cc-window');
    const hasChild = document.querySelector('.cc-window .jeo');
    const acceptAllBtn = document.querySelector('.cc-accept-all');
    
    if (parent && !hasChild) {
        const content = parent.innerHTML;
        const additionalElement = document.createElement('div');
        additionalElement.classList.add('jeo');
        additionalElement.innerHTML = content;
        parent.innerHTML = "";
        parent.appendChild(additionalElement);
    }

    if (!parent.classList.contains('cc-invisible') || parent.style.display != 'none') {
        document.querySelector('#page').style.background = 'grey';
        document.querySelector('#page').style.filter = 'brightness(0.5)';
    }

    const buttons = [document.querySelector('.cc-window a.cc-deny'), document.querySelector('.cc-window a.cc-allow')]
    buttons.map(button => {
        button.onclick = () => {
            document.querySelector('#page').style.background = 'unset';
            document.querySelector('#page').style.filter = 'unset';
        }
    });

    if(document.querySelector('.cc-bottom')) {
        document.querySelector('.cc-bottom').onclick = () => {
            document.querySelector('#page').style.background = 'grey';
            document.querySelector('#page').style.filter = 'brightness(0.5)';
        }
    }
})