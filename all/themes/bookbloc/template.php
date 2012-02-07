<?php
// $Id: template.php,v 1.1.2.5 2008/12/03 08:22:45 jwolf Exp $

/**
 * Force refresh of theme registry.
 * DEVELOPMENT USE ONLY - COMMENT OUT FOR PRODUCTION
 */
// drupal_rebuild_theme_registry();

/**
 * Initialize theme settings
 */
if (is_null(theme_get_setting('user_notverified_display'))) {
  global $theme_key;
  // Get node types
  $node_types = node_get_types('names');
  
  /**
   * The default values for the theme variables. Make sure $defaults exactly
   * matches the $defaults in the theme-settings.php file.
   */
  $defaults = array(
    'user_notverified_display'              => 1,
    'breadcrumb_display'                    => 0,
    'search_snippet'                        => 1,
    'search_info_type'                      => 1,
    'search_info_user'                      => 1,
    'search_info_date'                      => 1,
    'search_info_comment'                   => 1,
    'search_info_upload'                    => 1,
    'mission_statement_pages'               => 'home',
    'front_page_title_display'              => 'title_slogan',
    'page_title_display_custom'             => '',
    'other_page_title_display'              => 'ptitle_slogan',
    'other_page_title_display_custom'       => '',
    'configurable_separator'                => ' | ',
    'meta_keywords'                         => '',
    'meta_description'                      => '',
    'taxonomy_display_default'              => 'only',
    'taxonomy_format_default'               => 'vocab',
    'taxonomy_enable_content_type'          => 0,
    'submitted_by_author_default'           => 1,
    'submitted_by_date_default'             => 1,
    'submitted_by_enable_content_type'      => 0,
    'readmore_default'                      => t('Read more'),
    'readmore_title_default'                => t('Read the rest of this posting.'),
    'readmore_prefix_default'               => '',
    'readmore_suffix_default'               => '',
    'readmore_enable_content_type'          => 0,
    'comment_singular_default'              => t('1 comment'),
    'comment_plural_default'                => t('@count comments'),
    'comment_title_default'                 => t('Jump to the first comment of this posting.'),
    'comment_prefix_default'                => '',
    'comment_suffix_default'                => '',
    'comment_new_singular_default'          => t('1 new comment'),
    'comment_new_plural_default'            => t('@count new comments'),
    'comment_new_title_default'             => t('Jump to the first new comment of this posting.'),
    'comment_new_prefix_default'            => '',
    'comment_new_suffix_default'            => '',
    'comment_add_default'                   => t('Add new comment'),
    'comment_add_title_default'             => t('Add a new comment to this page.'),
    'comment_add_prefix_default'            => '',
    'comment_add_suffix_default'            => '',
    'comment_node_default'                  => t('Add new comment'),
    'comment_node_title_default'            => t('Share your thoughts and opinions related to this posting.'),
    'comment_node_prefix_default'           => '',
    'comment_node_suffix_default'           => '',
    'comment_enable_content_type'           => 0,
  );
  
  // Make the default content-type settings the same as the default theme settings,
  // so we can tell if content-type-specific settings have been altered.
  $defaults = array_merge($defaults, theme_get_settings());
  
  // Set the default values for content-type-specific settings
  foreach ($node_types as $type => $name) {
    $defaults["taxonomy_display_{$type}"]         = $defaults['taxonomy_display_default'];
    $defaults["taxonomy_format_{$type}"]          = $defaults['taxonomy_format_default'];
    $defaults["submitted_by_author_{$type}"]      = $defaults['submitted_by_author_default'];
    $defaults["submitted_by_date_{$type}"]        = $defaults['submitted_by_date_default'];
    $defaults["readmore_{$type}"]                 = $defaults['readmore_default'];
    $defaults["readmore_title_{$type}"]           = $defaults['readmore_title_default'];
    $defaults["readmore_prefix_{$type}"]          = $defaults['readmore_prefix_default'];
    $defaults["readmore_suffix_{$type}"]          = $defaults['readmore_suffix_default'];
    $defaults["comment_singular_{$type}"]         = $defaults['comment_singular_default'];
    $defaults["comment_plural_{$type}"]           = $defaults['comment_plural_default'];
    $defaults["comment_title_{$type}"]            = $defaults['comment_title_default'];
    $defaults["comment_prefix_{$type}"]           = $defaults['comment_prefix_default'];
    $defaults["comment_suffix_{$type}"]           = $defaults['comment_suffix_default'];
    $defaults["comment_new_singular_{$type}"]     = $defaults['comment_new_singular_default'];
    $defaults["comment_new_plural_{$type}"]       = $defaults['comment_new_plural_default'];
    $defaults["comment_new_title_{$type}"]        = $defaults['comment_new_title_default'];
    $defaults["comment_new_prefix_{$type}"]       = $defaults['comment_new_prefix_default'];
    $defaults["comment_new_suffix_{$type}"]       = $defaults['comment_new_suffix_default'];
    $defaults["comment_add_{$type}"]              = $defaults['comment_add_default'];
    $defaults["comment_add_title_{$type}"]        = $defaults['comment_add_title_default'];
    $defaults["comment_add_prefix_{$type}"]       = $defaults['comment_add_prefix_default'];
    $defaults["comment_add_suffix_{$type}"]       = $defaults['comment_add_suffix_default'];
    $defaults["comment_node_{$type}"]             = $defaults['comment_node_default'];
    $defaults["comment_node_title_{$type}"]       = $defaults['comment_node_title_default'];
    $defaults["comment_node_prefix_{$type}"]      = $defaults['comment_node_prefix_default'];
    $defaults["comment_node_suffix_{$type}"]      = $defaults['comment_node_suffix_default'];
  }
  
  // Get default theme settings.
  $settings = theme_get_settings($theme_key);
  
  // If content type-specifc settings are not enabled, reset the values
  if (!$settings['readmore_enable_content_type']) {
    foreach ($node_types as $type => $name) {
      $settings["readmore_{$type}"]                    = $settings['readmore_default'];
      $settings["readmore_title_{$type}"]              = $settings['readmore_title_default'];
      $settings["readmore_prefix_{$type}"]             = $settings['readmore_prefix_default'];
      $settings["readmore_suffix_{$type}"]             = $settings['readmore_suffix_default'];
    }
  }
  if (!$settings['comment_enable_content_type']) {
    foreach ($node_types as $type => $name) {
      $defaults["comment_singular_{$type}"]         = $defaults['comment_singular_default'];
      $defaults["comment_plural_{$type}"]           = $defaults['comment_plural_default'];
      $defaults["comment_title_{$type}"]            = $defaults['comment_title_default'];
      $defaults["comment_prefix_{$type}"]           = $defaults['comment_prefix_default'];
      $defaults["comment_suffix_{$type}"]           = $defaults['comment_suffix_default'];
      $defaults["comment_new_singular_{$type}"]     = $defaults['comment_new_singular_default'];
      $defaults["comment_new_plural_{$type}"]       = $defaults['comment_new_plural_default'];
      $defaults["comment_new_title_{$type}"]        = $defaults['comment_new_title_default'];
      $defaults["comment_new_prefix_{$type}"]       = $defaults['comment_new_prefix_default'];
      $defaults["comment_new_suffix_{$type}"]       = $defaults['comment_new_suffix_default'];
      $defaults["comment_add_{$type}"]              = $defaults['comment_add_default'];
      $defaults["comment_add_title_{$type}"]        = $defaults['comment_add_title_default'];
      $defaults["comment_add_prefix_{$type}"]       = $defaults['comment_add_prefix_default'];
      $defaults["comment_add_suffix_{$type}"]       = $defaults['comment_add_suffix_default'];
      $defaults["comment_node_{$type}"]             = $defaults['comment_node_default'];
      $defaults["comment_node_title_{$type}"]       = $defaults['comment_node_title_default'];
      $defaults["comment_node_prefix_{$type}"]      = $defaults['comment_node_prefix_default'];
      $defaults["comment_node_suffix_{$type}"]      = $defaults['comment_node_suffix_default'];
    }
  }
  
  // Don't save the toggle_node_info_ variables
  if (module_exists('node')) {
    foreach (node_get_types() as $type => $name) {
      unset($settings['toggle_node_info_'. $type]);
    }
  }
  // Save default theme settings
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, $settings)
  );
  // Force refresh of Drupal internals
  theme_get_setting('', TRUE);
}
/**
 * Modify theme variables
 */
