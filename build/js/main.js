// Main JS file for theme enhancements
jQuery(function ($) {

  function applyAOSBlockStyles() {
    var selectors = [
      '.is-style-aos-fade-up',
      '.is-style-aos-fade-down',
      '.is-style-aos-fade-left',
      '.is-style-aos-fade-right',
      '.is-style-aos-zoom-in',
      '.wp-block-columns.is-style-motion-cards > .wp-block-column'
    ].join(',');

    $(selectors).each(function (index) {
      var $el = $(this);

      if ($el.hasClass('hero-blob-aos')) return;

      $el
        .addClass('fr-aos-ready')
        .css('--fr-aos-delay', Math.min(index * 100, 300) + 'ms');
    });

    if ('IntersectionObserver' in window) {
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('fr-aos-in');
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.1,
        rootMargin: '0px 0px -30px 0px'
      });

      document.querySelectorAll('.fr-aos-ready').forEach(function (el) {
        observer.observe(el);
      });
    } else {
      $('.fr-aos-ready').addClass('fr-aos-in');
    }
  }

  $(window).on('load', function () {
    applyAOSBlockStyles();

    if (window.AOS) {
      AOS.init({
        duration: 700,
        easing: 'ease-out',
        once: true,
        offset: 10,
        mirror: false,
        disable: function () {
          return false;
        }
      });

      setTimeout(function () {
        applyAOSBlockStyles();
        AOS.refreshHard();
        $('.hero-blob-blob, .hero-blob-aos').css('opacity', '0.22');
      }, 500);

      setTimeout(function () {
        AOS.refreshHard();
        $('.hero-blob-blob, .hero-blob-aos').css('opacity', '0.22');
      }, 1200);
    }
  });

  /*
   * Smooth anchor scrolling
   */
  var offset = 125;

  $('a[href^="#"]').not('[href="#"]').on('click', function (e) {
    var targetID = $(this).attr('href');
    var $target = $(targetID);

    if ($target.length) {
      e.preventDefault();

      $('html, body').stop(true).animate({
        scrollTop: $target.offset().top - offset
      }, 700, 'swing');
    }
  });

  function scrollToHashOnLoad() {
    if (!window.location.hash) return;

    var $target = $(window.location.hash);

    if ($target.length) {
      setTimeout(function () {
        $('html, body').scrollTop($target.offset().top - offset);
      }, 150);
    }
  }

  scrollToHashOnLoad();
  $(window).on('hashchange', scrollToHashOnLoad);

  /*
   * Typewriter effect
   */
  var words = [
    "full-stack development.",
    "custom WordPress themes.",
    "Shopify store development.",
    "HubSpot CRM integration.",
    "performance optimization.",
    "responsive design.",
    "web accessibility."
  ];

  var el = document.getElementById('typewriter');

  if (el) {
    var wordIndex = 0;
    var charIndex = 0;
    var isDeleting = false;

    var cursor = document.createElement('span');
    cursor.className = 'typewriter-cursor';
    cursor.textContent = '|';

    el.textContent = '';
    el.appendChild(cursor);

    function type() {
      var current = words[wordIndex];
      var display = current.substring(0, charIndex);

      if (el.firstChild && el.firstChild.nodeType === 3) {
        el.removeChild(el.firstChild);
      }

      el.insertBefore(document.createTextNode(display), cursor);

      if (!isDeleting && charIndex < current.length) {
        charIndex++;
        setTimeout(function () {
          requestAnimationFrame(type);
        }, 100);
      } else if (isDeleting && charIndex > 0) {
        charIndex--;
        setTimeout(function () {
          requestAnimationFrame(type);
        }, 70);
      } else {
        if (!isDeleting) {
          isDeleting = true;
          setTimeout(function () {
            requestAnimationFrame(type);
          }, 1200);
        } else {
          isDeleting = false;
          wordIndex = (wordIndex + 1) % words.length;

          setTimeout(function () {
            requestAnimationFrame(type);
          }, 400);
        }
      }
    }

    requestAnimationFrame(type);
  }

  /*
   * Enhance ACF details field
   */
  var $details = $('.js-acf-details, .acf-details');

  if ($details.length) {
    $details.each(function () {
      var $el = $(this);
      var text = $el.text().trim();

      if (!text) return;

      var detailWords = text.split(/\s+/).filter(Boolean);

      var html = detailWords.map(function (word) {
        return '<span class="acf-details__item">' + word + '</span>';
      }).join(' ');

      $el.html(html);
    });
  }

});