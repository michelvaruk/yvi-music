import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

  static targets = ["toggle"]

  toggle() {
    this.toggleTargets.forEach(element => {
      element.classList.toggle('hidden')
    });
    this.element.classList.toggle('menu-displayed')
  }

}