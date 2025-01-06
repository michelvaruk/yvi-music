import Carousel from "@stimulus-components/carousel"

export default class extends Carousel {
  connect() {
    super.connect()
    // let myWidth = window.innerWidth
    // let myBreakPoint = 0
    // let slides = 0

    // for (let key in this.defaultOptions.breakpoints) {
    //   if (myWidth > Number(key) && myBreakPoint < Number(key)) {
    //     myBreakPoint = Number(key)
    //     slides = this.defaultOptions.breakpoints[key]['slidesPerView']
    //   }
    // }
    
    // if(Number(this.element.dataset.count) <= slides && slides > 0) {
    //   this.swiper.params.slidesPerView = slides;
    //   this.swiper.params.loop = false
    // }
    // Default options for every carousels.
    this.defaultOptions
  }

  // You can set default options in this getter.
  get defaultOptions() {
    return {
      // Your default options here
      loop: true,
      effect: 'slide',
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
        640: {
          effect: 'slide',
          slidesPerView: 2,
          spaceBetween: 20,
        },
        1080: {
          slidesPerView: 3,
        }
      }
    }
  }
}