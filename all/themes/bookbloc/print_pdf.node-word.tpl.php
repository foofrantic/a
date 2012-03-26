<?php

/**
 * @file
 * Print module template overriden for PDF version of a Word node
 *
 * @ingroup print
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $print['language']; ?>" xml:lang="<?php print $print['language']; ?>">
  <head>
    <?php print $print['head']; ?>
    <?php print $print['base_href']; ?>
    <title><?php print $print['title']; ?></title>
    <?php print $print['scripts']; ?>
    <?php print $print['sendtoprinter']; ?>
    <?php print $print['robots_meta']; ?>
    <?php print $print['favicon']; ?>
    <?php print $print['css']; ?>
  </head>
  <body>
    <?php if (!empty($print['message'])) {
      print '<div class="print-message">'. $print['message'] .'</div><p />';
    } ?>

    <!-- Replace logo with a biggun to take a whole page -->
    <div class="print-logo" style="background-color: #27946A; padding: 5px 0 10px 10px;">
      <!-- HACK - logo failed to print on the live server so doing
           this instead -->
      <?php // print $print['logo']; ?>
      <?php $logo_src = '../sites/default/files/bookbloc_logo.gif'; ?>
      <img class='print-logo' src="<?php print $logo_src; ?>" alt='Bookbloc' id='logo' />
    </div>
    <!-- <div style="page-break-before: always;"></div> -->

    <div class="print-site_name"><?php print $print['site_name']; ?></div>
    <hr class="print-hr" />
    
    <?php
      $break1 = strpos( $print['content'], '<div class="field field-type-text field-field-word-full-text"' );
      $break2 = strpos( $print['content'], '<fieldset class="fieldgroup group-word-cover-image">' );

      $full_text_field_exists = ( $break1 !== FALSE );
  
      if ( $full_text_field_exists ) {
        $synopsis = substr( $print['content'], 0, $break1 );
        $full_text = substr( $print['content'], $break1, $break2 - $break1 );
      }
      else {
        $synopsis = substr( $print['content'], 0, $break2 );
        $full_text = "";
      }
    ?>

    <?php if ( $full_text_field_exists ): ?>
      <h1 class="print-title"><?php print $print['title']; ?></h1>
      <div class="print-content"><?php print $synopsis; ?>
      <br /><br /><br />
      <div class="print-source_url"><?php print $print['source_url']; ?></div>
      <div style="page-break-before: always;"></div>
      <h1 class="print-title"><?php print $print['title']; ?></h1>
      <div class="print-content"><?php print $full_text; ?></div>
    <?php else: ?>
      <h1 class="print-title"><?php print $print['title']; ?></h1>
      <div class="print-content"><?php print $synopsis; ?>
      <br /><br /><br />
      <div class="print-source_url"><?php print $print['source_url']; ?></div>
    <?php endif; ?>
  </body>
</html>
