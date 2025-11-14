/**
 * BeforeAfterSlider - Interactive Image Comparison Component
 * For Moofar Proprietary Limited Website
 */

class BeforeAfterSlider {
  constructor(options) {
    this.container = typeof options.container === 'string' 
      ? document.querySelector(options.container) 
      : options.container;
    
    if (!this.container) {
      console.error('BeforeAfterSlider: Container not found');
      return;
    }

    this.beforeImage = options.beforeImage;
    this.afterImage = options.afterImage;
    this.beforeLabel = options.beforeLabel || 'Before';
    this.afterLabel = options.afterLabel || 'After';
    this.initialPosition = options.initialPosition || 50;
    this.slideOnHover = options.slideOnHover || false;

    this.isDragging = false;
    this.init();
  }

  init() {
    this.createStructure();
    this.attachEvents();
    this.setPosition(this.initialPosition);
  }

  createStructure() {
    this.container.classList.add('ba-slider-wrapper');
    
    this.container.innerHTML = `
      <div class="ba-slider-container">
        <div class="ba-image-container ba-before">
          <img src="${this.beforeImage}" alt="${this.beforeLabel}" class="ba-image">
          <div class="ba-label ba-label-before">${this.beforeLabel}</div>
        </div>
        <div class="ba-image-container ba-after">
          <img src="${this.afterImage}" alt="${this.afterLabel}" class="ba-image">
          <div class="ba-label ba-label-after">${this.afterLabel}</div>
        </div>
        <div class="ba-handle" role="slider" aria-label="Slide to compare images" aria-valuemin="0" aria-valuemax="100" aria-valuenow="${this.initialPosition}" tabindex="0">
          <div class="ba-handle-line"></div>
          <button class="ba-handle-button" aria-label="Drag to compare">
            <span class="ba-arrow ba-arrow-left">◀</span>
            <span class="ba-arrow ba-arrow-right">▶</span>
          </button>
        </div>
      </div>
    `;

    this.sliderContainer = this.container.querySelector('.ba-slider-container');
    this.beforeContainer = this.container.querySelector('.ba-before');
    this.afterContainer = this.container.querySelector('.ba-after');
    this.handle = this.container.querySelector('.ba-handle');
  }

  attachEvents() {
    // Mouse events
    this.handle.addEventListener('mousedown', this.onDragStart.bind(this));
    document.addEventListener('mousemove', this.onDrag.bind(this));
    document.addEventListener('mouseup', this.onDragEnd.bind(this));

    // Touch events
    this.handle.addEventListener('touchstart', this.onDragStart.bind(this), { passive: false });
    document.addEventListener('touchmove', this.onDrag.bind(this), { passive: false });
    document.addEventListener('touchend', this.onDragEnd.bind(this));

    // Keyboard navigation
    this.handle.addEventListener('keydown', this.onKeyDown.bind(this));

    // Hover slide
    if (this.slideOnHover) {
      this.sliderContainer.addEventListener('mousemove', this.onHover.bind(this));
    }

    // Prevent image dragging
    const images = this.container.querySelectorAll('img');
    images.forEach(img => {
      img.addEventListener('dragstart', (e) => e.preventDefault());
    });
  }

  onDragStart(e) {
    e.preventDefault();
    this.isDragging = true;
    this.container.classList.add('ba-dragging');
  }

  onDrag(e) {
    if (!this.isDragging && !this.slideOnHover) return;
    
    e.preventDefault();
    const rect = this.sliderContainer.getBoundingClientRect();
    const x = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
    const position = ((x - rect.left) / rect.width) * 100;
    
    this.setPosition(Math.max(0, Math.min(100, position)));
  }

  onDragEnd() {
    this.isDragging = false;
    this.container.classList.remove('ba-dragging');
  }

  onHover(e) {
    if (this.isDragging) return;
    
    const rect = this.sliderContainer.getBoundingClientRect();
    const x = e.clientX;
    const position = ((x - rect.left) / rect.width) * 100;
    
    this.setPosition(Math.max(0, Math.min(100, position)));
  }

  onKeyDown(e) {
    let position = parseFloat(this.handle.getAttribute('aria-valuenow'));
    
    if (e.key === 'ArrowLeft') {
      position = Math.max(0, position - 2);
      this.setPosition(position);
      e.preventDefault();
    } else if (e.key === 'ArrowRight') {
      position = Math.min(100, position + 2);
      this.setPosition(position);
      e.preventDefault();
    }
  }

  setPosition(percentage) {
    this.beforeContainer.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
    this.handle.style.left = `${percentage}%`;
    this.handle.setAttribute('aria-valuenow', percentage.toFixed(1));
  }

  setImages(beforeImage, afterImage) {
    this.beforeImage = beforeImage;
    this.afterImage = afterImage;
    
    const beforeImg = this.container.querySelector('.ba-before img');
    const afterImg = this.container.querySelector('.ba-after img');
    
    beforeImg.src = beforeImage;
    afterImg.src = afterImage;
  }

  reset() {
    this.setPosition(this.initialPosition);
  }
}

// Auto-initialize sliders with data attributes
document.addEventListener('DOMContentLoaded', function() {
  const sliders = document.querySelectorAll('[data-before-after]');
  
  sliders.forEach(slider => {
    new BeforeAfterSlider({
      container: slider,
      beforeImage: slider.getAttribute('data-before-image'),
      afterImage: slider.getAttribute('data-after-image'),
      beforeLabel: slider.getAttribute('data-before-label') || 'Before',
      afterLabel: slider.getAttribute('data-after-label') || 'After',
      initialPosition: parseInt(slider.getAttribute('data-initial-position')) || 50,
      slideOnHover: slider.hasAttribute('data-slide-on-hover')
    });
  });
});

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = BeforeAfterSlider;
}
