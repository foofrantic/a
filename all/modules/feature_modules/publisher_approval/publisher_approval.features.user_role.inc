<?php

/**
 * Implementation of hook_user_default_roles().
 */
function publisher_approval_user_default_roles() {
  $roles = array();

  // Exported role: notified-on-new-publisher
  $roles['notified-on-new-publisher'] = array(
    'name' => 'notified-on-new-publisher',
  );

  return $roles;
}
