<?php

/**
 * Implementation of hook_views_default_views().
 */
function search_2012_views_default_views() {
  $views = array();

  // Exported view: Search
  $view = new view;
  $view->name = 'Search';
  $view->description = 'search';
  $view->tag = '';
  $view->base_table = 'node';
  $view->core = 0;
  $view->api_version = '2';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('relationships', array(
    'votingapi_cache' => array(
      'label' => 'Vote results',
      'required' => 0,
      'votingapi' => array(
        'value_type' => '',
        'tag' => '',
        'function' => '',
      ),
      'id' => 'votingapi_cache',
      'table' => 'node',
      'field' => 'votingapi_cache',
      'relationship' => 'none',
    ),
  ));
  $handler->override_option('fields', array(
    'title' => array(
      'label' => 'Title',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'absolute' => 0,
        'link_class' => '',
        'alt' => '',
        'rel' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'hide_alter_empty' => 1,
      'link_to_node' => 1,
      'exclude' => 0,
      'id' => 'title',
      'table' => 'node',
      'field' => 'title',
      'relationship' => 'none',
    ),
    'name' => array(
      'label' => 'Author',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'absolute' => 0,
        'link_class' => '',
        'alt' => '',
        'rel' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'hide_alter_empty' => 1,
      'link_to_user' => 1,
      'overwrite_anonymous' => 0,
      'anonymous_text' => '',
      'exclude' => 0,
      'id' => 'name',
      'table' => 'users',
      'field' => 'name',
      'relationship' => 'none',
    ),
    'created' => array(
      'label' => 'Date',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'absolute' => 0,
        'link_class' => '',
        'alt' => '',
        'rel' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'hide_alter_empty' => 1,
      'date_format' => 'medium',
      'custom_date_format' => '',
      'exclude' => 0,
      'id' => 'created',
      'table' => 'node',
      'field' => 'created',
      'relationship' => 'none',
    ),
    'totalcount' => array(
      'label' => 'Views',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'absolute' => 0,
        'link_class' => '',
        'alt' => '',
        'rel' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'hide_alter_empty' => 1,
      'set_precision' => FALSE,
      'precision' => 0,
      'decimal' => '.',
      'separator' => ',',
      'format_plural' => 0,
      'format_plural_singular' => '1',
      'format_plural_plural' => '@count',
      'prefix' => '',
      'suffix' => '',
      'exclude' => 0,
      'id' => 'totalcount',
      'table' => 'node_counter',
      'field' => 'totalcount',
      'relationship' => 'none',
    ),
    'comment_count' => array(
      'label' => 'Comments',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'absolute' => 0,
        'link_class' => '',
        'alt' => '',
        'rel' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'hide_alter_empty' => 1,
      'set_precision' => FALSE,
      'precision' => 0,
      'decimal' => '.',
      'separator' => ',',
      'format_plural' => 0,
      'format_plural_singular' => '1',
      'format_plural_plural' => '@count',
      'prefix' => '',
      'suffix' => '',
      'exclude' => 0,
      'id' => 'comment_count',
      'table' => 'node_comment_statistics',
      'field' => 'comment_count',
      'relationship' => 'none',
    ),
    'value' => array(
      'label' => 'Rating',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'absolute' => 0,
        'link_class' => '',
        'alt' => '',
        'rel' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'hide_alter_empty' => 1,
      'set_precision' => 1,
      'precision' => '2',
      'decimal' => '.',
      'separator' => ',',
      'format_plural' => 1,
      'format_plural_singular' => '1',
      'format_plural_plural' => '@count',
      'prefix' => '',
      'suffix' => '',
      'appearance' => 'fivestar_views_value_display_handler',
      'exclude' => 0,
      'id' => 'value',
      'table' => 'votingapi_cache',
      'field' => 'value',
      'relationship' => 'votingapi_cache',
    ),
  ));
  $handler->override_option('sorts', array(
    'totalcount' => array(
      'order' => 'DESC',
      'id' => 'totalcount',
      'table' => 'node_counter',
      'field' => 'totalcount',
      'override' => array(
        'button' => 'Override',
      ),
      'relationship' => 'none',
    ),
    'name' => array(
      'id' => 'name',
      'table' => 'users',
      'field' => 'name',
    ),
  ));
  $handler->override_option('filters', array(
    'type' => array(
      'operator' => 'in',
      'value' => array(
        'word' => 'word',
      ),
      'group' => '0',
      'exposed' => FALSE,
      'expose' => array(
        'operator' => FALSE,
        'label' => '',
      ),
      'id' => 'type',
      'table' => 'node',
      'field' => 'type',
      'override' => array(
        'button' => 'Override',
      ),
      'relationship' => 'none',
    ),
    'keys' => array(
      'operator' => 'optional',
      'value' => '',
      'group' => '0',
      'exposed' => TRUE,
      'expose' => array(
        'use_operator' => 0,
        'operator' => 'keys_op',
        'identifier' => 'search_terms',
        'label' => 'Search',
        'optional' => 1,
        'remember' => 0,
      ),
      'id' => 'keys',
      'table' => 'search_index',
      'field' => 'keys',
      'relationship' => 'none',
    ),
    'uid' => array(
      'operator' => 'in',
      'value' => '',
      'group' => '0',
      'exposed' => TRUE,
      'expose' => array(
        'use_operator' => 0,
        'operator' => 'uid_op',
        'identifier' => 'author',
        'label' => 'Author',
        'optional' => 1,
        'remember' => 0,
        'reduce' => 0,
      ),
      'id' => 'uid',
      'table' => 'users',
      'field' => 'uid',
      'relationship' => 'none',
    ),
    'vid' => array(
      'operator' => 'in',
      'value' => array(
        1 => '1',
      ),
      'group' => '0',
      'exposed' => FALSE,
      'expose' => array(
        'operator' => FALSE,
        'label' => '',
      ),
      'id' => 'vid',
      'table' => 'term_data',
      'field' => 'vid',
      'relationship' => 'none',
    ),
    'name' => array(
      'operator' => 'contains',
      'value' => '',
      'group' => '0',
      'exposed' => TRUE,
      'expose' => array(
        'use_operator' => 0,
        'operator' => 'name_op',
        'identifier' => 'genre',
        'label' => 'Genre',
        'remember' => 0,
      ),
      'case' => 0,
      'id' => 'name',
      'table' => 'term_data',
      'field' => 'name',
      'relationship' => 'none',
    ),
  ));
  $handler->override_option('access', array(
    'type' => 'perm',
    'perm' => 'access content',
  ));
  $handler->override_option('cache', array(
    'type' => 'none',
  ));
  $handler->override_option('use_ajax', TRUE);
  $handler->override_option('items_per_page', 0);
  $handler->override_option('use_pager', '1');
  $handler->override_option('distinct', 1);
  $handler->override_option('style_plugin', 'table');
  $handler->override_option('style_options', array(
    'grouping' => '',
    'override' => 1,
    'sticky' => 0,
    'order' => 'asc',
    'summary' => '',
    'columns' => array(
      'title' => 'title',
      'name' => 'name',
      'created' => 'created',
      'totalcount' => 'totalcount',
      'comment_count' => 'comment_count',
      'value' => 'value',
    ),
    'info' => array(
      'title' => array(
        'sortable' => 0,
        'separator' => '',
      ),
      'name' => array(
        'sortable' => 1,
        'separator' => '',
      ),
      'created' => array(
        'sortable' => 1,
        'separator' => '',
      ),
      'totalcount' => array(
        'sortable' => 1,
        'separator' => '',
      ),
      'comment_count' => array(
        'sortable' => 1,
        'separator' => '',
      ),
      'value' => array(
        'sortable' => 1,
        'separator' => '',
      ),
    ),
    'default' => '-1',
  ));
  $handler = $view->new_display('page', 'Page', 'page_1');
  $handler->override_option('path', 'search');
  $handler->override_option('menu', array(
    'type' => 'none',
    'title' => '',
    'description' => '',
    'weight' => 0,
    'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
    'type' => 'none',
    'title' => '',
    'description' => '',
    'weight' => 0,
    'name' => 'navigation',
  ));
  $handler = $view->new_display('block', 'Block', 'block_1');
  $handler->override_option('block_description', '');
  $handler->override_option('block_caching', -1);

  $views[$view->name] = $view;

  return $views;
}
