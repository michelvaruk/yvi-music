import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

  static targets = ["toggle"]

  connect() {
    // const $menuBtn = document.getElementById('mobile-menu-btn');
    // const $mainNav = document.getElementById('main-nav');
    // $menuBtn.addEventListener('click', () => {
    //   $mainNav.classList.add('display-menu');
      
        
    //   const $closeMenuBtn = document.getElementById('close-mobile-menu-btn');
    //   $closeMenuBtn.addEventListener('click', () => {
    //     // On supprime tous les chevrons
    //     let chevrons = document.querySelectorAll('header .chevron.rotate')
    //     chevrons.forEach( (i) => i.classList.remove('rotate') )
    //     // On ferme tous les menus
    //     let menusToClose = document.querySelectorAll('.sub-nav.reveal, .third-nav.reveal')
    //     menusToClose.forEach( (i) => i.classList.remove('reveal'))

    //     $mainNav.classList.remove('display-menu');
    //   })
    // })
  }
  toggle() {
    this.toggleTargets.forEach(element => {
      console.log(element)
      element.classList.toggle('hidden')
    });
    this.element.classList.toggle('menu-displayed')
  }

}