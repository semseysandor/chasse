<?php

use CRM_Chasse_ExtensionUtil as E;

/**
 * CRM_Chasse_Page_Summary Class
 */
class CRM_Chasse_Page_Summary extends CRM_Core_Page
{
  /**
   * Page assembly
   *
   * @return void|null
   * @throws \CiviCRM_API3_Exception
   */
  public function run()
  {
    // Check permission
    if (!CRM_Core_Permission::check('access CiviMail')) {
      CRM_Core_Error::statusBounce(ts('You do not have permission to view this page.'));
    }

    // Page title
    CRM_Utils_System::setTitle(E::ts('Journey Summary'));

    // Get journeys
    $journeys_all = Civi::settings()->get('chasse_config');

    // If no journeys --> stop further processing
    if (is_null($journeys_all)) {
      $this->assign('no_journeys', true);
      parent::run();

      return;
    }

    // Init results
    $journeys = [];

    // Loop through journeys
    foreach ($journeys_all['journeys'] as $journey) {
      // Journey details
      $name = $journey['name'];
      $id = $journey['id'];
      $steps = $journey['steps'];

      // Loop through journey steps
      foreach ($steps as $step) {
        // Get associated mailing
        $result = civicrm_api3(
          'Mailing',
          'get',
          [
            'sequential' => 1,
            'return' => ["name", "subject", "from_name", "from_email", "replyto_email"],
            'msg_template_id' => $step['send_mailing'],
            'options' => ['limit' => 1],
          ]
        );

        // No mailing found --> move to next step
        if ($result['count'] < 1) {
          break;
        }

        // Add details to results
        $journeys[] = [
          'id' => $id,
          'name' => $name,
          'code' => $step['code'],
          'msg_template_id' => $step['send_mailing'],
          'mailing_name' => $result['values'][0]['name'],
          'mailing_subject' => $result['values'][0]['subject'],
          'mailing_from_name' => $result['values'][0]['from_name'],
          'mailing_from' => $result['values'][0]['from_email'],
          'mailing_replyto' => $result['values'][0]['replyto_email'],
        ];
      }
    }

    // Assign results to template
    $this->assign('journeys', $journeys);

    parent::run();
  }
}