function phptemplate_preprocess(&$vars) {
  global $user;                                            // Get the current user
  $vars['is_admin'] = in_array('admin', $user->roles);     // Check for Admin, logged in
  $vars['logged_in'] = ($user->uid > 0) ? TRUE : FALSE;
}


function bookbloc_archive_navigation($type, $date) {
  $output  = "<div id=\"archive-container\"><dl><dt>". t('Date') ."</dt><dd>\n";
  $output .= theme('archive_navigation_years', $type, $date);
  if (_archive_validate_date($date->year)) {
    $output .= theme('archive_navigation_months', $type, $date);
  }
  if (_archive_validate_date($date->year, $date->month)) {
    $output .= theme('archive_navigation_days', $type, $date);
  }
  $output .= "</dd>";
  
  // Only display node type filter if more than one node type represented
  if (sizeof(_archive_node_types($date)) > 1) {
    $output .= "<dt>". t('Type') ."</dt><dd>\n";
    $output .= theme('archive_navigation_node_types', $type, $date);
    $output .= "</dd>";
  }
  $output .= "</dl></div>\n";
  return $output;
}

function phptemplate_preprocess_page(&$vars) {
  // Remove sidebars if disabled
  if (!$vars['show_blocks']) {
    $vars['sidebar_first'] = '';
    $vars['sidebar_last'] = '';
  }
  // Build array of helpful body classes
  $body_classes = array();
  $body_classes[] = ($vars['logged_in']) ? 'logged-in' : 'not-logged-in';                                 // Page user is logged in
  $body_classes[] = ($vars['is_front']) ? 'front' : 'not-front';                                          // Page is front page
  if (isset($vars['node'])) {
    $body_classes[] = ($vars['node']) ? 'full-node' : '';                                                   // Page is one full node
    $body_classes[] = (($vars['node']->type == 'forum') || (arg(0) == 'forum')) ? 'forum' : '';             // Page is Forum page
    $body_classes[] = ($vars['node']->type) ? 'node-type-'. $vars['node']->type : '';                       // Page has node-type-x, e.g., node-type-page
  }
  else {
    $body_classes[] = (arg(0) == 'forum') ? 'forum' : '';                                                   // Page is Forum page
  }
  $body_classes[] = (module_exists('panels_page') && (panels_page_get_current())) ? 'panels' : '';        // Page is Panels page
  $body_classes[] = 'layout-'. (($vars['sidebar_first']) ? 'first-main' : 'main') . (($vars['sidebar_last']) ? '-last' : '');  // Page sidebars are active
  if ($vars['preface_first'] || $vars['preface_middle'] || $vars['preface_last']) {                       // Preface regions are active
    $preface_regions = 'preface';
    $preface_regions .= ($vars['preface_first']) ? '-first' : '';
    $preface_regions .= ($vars['preface_middle']) ? '-middle' : '';
    $preface_regions .= ($vars['preface_last']) ? '-last' : '';
    $body_classes[] = $preface_regions;
  }
  if ($vars['postscript_first'] || $vars['postscript_middle'] || $vars['postscript_last']) {              // Postscript regions are active
    $postscript_regions = 'postscript';
    $postscript_regions .= ($vars['postscript_first']) ? '-first' : '';
    $postscript_regions .= ($vars['postscript_middle']) ? '-middle' : '';
    $postscript_regions .= ($vars['postscript_last']) ? '-last' : '';
    $body_classes[] = $postscript_regions;
  }
  $body_classes = array_filter($body_classes);                                                            // Remove empty elements
  $vars['body_classes'] = implode(' ', $body_classes);                                                    // Create class list separated by spaces

  // Add preface & postscript classes with number of active sub-regions
  $region_list = array(
    'prefaces' => array('preface_first', 'preface_middle', 'preface_last'), 
    'postscripts' => array('postscript_first', 'postscript_middle', 'postscript_last')
  );
  foreach ($region_list as $sub_region_key => $sub_region_list) {
    $active_regions = array();
    foreach ($sub_region_list as $region_item) {
      if ($vars[$region_item]) {
        $active_regions[] = $region_item;
      }
    }
    $vars[$sub_region_key] = $sub_region_key .'-'. strval(count($active_regions));
  }

  // TNT THEME SETTINGS SECTION
  // Display mission statement on all pages
  if (theme_get_setting('mission_statement_pages') == 'all') {
    $vars['mission'] = theme_get_setting('mission', false);  
  }
  
  // Hide breadcrumb on all pages
  if (theme_get_setting('breadcrumb_display') == 0) {
    $vars['breadcrumb'] = '';  
  }
  
  // Set site title, slogan, mission, page title & separator
  $title = t(variable_get('site_name', ''));
  $slogan = t(variable_get('site_slogan', ''));
  $mission = t(variable_get('site_mission', ''));
  $page_title = t(drupal_get_title());
  $title_separator = theme_get_setting('configurable_separator');
  if (drupal_is_front_page()) {                                                // Front page title settings
    switch (theme_get_setting('front_page_title_display')) {
      case 'title_slogan':
        $vars['head_title'] = drupal_set_title($title . $title_separator . $slogan);
        break;
      case 'slogan_title':
        $vars['head_title'] = drupal_set_title($slogan . $title_separator . $title);
        break;
      case 'title_mission':
        $vars['head_title'] = drupal_set_title($title . $title_separator . $mission);
        break;
      case 'custom':
        if (theme_get_setting('page_title_display_custom') !== '') {
          $vars['head_title'] = drupal_set_title(t(theme_get_setting('page_title_display_custom')));
        }
    }
  }
  else {                                                                       // Non-front page title settings
    switch (theme_get_setting('other_page_title_display')) {
      case 'ptitle_slogan':
        $vars['head_title'] = drupal_set_title($page_title . $title_separator . $slogan);
        break;
      case 'ptitle_stitle':
        $vars['head_title'] = drupal_set_title($page_title . $title_separator . $title);
        break;
      case 'ptitle_smission':
        $vars['head_title'] = drupal_set_title($page_title . $title_separator . $mission);
        break;
      case 'ptitle_custom':
        if (theme_get_setting('other_page_title_display_custom') !== '') {
          $vars['head_title'] = drupal_set_title($page_title . $title_separator . t(theme_get_setting('other_page_title_display_custom')));
        }
        break;
      case 'custom':
        if (theme_get_setting('other_page_title_display_custom') !== '') {
          $vars['head_title'] = drupal_set_title(t(theme_get_setting('other_page_title_display_custom')));
        }
    }
  }
  $vars['head_title'] = strip_tags($vars['head_title']);                       // Remove any potential html tags
  
  if (!module_exists('nodewords')) {
    if (theme_get_setting('meta_keywords') !== '') {
      $keywords = '<meta name="keywords" content="'. theme_get_setting('meta_keywords') .'" />';
      $vars['head'] .= $keywords ."\n";
    } 
    if (theme_get_setting('meta_description') !== '') {
      $keywords = '<meta name="description" content="'. theme_get_setting('meta_description') .'" />';
      $vars['head'] .= $keywords ."\n";
    } 
  }
  $vars['closure'] .= '';
}


