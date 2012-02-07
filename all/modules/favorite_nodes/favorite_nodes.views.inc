<?php
/**
 * Implementation of hook_views_handlers().
 */
function favorite_nodes_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'favorite_nodes') .'/includes',
    ),
    'handlers' => array(
      /*'favorite_nodes_handler_argument_uid' => array(
        'parent' => 'views_handler_argument_numeric',
      ),*/
      'favorite_nodes_handler_user_count' => array(
        'parent' => 'views_handler_field',
      ),
    ),
  );
}

/**
 * Implementation of hook_views_data().
 */
function favorite_nodes_views_data() {
  $data['favorite_nodes']['table']['group'] = t('Favorite Nodes');
  
  $data['favorite_nodes']['table']['join'] = array(
    'node' => array(
      'field' => 'nid',
      'left_field' => 'nid',
    ),
    'users' => array(
      'field' => 'uid',
      'left_field' => 'uid',
    ),
  );
  
  $data['favorite_nodes']['last'] = array(
    'title' => t('Time Added'),
    'help' => t('Display the date/time the favorite node was added.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
      'help' => t('This filter allows favorite nodes to be filtered by the date and time the user added them. Enter dates in the format: CCYY-MM-DD HH:MM:SS. Enter \'now\' to use the current time. You may enter a delta (in seconds) to the option that will be added to the time; this is most useful when combined with now.'),
    ),
  );
  
  $data['favorite_nodes']['count'] = array(
    'title' => t('Count'),
    'help' => t('Number of times this node was added to favorites by any user.'),
    'real field' => 'nid',
    'field' => array(
      'handler' => 'favorite_nodes_handler_user_count',
      'click sortable' => FALSE,
    ),
  );
  
  $data['favorite_nodes']['uid'] = array(
    'title' => t('User ID'),
    'help' => t('This allows you to filter based on favorites nodes.'),
    'filter' => array(
      'handler' => 'views_handler_filter_user_current',
    ),
    'argument' => array(
      // use favorite nodes handler?
      'handler' => 'views_handler_argument_numeric',
    ),
  );

  return $data;
}