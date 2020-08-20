window.addEventListener("DOMContentLoaded", function () {
    const parent = document.querySelector('.cc-window');
    const hasChild = document.querySelector('.cc-window .jeo');
    if (parent && !hasChild) {
        const content = parent.innerHTML;
        const additionalElement = document.createElement('div');
        additionalElement.classList.add('jeo');
        additionalElement.innerHTML = content;
        parent.innerHTML = "";
        parent.appendChild(additionalElement);
    }
})