$(function(){

  const MSG_TEXT_MAX = '20文字以内で入力してください。';

  $('.pass').keyup(function(){
    var form_g = $(this).closest('.form-pass');
    if ($(this).val().length > 20) {
      form_g.removeClass('has-success').addClass('has-error');
      form_g.find('.area-msg').text(MSG_TEXT_MAX);
    }else{
      form_g.removeClass('has-error').addClass('has-success');
      form_g.find('.area-msg').text('');
    }
  });

  $('#js-count').keyup(function(){
    var count = $(this).val().length;
    $('.show-count').text(count);
  });

  $('.js-toggle-sp-menu').on('click', function () {
  $(this).toggleClass('active');
  $('.js-toggle-sp-menu-target').toggleClass('active');
  });

});