function phptemplate_preprocess_block(&$vars) {
  // Add regions with rounded blocks (e.g., sidebar_first, sidebar_last) to $rounded_regions array
  $rounded_regions = array('sidebar_first','sidebar_last','postscript_first','postscript_middle','postscript_last');
  $vars['rounded_block'] = (in_array($vars['block']->region, $rounded_regions)) ? TRUE : FALSE;
}


function phptemplate_preprocess_node(&$vars) {
  // Build array of handy node classes
  $node_classes = array();
  $node_classes[] = $vars['zebra'];                                      // Node is odd or even
  $node_classes[] = (!$vars['node']->status) ? 'node-unpublished' : '';  // Node is unpublished
  $node_classes[] = ($vars['sticky']) ? 'sticky' : '';                   // Node is sticky
  $node_classes[] = (isset($vars['node']->teaser)) ? 'teaser' : 'full-node';    // Node is teaser or full-node
  $node_classes[] = 'node-type-'. $vars['node']->type;                   // Node is type-x, e.g., node-type-page
  $node_classes = array_filter($node_classes);                           // Remove empty elements
  $vars['node_classes'] = implode(' ', $node_classes);                   // Implode class list with spaces
  
  // Add node_bottom region content
  $vars['node_bottom'] = theme('blocks', 'node_bottom');

  // Add node template suggestions, in reverse order: last in, first tried
  if ($vars['page']) {
    $vars['template_files'] = array('node-'. $vars['node']->type, 'node-'. $vars['node']->nid, 'node-'. $vars['node']->type .'-page', 'node-'. $vars['node']->nid .'-page');
  }
  else {
    $vars['template_files'] = array('node-'. $vars['node']->type, 'node-'. $vars['node']->nid);
  }
  
  // Node Theme Settings
  
  // Date & author
  $date = t('Posted ') . format_date($vars['node']->created, 'medium');                 // Format date as small, medium, or large
  $author = theme('username', $vars['node']);
  $author_only_separator = t('Posted by ');
  $author_date_separator = t(' by ');
  $submitted_by_content_type = (theme_get_setting('submitted_by_enable_content_type') == 1) ? $vars['node']->type : 'default';
  $date_setting = (theme_get_setting('submitted_by_date_'. $submitted_by_content_type) == 1);
  $author_setting = (theme_get_setting('submitted_by_author_'. $submitted_by_content_type) == 1);
  $author_separator = ($date_setting) ? $author_date_separator : $author_only_separator;
  $date_author = ($date_setting) ? $date : '';
  $date_author .= ($author_setting) ? $author_separator . $author : '';
  $vars['submitted'] = $date_author;

  // Taxonomy
  $taxonomy_content_type = (theme_get_setting('taxonomy_enable_content_type') == 1) ? $vars['node']->type : 'default';
  $taxonomy_display = theme_get_setting('taxonomy_display_'. $taxonomy_content_type);
  $taxonomy_format = theme_get_setting('taxonomy_format_'. $taxonomy_content_type);
  if ((module_exists('taxonomy')) && ($taxonomy_display == 'all' || ($taxonomy_display == 'only' && $vars['page']))) {
    $vocabularies = taxonomy_get_vocabularies($vars['node']->type);
    $output = '';
    foreach ($vocabularies as $vocabulary) {
      $vocab_name_safe = str_replace(' ', '_', $vocabulary->name);
      if (theme_get_setting('taxonomy_vocab_display_'. $taxonomy_content_type .'_'. $vocab_name_safe) == 1) {
        $terms = taxonomy_node_get_terms_by_vocabulary($vars['node'], $vocabulary->vid);
        if ($terms) {
          $output .= ($taxonomy_format == 'vocab') ? '<li class="vocab '. $vocab_name_safe .'"><span class="vocab-name">'. $vocabulary->name .':</span> <ul class="vocab-list">' : '';
          $links = array();
          foreach ($terms as $term) {        
            $links[] = '<li class="vocab-term">'. l($term->name, taxonomy_term_path($term), array('attributes' => array('rel' => 'tag', 'title' => strip_tags($term->description)))) .'</li>';        
          }
          $output .= implode(", ", $links);
          $output .= ($taxonomy_format == 'vocab') ? '</ul></li>' : '';
          $output .= (($vocabulary !== end($vocabularies)) && $taxonomy_format == 'list') ? ', ' : '';
        }
      }
    }
    if ($output != '') {
      $output = '<ul class="taxonomy">'. $output .'</ul>';
    }
    $vars['terms'] = $output;
  }
  else {
    $vars['terms'] = '';
  }
  
  // Node Links
  if (isset($vars['node']->links['node_read_more'])) {
    $node_content_type = (theme_get_setting('readmore_enable_content_type') == 1) ? $vars['node']->type : 'default';
    $vars['node']->links['node_read_more'] = array(
      'title' => _themesettings_link(
      theme_get_setting('readmore_prefix_'. $node_content_type),
      theme_get_setting('readmore_suffix_'. $node_content_type),
      theme_get_setting('readmore_'. $node_content_type),
      'node/'. $vars['node']->nid,
      array(
        'attributes' => array('title' => theme_get_setting('readmore_title_'. $node_content_type)), 
        'query' => NULL, 'fragment' => NULL, 'absolute' => FALSE, 'html' => TRUE
      )
      ),
      'attributes' => array('class' => 'readmore-item'),
      'html' => TRUE,
    );
  }
  if (isset($vars['node']->links['comment_add'])) {
    $node_content_type = (theme_get_setting('comment_enable_content_type') == 1) ? $vars['node']->type : 'default';
    if ($vars['teaser']) {
      $vars['node']->links['comment_add'] = array(
        'title' => _themesettings_link(
        theme_get_setting('comment_add_prefix_'. $node_content_type),
        theme_get_setting('comment_add_suffix_'. $node_content_type),
        theme_get_setting('comment_add_'. $node_content_type),
        "comment/reply/".$vars['node']->nid,
        array(
          'attributes' => array('title' => theme_get_setting('comment_add_title_'. $node_content_type)), 
          'query' => NULL, 'fragment' => 'comment-form', 'absolute' => FALSE, 'html' => TRUE
        )
        ),
        'attributes' => array('class' => 'comment-add-item'),
        'html' => TRUE,
      );
    }
    else {
      $vars['node']->links['comment_add'] = array(
        'title' => _themesettings_link(
        theme_get_setting('comment_node_prefix_'. $node_content_type),
        theme_get_setting('comment_node_suffix_'. $node_content_type),
        theme_get_setting('comment_node_'. $node_content_type),
        "comment/reply/".$vars['node']->nid,
        array(
          'attributes' => array('title' => theme_get_setting('comment_node_title_'. $node_content_type)), 
          'query' => NULL, 'fragment' => 'comment-form', 'absolute' => FALSE, 'html' => TRUE
        )
        ),
        'attributes' => array('class' => 'comment-node-item'),
        'html' => TRUE,
      );
    }
  }
  if (isset($vars['node']->links['comment_new_comments'])) {
    $node_content_type = (theme_get_setting('comment_enable_content_type') == 1) ? $vars['node']->type : 'default';
    $vars['node']->links['comment_new_comments'] = array(
      'title' => _themesettings_link(
        theme_get_setting('comment_new_prefix_'. $node_content_type),
        theme_get_setting('comment_new_suffix_'. $node_content_type),
        format_plural(
          comment_num_new($vars['node']->nid),
          theme_get_setting('comment_new_singular_'. $node_content_type),
          theme_get_setting('comment_new_plural_'. $node_content_type)
        ),
      "node/".$vars['node']->nid,
      array(
          'attributes' => array('title' => theme_get_setting('comment_new_title_'. $node_content_type)), 
        'query' => NULL, 'fragment' => 'new', 'absolute' => FALSE, 'html' => TRUE
      )
      ),
      'attributes' => array('class' => 'comment-new-item'),
      'html' => TRUE,
    );
  }
  if (isset($vars['node']->links['comment_comments'])) {
    $node_content_type = (theme_get_setting('comment_enable_content_type') == 1) ? $vars['node']->type : 'default';
    $vars['node']->links['comment_comments'] = array(
      'title' => _themesettings_link(
        theme_get_setting('comment_prefix_'. $node_content_type),
        theme_get_setting('comment_suffix_'. $node_content_type),
        format_plural(
          comment_num_all($vars['node']->nid),
          theme_get_setting('comment_singular_'. $node_content_type),
          theme_get_setting('comment_plural_'. $node_content_type)
        ),
      "node/".$vars['node']->nid,
      array(
          'attributes' => array('title' => theme_get_setting('comment_title_'. $node_content_type)), 
        'query' => NULL, 'fragment' => 'comments', 'absolute' => FALSE, 'html' => TRUE
      )
      ),
      'attributes' => array('class' => 'comment-item'),
      'html' => TRUE,
    );
  }
  $vars['links'] = theme('links', $vars['node']->links, array('class' => 'links inline')); 
}


