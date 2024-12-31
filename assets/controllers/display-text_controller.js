import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

  static targets = ["text"]

  toggle() {
    this.textTarget.classList.toggle('display-text')
    event.currentTarget.classList.toggle('display-text')
  }
}