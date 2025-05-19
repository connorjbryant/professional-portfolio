// Main JS file for theme enhancements
jQuery(document).ready(function($){
  // Initialize AOS
  if (window.AOS) {
    AOS.init();
  }
  // Example: Smooth scroll for anchor links
  $('a[href^="#"]').on('click', function(e) {
    var target = $($(this).attr('href'));
    if(target.length) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: target.offset().top }, 600);
    }
  });

  // Typewriter effect for bio section
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
    // If the parent contains the static text, remove it from JS
    // Only animate the phrase
    // (No change needed here, but update HTML to include static text before the span)

    var wordIndex = 0, charIndex = 0, isDeleting = false;
    // Create a span for the blinking cursor
    var cursor = document.createElement('span');
    cursor.className = 'typewriter-cursor';
    cursor.textContent = '|';
    el.textContent = '';
    el.appendChild(cursor);

    var prevDisplay = '';
    function type() {
      var current = words[wordIndex];
      var display = current.substring(0, charIndex);
      // Only update if text changes
      if (el.firstChild.nodeType === 3) {
        el.removeChild(el.firstChild);
      }
      if (prevDisplay !== display) {
        el.insertBefore(document.createTextNode(display), cursor);
        prevDisplay = display;
      }
      if (!isDeleting && charIndex < current.length) {
        charIndex++;
        setTimeout(() => requestAnimationFrame(type), 100);
      } else if (isDeleting && charIndex > 0) {
        charIndex--;
        setTimeout(() => requestAnimationFrame(type), 70); // slightly slower backspace
      } else {
        if (!isDeleting) {
          isDeleting = true;
          setTimeout(() => requestAnimationFrame(type), 1200); // Pause before deleting
        } else {
          isDeleting = false;
          wordIndex = (wordIndex + 1) % words.length;
          setTimeout(() => requestAnimationFrame(type), 400);
        }
      }
    }
    // CSS for cursor blink
    var style = document.createElement('style');
    style.innerHTML = `.typewriter-cursor { display: inline-block; animation: blink 1s steps(1) infinite; }
    @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0; } }`;
    document.head.appendChild(style);

    requestAnimationFrame(type);
  }  
  // Enhance ACF details field: split by spaces, wrap each in styled span
  var $details = $('.js-acf-details');
  var $details = $('.acf-details');
  if ($details.length) {
    var text = $details.text().trim();
    var words = text.split(/\s+/).filter(Boolean);
    var html = words.map(function(word) {
      return '<span class="acf-details__item">' + word + '</span>';
    }).join(' ');
    $details.html(html);
  }
});
