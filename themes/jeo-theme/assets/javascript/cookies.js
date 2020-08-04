window.addEventListener("DOMContentLoaded", function () {
    const parent = document.querySelector('.cc-window');
    if (parent) {
        const content = parent.innerHTML;
        const additionalElement = document.createElement('div');
        additionalElement.classList.add('jeo');
        additionalElement.innerHTML = content;
        parent.innerHTML = "";
        parent.appendChild(additionalElement);
    }
})