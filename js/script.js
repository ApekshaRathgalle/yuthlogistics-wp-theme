
const hamburger = document.querySelector('.hamburger');
const hamburgerMenu = document.getElementById('hamburgerMenu');
const hamburgerClose = document.querySelector('.hamburger-close');

if (!hamburger || !hamburgerMenu || !hamburgerClose) {
  console.warn('Hamburger elements not found in DOM.');
} else {
  // Open hamburger menu
  hamburger.addEventListener('click', () => {
    hamburgerMenu.classList.add('active');
    hamburger.setAttribute('aria-expanded', 'true');
    hamburgerMenu.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden'; 
  });

  // Close hamburger menu
  hamburgerClose.addEventListener('click', () => {
    hamburgerMenu.classList.remove('active');
    hamburger.setAttribute('aria-expanded', 'false');
    hamburgerMenu.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = ''; 
  });

  // Close menu when clicking outside
  document.addEventListener('mousedown', (e) => {
    if (
      hamburgerMenu.classList.contains('active') &&
      !hamburgerMenu.contains(e.target) &&
      !hamburger.contains(e.target)
    ) {
      hamburgerMenu.classList.remove('active');
      hamburger.setAttribute('aria-expanded', 'false');
      hamburgerMenu.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }
  });
}

jQuery(document).ready(function($) {
  
  // Service Carousel
  if ($('.service-carousel').length) {
    $('.service-carousel').owlCarousel({
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      navText: [
        '<i class="fa-solid fa-chevron-left"></i>',
        '<i class="fa-solid fa-chevron-right"></i>'
      ],
      autoplay: false,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      smartSpeed: 800,
      responsive: {
        0: {
          items: 1,
          nav: false,
          dots: true
        },
        600: {
          items: 2,
          nav: true,
          dots: true
        },
        1000: {
          items: 3,
          nav: true,
          dots: true
        }
      }
    });
  }

// Navbar and Topbar scroll behavior
const navbar = document.querySelector('.navbar');
const topbar = document.querySelector('.topbar');

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;
  
  if (currentScroll > 80) {
    // Hide topbar and fix navbar
    topbar.style.transform = 'translateY(-100%)';
    topbar.style.opacity = '0';
    navbar.classList.add('sticky');
  } else {
    // Show topbar and unfix navbar
    topbar.style.transform = 'translateY(0)';
    topbar.style.opacity = '1';
    navbar.classList.remove('sticky');
  }
});
  
// Blog Carousel
  if ($('.ph-bl-bb-1').length) {
    $('.ph-bl-bb-1').owlCarousel({
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      navText: [
        "<i class='fa fa-chevron-left'></i>", 
        "<i class='fa fa-chevron-right'></i>"
      ],
      responsive: {
        0: {
          items: 1,
          nav: false
        },
        768: {
          items: 2
        },
        992: {
          items: 3
        }
      }
    });
  }
  
});

// Contact Form 
document.addEventListener('DOMContentLoaded', function() {
  const closeContactForm = document.getElementById('closeContactForm');
  const contactFormOverlay = document.getElementById('contactFormOverlay');

  if (closeContactForm && contactFormOverlay) {
    // Show overlay if on contact form page with !important via setAttribute
    if (document.body.classList.contains('page-template-contact_form')) {
      contactFormOverlay.style.setProperty('display', 'flex', 'important');
      document.body.style.overflow = 'hidden';
    }

    // Get home URL from data attribute
    const homeUrl = contactFormOverlay.getAttribute('data-home-url') || '/';

    // Close button click - navigate to homepage
    closeContactForm.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = homeUrl;
    });

    // Close on overlay click (outside form)
    contactFormOverlay.addEventListener('click', (e) => {
      if (e.target === contactFormOverlay) {
        e.preventDefault();
        window.location.href = homeUrl;
      }
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && contactFormOverlay.style.display === 'flex') {
        window.location.href = homeUrl;
      }
    });
  }

  // Handle CF7 form submission success
  document.addEventListener('wpcf7mailsent', function(event) {
    const overlay = document.getElementById('contactFormOverlay');
    const homeUrl = overlay ? overlay.getAttribute('data-home-url') : '/';
    
    setTimeout(() => {
      window.location.href = homeUrl;
    }, 2000); 
  }, false);
});



  // Other Services Carousel (for single service page)
jQuery(document).ready(function($) {
  if ($('.other-services-carousel').length) {
    $('.other-services-carousel').owlCarousel({
      loop: true,
      margin: 30,
      nav: true,
      dots: true,
      navText: [
        '<i class="fa-solid fa-chevron-left"></i>',
        '<i class="fa-solid fa-chevron-right"></i>'
      ],
      autoplay: false,
      smartSpeed: 800,
      responsive: {
        0: {
          items: 1,
          nav: false,
          dots: true
        },
        600: {
          items: 2,
          nav: true,
          dots: true
        },
        1000: {
          items: 3,
          nav: true,
          dots: true
        }
      }
    });
  }
});

jQuery(document).ready(function($) {
  if (typeof Fancybox !== 'undefined') {
    Fancybox.bind('[data-fancybox="service-gallery"]', {
      Toolbar: {
        display: {
          left: [],
          middle: [],
          right: ["close"],
        },
      },
      Thumbs: {
        autoStart: true,
      },
      Image: {
        zoom: true,
      },
    });
  }
});

// Profile Dropdown Toggle
document.addEventListener('DOMContentLoaded', function() {
  const profileToggle = document.getElementById('profileToggle');
  const profileDropdown = document.getElementById('profileDropdown');

  if (profileToggle && profileDropdown) {
    // Toggle dropdown on click
    profileToggle.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      profileDropdown.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.remove('active');
      }
    });

    // Prevent dropdown from closing when clicking inside it
    profileDropdown.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  }
});
