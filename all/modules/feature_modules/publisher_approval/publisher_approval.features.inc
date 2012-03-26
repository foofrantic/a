<?php

/**
 * Implementation of hook_rules_defaults().
 */
function publisher_approval_rules_defaults() {
  return array(
    'rules' => array(
      'rules_block_new_publishers' => array(
        '#type' => 'rule',
        '#set' => 'event_user_insert',
        '#label' => 'Block new publishers',
        '#active' => 1,
        '#weight' => '0',
        '#categories' => array(
          '0' => 'block',
          '1' => 'new user',
          '2' => 'publisher',
          'publisher_approval' => 'publisher_approval',
        ),
        '#status' => 'default',
        '#conditions' => array(
          '0' => array(
            '#type' => 'condition',
            '#settings' => array(
              'roles' => array(
                '0' => 4,
              ),
              'operation' => 'OR',
              '#argument map' => array(
                'user' => 'account',
              ),
            ),
            '#name' => 'rules_condition_user_hasrole',
            '#info' => array(
              'label' => 'New user has selected Publisher role',
              'label callback' => FALSE,
              'arguments' => array(
                'user' => array(
                  'type' => 'user',
                  'label' => 'User',
                ),
              ),
              'module' => 'User',
            ),
            '#weight' => 0,
          ),
        ),
        '#actions' => array(
          '0' => array(
            '#type' => 'action',
            '#settings' => array(
              '#argument map' => array(
                'user' => 'account',
              ),
            ),
            '#name' => 'rules_core_user_block_user_action',
            '#info' => array(
              'label' => 'Block new user requesting publisher status',
              'label callback' => FALSE,
              'module' => 'User',
              'arguments' => array(
                'user' => array(
                  'label' => 'User',
                  'type' => 'user',
                ),
              ),
              'base' => 'rules_core_action_execute',
              'action_name' => 'user_block_user_action',
              'configurable' => FALSE,
            ),
            '#weight' => 0,
          ),
          '1' => array(
            '#weight' => 0,
            '#info' => array(
              'label' => 'Notify relevant administrators of potential new publisher',
              'label callback' => FALSE,
              'module' => 'System',
              'eval input' => array(
                '0' => 'subject',
                '1' => 'message',
                '2' => 'from',
              ),
            ),
            '#name' => 'rules_action_mail_to_users_of_role',
            '#settings' => array(
              'recipients' => array(
                '0' => 8,
              ),
              'from' => '',
              'subject' => 'New user requested to be a Publisher',
              'message' => 'The new user [account:user] has requested publisher status. The user is currently blocked. You can unblock them via their edit page here...

    [account:account-edit-url]',
              '#eval input' => array(
                'token_rules_input_evaluator' => array(
                  'subject' => array(
                    '0' => ':global',
                  ),
                  'message' => array(
                    '0' => 'account',
                    '1' => ':global',
                  ),
                  'from' => array(
                    '0' => ':global',
                  ),
                ),
              ),
            ),
            '#type' => 'action',
          ),
        ),
        '#version' => 6003,
      ),
    ),
  );
}