function phptemplate_preprocess_comment(&$vars) {
  global $user;
  // Build array of handy comment classes
  $comment_classes = array();
  static $comment_odd = TRUE;                                                                             // Comment is odd or even
  $comment_classes[] = $comment_odd ? 'odd' : 'even';
  $comment_odd = !$comment_odd;
  $comment_classes[] = ($vars['comment']->status == COMMENT_NOT_PUBLISHED) ? 'comment-unpublished' : '';  // Comment is unpublished
  $comment_classes[] = ($vars['comment']->new) ? 'comment-new' : '';                                      // Comment is new
  $comment_classes[] = ($vars['comment']->uid == 0) ? 'comment-by-anon' : '';                             // Comment is by anonymous user
  $comment_classes[] = ($user->uid && $vars['comment']->uid == $user->uid) ? 'comment-mine' : '';         // Comment is by current user
  $node = node_load($vars['comment']->nid);                                                               // Comment is by node author
  $vars['author_comment'] = ($vars['comment']->uid == $node->uid) ? TRUE : FALSE;
  $comment_classes[] = ($vars['author_comment']) ? 'comment-by-author' : '';
  $comment_classes = array_filter($comment_classes);                                                      // Remove empty elements
  $vars['comment_classes'] = implode(' ', $comment_classes);                                              // Create class list separated by spaces
  // Date & author
  $submitted_by = t('by ') .'<span class="comment-name">'.  theme('username', $vars['comment']) .'</span>';
  $submitted_by .= t(' - ') .'<span class="comment-date">'.  format_date($vars['comment']->timestamp, 'small') .'</span>';     // Format date as small, medium, or large
  $vars['submitted'] = $submitted_by;
}


