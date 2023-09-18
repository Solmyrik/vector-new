new Swiper('.work__block', {
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  speed: 1100,
  spaceBetween: 15,
  simulateTouch: false,
  slidesPerView: 1,
  navigation: {
    nextEl: '.work__arrow_next',
    prevEl: '.work__arrow_prew',
  },
});
