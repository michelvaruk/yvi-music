import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

  static targets = ["image"]
  connect() {
    this.scroll();
  }
  scroll() {
    let offset = window.scrollY;
    this.imageTarget.style.backgroundPositionY = `${offset * -.3}px`
  }
}