/**
 * Set defaults for comments display
 * (Requires comment-wrapper.tpl.php file in theme directory)
 */
function phptemplate_preprocess_comment_wrapper(&$vars) {
  $vars['display_mode']  = COMMENT_MODE_FLAT_EXPANDED;
  $vars['display_order'] = COMMENT_ORDER_OLDEST_FIRST;
  $vars['comment_controls_state'] = COMMENT_CONTROLS_HIDDEN;
}


/**
 * Adds a class for the style of view  
 * (e.g., node, teaser, list, table, etc.)
 * (Requires views-view.tpl.php file in theme directory)
 */
function phptemplate_preprocess_views_view(&$vars) {
  $vars['css_name'] = $vars['css_name'] .' view-style-'. views_css_safe(strtolower($vars['view']->type));
}


/**
 * Modify search results based on theme settings
 */
function phptemplate_preprocess_search_result(&$variables) {
  static $search_zebra = 'even';
  $search_zebra = ($search_zebra == 'even') ? 'odd' : 'even';
  $variables['search_zebra'] = $search_zebra;
  
  $result = $variables['result'];
  $variables['url'] = check_url($result['link']);
  $variables['title'] = check_plain($result['title']);

  // Check for existence. User search does not include snippets.
  $variables['snippet'] = '';
  if (isset($result['snippet']) && theme_get_setting('search_snippet')) {
    $variables['snippet'] = $result['snippet'];
  }
  
  $info = array();
  if (!empty($result['type']) && theme_get_setting('search_info_type')) {
    $info['type'] = check_plain($result['type']);
  }
  if (!empty($result['user']) && theme_get_setting('search_info_user')) {
    $info['user'] = $result['user'];
  }
  if (!empty($result['date']) && theme_get_setting('search_info_date')) {
    $info['date'] = format_date($result['date'], 'small');
  }
  if (isset($result['extra']) && is_array($result['extra'])) {
    // $info = array_merge($info, $result['extra']);  Drupal bug?  [extra] array not keyed with 'comment' & 'upload'
    if (!empty($result['extra'][0]) && theme_get_setting('search_info_comment')) {
      $info['comment'] = $result['extra'][0];
    }
    if (!empty($result['extra'][1]) && theme_get_setting('search_info_upload')) {
      $info['upload'] = $result['extra'][1];
    }
  }

  // Provide separated and grouped meta information.
  $variables['info_split'] = $info;
  $variables['info'] = implode(' - ', $info);

  // Provide alternate search result template.
  $variables['template_files'][] = 'search-result-'. $variables['type'];
}


