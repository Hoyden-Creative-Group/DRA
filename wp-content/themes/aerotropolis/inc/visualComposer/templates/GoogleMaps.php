<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for Google Maps
 */
?>

<?php ob_start() ;?>

<div id="aero_google_map" class="<?php echo $class; ?> google-map"></div>

<script>
  function initMap() {
    var geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById('aero_google_map'), {
      zoom: <?php echo $zoom; ?>
    });

    geocoder.geocode( { 'address': '<?php echo $map_address; ?>'}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

          var infowindow = new google.maps.InfoWindow(
              { content: '<b><?php echo preg_replace("/'/", "\'", $marker); ?></b>',
                size: new google.maps.Size(250,50)
              });

          var marker = new google.maps.Marker({
              position: results[0].geometry.location,
              map: map,
              title: '<?php echo preg_replace("/'/", "\'", $marker); ?>'
          });

          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
          });
        }
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>&callback=initMap"></script>

<?php
  $output = ob_get_clean();
  return $output;