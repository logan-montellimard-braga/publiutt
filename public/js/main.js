(function($) {
  $(document).ready(function() {
    $('body').css('overflow-y', 'scroll');
    $('#loader').remove();
  });

  $('.to-content').click(function(e){
    e.preventDefault();
    $('html, body').animate({
      scrollTop: $('section').offset().top - 80
    }, 300);
  });
}(jQuery));