/**
 * Override username theming to display/hide 'not verified' text
 */
function phptemplate_username($object) {
  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }
    if (user_access('access user profiles')) {
      $output = l($name, 'user/'. $object->uid, array('attributes' => array('title' => t('View user profile.'))));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage, array('attributes' => array('rel' => 'nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }
    // Display or hide 'not verified' text
    if (theme_get_setting('user_notverified_display') == 1) {
      $output .= ' ('. t('not verified') .')';
    }
  }
  else {
    $output = variable_get('anonymous', t('Anonymous'));
  }
  return $output;
}


/**
 * Set default form file input size 
 */
function phptemplate_file($element) {
  $element['#size'] = 40;
  return theme_file($element);
}


//==============================
 	//phptemplate overrides
//==============================

//ADD CSS
drupal_add_css(drupal_get_path('theme', 'bookbloc') . '/styles/main.css', 'theme');
drupal_add_css(drupal_get_path('theme', 'bookbloc') . '/styles/admin.css', 'theme');
drupal_add_css(drupal_get_path('theme', 'bookbloc') . '/styles/menu.css', 'theme');
drupal_add_css(drupal_get_path('theme', 'bookbloc') . '/styles/layout.css', 'theme');
drupal_add_css(drupal_get_path('theme', 'bookbloc') . '/styles/blocks.css', 'theme');
drupal_add_css(drupal_get_path('theme', 'bookbloc') . '/styles/views.css', 'theme');
//==============================
//Adds Javascript file to theme
//=============================
//drupal_add_js(drupal_get_path('theme', 'main') . '/js/global.js', 'theme');
//drupal_add_js(drupal_get_path('theme', 'main') . '/js/sifr.js', 'theme');
drupal_add_js(drupal_get_path('theme', 'bookbloc') .'/js/javascript.js');

//==============================
//Themable admin menu blocks
//==============================
function bookbloc_admin_block($block) {
//Don't display the block if it has no content to display.
  if (!$block['content']) {
    return '';
  }
//converts all module titles to lowercase and replace space with hyphens for css.
$block[title] = strtolower($block[title]);
$block[title] = str_replace(' ','_',$block[title]);
//Making Module Title Human Readable
$title = ucfirst($block[title]);
$title = str_replace('_',' ',$title);
$filename = "./sites/all/themes/bookbloc/images/admin/$block[title].gif";
if (file_exists($filename)) {
 $admin_image = '<img src="/sites/all/themes/bookbloc/images/admin/'.$block[title].'.gif" />';
  } else {
  $admin_image ='';
}
//Displays the Module Settings blocks
$output = '
<div class="admin-panel">
  <h3>'.$title.'</h3> 
	<div class="content">
	<p class="description">
        '.$block[description].'
     </p>
	 '.$admin_image.'
	 '.$block[content].'
    </div>
  </div>';
return $output;
}

//==================================
// Customise Block ids 
//==================================

function bookbloc_block($block) {
  if($block->content) {
		/*--------------------------
			FILTER BOCK CONTENT
		--------------------------*/
		global $user;
		if($block->bid=='25') {
			$block->content ='';
			$block->content .= '<ul>';
			$block->content .= '<li class="view-icon"><a href="/'.user_username($user->uid).'">View my profile</a></li>';
			if(!is_publisher()) {
			$block->content .= '<li class="add_book"><a href="/node/add/word">Upload your words</a></li>';
		}
			//$block->content .= '<li class="view-icon"><a href="/user">Edit/Delete my words</a></li>';
			
			if(is_publisher()) {
				$block->content .= '<li class="add_blog"><a href="/node/add/blog">Add Blog</a></li>';
				$block->content .= '<li class="add_author"><a href="/node/add/supported-author">Add Supported Author</a></li>';
				$block->content .= '<li class="add_book"><a href="/node/add/book-published">Add Book Published</a></li>';
				$block->content .= '<li class="add_release"><a href="/node/add/release">Add forthcoming release</a></li>';
				$block->content .= '<li class="add_event"><a href="/node/add/event">Add Event</a></li>';
				//$block->content .= '<li class="add_review"><a href="/node/add/publisher-review">Add Review</a></li>';
				if(!publisher_banner($user->uid)) {
					$block->content .= '<li class="add_banner"><a href="/node/add/banner">Add Banner</a></li>';
				} else {
					$block->content .= '<li class="edit_banner"><a href="/node/'.publisher_banner($user->uid).'/edit">Edit Banner</a></li>';
				}
				
			}
			
			
			$block->content .= '<li class="edit_account"><a href="/user/'.$user->uid.'/edit">Edit my Account</a></li>';
			$block->content .= '<li class="pass"><a href="/user/'.$user->uid.'/edit">Change my password</a></li>';
			$block->content .= '<li class="alerts"><a href="/alerts">My alerts</a></li>';
			$block->content .= '<li class="friends"><a href="/relationships/1">My friends</a><li>';
			$block->content .= '</ul>';
		}
		
		
		
	    $output = '<div id="block_'.$block->bid.'"><div class="block"><h2>'.$block->title.'</h2>';
	    if(!$menu_block) { $output .= '<div class="block_content">';}
	    if($block->bid!='48') {
			$output .= $block->content;
 	    }else{
			$output .= generate_facts();
		}
		if(!$menu_block) { $output .= '</div>';}
		$output .='</div>';
		if($menu_block) { $output .= '<div class="block_bottom"></div>'; }
		$output .= '</div>';
	}
	return $output;
}


function phptemplate_tinymce_theme($init, $textarea_name, $theme_name, $is_running) {
   	static $access, $integrated;

	  if (!isset($access)) {
	    $access = function_exists('imce_access') && imce_access();
	  }

	  $init = theme_tinymce_theme($init, $textarea_name, $theme_name, $is_running);

	  if ($init && $access) {
	    $init['file_browser_callback'] = 'imceImageBrowser';
	    if (!isset($integrated)) {
	      $integrated = TRUE;
	      drupal_add_js("function imceImageBrowser(fid, url, type, win) {win.open(Drupal.settings.basePath +'?q=imce&app=TinyMCE|url@'+ fid, '', 'width=760,height=560,resizable=1');}", 'inline');
	    }
	  }

  //print $textarea_name;
  switch($textarea_name){
    //add text areas to disable tinymce for
    case 'log':
	case 'options':
	case 'pages-pages':
	case 'access-pages':
	case 'extra-items':
	case 'submitted-message':
	case 'submitted-comments':
	case 'submitted-quiz-details':
	case 'emails':
	  unset($init);
	  return($init);
	break;
    
    case 'body':
      if (arg(0)=='admin' && arg(1)=='build' && arg(2)=='block'){
        $format = db_result(db_query("
          SELECT format 
          FROM {boxes} 
          WHERE bid=%d",$bid
        ));
        if ($format==2){
          unset($init);
          return $init;
        }
      }
    
    default:
      return theme_tinymce_theme($init, $textarea_name, $theme_name, $is_running);
  }
}
function phptemplate_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  $class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  if (!empty($extra_class)) {
    $class .= ' '. $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active-trail';
  }
  $id = preg_replace("/[^a-zA-Z0-9]/", "", strip_tags($link));
  return '<li id="'.strtolower($id).'" class="'. strtolower($class) .'"><span>'. $link."</span>$menu</li>\n";
}

