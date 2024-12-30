import Carousel from "@stimulus-components/carousel"

export default class extends Carousel {
  connect() {
    super.connect()
    console.log("Do what you want here.")

    // The swiper instance.
    console.log(this.swiper)

    // Default options for every carousels.
    this.defaultOptions
  }

  // You can set default options in this getter.
  get defaultOptions() {
    return {
      // Your default options here
      loop: true,
      spaceBetween: 30,
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets'
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      autoplay: true
    }
  }
}