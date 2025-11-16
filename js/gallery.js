// Moofar Gallery - Lightbox and Animations

// Project data (high-res images - replace with local assets in /assets/ for production)
const projects = [
  {
    img: 'https://images.unsplash.com/photo-1558904541-efa843a96f01?w=1920&h=1080&fit=crop&q=80',
    title: 'Luxury Residential Estate',
    desc: 'Featured transformation project with comprehensive landscaping'
  },
  {
    img: 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=1600&h=1200&fit=crop&q=80',
    title: 'Business Park Landscaping',
    desc: 'Commercial development in Gaborone'
  },
  {
    img: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=1600&h=1200&fit=crop&q=80',
    title: 'Modern Garden Oasis',
    desc: 'Water-wise design with native plants'
  },
  {
    img: 'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=1600&h=1200&fit=crop&q=80',
    title: 'Outdoor Living Space',
    desc: 'Complete outdoor entertainment area'
  },
  {
    img: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1600&h=1200&fit=crop&q=80',
    title: 'Security Fencing',
    desc: 'Commercial-grade fencing installation'
  },
  {
    img: 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=1600&h=1200&fit=crop&q=80',
    title: 'Property Development',
    desc: 'Large-scale residential project in Francistown'
  },
  {
    img: 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=1600&h=1200&fit=crop&q=80',
    title: 'Garden Care',
    desc: 'Professional maintenance services'
  },
  {
    img: 'https://images.unsplash.com/photo-1600585152915-d208bec867a1?w=1200&h=800&fit=crop&q=80',
    title: 'Residential Transformation',
    desc: 'Complete yard redesign'
  },
  {
    img: 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=1200&h=1200&fit=crop&q=80',
    title: 'Commercial Plaza',
    desc: 'Professional landscaping for business center'
  },
  {
    img: 'https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=1200&h=1000&fit=crop&q=80',
    title: 'Fence & Gate Install',
    desc: 'Security solutions with aesthetic appeal'
  },
  {
    img: 'https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=1200&h=1400&fit=crop&q=80',
    title: 'Garden Paradise',
    desc: 'Native plant showcase garden'
  },
  {
    img: 'https://images.unsplash.com/photo-1600566752229-250ed79470f6?w=1200&h=900&fit=crop&q=80',
    title: 'Bush Clearing',
    desc: 'Professional land preparation'
  },
  {
    img: 'https://images.unsplash.com/photo-1600607686527-6fb886090705?w=1200&h=1100&fit=crop&q=80',
    title: 'Irrigation System',
    desc: 'Smart water management installation'
  }
];

// Lightbox functions
function openLightbox(index) {
  const project = projects[index] || projects[0];
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxTitle = document.getElementById('lightboxTitle');
  const lightboxDesc = document.getElementById('lightboxDesc');

  if (lightbox && lightboxImg && lightboxTitle && lightboxDesc) {
    lightboxImg.src = project.img;
    lightboxImg.alt = project.title;
    lightboxTitle.textContent = project.title;
    lightboxDesc.textContent = project.desc;
    
    lightbox.classList.add('active');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
}

function closeLightbox() {
  const lightbox = document.getElementById('lightbox');
  
  if (lightbox) {
    lightbox.classList.remove('active');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
}

// Close lightbox on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeLightbox();
  }
});

// Progressive reveal for gallery items on scroll
const observerOptions = {
  threshold: 0.12,
  rootMargin: '0px 0px -50px 0px'
};

const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = 1;
      entry.target.style.transform = 'translateY(0)';
      revealObserver.unobserve(entry.target);
    }
  });
}, observerOptions);

// Apply animation to gallery items
document.querySelectorAll('.gallery-item, .masonry-item').forEach(el => {
  el.style.opacity = 0;
  el.style.transform = 'translateY(12px)';
  el.style.transition = 'all .6s ease';
  revealObserver.observe(el);
});

// Keyboard navigation in lightbox (optional: next/previous)
let currentLightboxIndex = 0;

document.addEventListener('keydown', (e) => {
  const lightbox = document.getElementById('lightbox');
  if (lightbox && lightbox.classList.contains('active')) {
    if (e.key === 'ArrowRight') {
      currentLightboxIndex = (currentLightboxIndex + 1) % projects.length;
      openLightbox(currentLightboxIndex);
    } else if (e.key === 'ArrowLeft') {
      currentLightboxIndex = (currentLightboxIndex - 1 + projects.length) % projects.length;
      openLightbox(currentLightboxIndex);
    }
  }
});

// Update current index when opening lightbox
const originalOpenLightbox = openLightbox;
openLightbox = function(index) {
  currentLightboxIndex = index;
  originalOpenLightbox(index);
};
