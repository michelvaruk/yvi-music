import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

  liveSearch() {
    let query =  event.target.value.toLowerCase()
    let rows = event.target.parentNode.parentNode.querySelectorAll('tbody tr')
    let typingTimer;
    let typeInterval = 300;
    clearTimeout(typingTimer)
    typingTimer = setTimeout(()=>{
      rows.forEach(row => {
        row.textContent.toLowerCase().includes(query) ?
          row.classList.remove("hidden") :
          row.classList.add("hidden");
      })
    }, typeInterval)
  }
}
