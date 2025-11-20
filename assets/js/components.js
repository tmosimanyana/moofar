// js/components.js
(function(){
  'use strict';

  /*** HTML Templates ***/
  function createHeader(){
    return `
      <header id="site-header" class="site-header">
        <div class="container header-inner">
          <a href="/" class="brand" aria-label="Moofar home">
            <img src="assets/MOOFAR (PTY)LTD Logo.jpg" alt="Moofar logo" width="48" height="48">
            <span>Moofar</span>
          </a>
          <button id="mobile-toggle" aria-label="Menu">☰</button>
          <nav id="main-nav" class="main-nav" role="navigation" aria-label="Primary navigation">
            <ul>
              <li><a href="/" class="nav-link">Home</a></li>
              <li><a href="/services.html" class="nav-link">Services</a></li>
              <li><a href="/gallery.html" class="nav-link">Gallery</a></li>
              <li><a href="/contact.html" class="nav-link">Contact</a></li>
            </ul>
          </nav>
          <a href="https://wa.me/26777723232" target="_blank" aria-label="WhatsApp" class="whatsapp-header-btn">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
          </a>
        </div>
      </header>

      <a href="https://wa.me/26777723232" target="_blank" aria-label="Chat on WhatsApp" id="floating-wa">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg">
      </a>
    `;
  }

  function createFooter(){
    return `
      <footer id="site-footer" class="site-footer">
        <div class="container">
          <div class="footer-brand">
            <img src="assets/MOOFAR (PTY)LTD Logo.jpg" alt="Moofar logo" width="48" height="48">
            <strong>Moofar Proprietary Limited</strong>
          </div>

          <address>
            Francistown<br>
            North-East District, Botswana<br>
            <a href="tel:+26777723232">+267 777 23232</a>
          </address>

          <nav aria-label="Footer Navigation">
            <a href="/services.html">Services</a>
            <a href="/gallery.html">Gallery</a>
            <a href="/contact.html">Contact</a>
          </nav>

          <div class="footer-right">
            <p>© <span id="year"></span> Moofar Proprietary Limited</p>
          </div>
        </div>
      </footer>
    `;
  }

  function createMap(){
    if(window.location.pathname.includes('contact.html')){
      return `
        <section id="contact-map" style="margin-top:2rem;">
          <h2 style="color:#fff; font-size:1.5rem; margin-bottom:1rem; text-align:center;">Our Location</h2>
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2882.563004530622!2d25.75225421553782!3d-24.82612308405988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ec6f0e5b8e6c1bf%3A0x123456789abcdef!2sMoofar%20Proprietary%20Limited!5e0!3m2!1sen!2sbt!4v1700000000000!5m2!1sen!2sbt" 
            width="100%" 
            height="400" 
            style="border:0; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.3);" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </section>
      `;
    }
    return '';
  }

  /*** Inject HTML into placeholders ***/
  document.addEventListener('DOMContentLoaded', function() {
    const headerPlaceholder = document.getElementById('header-placeholder');
    const footerPlaceholder = document.getElementById('footer-placeholder');
    const mapPlaceholder = document.getElementById('map-placeholder');

    if(headerPlaceholder) headerPlaceholder.innerHTML = createHeader();
    if(footerPlaceholder) footerPlaceholder.innerHTML = createFooter();
    if(mapPlaceholder) mapPlaceholder.innerHTML = createMap();

    const yearEl = document.getElementById('year');
    if(yearEl) yearEl.textContent = new Date().getFullYear();

    initHeaderScripts();
  });

  /*** Header Scripts (mobile toggle, scroll, WhatsApp animation) ***/
  function initHeaderScripts(){
    const header = document.getElementById('site-header');
    const mobileToggle = document.getElementById('mobile-toggle');
    const nav = document.getElementById('main-nav');
    const floatingWA = document.getElementById('floating-wa');

    if(mobileToggle){
      mobileToggle.addEventListener('click', ()=> nav.classList.toggle('open'));
    }

    // Sticky header scroll effect
    function updateHeader(){
      if(window.scrollY > 60){
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
        if(!(window.location.pathname === '/' || window.location.pathname.endsWith('index.html'))){
          header.classList.add('scrolled');
        }
      }
    }

    updateHeader();
    window.addEventListener('scroll', updateHeader);

    // Floating WhatsApp scroll direction + bounce + hover
    if(floatingWA){
      let lastScrollY = window.scrollY;

      // Initial state: hidden right
      floatingWA.style.transition = 'transform 0.6s cubic-bezier(0.68,-0.55,0.265,1.55), opacity 0.4s ease';
      floatingWA.style.transform = 'translateX(100px)';
      floatingWA.style.opacity = '0';

      function updateFloatingWA(){
        let currentScrollY = window.scrollY;

        if(currentScrollY > 100 && currentScrollY < lastScrollY){
          // Scrolling up: show
          floatingWA.style.transform = 'translateX(0)';
          floatingWA.style.opacity = '1';
        } else if(currentScrollY <= 100 || currentScrollY > lastScrollY){
          // Scrolling down: hide
          floatingWA.style.transform = 'translateX(100px)';
          floatingWA.style.opacity = '0';
        }

        lastScrollY = currentScrollY;
      }

      window.addEventListener('scroll', updateFloatingWA);
      updateFloatingWA();
    }
  }

})();