/**
 * Creates a link with prefix and suffix text
 *
 * @param $prefix
 *   The text to prefix the link.
 * @param $suffix
 *   The text to suffix the link.
 * @param $text
 *   The text to be enclosed with the anchor tag.
 * @param $path
 *   The Drupal path being linked to, such as "admin/content/node". Can be an external
 *   or internal URL.
 *     - If you provide the full URL, it will be considered an
 *   external URL.
 *     - If you provide only the path (e.g. "admin/content/node"), it is considered an
 *   internal link. In this case, it must be a system URL as the url() function
 *   will generate the alias.
 * @param $options
 *   An associative array that contains the following other arrays and values
 *     @param $attributes
 *       An associative array of HTML attributes to apply to the anchor tag.
 *     @param $query
 *       A query string to append to the link.
 *     @param $fragment
 *       A fragment identifier (named anchor) to append to the link.
 *     @param $absolute
 *       Whether to force the output to be an absolute link (beginning with http:).
 *       Useful for links that will be displayed outside the site, such as in an RSS
 *       feed.
 *     @param $html
 *       Whether the title is HTML or not (plain text)
 * @return
 *   an HTML string containing a link to the given path.
 */
function _themesettings_link($prefix, $suffix, $text, $path, $options) {
  return $prefix . (($text) ? l($text, $path, $options) : '') . $suffix;
}

