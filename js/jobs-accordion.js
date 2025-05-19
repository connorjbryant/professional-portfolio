// Accessible accordion for jobs section with arrow toggle
// Rotates arrow when expanded

jQuery(document).ready(function($) {
  var headers = $('.job-card__header');
  headers.on('click', function(e) {
    var $btn = $(this);
    var $card = $btn.closest('.job-card');
    var $body = $card.find('.job-card__body');
    var expanded = $btn.attr('aria-expanded') === 'true';

    // Close all others
    headers.each(function() {
      if (this !== $btn[0]) {
        $(this).attr('aria-expanded', 'false');
      }
    });

    // Toggle current
    $btn.attr('aria-expanded', !expanded);

    // Focus for accessibility
    if (!expanded) {
      setTimeout(function() {
        var $focusable = $body.find('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])').first();
        if ($focusable.length) $focusable.focus();
      }, 200);
    }
  });

  // Keyboard accessibility
  headers.on('keydown', function(e) {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      $(this).trigger('click');
    }
  });
});
