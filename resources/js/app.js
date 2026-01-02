import './bootstrap';
import Alpine from 'alpinejs'

// 1) Definisikan dulu fungsi slider
window.heroSlider = function (slides) {
  return {
    slides,
    current: 0,
    timer: null,

    start() {
      this.stop()
      this.timer = setInterval(() => this.next(), 4500)
    },
    stop() {
      if (this.timer) clearInterval(this.timer)
      this.timer = null
    },
    next() {
      this.current = (this.current + 1) % this.slides.length
    },
    prev() {
      this.current = (this.current - 1 + this.slides.length) % this.slides.length
    },
    go(i) {
      this.current = i
      this.start()
    },
  }
}

// 2) Baru start Alpine SETELAH heroSlider ada
window.Alpine = Alpine
Alpine.start()
