import Sortable from '@stimulus-components/sortable'

export default class extends Sortable {
  static targets = ["formula"]
  connect() {
    super.connect()

    this.defaultOptions
  }

  onUpdate(event) {
    super.onUpdate(event)
    // Faire un appel AJAX event.item.dataset.formula est l'id de la formule, (event.newIndex + 1) est sa nouvelle position
    console.log(event.item.dataset.formula)
    console.log(`from : ${event.oldIndex + 1} to : ${event.newIndex + 1}`)
  }

  get defaultOptions() {
    return {
      animation: 150,
    }
  }
}