// ================================
// MOOFAR (PTY) LTD - Main JS
// ================================

document.addEventListener("DOMContentLoaded", () => {
  /* =========================================
     MOBILE NAV TOGGLE
  ========================================= */
  const mobileToggle = document.querySelector(".mobile-toggle");
  const nav = document.querySelector("nav");

  mobileToggle.addEventListener("click", () => {
    nav.classList.toggle("open");
    const expanded = mobileToggle.getAttribute("aria-expanded") === "true" || false;
    mobileToggle.setAttribute("aria-expanded", !expanded);
  });

  /* =========================================
     GALLERY LIGHTBOX
  ========================================= */
  const galleryItems = document.querySelectorAll(".gallery-item img");

  galleryItems.forEach((img) => {
    img.addEventListener("click", () => {
      const lightbox = document.createElement("div");
      lightbox.classList.add("lightbox-overlay");

      const lightboxImg = document.createElement("img");
      lightboxImg.src = img.src;
      lightbox.appendChild(lightboxImg);

      const closeBtn = document.createElement("a");
      closeBtn.href = "#";
      closeBtn.classList.add("close-lightbox");
      closeBtn.innerHTML = "&times;";
      lightbox.appendChild(closeBtn);

      document.body.appendChild(lightbox);

      closeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        document.body.removeChild(lightbox);
      });

      lightbox.addEventListener("click", (e) => {
        if (e.target === lightbox) {
          document.body.removeChild(lightbox);
        }
      });
    });
  });
});

