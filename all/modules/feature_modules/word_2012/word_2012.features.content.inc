<?php

/**
 * Implementation of hook_content_default_fields().
 */
function word_2012_content_default_fields() {
  $fields = array();

  // Exported field: field_cover
  $fields['word-field_cover'] = array(
    'field_name' => 'field_cover',
    'type_name' => 'word',
    'display_settings' => array(
      'weight' => '1',
      'parent' => 'group_word_cover_image',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'hidden',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      '2' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      '3' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      'email_plain' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      'email_html' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'image_plain',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'filefield',
    'required' => '0',
    'multiple' => '0',
    'module' => 'filefield',
    'active' => '1',
    'list_field' => '0',
    'list_default' => 1,
    'description_field' => '0',
    'widget' => array(
      'file_extensions' => 'png gif jpg jpeg',
      'file_path' => '',
      'progress_indicator' => 'bar',
      'max_filesize_per_file' => '2M',
      'max_filesize_per_node' => '',
      'max_resolution' => '0',
      'min_resolution' => '0',
      'alt' => '',
      'custom_alt' => 0,
      'title' => '',
      'custom_title' => 0,
      'title_type' => 'textfield',
      'default_image' => array(
        'filename' => 'default_cover.jpg',
        'filepath' => 'sites/default/files/imagefield_default_images/default_cover.jpg',
        'filemime' => 'image/jpeg',
        'source' => 'default_image_upload',
        'destination' => 'sites/default/files/imagefield_default_images/default_cover.jpg',
        'filesize' => '2984',
        'uid' => '1',
        'status' => 1,
        'timestamp' => 1274519168,
        'fid' => '201',
      ),
      'use_default_image' => 1,
      'label' => 'Cover',
      'weight' => '1',
      'description' => 'Upload an image as a cover for your work.',
      'type' => 'imagefield_widget',
      'module' => 'imagefield',
    ),
  );

  // Exported field: field_upload
  $fields['word-field_upload'] = array(
    'field_name' => 'field_upload',
    'type_name' => 'word',
    'display_settings' => array(
      'weight' => '33',
      'parent' => 'group_chapter',
      'label' => array(
        'format' => 'above',
      ),
      'teaser' => array(
        'format' => 'hidden',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'filefield',
    'required' => '0',
    'multiple' => '0',
    'module' => 'filefield',
    'active' => '1',
    'list_field' => TRUE,
    'list_default' => '1',
    'description_field' => '1',
    'widget' => array(
      'file_extensions' => 'txt pdf doc rtf',
      'file_path' => 'ideas',
      'max_filesize_per_file' => '10M',
      'max_filesize_per_node' => '40M',
      'file_widgets' => NULL,
      'label' => 'Upload your idea',
      'weight' => '33',
      'description' => '',
      'type' => 'filefield_widget',
      'module' => 'filefield',
    ),
  );

  // Exported field: field_word_full_text
  $fields['word-field_word_full_text'] = array(
    'field_name' => 'field_word_full_text',
    'type_name' => 'word',
    'display_settings' => array(
      'weight' => '-1',
      'parent' => '',
      'label' => array(
        'format' => 'hidden',
      ),
      'teaser' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'full' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '4' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '2' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '3' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      '5' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'email_plain' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'email_html' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
      'token' => array(
        'format' => 'default',
        'exclude' => 0,
      ),
    ),
    'widget_active' => '1',
    'type' => 'text',
    'required' => '1',
    'multiple' => '0',
    'module' => 'text',
    'active' => '1',
    'text_processing' => '1',
    'max_length' => '',
    'allowed_values' => '',
    'allowed_values_php' => '',
    'widget' => array(
      'rows' => '20',
      'size' => 60,
      'default_value' => array(
        '0' => array(
          'value' => '',
          'format' => '2',
          '_error_element' => 'default_value_widget][field_word_full_text][0][value',
        ),
      ),
      'default_value_php' => NULL,
      'label' => 'Full text',
      'weight' => '-1',
      'description' => 'Upload the full text of your submission (your chapter or poem) here.',
      'type' => 'text_textarea',
      'module' => 'text',
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Cover');
  t('Full text');
  t('Upload your idea');

  return $fields;
}
