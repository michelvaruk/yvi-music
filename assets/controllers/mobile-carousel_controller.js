import Carousel from "@stimulus-components/carousel"

export default class extends Carousel {
  connect() {
    super.connect()
    // Default options for every carousels.
    this.defaultOptions
  }

  // You can set default options in this getter.
  get defaultOptions() {
    return {
      // Your default options here
      loop: true,
      effect: 'flip',
      pagination: {
        clickable: true,
        el: '.swiper-pagination',
        type: 'bullets'
      },
      autoplay: true,
      autoplay: {
        delay: 5000,
      },
    }
  }
}