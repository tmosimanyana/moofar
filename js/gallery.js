(function(){
  const items = [
    {src:'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=1200',title:'Front yard renovation',tags:['residential','landscaping']},
    {src:'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1200',title:'Commercial grounds',tags:['commercial']},
    {src:'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=1200',title:'Green walkway',tags:['landscaping']},
    {src:'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200',title:'Before/After example',tags:['landscaping','residential']}
  ];

  function makeItem(i){
    const div = document.createElement('div'); div.className='gallery-item';
    const img = document.createElement('img'); img.loading='lazy'; img.alt=i.title; img.src=i.src;
    const cap = document.createElement('div'); cap.className='gallery-caption'; cap.textContent=i.title;
    div.appendChild(img); div.appendChild(cap);
    div.dataset.tags = i.tags.join(' ');
    div.addEventListener('click', ()=>openLightbox(i));
    return div;
  }

  function render(filter){
    const grid = document.getElementById('galleryGrid'); if(!grid) return;
    grid.innerHTML='';
    items.filter(i=> filter==='all' || i.tags.includes(filter)).forEach(i=>grid.appendChild(makeItem(i)));
  }

  function openLightbox(item){
    const lb = document.getElementById('lightbox'); if(!lb) return;
    lb.querySelector('#lightboxImg').src = item.src;
    lb.querySelector('#lightboxImg').alt = item.title;
    lb.querySelector('#lightboxCaption').textContent = item.title;
    lb.style.display='block'; lb.setAttribute('aria-hidden','false');
  }

  function closeLightbox(){
    const lb = document.getElementById('lightbox'); if(!lb) return; lb.style.display='none'; lb.setAttribute('aria-hidden','true'); lb.querySelector('#lightboxImg').src='';
  }

  document.addEventListener('DOMContentLoaded', function(){
    render('all');
    document.querySelectorAll('.filter-btn').forEach(btn=>{
      btn.addEventListener('click', function(){
        document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
        this.classList.add('active');
        render(this.dataset.filter || 'all');
      })
    });

    const lb = document.getElementById('lightbox');
    if(lb){
      lb.querySelector('.lightbox-close')?.addEventListener('click', closeLightbox);
      lb.querySelector('.lightbox-prev')?.addEventListener('click', closeLightbox);
      lb.querySelector('.lightbox-next')?.addEventListener('click', closeLightbox);
      lb.addEventListener('click', (e)=>{ if(e.target===lb) closeLightbox() });
      document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeLightbox() });
    }
  });
})();