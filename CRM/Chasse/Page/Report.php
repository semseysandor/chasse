<?php

use CRM_Chasse_ExtensionUtil as E;

/**
 * CRM_Chasse_Page_Report Class
 */
class CRM_Chasse_Page_Report extends CRM_Core_Page
{

  /**
   * Page assembly
   *
   * @return void|null
   * @throws \CRM_Core_Exception
   * @throws \CiviCRM_API3_Exception
   */
  public function run()
  {
    // Get msg_template_id from request
    $msg_template_id = CRM_Utils_Request::retrieve('msg_template_id', 'Positive');

    // Get associated mailings
    $result = civicrm_api3(
      'Mailing',
      'get',
      [
        'sequential' => 1,
        'return' => ["name", "subject", "id"],
        'msg_template_id' => $msg_template_id,
      ]
    );

    // No mailing found
    if ($result['count'] <= 0) {
      $this->assign('no_mailing', true);
      parent::run();

      return;
    }

    // Set page title
    CRM_Utils_System::setTitle(E::ts("Journey Report: {$result['values'][0]['name']}"));

    // Report fields
    $report_fields_sum = ['queue', 'delivered', 'url', 'forward', 'reply', 'unsubscribe', 'optout', 'opened', 'total_opened', 'bounce'];
    $report_fields_ave = ['delivered_rate', 'bounce_rate', 'unsubscribe_rate', 'optout_rate', 'clickthrough_rate'];

    // Init total
    $total = [];
    foreach ($report_fields_sum as $item) {
      $total[$item] = 0;
    }
    foreach ($report_fields_ave as $item) {
      $total[$item] = 0;
    }
    $total['clicks'] = 0;

    // Loop through mailings
    foreach ($result['values'] as $mailing) {
      // Get mailing report
      $report = CRM_Mailing_BAO_Mailing::report($mailing['id']);

      // Loop through report data
      foreach ($report['event_totals'] as $param => $value) {
        // If data needs to be summarized
        if (in_array($param, $report_fields_sum)) {
          $total[$param] += $value;
        }
      }

      // Calculate clicks
      $clicks = (int)$report['event_totals']['clickthrough_rate'] * $report['event_totals']['delivered'];
      $total['clicks'] += $clicks;
    }

    // Prevent divide by zero error later
    if ($total['queue'] == 0) {
      foreach ($report_fields_ave as $item) {
        $total[$item] = 0;
      }
    } else {
      // Calculate average fields
      $total['delivered_rate'] = $total['delivered'] / $total['queue'] * 100.0;
      $total['bounce_rate'] = $total['bounce'] / $total['queue'] * 100.0;
      $total['unsubscribe_rate'] = $total['unsubscribe'] / $total['queue'] * 100.0;
      $total['optout_rate'] = $total['optout'] / $total['queue'] * 100.0;
      $total['clickthrough_rate'] = $total['clicks'] / $total['queue'] * 100.0;
    }

    // Assign report to template
    $this->assign('report_total', $total);
    parent::run();
  }

}
