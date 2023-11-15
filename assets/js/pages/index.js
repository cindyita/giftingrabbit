var swiper = new Swiper(".mySwiper", {
  loop: true,
  centeredSlides: true,
  autoplay: {
        delay: 6000,
        disableOnInteraction: true,
      },
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
});