<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for SiteSelectionItem.
 */

?>

<?php ob_start() ;?>

<div class="contact-information">
  <?php if ($contact_name || $contact_title) : ?>
    <p class="name">
      <?php if ($contact_labels) { echo '<span class="label">Contact:</span> '; } ?>
      <?php if ($contact_name) { echo get_option('contact_person_name'); } ?><?php if ($contact_title) { echo ', <span class="title">'. get_option('contact_person_title') .'</span>'; } ?>
    </p>
  <?php endif; ?>

  <?php if ($contact_address) : ?>
    <p class="address">
      <?php if ($contact_labels) { echo '<span class="label">Address:</span> '; } ?>
      <?php echo nl2br(get_option('address')); ?>
    </p>
  <?php endif; ?>

  <?php if ($contact_phone) : ?>
    <?php $phone = get_option('phone_number'); ?>
    <p class="phone">
      <?php if ($contact_labels) { echo '<span class="label">Phone:</span> '; } ?>
      <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
    </p>
  <?php endif; ?>

  <?php if ($contact_email) : ?>
    <?php $email = get_option('email'); ?>
    <p class="email">
      <?php if ($contact_labels) { echo '<span class="label">Email:</span> '; } ?>
      <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
    </p>
  <?php endif; ?>

  <?php if ($contact_twitter) : ?>
    <?php $twitter = get_option('twitter'); ?>
    <?php $twitterURL = 'https://twitter.com/'. preg_replace("/^@/", "", $twitter); ?>
    <p class="twitter">
      <?php if ($contact_labels) { echo '<span class="label">Twitter:</span> '; } ?>
      <a href="<?php echo $twitterURL; ?>"><?php echo $twitter; ?></a>
    </p>
  <?php endif; ?>
</div>

<?php
  $output = ob_get_clean();
  return $output;