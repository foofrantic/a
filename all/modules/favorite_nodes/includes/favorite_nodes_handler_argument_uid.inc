<?php
// currently not used, and not ported for views 2 api
function favorite_nodes_handler_argument_uid($op, &$query, $argtype, $arg = '') {
  switch ($op) {
    case 'sort':
      // no luck using add_orderby method.
      $query->orderby[] = ' num_nodes '. $argtype;
      break;
    case 'filter':
      list($and_or, $uids) = _views_break_phrase($arg);
      $and_or = drupal_strtoupper($and_or);
      // Similar to taxonomy AND/OR query.

      if ($and_or == 'OR') {
        $query->ensure_table('favorite_nodes');
        $cond = array_fill(0, count($uids), "favorite_nodes.uid = %d");
        $query->add_where(implode(" $and_or ", $cond), $uids);
      }
      else {
        foreach ((array)$uids as $uid) {
          $num = $query->add_table('favorite_nodes');
          $tablename = $query->get_table_name('favorite_nodes', $num);
          $query->add_where("$tablename.uid = %d", $uid);
        }
      }
      break;
  }
}