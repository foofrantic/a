<?php

/**
 * Implementation of hook_node_info().
 */
function word_2012_node_info() {
  $items = array(
    'word' => array(
      'name' => t('Word'),
      'module' => 'features',
      'description' => t('Words also known as ideas'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '1',
      'body_label' => t('Synopsis'),
      'min_word_count' => '0',
      'help' => t('Use the "Synopsis" to say something about your chapter or poem. Keep it short and relevant and try to get the reader\'s interest so that they are motivated to read your work. Paste the text of your chapter or poem in to the "Full text" field.'),
    ),
  );
  return $items;
}
