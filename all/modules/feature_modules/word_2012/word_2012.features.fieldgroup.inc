<?php

/**
 * Implementation of hook_fieldgroup_default_groups().
 */
function word_2012_fieldgroup_default_groups() {
  $groups = array();

  // Exported group: group_chapter
  $groups['word-group_chapter'] = array(
    'group_type' => 'standard',
    'type_name' => 'word',
    'group_name' => 'group_chapter',
    'label' => 'Chapter - obsolete - remove this',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset_collapsed',
        'description' => '<p>Upload the first chapter of your story here.</p>',
      ),
      'display' => array(
        'weight' => '2',
        'label' => 'above',
        'teaser' => array(
          'format' => 'hidden',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'description' => '',
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '2' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '3' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '5' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'email_plain' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'email_html' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
      ),
    ),
    'weight' => '2',
    'fields' => array(
      '0' => 'field_upload',
    ),
  );

  // Exported group: group_word_cover_image
  $groups['word-group_word_cover_image'] = array(
    'group_type' => 'standard',
    'type_name' => 'word',
    'group_name' => 'group_word_cover_image',
    'label' => 'Cover image',
    'settings' => array(
      'form' => array(
        'style' => 'fieldset',
        'description' => '',
      ),
      'display' => array(
        'weight' => '0',
        'label' => 'above',
        'teaser' => array(
          'format' => 'hidden',
          'exclude' => 0,
        ),
        'full' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'description' => '',
        '4' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '2' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '3' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        '5' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'email_plain' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'email_html' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
        'token' => array(
          'format' => 'fieldset',
          'exclude' => 0,
        ),
      ),
    ),
    'weight' => '0',
    'fields' => array(
      '0' => 'field_cover',
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Chapter - obsolete - remove this');
  t('Cover image');

  return $groups;
}
