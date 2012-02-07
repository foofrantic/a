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
$output = '';
$output .='<h4><a href="/node/'.$row->nid.'">'.node_title($row->nid).'</a></h4>';
$output .= neat_trim(get_revision($row->nid),'250','...');
$output .= '<br/><a href="/node/'.$row->nid.'">Read more</a>';
$comments = get_node_comments($row->nid);
$output .= '<p class="utilities"><span class="comments">'.count($comments).' Comments</span> <span class="comment_add"><a href="/comment/reply/'.$row->nid.'">Add a Comment</a></p>';
?>

<?php print $output; ?>