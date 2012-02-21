<?php
// $Id: views-view.tpl.php,v 1.10 2008/09/22 20:50:58 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>
<table class="myTable">

<thead>
<tr>
<th class="itemlong header">Title</th>
<th class="item header">Author</th>
<th class="item header">Date</th>
<th class="item header">Views&nbsp;</th>
<th class="item header">Comments&nbsp;</th>
<th class="item header">Rating&nbsp;</th>
</tr>
<thead>

</div class="clear"></div>



  <div class="clear"></div>
  <?php if ($rows): ?>
<tbody>
      <?php print $rows; ?>
</tbody>
</table>

  <?php endif;?>
  
  <p>&nbsp;</p>
  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>



 <?php // class view ?>
