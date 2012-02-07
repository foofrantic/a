<?php
                                     
function jcarousellite_views_views_plugins() {
  return array(
    'style' => array(
      'jcarousellite' => array(
        'title' => t('jCarousel Lite'),
        'help' => t('Displays lists with next and previous buttons in the famous carousel effect.'),
        'handler' => 'jcarousellite_views_plugin_style',
        'parent' => 'list',
        'uses row plugin' => TRUE,
        'uses fields' => TRUE,
        'uses options' => TRUE,
        'type' => 'normal',
        'theme' => 'views_view_jcarousellite',
      ),
    ),
  );
}

