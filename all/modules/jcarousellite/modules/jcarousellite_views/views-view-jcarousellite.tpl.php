<?php
// $Id: views-view-jcarousellite.tpl.php,v 1.1.2.5 2009/12/01 22:34:06 owahab Exp $
/**
 * @file views-view-jcarousellite.tpl.php
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
<div class="jcarousellite jcarousellite-<?php print $view->vid; ?> jcarousellite-<?php print $view->vid; ?>-<?php print $options['counter']; ?>">
  <div class="jcarousellite-prev jcarousellite-prev-<?php print $view->vid; ?> jcarousellite-prev-<?php print $view->vid; ?>-<?php print $options['counter']; ?>">
<?php
print l(
  theme('image', drupal_get_path('module', 'jcarousellite_views') .'/images/prev-horizontal.png',
  '<<',
  t('Scroll back')),
  NULL,
  array(
    'query' => NULL,
    'fragment' => 'sb',
    'absolute' => FALSE,
    'html' => TRUE
  )
);
  ?>
  </div>
	<div class="item-list">
	  <?php if (!empty($title)) : ?>
	    <h3><?php print $title; ?></h3>
	  <?php endif; ?>
	  <<?php print $options['type']; ?>>
	    <?php foreach ($rows as $id => $row): ?>
	      <li class="<?php print $classes[$id]; ?>"><?php print $row; ?></li>
	    <?php endforeach; ?>
	  </<?php print $options['type']; ?>>
	</div>
  <div class="jcarousellite-next jcarousellite-next-<?php print $view->vid; ?> jcarousellite-next-<?php print $view->vid; ?>-<?php print $options['counter']; ?>">
<?php
print l(
  theme('image', drupal_get_path('module', 'jcarousellite_views') .'/images/next-horizontal.png',
  '>>',
  t('Scroll forward')),
  NULL,
  array(
    'query' => NULL,
    'fragment' => 'sf',
    'absolute' => FALSE,
    'html' => TRUE
  )
);
  ?>
  </div>
</div>
