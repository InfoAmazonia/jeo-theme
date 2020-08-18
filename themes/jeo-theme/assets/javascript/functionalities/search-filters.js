window.addEventListener("DOMContentLoaded", function () {

    jQuery('.filters select#topics').select2({
        placeholder: "Topics",
    });

    jQuery('.filters select#regions').select2({
        placeholder: "Regions",
    });
})