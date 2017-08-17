<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


function mapping_assets() {
    // Leaflet Mapping

    wp_enqueue_style('searchCSS', plugins_url() . "/punchgroove/assets/css/search.css" );
    wp_enqueue_style('searchCSS');

    wp_enqueue_style('leafletCSS', plugins_url() . "/punchgroove/assets/css/leaflet.css" );
    wp_enqueue_style('leafletCSS');

    wp_enqueue_script('jquery');
    wp_enqueue_script('leafletscript',  plugins_url() . "/punchgroove/assets/js/leaflet.js" );
    wp_enqueue_script('tablesorterscript',  plugins_url() . "/punchgroove/assets/js/jquery.tablesorter.min.js" );
    wp_enqueue_script('mappingscript',  plugins_url() . "/punchgroove/assets/js/mapping.js" );
    wp_enqueue_script('search',  plugins_url() . "/punchgroove/assets/js/search.js", '', '1.0', true);
}

add_action( 'wp_enqueue_scripts', 'mapping_assets' );


function saveXML($xml) {
  set_transient( 'punchgroove_xml', $xml, 60*60 );
}


function getGeo($city, $state) {
  $json = file_get_contents(plugins_url() . '/punchgroove/includes/geodata/' . $state . '.json');
  $ob = json_decode($json);
  if (count($ob->result) > 0) {
    foreach ($ob->result as $key => $value) {
      if (strtoupper(trim($city)) === $value->City && $state === $value->State) {
        return preg_replace('/\+/', '', $value->Latitude) . ',' . preg_replace('/\+/', '', $value->Longitude);
      }
    }
  }
}

function getGoogleGeo($city, $state) {
  $city_state = preg_replace('/ /', '', $city . ',' . $state);
  $city_state = preg_replace('/\//', '_', $city_state);
  $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $city_state . '&&key=AIzaSyCERrd1-fjZEBYpXqCTkAM9SvmwnUCD4x4';
  $result = file_get_contents($url);
  $return = json_decode($result, true);
  return $return;
}
