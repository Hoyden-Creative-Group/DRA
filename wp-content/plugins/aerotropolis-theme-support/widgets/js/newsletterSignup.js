/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Handles the submission of a newsletter widget and performs
 * an ajax request to submit it.
 *
 * NOTE: This is shared between "widget-news-subscribe.js" and "widget-newsletter"
 */

jQuery(document).ready(function($){
  var emailRegex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i
  var isSubmittingNewsletterSignup = false;
  var count = 0;

  $('.aero-mailchimp-widget').on('submit', function(e){
    e.preventDefault();

    if (isSubmittingNewsletterSignup) {
      return;
    }

    isSubmittingNewsletterSignup = true;

    var $form = $(this);
    var $email = $('.email', $form);
    var $message = $('.message', $form);
    var $button = $('.btn', $form);

    $message.removeClass('success error').html('');
    $email.removeClass('error');

    if (!emailRegex.test($email.val())) {
      $message.addClass('error').text('Oops! Invalid Email.');
      $email.addClass('error');
      isSubmittingNewsletterSignup = false;
      return;
    }

    function errorHandler (err) {
      if (err.title === "Member Exists") {
        $message.addClass('success').text('You are already added to our mailing list. Thank you!');
        return;
      }

      console.log(err);

      if (count > 1) {
        $message.addClass('error').html('Something still didn\'t process correctly.  Please try contacting us directly <a href="/contact">here.</a>');
        return;
      }

      $message.addClass('error').html('Oops! Something didn\'t go quite right. Please try again.');
    }

    // Store how many times the user submits the form
    count++;
    $button.val('Sending...');

    $.ajax({
      url: $form.attr('action'),
      method: 'POST',
      data: $form.serialize(),
      dataType: 'json'
    })
    .done(function(data) {
      if (data.status === "subscribed") {
        $message.addClass('success').text('Thank you! You are now signed up for our newsletter.');
        return;
      }
      errorHandler(data);
    })
    .fail(errorHandler)
    .always(function(){
      isSubmittingNewsletterSignup = false;
      $button.val($button.data('value'));
    });
  });
});