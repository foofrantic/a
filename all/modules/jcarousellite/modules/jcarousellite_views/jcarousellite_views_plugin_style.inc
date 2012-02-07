<?php
// $Id: jcarousellite_views_plugin_style.inc,v 1.1.2.6 2009/12/26 10:34:42 owahab Exp $

class jcarousellite_views_plugin_style extends views_plugin_style_list {
  function options(&$options) {
    parent::options($options);
    $options['items_visible'] = 4;
  }

  function options_form(&$form, &$form_values) {
    parent::options_form($form, $form_values);
    unset($form['grouping']);
    unset($form['type']);
    $form['items_visible'] = array(
      '#type' => 'textfield',
      '#title' => t('Visible items'),
      '#required' => TRUE,
      '#description' => t('Specify number of items visible in the Carousel.'),
      '#default_value' => $this->options['items_visible'],
    );
  }

  function options_validate($form, &$form_state) {
    parent::options_validate($form, $form_state);
    $options = &$form_state['values']['style_options'];
    if (!is_numeric($options['items_visible'])) {
      form_error($form['items_visible'], t('Please specify a numerical value for the number of items visible.'));
    }
  }

  function render() {
    static $counter;
    // @FIXME: Keep count of number of rendered views per page
    $counter[$this->view->vid]++;
    drupal_add_css(drupal_get_path('module', 'jcarousellite_views') .'/jcarousellite_views.css');
    $js_code = jcarousellite_callback('add_view_js', $this->view->vid, $counter[$this->view->vid], $this->options);
    jcarousellite_add($js_code);
    // Group the rows according to the grouping field, if specified.
    $sets = $this->render_grouping($this->view->result, $this->options['grouping']);
    $this->options['counter'] = $counter[$this->view->vid];
    // Render each group separately and concatenate.  Plugins may override this
    // method if they wish some other way of handling grouping.
    $output = $view_output = '';
    $this->view->row_index = 0;
    foreach ($sets as $title => $records) {
      if ($this->uses_row_plugin()) {
        $rows = array();
        foreach ($records as $label => $row) {
          $rows[] = $this->row_plugin->render($row);
          $this->view->row_index++;
        }
      }
      else {
        $rows = $records;
      }
      $view_output .= theme($this->theme_functions(), $this->view, $this->options, $rows, $title);
    }
    if (!is_null($view_output)) {
      $output .= $view_output;
    }
    
    return $output;
  }
}

