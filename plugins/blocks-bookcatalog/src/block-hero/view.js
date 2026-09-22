document.addEventListener('DOMContentLoaded', function () {
    var swiperHero = new Swiper ('.hero-slider .slider_container', {
        loop:true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        slidesPerView: 'auto',
        speed: 1500,
        grabCursor: true,
        mousewheelControl: true,
        keyboardControl:true
    });
})