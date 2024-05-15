function toggleCheckboxColor(checkbox) {
    var adjacentText = checkbox.parentNode.nextElementSibling;
    if (checkbox.checked) {
        adjacentText.style.textDecoration='line-through'
    } else {
        adjacentText.style.textDecoration='none'
    }
}

// Écouter les changements d'état de la checkbox
document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            toggleCheckboxColor(this);
        });
    });
});