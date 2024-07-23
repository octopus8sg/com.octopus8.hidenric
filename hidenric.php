<?php

require_once 'hidenric.civix.php';

use CRM_Hidenric_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function hidenric_civicrm_config(&$config): void {
  _hidenric_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function hidenric_civicrm_install(): void {
  _hidenric_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function hidenric_civicrm_enable(): void {
  _hidenric_civix_civicrm_enable();
}

function hidenric_civicrm_permission(array &$permissions): void {
  $permissions['hide nric'] = [
    'label' => E::ts('O8: hide nric'),
    'description' => E::ts('Hide NRIC number'),
  ];
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_buildForm/
 */
function hidenric_civicrm_buildForm($formName, &$form) { 
  $currentUser = wp_get_current_user();
  $userRoles = $currentUser->roles;
  civi::log()->debug("Current user roles: " . implode(', ', $userRoles));

  $cannot_view = CRM_Core_Permission::check('hide nric') && !CRM_Core_Permission::check('administer SocialServicesConnect');  
  //$cannot_view1 = CRM_Core_Permission::check('hide nric');
  civi::log()->debug("cannot view : " . $cannot_view);
  //civi::log()->debug("cannot view : " . $cannot_view1);
  
  if ($cannot_view ) {
    hideNricField($form);
  }

}

/**
 * Hides the NRIC field on a form if the user has the "hide nric" permission.
 *
 * @param CRM_Core_Form $form
 *   The form object.
 */
function hideNricField(CRM_Core_Form $form) {
  $cannot_view = CRM_Core_Permission::check('hide nric') && !CRM_Core_Permission::check('administer SocialServicesConnect');
  if ($cannot_view) {
    CRM_Core_Session::setStatus(E::ts('User has "hide nric" permission.'), E::ts('Debug'), 'debug'); // Debug message

    // Find the NRIC field on the form
    $elements = $form->getVar('_elements');
    foreach ($elements as $element) {
      if ($element->getName() == 'external_identifier') {
        // Check if the NRIC field is filled
        $nricValue = $element->getValue();
        if (!empty($nricValue)) {
          //CRM_Core_Session::setStatus(E::ts('NRIC field is filled.'), E::ts('Debug'), 'debug'); // Debug message

          // Hide the NRIC field
          $element->setLabel('External ID');

          // Hide the field using CSS
          $element->updateAttributes(['style' => 'display: none;']); 
        }
        break;
      } 
    }
  }
}


/**
 * Implements hook_civicrm_summary().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_summary/
 */
function hidenric_civicrm_summary($contactID, &$content, $context) {
  $cannot_view = CRM_Core_Permission::check('hide nric') && !CRM_Core_Permission::check('administer SocialServicesConnect');
  
  $currentUserID = CRM_Core_Session::getLoggedInContactID();
  $currentUser = wp_get_current_user();
  $userRoles = $currentUser->roles;

  if ($cannot_view) {
    if (isset($content['external_identifier']) && !is_null($content['external_identifier'])) {
      $content['external_identifier']['value'] = 'External ID (Hidden)';
      CRM_Core_Session::setStatus('You do not have access to view External ID.', '', 'info');
    }
  } else {
    // Display the NRIC value for non-editor roles
    if (isset($content['external_identifier']) && !is_null($content['external_identifier'])) {
      $content['external_identifier']['value'] = $content['external_identifier']['value'];
    }
  }

  // Assign the $cannot_view variable to the template
  CRM_Core_Smarty::singleton()->assign('cannot_view', $cannot_view);
}