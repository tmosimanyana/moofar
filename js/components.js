// js/components.js
// Inject header and footer into pages that contain placeholders.
// Place this at /js/components.js. Defer-load it in HTML.

(function(){
  'use strict';

  function createHeader(){
    return `
      <header id="site-header" class="site-header" role="banner">
        <div class="container header-inner" style="display:flex;align-items:center;justify-content:space-between;gap:1rem">
          <a href="/" class="brand" aria-label="Moofar home" style="display:flex;align-items:center;gap:.5rem;text-decoration:none">
            <img src="/favicon.png" alt="Moofar logo" width="40" height="40" style="display:block;border-radius:6px">
            <span style="font-weight:700">Moofar</span>
          </a>

          <nav id="main-nav" class="main-nav" role="navigation" aria-label="Primary">
            <ul style="display:flex;gap:1rem;list-style:none;margin:0;padding:0">
              <li><a href="/" aria-current="page">Home</a></li>
              <li><a href="/services.html">Services</a></li>
              <li><a href="/gallery.html">Gallery</a></li>
              <li><a href="/contact.html">Contact</a></li>
            </ul>
          </nav>
        </div>
      </header>
    `;
  }

  function createFooter(){
    return `
      <footer id="site-footer" class="site-footer" role="contentinfo" style="margin-top:2.5rem;padding:2rem 0;background:#111;color:#fff">
        <div class="container" style="display:flex;flex-wrap:wrap;gap:1rem;justify-content:space-between;align-items:flex-start">
          <div>
            <strong>Moofar Proprietary Limited</strong>
            <address style="font-style:normal;margin-top:.5rem">
              Francistown<br>
              North-East District, Botswana<br>
              <a href="tel:+26777723232" style="color:inherit;text-decoration:underline">+267 777 23232</a>
            </address>
          </div>

          <nav aria-label="Footer" style="display:flex;gap:1rem">
            <a href="/services.html">Services</a>
            <a href="/gallery.html">Gallery</a>
            <a href="/contact.html">Contact</a>
          </nav>

          <div style="min-width:180px;text-align:right;color:#fff">
            <p style="margin:0">© <span id="year"></span> Moofar Proprietary Limited</p>
          </div>
        </div>
      </footer>
    `;
  }

  // Insert header/footer if placeholders exist
  document.addEventListener('DOMContentLoaded', function() {
    var headerPlaceholder = document.getElementById('header-placeholder');
    var footerPlaceholder = document.getElementById('footer-placeholder');

    if(headerPlaceholder){
      headerPlaceholder.innerHTML = createHeader();
    }
    if(footerPlaceholder){
      footerPlaceholder.innerHTML = createFooter();
    }

    // set year in footer if present
    var yearEl = document.getElementById('year');
    if(yearEl) yearEl.textContent = new Date().getFullYear();
  });
})();

