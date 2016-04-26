(function($) {
  // if (window.hasOwnProperty('jqReady'))
  if (Object.prototype.hasOwnProperty.call(window, 'jqReady'))
    $(function() {window.jqReady();});

  $('input, textarea').placeholder();

  $(document).ready(function() {
    $('body').css('overflow-y', 'scroll');
    $('#loader').remove();
  });

  $('abbr, .tooltip-on').tooltip();

  $('.publi-collapse').click(function() {
    $(this).toggleClass('fa-minus').toggleClass('fa-plus');
  });

  if ($('html').hasClass('lt-ie10')) {
    $('.collapse').addClass('in');
    $('[data-toggle="collapse"]').attr('href', '#');
  }

  $('.publi-expand-all').hide();
  $('.publi-collapse-all').click(function() {
    $('.publication .collapse').collapse('hide');
    $('.publi-collapse').addClass('fa-plus').removeClass('fa-minus');
    $(this).hide();
    $(this).siblings('.publi-expand-all').show();
    return false;
  });
  $('.publi-expand-all').click(function() {
    $('.publication .collapse').collapse('show');
    $('.publi-collapse').addClass('fa-minus').removeClass('fa-plus');
    $(this).hide();
    $(this).siblings('.publi-collapse-all').show();
    return false;
  });

  $('[data-toggle="collapse"]').click(function() {
    var id = $(this).attr('href');
    var group = $(id).attr('data-group');
    $('[data-group="' + group + '"]').collapse('hide');
    $(id).collapse('show');
  });

  $('.to-content').click(function(e){
    e.preventDefault();
    $('html, body').animate({
      scrollTop: $('section').offset().top - 80
    }, 300);
  });
}(jQuery));
