// js/components.js
(function(){
  'use strict';

  /*** HTML Templates ***/
  function createHeader(){
    return `
      <header id="site-header" class="site-header">
        <div class="container header-inner">

          <!-- Brand -->
          <a href="/" class="brand" aria-label="Moofar home">
            <img src="assets/MOOFAR (PTY)LTD Logo.jpg" alt="Moofar logo" width="48" height="48">
            <span>Moofar</span>
          </a>

          <!-- Mobile Menu Button -->
          <button id="mobile-toggle" aria-label="Menu">☰</button>

          <!-- Navigation -->
          <nav id="main-nav" class="main-nav" role="navigation" aria-label="Primary navigation">
            <ul>
              <li><a href="/" class="nav-link">Home</a></li>
              <li><a href="/services.html" class="nav-link">Services</a></li>
              <li><a href="/gallery.html" class="nav-link">Gallery</a></li>
              <li><a href="/contact.html" class="nav-link">Contact</a></li>
            </ul>
          </nav>

          <!-- WhatsApp Button -->
          <a href="https://wa.me/26777723232" target="_blank" aria-label="WhatsApp" class="whatsapp-header-btn">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
          </a>
        </div>
      </header>

      <!-- Floating WhatsApp Button -->
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

  /*** Inject HTML into placeholders ***/
  document.addEventListener('DOMContentLoaded', function() {
    const headerPlaceholder = document.getElementById('header-placeholder');
    const footerPlaceholder = document.getElementById('footer-placeholder');

    if(headerPlaceholder) headerPlaceholder.innerHTML = createHeader();
    if(footerPlaceholder) footerPlaceholder.innerHTML = createFooter();

    const yearEl = document.getElementById('year');
    if(yearEl) yearEl.textContent = new Date().getFullYear();

    initHeaderScripts();
  });

  /*** Header Scripts (mobile toggle & scroll effect) ***/
  function initHeaderScripts(){
    const header = document.getElementById('site-header');
    const mobileToggle = document.getElementById('mobile-toggle');
    const nav = document.getElementById('main-nav');

    if(mobileToggle){
      mobileToggle.addEventListener('click', ()=> nav.classList.toggle('open'));
    }

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
  }

})();

