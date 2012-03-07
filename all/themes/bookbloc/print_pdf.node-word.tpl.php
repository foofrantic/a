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
    <div class="print-logo" style="background-color: #27946A; padding: 5px 0 10px 10px;"><?php print $print['logo']; ?></div>
    <!-- <div style="page-break-before: always;"></div> -->

    <div class="print-site_name"><?php print $print['site_name']; ?></div>
    <hr class="print-hr" />
    
    <?php
      $break1 = strpos( $print['content'], '<div class="field field-type-text field-field-word-full-text"' );
      $synopsis = substr( $print['content'], 0, $break1 );
      $break2 = strpos( $print['content'], '<fieldset class="fieldgroup group-word-cover-image">' );
      $full_text = substr( $print['content'], $break1, $break2 - $break1 );
    ?>

    <h1 class="print-title"><?php print $print['title']; ?></h1>
    <div class="print-content"><?php print $synopsis; ?>
    <br /><br /><br />
    <div class="print-source_url"><?php print $print['source_url']; ?></div>
    <div style="page-break-before: always;"></div>

    <h1 class="print-title"><?php print $print['title']; ?></h1>
    <div class="print-content"><?php print $full_text; ?></div>

    <div class="print-links"><?php // print $print['pfp_links']; ?></div>
  </body>
</html>
