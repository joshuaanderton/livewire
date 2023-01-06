export default function (Alpine) {

  Alpine.directive('button-confirm', (el, {}, { cleanup }) => {

    const handler = event => {

      confirming: false,
      confirm(event) {
          if (!this.confirming) {
              this.confirming = true

              event.preventDefault()
              return false
          }
          
          this.confirming = false
      },
      init() {
          $refs.button.addEventListener('click', event => this.confirm(event))
      }
    }

    el.addEventListener('click', handler)
 
    cleanup(() => {
      el.removeEventListener('click', handler)
    })
  })
  // Alpine.magic('foo', ...)
}