<?php
class favorite_nodes_handler_user_count extends views_handler_field {
  function render($values) {
    return db_result(db_query("SELECT COUNT(*) FROM {favorite_nodes} WHERE nid = %d", $values->nid));
  }
}