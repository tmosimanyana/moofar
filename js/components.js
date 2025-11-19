(function(){
  // Simple header/footer injector
  const headerHTML = `
  <header class="site-header" role="banner">
    <div class="container header-inner">
      <a class="brand" href="/">🌿 Moofar</a>
      <nav class="nav" role="navigation" aria-label="Main navigation">
        <a href="/">Home</a>
        <a href="/services.html">Services</a>
        <a href="/gallery.html">Gallery</a>
        <a href="/about.html">About</a>
        <a href="/contact.html">Contact</a>
      </nav>
    </div>
  </header>`;

  const footerHTML = `
  <footer class="site-footer" role="contentinfo">
    <div class="container" style="padding:2rem 0;font-size:0.95rem;color:#6b7280;">
      <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>© ${new Date().getFullYear()} Moofar Proprietary Limited — Francistown, Botswana</div>
        <div>Phone: <a href="tel:+26777723232">+267 77 723 232</a> · Email: <a href="mailto:Mookfara@gmail.com">Mookfara@gmail.com</a></div>
      </div>
    </div>
  </footer>`;

  document.getElementById('header-placeholder')?.insertAdjacentHTML('afterend', headerHTML);
  document.getElementById('footer-placeholder')?.insertAdjacentHTML('beforebegin', footerHTML);

  // Basic contact form handling (progressive enhancement)
  const form = document.getElementById('contactForm');
  if(form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      const honeypot = form.querySelector('[name="company"]').value;
      if(honeypot){
        // likely bot
        return;
      }
      // Basic front-end validation
      const name = form.name.value.trim();
      const email = form.email.value.trim();
      const service = form.service.value;
      const message = form.message.value.trim();
      let ok=true;
      const setErr=(id,txt)=>{const el=document.getElementById(id); if(el) el.textContent=txt}
      setErr('nameError',''); setErr('emailError',''); setErr('serviceError',''); setErr('messageError','');
      if(!name){setErr('nameError','Please enter your name'); ok=false}
      if(!email || !/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,}$/.test(email)){setErr('emailError','Please enter a valid email'); ok=false}
      if(!service){setErr('serviceError','Please select a service'); ok=false}
      if(!message){setErr('messageError','Please enter a message'); ok=false}
      if(!ok) return;

      // Show a friendly status (server-side integration required to actually send)
      const status = document.getElementById('formStatus');
      status.textContent = 'Sending…';
      // replace this fetch with your real endpoint
      setTimeout(()=>{ status.textContent='Thank you — we received your message and will be in touch soon.'; form.reset()}, 800);
    })
  }
})();