import Carousel from "@stimulus-components/carousel"

export default class extends Carousel {
  connect() {
    super.connect()
    this.defaultOptions
  }

  // You can set default options in this getter.
  get defaultOptions() {
    return {
      // Your default options here
      loop: true,
      effect: 'slide',
      slidesPerView: 2,
      spaceBetween: 20,
      pagination: {
        clickable: true,
        el: '.swiper-pagination',
        type: 'bullets'
      },
      // navigation: {
      //   nextEl: '.swiper-button-next',
      //   prevEl: '.swiper-button-prev',
      // },
      autoplay: true,
      autoplay: {
        delay: 5000,
      },
      breakpoints: {
        1080: {
          slidesPerView: 3,
        }
      }
    }
  }
}