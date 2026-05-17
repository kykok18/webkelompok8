// main.js - Desa Wisata Cibuntu

document.addEventListener("DOMContentLoaded", function () {
  // Initialize AOS
  AOS.init({
    duration: 800,
    easing: "ease-out-cubic",
    once: true,
    offset: 50,
  });

  // Navbar scroll effect
  const navbar = document.getElementById("mainNavbar");

  function handleNavbarScroll() {
    if (window.scrollY > 50) {
      navbar?.classList.add("scrolled");
    } else {
      navbar?.classList.remove("scrolled");
    }
  }

  window.addEventListener("scroll", handleNavbarScroll);
  handleNavbarScroll();

  // Hero Slider
  const slides = document.querySelectorAll(".hero-slide");
  const indicators = document.querySelectorAll(".hero-indicators button");
  let currentSlide = 0;
  let slideInterval;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === index);
    });
    indicators.forEach((indicator, i) => {
      indicator.classList.toggle("active", i === index);
    });
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  }

  function startSlider() {
    if (slides.length > 0) {
      slideInterval = setInterval(nextSlide, 5000);
    }
  }

  function stopSlider() {
    clearInterval(slideInterval);
  }

  startSlider();

  indicators.forEach((indicator, index) => {
    indicator.addEventListener("click", () => {
      stopSlider();
      currentSlide = index;
      showSlide(currentSlide);
      startSlider();
    });
  });

  const heroSection = document.querySelector(".hero");
  heroSection?.addEventListener("mouseenter", stopSlider);
  heroSection?.addEventListener("mouseleave", startSlider);

  // Counter Animation
  const counters = document.querySelectorAll(".counter");
  let countersAnimated = false;

  function animateCounters() {
    counters.forEach((counter) => {
      const target = parseInt(counter.getAttribute("data-target"));
      const duration = 2000;
      const startTime = performance.now();

      function updateCounter(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
        const current = Math.floor(easeOutQuart * target);

        counter.textContent = current.toLocaleString("id-ID");

        if (progress < 1) {
          requestAnimationFrame(updateCounter);
        } else {
          counter.textContent = target.toLocaleString("id-ID");
        }
      }

      requestAnimationFrame(updateCounter);
    });
  }

  const statsSection = document.querySelector(".stats-section");
  if (statsSection) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !countersAnimated) {
            countersAnimated = true;
            animateCounters();
          }
        });
      },
      { threshold: 0.5 },
    );
    observer.observe(statsSection);
  }

  // Lightbox Options
  if (typeof lightbox !== "undefined") {
    lightbox.option({
      resizeDuration: 200,
      wrapAround: true,
      albumLabel: "Gambar %1 dari %2",
      fadeDuration: 300,
    });
  }

  // Smooth Scroll
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const href = this.getAttribute("href");
      if (href !== "#" && href !== "#!") {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          target.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        }
      }
    });
  });

  // Form Validation
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const requiredFields = this.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add("is-invalid");
        } else {
          field.classList.remove("is-invalid");
        }
      });

      if (!isValid) {
        e.preventDefault();
      }
    });

    form.querySelectorAll(".form-control, .form-select").forEach((field) => {
      field.addEventListener("input", function () {
        this.classList.remove("is-invalid");
      });
    });
  });

  // Back to Top
  const backToTop = document.createElement("button");
  backToTop.innerHTML = '<i class="bi bi-arrow-up"></i>';
  backToTop.className = "back-to-top";
  backToTop.style.cssText = `
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        border: none;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 99;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    `;
  document.body.appendChild(backToTop);

  window.addEventListener("scroll", () => {
    if (window.scrollY > 500) {
      backToTop.style.opacity = "1";
      backToTop.style.visibility = "visible";
    } else {
      backToTop.style.opacity = "0";
      backToTop.style.visibility = "hidden";
    }
  });

  backToTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  backToTop.addEventListener("mouseenter", function () {
    this.style.transform = "translateY(-5px)";
  });

  backToTop.addEventListener("mouseleave", function () {
    this.style.transform = "translateY(0)";
  });

  // Lazy Load Images
  const lazyImages = document.querySelectorAll("img[data-src]");
  const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.removeAttribute("data-src");
        imageObserver.unobserve(img);
      }
    });
  });
  lazyImages.forEach((img) => imageObserver.observe(img));
});

// PREVIEW IMAGE FUNCTION (GLOBAL)
function previewImage(input, previewId) {
  const preview = document.getElementById(previewId);
  if (preview && input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = "block";
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// Make it available globally
window.previewImage = previewImage;
