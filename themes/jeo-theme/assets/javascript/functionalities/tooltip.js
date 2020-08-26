window.addEventListener("DOMContentLoaded", function () {
    // This fixes inner tooltip ": " to prevent recursive strategy
    const stringAcumulator = (finalString, item) => {
        return finalString + ': ' + item;
    };

    document.querySelectorAll('.tooltip-block').forEach(tooltip => {
        const splitResult = tooltip.innerText.split(': ');
        const referenceWord = splitResult[0];
        const contentTooltip = splitResult.length >= 1? splitResult.splice(1).reduce(stringAcumulator): '';

        const tooltipElement = document.createElement('div');
        tooltipElement.classList.add('tooltip-block--content');
        tooltipElement.innerText = contentTooltip;

        const closeIcon = document.createElement('i');
        closeIcon.classList.add('fas', 'fa-times-circle');

        tooltip.innerText = referenceWord;

        tooltipElement.appendChild(closeIcon);
        tooltip.appendChild(tooltipElement);

        tooltip.onclick = function() {
            this.classList.toggle('active');
        }
    })
})