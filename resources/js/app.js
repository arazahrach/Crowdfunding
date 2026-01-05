import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Slider helper untuk hero
window.heroSlider = function (slides = []) {
  return {
    slides,
    current: 0,
    timer: null,

    start() {
      if (!this.slides || this.slides.length === 0) return;

      // auto slide tiap 5 detik
      this.timer = setInterval(() => this.next(), 5000);
    },

    next() {
      if (!this.slides || this.slides.length === 0) return;
      this.current = (this.current + 1) % this.slides.length;
    },

    prev() {
      if (!this.slides || this.slides.length === 0) return;
      this.current = (this.current - 1 + this.slides.length) % this.slides.length;
    },

    go(i) {
      if (!this.slides || this.slides.length === 0) return;
      this.current = i;
    },

    stop() {
      if (this.timer) clearInterval(this.timer);
      this.timer = null;
    }
  };
};

window.donateForm = function () {
  return {
    amount: 0,
    setAmount(v) {
      this.amount = v;
    }
  };
};

// 2) Baru start Alpine SETELAH heroSlider ada
window.Alpine = Alpine
Alpine.start()
