<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

class PunchGroove_Admin {

  public function __construct() {
    add_action('admin_init', array( $this, 'wp_punchgroove_admin_init'));
    add_action('admin_init', array( $this, 'admin_scripts_style'));
    add_action('admin_menu', array( $this, 'admin_menu'));
  }

  public function admin_scripts_style() {
    if (isset($_REQUEST['page'])) {
      if ($_REQUEST['page'] == "punchgroove") {

        wp_enqueue_style('punchgrooveCSS', plugins_url() . "/punchgroove/assets/css/punchgroove.css" );
        wp_enqueue_style('punchgrooveCSS');

        // wp_enqueue_script('jquery');
        wp_enqueue_script('punchgrooveJS',  plugins_url() . "/punchgroove/assets/js/punchgroove.js" );
        wp_enqueue_script('punchgrooveJS');

        add_action( 'wp_enqueue_scripts', 'punchgrooveJS' );
      }
    }

  }


  public function admin_menu() {
    $page = add_management_page('Punch Groove', 'Punch Groove ', 'manage_options', 'punchgroove', array( $this,'wp_punchgroove_settings_page'));
  }


  function wp_punchgroove_admin_init() {
    if(is_admin()){
      //print plugins_url() . '<br>';
    }
  }

  public function wp_punchgroove_settings_page(){
    include('functions.php');
    include('punchgroove_admin.tpl.php');

  }

}


return new PunchGroove_Admin();


function getXML() {
  global $wpdb;
  $sql = 'SELECT xml_url, field_to_from FROM ' . $wpdb->prefix . 'punchgroove ORDER BY TIME DESC LIMIT 1';
  $xml = $wpdb->get_results($sql);
  return $xml;
}



function getFields($item) {
  $rows = [];
  $xml = json_decode(file_get_contents($item));

  foreach ($xml as $key => $state) {
    foreach ($state as $obj => $detail) {
      if ($obj == 0) {
        foreach ($detail as $row => $job) {
          $rows[] = $row;
        }
      }
    }
  }
  return $rows;
}


function getContent($url) {
  $xml = json_decode(file_get_contents($url));
  return $xml;
}
