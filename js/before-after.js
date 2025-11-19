// js/before-after.js
// Accessible before/after slider implemented with an overlay & range input.
// Place at /js/before-after.js

(function(){
  'use strict';

  function initBA(wrapper){
    // If images already present as <figure> pairs, just layer them.
    // If not, attempt to read data-before/data-after attributes and create markup.
    if(!wrapper) return;

    // ensure we have before and after image elements
    var beforeImg = wrapper.querySelector('.ba-before img');
    var afterImg = wrapper.querySelector('.ba-after img');

    if(!beforeImg || !afterImg){
      // build fallback markup if data attributes exist
      var beforeUrl = wrapper.getAttribute('data-before');
      var afterUrl = wrapper.getAttribute('data-after');
      if(beforeUrl && afterUrl){
        wrapper.innerHTML = `
          <figure class="ba-before"><img src="${beforeUrl}" alt="Before image" loading="lazy"></figure>
          <figure class="ba-after" style="width:50%"><img src="${afterUrl}" alt="After image" loading="lazy"></figure>
          <input class="ba-range" type="range" min="0" max="100" value="50" aria-label="Compare before and after" />
        `;
        beforeImg = wrapper.querySelector('.ba-before img');
        afterImg = wrapper.querySelector('.ba-after img');
      } else {
        return; // nothing to do
      }
    } else {
      // if markup exists, append a range input and wrapper styles
      var range = document.createElement('input');
      range.type = 'range';
      range.min = 0;
      range.max = 100;
      range.value = 50;
      range.className = 'ba-range';
      range.setAttribute('aria-label','Compare before and after');
      wrapper.appendChild(range);
    }

    // now ensure after container is positioned absolutely
    var afterFigure = wrapper.querySelector('.ba-after');
    var rangeEl = wrapper.querySelector('.ba-range');

    wrapper.style.position = 'relative';
    wrapper.querySelectorAll('figure').forEach(function(fig){
      fig.style.margin = '0';
    });

    if(afterFigure){
      afterFigure.style.position = 'absolute';
      afterFigure.style.top = '0';
      afterFigure.style.left = '0';
      afterFigure.style.height = '100%';
      afterFigure.style.width = (rangeEl ? (rangeEl.value + '%') : '50%');
      afterFigure.style.overflow = 'hidden';
    }

    // create a simple handle line for visual affordance
    var handle = document.createElement('div');
    handle.className = 'ba-handle';
    handle.style.left = (rangeEl ? (rangeEl.value+'%') : '50%');
    wrapper.appendChild(handle);

    function update(val){
      if(afterFigure){
        afterFigure.style.width = val + '%';
      }
      handle.style.left = val + '%';
      // position range under handle if you want; we keep range full width (screen reader friendly)
      if(rangeEl) rangeEl.value = val;
    }

    if(rangeEl){
      rangeEl.addEventListener('input', function(e){
        update(e.target.value);
      });
      // support keyboard arrow keys fine via native input range
    }

    // make wrapper friendly for touch dragging (optional)
    var dragging = false;
    wrapper.addEventListener('pointerdown', function(e){
      dragging = true;
    });
    wrapper.addEventListener('pointerup', function(){ dragging = false; });
    wrapper.addEventListener('pointercancel', function(){ dragging = false; });

    wrapper.addEventListener('pointermove', function(e){
      if(!dragging) return;
      var rect = wrapper.getBoundingClientRect();
      var pct = Math.max(0, Math.min(100, ((e.clientX - rect.left) / rect.width) * 100));
      update(pct);
    });

    // accessibility: allow focus to range
    if(rangeEl){
      rangeEl.addEventListener('focus', function(){ wrapper.classList.add('ba-focus'); });
      rangeEl.addEventListener('blur', function(){ wrapper.classList.remove('ba-focus'); });
    }
  }

  document.addEventListener('DOMContentLoaded', function(){
    var wrappers = document.querySelectorAll('.before-after-wrapper[data-ba]');
    wrappers.forEach(function(w){
      initBA(w);
    });
  });
})();

