window.addEventListener("DOMContentLoaded", function () {
    const removedItensLabel = ['Small', 'Beside article title']
    document.querySelector('.components-base-control.components-radio-control').querySelectorAll('.components-radio-control__option').forEach(element => {
        const label = element.querySelector('label');
        if(removedItensLabel.includes(label.innerHTML)){
            element.remove();
        };

    })
})