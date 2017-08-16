<?php

$get_XML = get_transient( 'punchgroove_xml' );


$xml = getXML();

if (strlen($xml[0]->xml_url) > 1) {
  $value = $xml[0]->xml_url;
  $fieldMapping = $xml[0]->field_to_from;

  $fieldsmapped = json_decode($fieldMapping);

  $rows = getFields($value);

  $fieldRow = '<div id="fieldSets">';
    foreach ($rows as $field) {
     if ($fieldsmapped) {
       foreach ($fieldsmapped as $fkey => $fvalue) {
         if ($field === $fvalue->xml) {
           $fieldValue = $fvalue->human;
           $set = 'mapped';
         }
       }
     }

      $fieldRow .= '<div class="left">' . $field . ':</div>' .
                   '<div class="right"><input type="text" value="' . $fieldValue . '" id="' . $field . '" class="fieldAdd"></div>';
                   //'<div class="right">' . $set . '</div>';
      unset($fieldValue);
      $set = ' ';
    }
    $fieldRow .= '<button id="setbutton" value="Save">Save</button>';
  $fieldRow .= '</div>';
}
 else {
  $value = '//';
 }
?>

    <div class="panel panel-info">
      <div class="panel-heading">
          <img src="<?php print plugins_url(); ?>/punchgroove/assets/images/punchgroove.png" width="200px">
       </div>
       <div class="panel-body">

    <div id="xml_button">
      <input type="text" value="<?php print $value; ?>" id="url" size="60">

      <button id="button" value="xml">XML URL</button>

    </div>


    <div id="right">
      <h3>Search XML Mapping</h3>
      <div class="content_result">
        <div id="pagewrap">
          <?php
            print $fieldRow;
          ?>
        </div>
        <div class="datamapping">
        </div>
      </div>
    </div>


    <div class="clear"></div>

    </div>
  </div>



