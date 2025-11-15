// components.js - Shared Navigation and Footer Components

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

// WhatsApp Floating Button
function createWhatsAppButton() {
  return `
    <a href="https://wa.me/26777723232?text=Hi%20Moofar!%20I'm%20interested%20in%20your%20landscaping%20services." 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Chat with us on WhatsApp">
        <span class="whatsapp-tooltip">Chat with us!</span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
        </svg>
    </a>
  `;
}

// Inject components when DOM loads
document.addEventListener('DOMContentLoaded', () => {
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
  
  // Inject WhatsApp button
  setTimeout(() => {
    if (!document.querySelector('.whatsapp-float')) {
      document.body.insertAdjacentHTML('beforeend', createWhatsAppButton());
      console.log('💬 WhatsApp button added');
    }
  }, 500);
  
  // Highlight active page in navigation
  highlightActivePage();
  
  // Initialize mobile menu
  initMobileMenu();
  
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

// Mobile Menu Functionality
function initMobileMenu() {
  setTimeout(() => {
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');

    if (!menuToggle || !navLinks) {
      console.warn('Menu elements not found');
      return;
    }

    // Toggle menu function
    function toggleMenu() {
      const isOpen = navLinks.classList.contains('active');
      
      if (isOpen) {
        navLinks.classList.remove('active');
        menuToggle.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      } else {
        navLinks.classList.add('active');
        menuToggle.classList.add('active');
        menuToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
      }
    }

    // Click handler for hamburger button
    menuToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleMenu();
    });

    // Close menu when clicking a link
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        if (navLinks.classList.contains('active')) {
          toggleMenu();
        }
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
      if (navLinks.classList.contains('active')) {
        if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
          toggleMenu();
        }
      }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && navLinks.classList.contains('active')) {
        toggleMenu();
        menuToggle.focus();
      }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
          toggleMenu();
        }
      }, 250);
    });

    console.log('📱 Mobile menu initialized');
  }, 100);
}
