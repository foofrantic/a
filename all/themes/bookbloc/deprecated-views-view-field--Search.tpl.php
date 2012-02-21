<?php
// $Id: views-view-field.tpl.php,v 1.1 2008/05/16 22:22:32 merlinofchaos Exp $
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>
<?php
    $rate = get_rating($row->nid);
    $rate = $rate/20;
 	$output = '<td class="itemlong"><a href="/node/'.$row->nid.'">'.node_title($row->nid).'</a></td>';
	$output .= '<td class="item"><a href="/'.user_username(node_author($row->nid)).'">'.user_username(node_author($row->nid)).'</a></td>';
	$output .= '<td class="item">'.date('d F Y',node_created($row->nid)).'</td>';
	$output .= '<td class="item">'.get_node_count($row->nid).' </td>';
	$output .= '<td class="item">'.count(get_node_comments($row->nid)).'</td>';
	$output .= '<td class="item">'.$rate.'</td>';
?>


<?php print $output; ?>