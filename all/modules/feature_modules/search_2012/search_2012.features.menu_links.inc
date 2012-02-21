<?php

/**
 * Implementation of hook_menu_default_menu_links().
 */
function search_2012_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: menu-main-menu:search
  $menu_links['menu-main-menu:search'] = array(
    'menu_name' => 'menu-main-menu',
    'link_path' => 'search',
    'router_path' => 'search',
    'link_title' => 'Search',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => '0',
    'external' => '0',
    'has_children' => '0',
    'expanded' => '0',
    'weight' => '0',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Search');


  return $menu_links;
}
