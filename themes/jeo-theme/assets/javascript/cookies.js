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
        parent.style.zIndex = '9999999999999';
    }

    const darkerScreen = document.createElement('div');
    darkerScreen.classList.add('darker-screen');
    darkerScreen.style.position = 'fixed';
    darkerScreen.style.width = '100vw';
    darkerScreen.style.height = '100vh';
    darkerScreen.style.background = 'black';
    darkerScreen.style.opacity = '0.5';
    darkerScreen.style.display = 'none';
    darkerScreen.style.zIndex = '99999999';
    darkerScreen.style.top = '0';
    document.querySelector('body').appendChild(darkerScreen);

    if (!parent.classList.contains('cc-invisible') || parent.style.display != 'none') {
        darkerScreen.style.display = 'block';
    }

    const buttons = document.querySelectorAll('.cc-btn');

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            darkerScreen.style.display = 'none';
        });
      });

    if(document.querySelector('.cc-bottom')) {
        document.querySelector('.cc-bottom').onclick = () => {
            darkerScreen.style.display = 'block';
        }
    }
})