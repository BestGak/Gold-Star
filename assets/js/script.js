const menuBtn = document.querySelector('.menu-btn');
const menuLinks = document.querySelectorAll('.menu nav ul li a');

menuBtn.addEventListener('click' , () => document.querySelector('html').classList.toggle('active'));

const swiper = new Swiper('.models .swiper .swiper__hidden', {
    // Optional parameters
    direction: 'horizontal',
    loop: false,
    spaceBetween: 20,
    slidesPerView: 2,
    autoplay: {
        delay: 3000,
      },
    speed: 500,
    // Navigation arrows
    navigation: {
      nextEl: '.models .swiper-button-next',
      prevEl: '.models .swiper-button-prev',
    },
    breakpoints: {
      1: {
        slidesPerView: 2,
      },
      767: {
          slidesPerView: 4.2,  
      },
      1023: {
          slidesPerView: 6,  
          spaceBetween: 40,
      },
  }
  });

  const swiperProjects = new Swiper('.projects .swiper .swiper__hidden', {
    // Optional parameters
    direction: 'horizontal',
    loop: false,
    slidesPerView: 4,
    clickable: false,
      // If we need pagination
      pagination: {
        el: '.projects .swiper-pagination',
        clickable: true,
      },
    autoplay: {
        delay: 3000,
      },
    speed: 500,
    // Navigation arrows
    navigation: {
      nextEl: '.projects .swiper-button-next',
      prevEl: '.projects .swiper-button-prev',
    },
    breakpoints: {
      200: {
          slidesPerView: 2,  
          spaceBetween: 20,
      },
      767: {
          slidesPerView: 3,  
      },
      1023: {
          slidesPerView: 4,  
          spaceBetween: 40,
      },
  }
  });