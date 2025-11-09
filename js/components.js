// components.js - Shared Navigation and Footer Components
// This file creates reusable components that appear on every page

// Navigation Component
function createNavigation() {
  return `
    <nav id="navbar">
      <div class="nav-container">
        <a href="index.html" class="logo">MOOFAR</a>
        <button 
          class="menu-toggle" 
          id="menuToggle" 
          aria-label="Toggle navigation menu"
          aria-expanded="false"
          aria-controls="navLinks">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <ul class="nav-links" id="navLinks">
          <li><a href="index.html">Home</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
    </nav>
  `;
}

// Footer Component
function createFooter() {
  return `
    <footer>
      <div class="footer-content">
        <div class="footer-section">
          <h3>MOOFAR PROPRIETARY LIMITED</h3>
          <p>Botswana's premier landscaping and horticultural services provider.</p>
          <p style="font-size: 0.9rem; margin-top: 1rem;">
            <strong>Director:</strong> Mooketsi Mapugwa<br>
            <strong>Manager:</strong> Farai Madorobo
          </p>
          <div class="social-icons">
            <a href="#" aria-label="Visit our Facebook page">F</a>
            <a href="#" aria-label="Visit our Instagram page">I</a>
          </div>
        </div>
        <div class="footer-section">
          <h3>Quick Links</h3>
          <a href="services.html">Services</a>
          <a href="about.html">About Us</a>
          <a href="gallery.html">Gallery</a>
          <a href="contact.html">Contact</a>
        </div>
        <div class="footer-section">
          <h3>Services</h3>
          <a href="services.html#maintenance">Landscape Maintenance</a>
          <a href="services.html#nursery">Horticultural Nursery</a>
          <a href="services.html#clearing">Bush Clearing</a>
          <a href="services.html#fencing">Fencing Services</a>
        </div>
        <div class="footer-section">
          <h3>Contact</h3>
          <p>Francistown, Botswana</p>
          <p><a href="mailto:Mookfara@gmail.com">Mookfara@gmail.com</a></p>
          <p><a href="tel:+26777723232">+267 77 723 232</a></p>
          <p><a href="tel:+26777085655">+267 77 085 655</a></p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Moofar Proprietary Limited. All rights reserved. | UIN: BW00009410484</p>
      </div>
    </footer>
  `;
}

// Skip Link Component (for accessibility)
function createSkipLink() {
  return `<a href="#mainContent" class="skip-link">Skip to main content</a>`;
}

// Inject components when DOM loads
document.addEventListener('DOMContentLoaded', () => {
  // Inject skip link at start of body
  if (!document.querySelector('.skip-link')) {
    document.body.insertAdjacentHTML('afterbegin', createSkipLink());
  }

  // Inject navigation
  const headerPlaceholder = document.getElementById('header-placeholder');
  if (headerPlaceholder) {
    headerPlaceholder.innerHTML = createNavigation();
  }
  
  // Inject footer
  const footerPlaceholder = document.getElementById('footer-placeholder');
  if (footerPlaceholder) {
    footerPlaceholder.innerHTML = createFooter();
  }
  
  // Highlight active page in navigation
  highlightActivePage();
  
  console.log('🌿 Moofar components loaded');
});

// Highlight the current page in navigation
function highlightActivePage() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  const navLinks = document.querySelectorAll('.nav-links a');
  
  navLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage) {
      link.classList.add('active');
      link.setAttribute('aria-current', 'page');
    }
  });
}
