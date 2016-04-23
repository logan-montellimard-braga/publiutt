(function($) {
  if (window.hasOwnProperty('jqReady')) $(function() {window.jqReady();});

  $(document).ready(function() {
    $('body').css('overflow-y', 'scroll');
    $('#loader').remove();
  });

  $('abbr, .tooltip-on').tooltip({ placement: 'top' });

  $('.to-content').click(function(e){
    e.preventDefault();
    $('html, body').animate({
      scrollTop: $('section').offset().top - 80
    }, 300);
  });
}(jQuery));
