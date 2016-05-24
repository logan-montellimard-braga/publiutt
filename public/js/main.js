(function($) {

  var jqReadyCalled = false;

  var validateConfig = {
    rules: {
      email: {
        email_utt: true,
      },
      annee: {
        annee: true,
      },
      nom: {
        minlength: 2,
        maxlength: 255,
      },
      lieu: {
        minlength: 2,
        maxlength: 255,
        required: "[name='is_conference']:checked"
      },
      titre: {
        minlength: 2,
        maxlength: 255
      },
      reference: {
        minlength: 2,
        maxlength: 255
      },
      prenom: {
        minlength: 2,
        maxlength: 255
      },
      description: {
        minlength: 2,
        maxlength: 255
      },
      password: {
        minlength: 6
      },
      'password_confirmation': {
        minlength: 6,
        equalTo: "[name='password']"
      }
    },
    errorPlacement: function(error, element) {
      error.appendTo(element.parents(".form-group")).hide();
      error.fadeIn();
      error.addClass('help-block');
    },
    highlight: function(element, errorClass) {
      $(element).parents(".form-group").addClass('has-error');
    },
    errorElement: "strong",
    wrapper: "div",
    success: function(label, element) {
      $(element).parents(".form-group").removeClass('has-error');
      $(element).parents(".form-group").children('.help-block').remove();
    }
  };

  if (Object.prototype.hasOwnProperty.call(window, 'jqReady') && $('form.js-validate').size() === 0) {
        $(function() {window.jqReady();});
        jqReadyCalled = true;
  }

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

  if ($('form.js-validate').size() > 0) {

    $.getScript('/js/vendor/jquery.validate.min.js', function() {

      $.validator.addMethod("annee", function(value, element) {
        return /^(19[5-9]\d|200\d|201[0-6])$/.test(value);
      }, "Veuillez fournir une année comprise entre 1950 et 2016.");

      $.validator.addMethod("email_utt", function(value, element) {
        return /@utt.fr$/.test(value);
      }, "Veuillez fournir une adresse email de l'UTT.");

      $.extend($.validator.messages, {
        required: "Ce champ est obligatoire.",
        email: "Veuillez fournir une adresse électronique valide.",
        equalTo: "Veuillez répéter la même valeur.",
        maxlength: $.validator.format( "Veuillez fournir au plus {0} caractères." ),
        minlength: $.validator.format( "Veuillez fournir au moins {0} caractères." ),
      });

      $('form.js-validate:not(.manual-validate)').validate(validateConfig);

      if (Object.prototype.hasOwnProperty.call(window, 'jqReady') && !jqReadyCalled) {
        $(function() {window.jqReady({validation: validateConfig});});
        jqReadyCalled = true;
      }

    });

  }

}(jQuery));
