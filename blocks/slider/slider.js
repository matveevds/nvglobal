document.addEventListener("DOMContentLoaded", () => {
  if (typeof Swiper === "undefined") return;

  const sliders = document.querySelectorAll("[data-nv-slider]");

  sliders.forEach((el) => {
    if (el.dataset.nvInited === "1") return;
    el.dataset.nvInited = "1";

    const pagination = el.querySelector(".post-slider__pagination");
    const prevEl = el.querySelector(".post-slider__btn--prev");
    const nextEl = el.querySelector(".post-slider__btn--next");

    new Swiper(el, {
      slidesPerView: 1,
      spaceBetween: 16,
      loop: false,
      watchOverflow: true,
      autoHeight: false,

      navigation: {
        prevEl,
        nextEl,
      },

      pagination: pagination
        ? {
            el: pagination,
            clickable: true,
          }
        : undefined,

    });
  });
});
