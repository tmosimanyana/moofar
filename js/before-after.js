// Very small accessible before/after slider
(function(){
  function initBA(container){
    const before = container.dataset.before;
    const after = container.dataset.after;
    const beforeLabel = container.dataset.beforeLabel || 'Before';
    const afterLabel = container.dataset.afterLabel || 'After';

    // build markup
    const wrapper = document.createElement('div'); wrapper.className='ba';
    wrapper.innerHTML = `
      <img class="ba-before" src="${before}" alt="${beforeLabel}" loading="lazy">
      <div class="ba-after" style="width:50%">
        <img src="${after}" alt="${afterLabel}" loading="lazy">
      </div>
      <div class="ba-handle" role="slider" tabindex="0" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" aria-label="Before/After slider"></div>
    `;
    container.appendChild(wrapper);

    const handle = wrapper.querySelector('.ba-handle');
    const afterPane = wrapper.querySelector('.ba-after');

    function setPos(pct){
      pct = Math.max(0, Math.min(100, pct));
      afterPane.style.width = pct+'%';
      handle.style.left = pct+'%';
      handle.setAttribute('aria-valuenow', Math.round(pct));
    }

    handle.addEventListener('keydown', function(e){
      if(e.key === 'ArrowLeft') setPos(parseFloat(handle.style.left) - 5 || 45);
      if(e.key === 'ArrowRight') setPos(parseFloat(handle.style.left) + 5 || 55);
      if(e.key === 'Home') setPos(0);
      if(e.key === 'End') setPos(100);
    });

    // pointer drag
    let dragging=false;
    handle.addEventListener('pointerdown', ()=>{dragging=true; handle.setPointerCapture(event.pointerId)});
    window.addEventListener('pointerup', ()=>dragging=false);
    window.addEventListener('pointermove', function(e){ if(!dragging) return; const r=wrapper.getBoundingClientRect(); const pct=((e.clientX - r.left)/r.width)*100; setPos(pct); });

    // click to move
    wrapper.addEventListener('click', function(e){ const r=wrapper.getBoundingClientRect(); const pct=((e.clientX - r.left)/r.width)*100; setPos(pct); });
  }

  // find all data-ba wrappers and init
  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('[data-ba] .ba, [data-ba] > .ba').forEach(el=>el.remove());
    document.querySelectorAll('[data-ba]').forEach(wrapperEl=>{
      const baElement = wrapperEl.querySelector('.ba');
      if(baElement) return; // already
      const inner = wrapperEl.querySelector('.ba');
      // data can be on inner .ba or on wrapper
      const data = wrapperEl.querySelector('.ba') || wrapperEl;
      // pull attributes from child or wrapper
      const d = wrapperEl.querySelector('.ba') ? wrapperEl.querySelector('.ba') : wrapperEl;
      // normalize
      const before = wrapperEl.getAttribute('data-before') || wrapperEl.dataset.before || wrapperEl.getAttribute('data-before-image') || wrapperEl.dataset.beforeImage;
      const after = wrapperEl.getAttribute('data-after') || wrapperEl.dataset.after || wrapperEl.getAttribute('data-after-image') || wrapperEl.dataset.afterImage;
      wrapperEl.dataset.before = before;
      wrapperEl.dataset.after = after;
      wrapperEl.dataset.beforeLabel = wrapperEl.getAttribute('data-before-label') || wrapperEl.dataset.beforeLabel || 'Before';
      wrapperEl.dataset.afterLabel = wrapperEl.getAttribute('data-after-label') || wrapperEl.dataset.afterLabel || 'After';
      if(before && after) initBA(wrapperEl);
    });
  });
})();