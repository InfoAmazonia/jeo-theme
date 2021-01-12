window.addEventListener("DOMContentLoaded", function () {
    // Only apply cookie banner js if it isn't an embed page
    if(!window.location.pathname.includes('/embed')) {
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
    
        if (parent) {
            if (!parent.classList.contains('cc-invisible') || parent.style.display != 'none') {
                darkerScreen.style.display = 'block';
            }
        }
    
        const buttons = document.querySelectorAll('.cc-compliance .cc-btn');
    
        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                if(!button.classList.contains('cc-show-settings')) {
                    darkerScreen.style.display = 'none';
                }
            });
          });
    
        if(document.querySelector('.cc-bottom')) {
            document.querySelector('.cc-bottom').onclick = () => {
                darkerScreen.style.display = 'block';
            }
        }
    } else {
        //Hide cookie banner in embed pages

        document.querySelector('.cc-revoke').style.display = 'none';
        document.querySelector('#cc-window.cc-window').style.display = 'none';
    }

})