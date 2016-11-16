<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for SiteSelectionItem.
 */

?>

<?php ob_start() ;?>

<?php
  function isValidEmail ($email) {
    $emailParts = explode('@', $email);
    if (sizeof($emailParts) != 2) {
      return false;
    }

    list($user, $domain) = explode('@', $email);
    $domainExists = checkdnsrr($domain, 'MX');

    if (!$domainExists) {
      return false;
    }

    return true;
  }

  function isValidPhoneNumber ($phoneNumber) {
    return preg_match("/^\(?[0-9]{3}\)?[-\.\s]?[0-9]{3}[-\.\s]?[0-9]{4}$/i", $phoneNumber);
  }

  function isValidCaptcha($captcha, $secret) {

    if (empty($captcha)) {
      return false;
    }

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = ['secret'   => $secret,
             'response' => $captcha,
             'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
      'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
      ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return json_decode($result)->success;
  }

  function validateFormSubmission($captcha_secret) {

    // validate CSRF
    $nonce = $_REQUEST['_wpnonce'];
    if (! wp_verify_nonce($nonce, 'aero_contact_submit')) {
      wp_die("Invalid form submission.");
    }

    $errors = array();

    // validate required fields
    if (empty($_POST['aero_message'])) {
      array_push($errors, "Please enter in a message");
    }

    if (empty($_POST['aero_name'])) {
      array_push($errors, "Please enter in a name");
    }

    if (empty($_POST['aero_email'])) {
      array_push($errors, "Please enter in an email address");
    }

    // return early if there are missing fields
    if (!empty($errors)) {
      return array(
        "success" => false,
        "errors" => $errors
      );
    }

    // validate values
    if (!isValidEmail($_POST['aero_email'])) {
      return array(
        "success" => false,
        "errors" => array("Invalid email address")
      );
    }

    if (!empty($_POST['aero_phonenumber']) && !isValidPhoneNumber($_POST['aero_phonenumber'])) {
      return array(
        "success" => false,
        "errors" => array("Invalid phone number")
      );
    }

    // validate reCaptcha
    if (!isValidCaptcha($_POST['g-recaptcha-response'], $captcha_secret)) {
      return array(
        "success" => false,
        "errors" => array("Invalid captcha. Please be sure to check the captcha box.")
      );
    }

    return array(
      "success" => true,
      "errors" => array()
    );
  }

  // upon form submission
  if (isset($_POST['action']) && $_POST['action'] == 'contact-submit') {
    // validate our fields
    $validation = validateFormSubmission($captcha_secret);

    // send an email out
    if (!$validation["success"]) {
      echo '<div class="form-errors">';
        echo '<ul>';
          foreach ($validation["errors"] as $error) {
            echo '<li>'. $error .'</li>';
          }
        echo '</ul>';
      echo '</div>';
    } else {

      // build our email
      $to = $contact_email;
      $subject = "Message sent from Aerotropolisss";
      $headers = "From: '". strip_tags($_POST['aero_name']) ."' <". strip_tags($_POST['aero_email']) . ">\r\n";
      $headers .= "Reply-To: '". strip_tags($_POST['aero_name']) ."' <". strip_tags($_POST['aero_email']) . ">\r\n";
      $headers .= "X-Mailer: PHP/" . phpversion()."\r\n";
      $headers .= "Content-type: text/html; charset=ISO-8859-1\r\n";

      // 4wV@)Mn7wA^v)9

      $message  = '<div style="font-size:12px; line-height:16px; font-family:Arial, Helvetica, sans-serif; width:600px;">';
      $message .=   '<p>Someone has contacted you through the website form on '. get_bloginfo('name') .'.  Please find below the information sent:</p>';
      $message .=   '<p>Name: '. $_POST['aero_name'] .'<br />';
      $message .=   'Email: '. $_POST['aero_email'] .'<br />';
      $message .=   'Phone: '. $_POST['aero_phonenumber'] .'<br />';
      $message .=   'Message: '. strip_tags($_POST['aero_message']) .'</p>';
      $message .=   '<p>This message was sent on '. date("F j, Y, g:i a") .'</p>';
      $message .= '</div>';

      $result = wp_mail($to, $subject, $message, $headers);


      if (!$result) {
        // global $ts_mail_errors;
        // global $phpmailer;
        // if (!isset($ts_mail_errors)) $ts_mail_errors = array();
        // if (isset($phpmailer)) {
        //   $ts_mail_errors[] = $phpmailer->ErrorInfo;
        // }

        // print_r($ts_mail_errors);
        // print_r($to);
        // print_r($subject);
        // print_r($message);
        // print_r($headers);

        echo '<div class="form-errors">';
          echo '<p>There was an error sending your form.  Please try again.</p>';
        echo '</div>';

      } else {
        $formSent = true;
      }
    }
  }

?>


<div class="contact-form">
  <?php if (isset($formSent)) : ?>

    <div class="contact-success">
      <h1 class="success">Thank you!</h1>
      <p>We have received your message and will be in touch.</p>
    </div>

  <?php else : ?>

    <form method="post" action="<?php the_permalink(); ?>">
      <input type="hidden" name="action" value="contact-submit" />
      <?php wp_nonce_field( 'aero_contact_submit' ); ?>

      <p class="form-field input-textarea">
        <label for="aero_message">Message<span class="req">*</span></label>
        <textarea name="aero_message" id="aero_message" placeholder="Your message"><?php echo !empty($_POST['aero_message']) ? $_POST['aero_message'] : ""; ?></textarea>
      </p>

      <p class="form-field input-text">
        <label for="aero_name">Name<span class="req">*</span></label>
        <input type="text" name="aero_name" id="aero_name" placeholder="Your name" value="<?php echo !empty($_POST['aero_name']) ? $_POST['aero_name'] : ""; ?>" />
      </p>

      <p class="form-field input-text">
        <label for="aero_email">Email<span class="req">*</span></label>
        <input type="text" name="aero_email" id="aero_email" placeholder="john@appleseed.com" value="<?php echo !empty($_POST['aero_email']) ? $_POST['aero_email'] : ""; ?>" />
      </p>

      <p class="form-field input-text">
        <label for="aero_phonenumber">Phone Number</label>
        <input type="text" name="aero_phonenumber" id="aero_phonenumber" placeholder="218-454-8321" value="<?php echo !empty($_POST['aero_phonenumber']) ? $_POST['aero_phonenumber'] : ""; ?>" />
      </p>

      <div class="captcha-wrapper">
        <div class="g-recaptcha" data-sitekey="<?php echo $captcha_site_key; ?>"></div>
      </div>

      <p class="submit">
        <input type="submit" class="button" value="Send Message" />
      </p>
    </form>

  <?php endif; ?>

</div>

<?php
  $output = ob_get_clean();
  return $output;