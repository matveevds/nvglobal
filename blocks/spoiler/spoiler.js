document.addEventListener("click", function (event) {

    const header = event.target.closest(".spoiler__title-block");
    if (!header) return; // Клик не по заголовку

    const spoiler = header.closest(".spoiler");
    if (!spoiler) return;

    // Переключаем класс active
    spoiler.classList.toggle("active");

});
