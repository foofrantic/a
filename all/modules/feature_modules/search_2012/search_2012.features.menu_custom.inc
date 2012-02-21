<?php

/**
 * Implementation of hook_menu_default_menu_custom().
 */
function search_2012_menu_default_menu_custom() {
  $menus = array();

  // Exported menu: menu-main-menu
  $menus['menu-main-menu'] = array(
    'menu_name' => 'menu-main-menu',
    'title' => 'Main Menu',
    'description' => '',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Main Menu');


  return $menus;
}
